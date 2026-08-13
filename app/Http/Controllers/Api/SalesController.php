<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesRequest;
use App\Models\CasePrice;
use App\Models\SalesRecord;
use App\Services\SalaryCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SalesController extends Controller
{
    public function store(StoreSalesRequest $request)
    {
        $user = $request->user();
        $repId = $user->rep?->id;

        $cases = [
            '500ml' => (int) $request->input('cases_500ml', 0),
            '1000ml' => (int) $request->input('cases_1000ml', 0),
            '1500ml' => (int) $request->input('cases_1500ml', 0),
            '5000ml' => (int) $request->input('cases_5000ml', 0),
        ];

        // Step 2 (spec): load current case prices.
        // This also warms CasePrice::current() cache.
        CasePrice::current('500ml');
        CasePrice::current('1000ml');
        CasePrice::current('1500ml');
        CasePrice::current('5000ml');

        $calculator = new SalaryCalculatorService();
        $result = $calculator->calculate($cases);

        DB::beginTransaction();
        try {
            $sale = SalesRecord::create([
                'rep_id' => $repId,
                'date' => $request->input('date'),

                'cases_500ml' => $cases['500ml'],
                'cases_1000ml' => $cases['1000ml'],
                'cases_1500ml' => $cases['1500ml'],
                'cases_5000ml' => $cases['5000ml'],

                'revenue_500ml' => $result['revenue_by_product']['500ml']['revenue'],
                'revenue_1000ml' => $result['revenue_by_product']['1000ml']['revenue'],
                'revenue_1500ml' => $result['revenue_by_product']['1500ml']['revenue'],
                'revenue_5000ml' => $result['revenue_by_product']['5000ml']['revenue'],

                'total_sales' => $result['total_sales'],
                'total_cost' => $result['total_cost'],
                'gross_profit' => $result['gross_profit'],

                'commission' => $result['commission'],
                'bonus' => $result['bonus'],
                'total_salary' => $result['total_salary'],
                'net_profit' => $result['net_profit'],

                'notes' => $request->input('notes'),

                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            // Deduct stock for each size sold
            $inventoryService = app(\App\Services\InventoryService::class);
            
            foreach ($cases as $sizeLabel => $caseQty) {
                if ($caseQty > 0) {
                    $sizeMl = (int) str_replace('ml', '', $sizeLabel);
                    
                    // Get bottles per case for this size
                    $casePriceRow = \App\Models\CasePrice::active()->where('product_size', $sizeLabel)->first();
                    $bottlesPerCase = $casePriceRow ? $casePriceRow->bottles_per_case : 24;
                    
                    $totalBottles = $caseQty * $bottlesPerCase;

                    // Find the active product corresponding to this size
                    $product = \App\Models\Product::where('size_ml', $sizeMl)->where('status', 'active')->first();
                    
                    if ($product) {
                        $inventoryService->adjustStock(
                            $product,
                            -$totalBottles, // deduct
                            'sale',
                            'Sales Rep Submission',
                            'Sale Record ID: ' . $sale->id,
                            $user->id,
                            'Sale',
                            $sale->id
                        );
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $this->formatSaleForApi($sale),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to store sales record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $repId = $user->rep?->id;

        $year = (int) $request->query('year', now()->year);
        $month = (int) $request->query('month', now()->month);

        $from = now()->setYear($year)->setMonth($month)->startOfMonth()->toDateString();
        $to = now()->setYear($year)->setMonth($month)->endOfMonth()->toDateString();

        $records = SalesRecord::query()
            ->where('rep_id', $repId)
            ->whereBetween('date', [$from, $to])
            ->orderBy('date', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $records->map(fn (SalesRecord $sale) => $this->formatSaleForApi($sale)),
        ]);
    }

    public function show(Request $request, int $id)
    {
        $user = $request->user();
        $repId = $user->rep?->id;

        $sale = SalesRecord::query()
            ->where('rep_id', $repId)
            ->where('id', $id)
            ->first();

        if (!$sale) {
            return response()->json([
                'success' => false,
                'message' => 'Sales record not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatSaleForApi($sale),
        ]);
    }

    public function summaryForMonth(Request $request)
    {
        $user = $request->user();
        $repId = $user->rep?->id;

        $year = (int) $request->query('year', now()->year);
        $month = (int) $request->query('month', now()->month);

        $calculator = new SalaryCalculatorService();
        $result = $calculator->calculateForMonth((int) $repId, $year, $month);

        return response()->json([
            'success' => true,
            'data' => [
                'month' => $month,
                'year' => $year,
                ...$result,
            ],
        ]);
    }

    public function casePrices()
    {
        $sizes = ['500ml', '1000ml', '1500ml', '5000ml'];
        $data = [];

        foreach ($sizes as $size) {
            $row = \App\Models\CasePrice::query()
                ->active()
                ->where('product_size', $size)
                ->orderBy('effective_from', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $data[$size] = [
                'price_per_case' => (float) ($row?->price_per_case ?? CasePrice::current($size)),
                'bottles_per_case' => (int) ($row?->bottles_per_case ?? 24),
                'effective_from' => $row?->effective_from?->toDateString(),
                'is_active' => (bool) ($row?->is_active ?? true),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    private function formatSaleForApi(SalesRecord $sale): array
    {
        $breakdown = $sale->commission_tier_breakdown;

        return [
            'sale_id' => (int) $sale->id,
            'date' => $sale->date->toDateString(),

            'total_sales' => (float) $sale->total_sales,
            'total_cost' => (float) $sale->total_cost,
            'gross_profit' => (float) $sale->gross_profit,
            'commission' => (float) $sale->commission,

            'commission_breakdown' => [
                'tier1_sales' => (float) $breakdown['tier1_sales'],
                'tier1_commission' => (float) $breakdown['tier1_amount'],
                'tier2_sales' => (float) $breakdown['tier2_sales'],
                'tier2_commission' => (float) $breakdown['tier2_amount'],
            ],

            'bonus' => (float) $sale->bonus,
            'bonus_earned' => (bool) ($sale->bonus > 0),

            'basic_salary' => (float) config('salary.basic_salary'),
            'allowance' => (float) config('salary.allowance'),
            'total_salary' => (float) $sale->total_salary,
            'net_profit' => (float) $sale->net_profit,

            'revenue_by_product' => [
                '500ml' => [
                    'cases' => (int) $sale->cases_500ml,
                    'revenue' => (float) $sale->revenue_500ml,
                ],
                '1000ml' => [
                    'cases' => (int) $sale->cases_1000ml,
                    'revenue' => (float) $sale->revenue_1000ml,
                ],
                '1500ml' => [
                    'cases' => (int) $sale->cases_1500ml,
                    'revenue' => (float) $sale->revenue_1500ml,
                ],
                '5000ml' => [
                    'cases' => (int) $sale->cases_5000ml,
                    'revenue' => (float) $sale->revenue_5000ml,
                ],
            ],

            'status' => $sale->status,
            'submitted_at' => $sale->submitted_at?->toDateTimeString(),
            'verified_at' => $sale->verified_at?->toDateTimeString(),
        ];
    }
}

