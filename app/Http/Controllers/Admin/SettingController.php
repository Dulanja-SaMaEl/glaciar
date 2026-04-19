<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CasePrice;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'general');

        return view('admin.settings.index', [
            'activeTab' => $activeTab,
            'settings' => [
                'app_name' => config('app.name'),
                'app_url' => config('app.url'),
                'mail_from' => config('mail.from.address'),
            ],
            'casePrices' => $this->currentCasePrices(),
            'salaryRules' => [
                'basic_salary' => config('salary.basic_salary'),
                'allowance' => config('salary.allowance'),
                'tier1_cap' => config('salary.tier1_cap'),
                'tier1_rate' => config('salary.tier1_rate'),
                'tier2_rate' => config('salary.tier2_rate'),
                'bonus_threshold' => config('salary.bonus_threshold'),
                'bonus_amount' => config('salary.bonus_amount'),
                'cost_ratio' => config('salary.cost_ratio'),
            ],
        ]);
    }

    private function currentCasePrices(): array
    {
        $sizes = ['500ml', '1000ml', '1500ml', '5000ml'];
        $prices = [];
        foreach ($sizes as $size) {
            $row = CasePrice::query()
                ->active()
                ->where('product_size', $size)
                ->orderBy('effective_from', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $prices[$size] = [
                'id' => $row?->id,
                'bottles_per_case' => (int) ($row?->bottles_per_case ?? 24),
                'price_per_case' => (float) ($row?->price_per_case ?? (match ($size) {
                    '500ml' => 750.00,
                    '1000ml' => 960.00,
                    '1500ml' => 960.00,
                    '5000ml' => 1000.00,
                    default => 0.00,
                })),
                'effective_from' => $row?->effective_from?->toDateString(),
                'is_active' => (bool) ($row?->is_active ?? true),
            ];
        }

        return $prices;
    }

    public function update(Request $request): RedirectResponse
    {
        $section = $request->input('section', 'general');

        if ($section === 'salary_pricing') {
            $request->validate([
                'case_prices' => ['required', 'array'],
                'case_prices.*.bottles_per_case' => ['required', 'integer', 'min:0'],
                'case_prices.*.price_per_case' => ['required', 'numeric', 'min:0'],
                'case_prices.*.effective_from' => ['required', 'date'],
                'case_prices.*.is_active' => ['required', 'boolean'],

                'basic_salary' => ['required', 'numeric', 'min:0'],
                'allowance' => ['required', 'numeric', 'min:0'],
                'tier1_cap' => ['required', 'numeric', 'min:0'],
                'tier1_rate' => ['required', 'numeric', 'min:0'],
                'tier2_rate' => ['required', 'numeric', 'min:0'],
                'bonus_threshold' => ['required', 'numeric', 'min:0'],
                'bonus_amount' => ['required', 'numeric', 'min:0'],
                'cost_ratio' => ['required', 'numeric', 'min:0'],
            ]);

            // Update case prices (effective_from versioning). Old rows are marked inactive.
            DB::beginTransaction();
            try {
                foreach ($request->input('case_prices') as $size => $data) {
                    if (!in_array($size, ['500ml', '1000ml', '1500ml', '5000ml'], true)) {
                        continue;
                    }

                    CasePrice::query()
                        ->where('product_size', $size)
                        ->update(['is_active' => false]);

                    CasePrice::updateOrCreate(
                        [
                            'product_size' => $size,
                            'effective_from' => $data['effective_from'],
                        ],
                        [
                            'bottles_per_case' => (int) $data['bottles_per_case'],
                            'price_per_case' => (float) $data['price_per_case'],
                            'is_active' => (bool) $data['is_active'],
                        ]
                    );
                }

                // Persist salary rules by rewriting config/salary.php.
                $basicSalary = (float) $request->input('basic_salary');
                $allowance = (float) $request->input('allowance');
                $tier1Cap = (float) $request->input('tier1_cap');
                $tier1Rate = (float) $request->input('tier1_rate');
                $tier2Rate = (float) $request->input('tier2_rate');
                $bonusThreshold = (float) $request->input('bonus_threshold');
                $bonusAmount = (float) $request->input('bonus_amount');
                $costRatio = (float) $request->input('cost_ratio');

                // UI inputs are commonly shown as percentages (e.g. "2" for 2%); config stores decimals (0.02).
                if ($tier1Rate > 1) {
                    $tier1Rate = $tier1Rate / 100;
                }
                if ($tier2Rate > 1) {
                    $tier2Rate = $tier2Rate / 100;
                }
                if ($costRatio > 1) {
                    $costRatio = $costRatio / 100;
                }

                $salaryConfigPath = config_path('salary.php');
                $newConfig = <<<PHP
<?php

return [
    'basic_salary' => {$basicSalary},
    'allowance' => {$allowance},

    'tier1_cap' => {$tier1Cap},
    'tier1_rate' => {$tier1Rate},
    'tier2_rate' => {$tier2Rate},

    'bonus_threshold' => {$bonusThreshold},
    'bonus_amount' => {$bonusAmount},

    'cost_ratio' => {$costRatio},
];

PHP;

                file_put_contents($salaryConfigPath, $newConfig);

                DB::commit();
                return back()->with('status', 'Salary & Pricing saved.');
            } catch (\Throwable $e) {
                DB::rollBack();
                return back()->with('status', 'Save failed: ' . $e->getMessage());
            }
        }

        // Default: general settings (preview only as per your existing implementation).
        $request->validate([
            'app_name' => ['nullable', 'string', 'max:255'],
            'app_url' => ['nullable', 'string', 'max:255'],
            'mail_from' => ['nullable', 'email', 'max:255'],
        ]);

        return back()->with('status', 'Settings saved (preview only).');
    }
}

