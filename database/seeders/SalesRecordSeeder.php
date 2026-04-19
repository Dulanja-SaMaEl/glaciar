<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\CasePrice;
use App\Models\Rep;
use App\Models\SalesRecord;
use App\Services\SalaryCalculatorService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SalesRecordSeeder extends Seeder
{
    public function run(): void
    {
        $service = new SalaryCalculatorService();

        $admins = Admin::query()->orderBy('id')->get();
        $verifiedById = $admins->first()?->id;

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = (clone $start)->endOfMonth();

        // "Working days" for demo seeding: Mon-Sat (skip Sunday).
        $dates = [];
        for ($d = $start->copy(); $d->lte($end) && count($dates) < 26; $d->addDay()) {
            $isoDow = (int) $d->dayOfWeekIso; // 1=Mon ... 7=Sun
            if ($isoDow === 7) {
                continue;
            }
            $dates[] = $d->copy();
        }

        $reps = Rep::query()->orderBy('id')->take(5)->get();
        if ($reps->count() === 0) {
            return;
        }

        $casePrice500ml = (float) CasePrice::current('500ml');

        foreach ($reps->values() as $repIndex => $rep) {
            // Category targets as required:
            // - 2 reps bonus: >= 1,500,000
            // - 2 reps tier2: between 1,200,000 and 1,500,000
            // - 1 rep below tier1: < 1,200,000
            $category = match (true) {
                $repIndex < 2 => 'bonus',
                $repIndex < 4 => 'tier2',
                default => 'below',
            };

            $desiredMonthlySales = match ($category) {
                'bonus' => 1560000.0,
                'tier2' => 1350000.0,
                default => 1050000.0,
            };

            $scale = match ($category) {
                'bonus' => 1.55,
                'tier2' => 1.22,
                default => 0.9,
            };

            $dailyCases = [];
            foreach ($dates as $date) {
                $day = (int) $date->day;

                // Baseline distribution; we scale 500ml and occasionally add other sizes.
                $base500 = 45 + ($day % 6) * 3; // ~45..60
                $base1000 = ($day % 7 === 0) ? 4 : (($day % 9 === 0) ? 2 : 0);
                $base1500 = ($day % 11 === 0) ? 3 : (($day % 13 === 0) ? 1 : 0);
                $base5000 = ($day % 17 === 0) ? 1 : 0;

                $dailyCases[] = [
                    'date' => $date->toDateString(),
                    'cases_500ml' => max(0, (int) round($base500 * $scale)),
                    'cases_1000ml' => max(0, (int) round($base1000 * $scale)),
                    'cases_1500ml' => max(0, (int) round($base1500 * $scale)),
                    'cases_5000ml' => max(0, (int) round($base5000 * $scale)),
                ];
            }

            // Compute totals, then adjust using only 500ml cases on the last day so thresholds match.
            $dailyCalc = [];
            $monthlyTotalSales = 0.0;
            foreach ($dailyCases as $i => $row) {
                $cases = [
                    '500ml' => $row['cases_500ml'],
                    '1000ml' => $row['cases_1000ml'],
                    '1500ml' => $row['cases_1500ml'],
                    '5000ml' => $row['cases_5000ml'],
                ];

                $calc = $service->calculate($cases);
                $dailyCalc[$i] = $calc;
                $monthlyTotalSales += (float) $calc['total_sales'];
            }

            $adjustLastDay = function () use (
                &$dailyCases,
                &$dailyCalc,
                &$monthlyTotalSales,
                $service,
                $desiredMonthlySales,
                $category,
                $casePrice500ml
            ) {
                $lastIdx = count($dailyCases) - 1;
                $min = match ($category) {
                    'bonus' => 1500000.0,
                    'tier2' => 1200000.0,
                    default => 0.0,
                };
                $max = match ($category) {
                    'bonus' => INF,
                    'tier2' => 1500000.0,
                    default => 1200000.0,
                };

                // Safety loop to guarantee the tier categories in the spec.
                for ($guard = 0; $guard < 25; $guard++) {
                    if ($monthlyTotalSales >= $min && $monthlyTotalSales < $max) {
                        return;
                    }

                    $diff = 0.0;
                    if ($monthlyTotalSales < $min) {
                        $diff = $min - $monthlyTotalSales;
                    } elseif ($monthlyTotalSales >= $max) {
                        $diff = $max - $monthlyTotalSales; // negative number
                    }

                    $neededCases = (int) round($diff / max($casePrice500ml, 0.01));
                    if ($neededCases === 0) {
                        $neededCases = $monthlyTotalSales < $min ? 1 : -1;
                    }

                    $current500 = (int) $dailyCases[$lastIdx]['cases_500ml'];
                    $new500 = $current500 + $neededCases;
                    $dailyCases[$lastIdx]['cases_500ml'] = max(0, $new500);

                    // Recompute last day and refresh monthly totals.
                    $dailyCalc[$lastIdx] = $service->calculate([
                        '500ml' => $dailyCases[$lastIdx]['cases_500ml'],
                        '1000ml' => $dailyCases[$lastIdx]['cases_1000ml'],
                        '1500ml' => $dailyCases[$lastIdx]['cases_1500ml'],
                        '5000ml' => $dailyCases[$lastIdx]['cases_5000ml'],
                    ]);

                    // Re-sum monthly total from scratch (only 26 records, keep it simple).
                    $monthlyTotalSales = 0.0;
                    foreach ($dailyCalc as $calc) {
                        $monthlyTotalSales += (float) $calc['total_sales'];
                    }
                }
            };

            $adjustLastDay();

            foreach ($dailyCases as $i => $row) {
                $calc = $dailyCalc[$i];

                // Mix submitted and verified statuses for realism.
                // (No "pending" in seeding as the spec only mentions submitted + verified.)
                $status = (random_int(0, 2) === 0) ? 'verified' : 'submitted';
                $now = now();

                $submittedAt = $now;
                $verifiedAt = $status === 'verified' ? $now : null;
                $verifiedBy = $status === 'verified' ? $verifiedById : null;

                SalesRecord::updateOrCreate(
                    [
                        'rep_id' => $rep->id,
                        'date' => $row['date'],
                    ],
                    [
                        'cases_500ml' => (int) $row['cases_500ml'],
                        'cases_1000ml' => (int) $row['cases_1000ml'],
                        'cases_1500ml' => (int) $row['cases_1500ml'],
                        'cases_5000ml' => (int) $row['cases_5000ml'],

                        'revenue_500ml' => $calc['revenue_by_product']['500ml']['revenue'],
                        'revenue_1000ml' => $calc['revenue_by_product']['1000ml']['revenue'],
                        'revenue_1500ml' => $calc['revenue_by_product']['1500ml']['revenue'],
                        'revenue_5000ml' => $calc['revenue_by_product']['5000ml']['revenue'],

                        'total_sales' => $calc['total_sales'],
                        'total_cost' => $calc['total_cost'],
                        'gross_profit' => $calc['gross_profit'],

                        'commission' => $calc['commission'],
                        'bonus' => $calc['bonus'],
                        'total_salary' => $calc['total_salary'],
                        'net_profit' => $calc['net_profit'],

                        'notes' => $status === 'verified' ? 'Seed verified.' : 'Seed submitted.',

                        'status' => $status,
                        'submitted_at' => $submittedAt,

                        'verified_at' => $verifiedAt,
                        'verified_by' => $verifiedBy,
                    ]
                );
            }
        }
    }
}

