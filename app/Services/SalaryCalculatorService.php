<?php

namespace App\Services;

use App\Models\CasePrice;
use App\Models\Rep;
use App\Models\SalesRecord;
use Carbon\Carbon;

class SalaryCalculatorService
{
    private function round2(float|int $value): float
    {
        return round((float) $value, 2);
    }

    /**
     * @param array{500ml:int,1000ml:int,1500ml:int,5000ml:int} $cases
     */
    public function calculate(array $cases): array
    {
        $normalizedCases = [
            '500ml' => (int) ($cases['500ml'] ?? 0),
            '1000ml' => (int) ($cases['1000ml'] ?? 0),
            '1500ml' => (int) ($cases['1500ml'] ?? 0),
            '5000ml' => (int) ($cases['5000ml'] ?? 0),
        ];

        // Load current active prices from DB (fallback defaults are handled in CasePrice::current()).
        $prices = [
            '500ml' => CasePrice::current('500ml'),
            '1000ml' => CasePrice::current('1000ml'),
            '1500ml' => CasePrice::current('1500ml'),
            '5000ml' => CasePrice::current('5000ml'),
        ];

        $revenueByProduct = [];
        $totalSales = 0.0;

        foreach ($normalizedCases as $size => $caseQty) {
            $revenue = (float) $caseQty * (float) $prices[$size];
            $totalSales += $revenue;

            $revenueByProduct[$size] = [
                'cases' => $caseQty,
                'revenue' => $this->round2($revenue),
            ];
        }

        $tier1Cap = (float) config('salary.tier1_cap');
        $tier1Rate = (float) config('salary.tier1_rate');
        $tier2Rate = (float) config('salary.tier2_rate');

        $tier1Sales = min($totalSales, $tier1Cap);
        $tier2Sales = max($totalSales - $tier1Cap, 0);

        $tier1Commission = $tier1Sales * $tier1Rate;
        $tier2Commission = $tier2Sales * $tier2Rate;
        $commission = $tier1Commission + $tier2Commission;

        $bonusThreshold = (float) config('salary.bonus_threshold');
        $bonusAmount = (float) config('salary.bonus_amount');
        $bonusEarned = $totalSales >= $bonusThreshold;
        $bonus = $bonusEarned ? $bonusAmount : 0.0;

        $basicSalary = (float) config('salary.basic_salary');
        $allowance = (float) config('salary.allowance');

        $costRatio = (float) config('salary.cost_ratio');
        $totalCost = $totalSales * $costRatio;
        $grossProfit = $totalSales - $totalCost;

        $totalSalary = $basicSalary + $allowance + $commission + $bonus;
        $netProfit = $grossProfit - $totalSalary;

        $salesVsTargetPct = $bonusThreshold > 0
            ? ($totalSales / $bonusThreshold) * 100
            : 0;

        return [
            'revenue_by_product' => $revenueByProduct,

            'total_sales' => $this->round2($totalSales),
            'total_cost' => $this->round2($totalCost),
            'gross_profit' => $this->round2($grossProfit),

            'commission' => $this->round2($commission),
            'commission_breakdown' => [
                'tier1_sales' => $this->round2($tier1Sales),
                'tier1_commission' => $this->round2($tier1Commission),
                'tier2_sales' => $this->round2($tier2Sales),
                'tier2_commission' => $this->round2($tier2Commission),
            ],

            'bonus' => $this->round2($bonus),

            'basic_salary' => $this->round2($basicSalary),
            'allowance' => $this->round2($allowance),
            'total_salary' => $this->round2($totalSalary),
            'net_profit' => $this->round2($netProfit),

            'bonus_earned' => $bonusEarned,
            'sales_vs_target_pct' => $this->round2($salesVsTargetPct),
        ];
    }

    public function calculateForMonth(int $repId, int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = (clone $start)->endOfMonth();

        $records = SalesRecord::query()
            ->where('rep_id', $repId)
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->whereIn('status', ['submitted', 'verified'])
            ->get();

        $cases = [
            '500ml' => 0,
            '1000ml' => 0,
            '1500ml' => 0,
            '5000ml' => 0,
        ];

        $revenueByProduct = [
            '500ml' => ['cases' => 0, 'revenue' => 0.0],
            '1000ml' => ['cases' => 0, 'revenue' => 0.0],
            '1500ml' => ['cases' => 0, 'revenue' => 0.0],
            '5000ml' => ['cases' => 0, 'revenue' => 0.0],
        ];

        $totalSales = 0.0;

        foreach ($records as $record) {
            $cases['500ml'] += (int) $record->cases_500ml;
            $cases['1000ml'] += (int) $record->cases_1000ml;
            $cases['1500ml'] += (int) $record->cases_1500ml;
            $cases['5000ml'] += (int) $record->cases_5000ml;

            $revenueByProduct['500ml']['cases'] += (int) $record->cases_500ml;
            $revenueByProduct['500ml']['revenue'] += (float) $record->revenue_500ml;

            $revenueByProduct['1000ml']['cases'] += (int) $record->cases_1000ml;
            $revenueByProduct['1000ml']['revenue'] += (float) $record->revenue_1000ml;

            $revenueByProduct['1500ml']['cases'] += (int) $record->cases_1500ml;
            $revenueByProduct['1500ml']['revenue'] += (float) $record->revenue_1500ml;

            $revenueByProduct['5000ml']['cases'] += (int) $record->cases_5000ml;
            $revenueByProduct['5000ml']['revenue'] += (float) $record->revenue_5000ml;

            $totalSales += (float) $record->total_sales;
        }

        // Salary math must follow business rules, but should be calculated from month totals.
        $tier1Cap = (float) config('salary.tier1_cap');
        $tier1Rate = (float) config('salary.tier1_rate');
        $tier2Rate = (float) config('salary.tier2_rate');

        $tier1Sales = min($totalSales, $tier1Cap);
        $tier2Sales = max($totalSales - $tier1Cap, 0);

        $tier1Commission = $tier1Sales * $tier1Rate;
        $tier2Commission = $tier2Sales * $tier2Rate;
        $commission = $tier1Commission + $tier2Commission;

        $bonusThreshold = (float) config('salary.bonus_threshold');
        $bonusAmount = (float) config('salary.bonus_amount');
        $bonusEarned = $totalSales >= $bonusThreshold;
        $bonus = $bonusEarned ? $bonusAmount : 0.0;

        $basicSalary = (float) config('salary.basic_salary');
        $allowance = (float) config('salary.allowance');

        $costRatio = (float) config('salary.cost_ratio');
        $totalCost = $totalSales * $costRatio;
        $grossProfit = $totalSales - $totalCost;

        $totalSalary = $basicSalary + $allowance + $commission + $bonus;
        $netProfit = $grossProfit - $totalSalary;

        $rep = Rep::query()->select(['monthly_target'])->find($repId);
        $repMonthlyTarget = $rep?->monthly_target ?? $bonusThreshold;
        $salesVsTargetPct = $repMonthlyTarget > 0
            ? ($totalSales / (float) $repMonthlyTarget) * 100
            : 0;

        // Normalize revenue decimals to 2dp.
        foreach ($revenueByProduct as $size => &$row) {
            $row['revenue'] = $this->round2($row['revenue']);
        }
        unset($row);

        return [
            'revenue_by_product' => $revenueByProduct,

            'total_sales' => $this->round2($totalSales),
            'total_cost' => $this->round2($totalCost),
            'gross_profit' => $this->round2($grossProfit),

            'commission' => $this->round2($commission),
            'commission_breakdown' => [
                'tier1_sales' => $this->round2($tier1Sales),
                'tier1_commission' => $this->round2($tier1Commission),
                'tier2_sales' => $this->round2($tier2Sales),
                'tier2_commission' => $this->round2($tier2Commission),
            ],

            'bonus' => $this->round2($bonus),

            'basic_salary' => $this->round2($basicSalary),
            'allowance' => $this->round2($allowance),
            'total_salary' => $this->round2($totalSalary),
            'net_profit' => $this->round2($netProfit),

            'bonus_earned' => $bonusEarned,
            'sales_vs_target_pct' => $this->round2($salesVsTargetPct),
        ];
    }
}

