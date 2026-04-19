@props(['monthly'])

@php
    $basic = (float) ($monthly['basic_salary'] ?? 0);
    $allow = (float) ($monthly['allowance'] ?? 0);
    $commission = (float) ($monthly['commission'] ?? 0);
    $break = $monthly['commission_breakdown'] ?? [];

    $tier1Cap = (float) config('salary.tier1_cap');
    $tier1Rate = (float) config('salary.tier1_rate');
    $tier2Rate = (float) config('salary.tier2_rate');

    $tier1Sales = (float) ($break['tier1_sales'] ?? 0);
    $tier1Comm = (float) ($break['tier1_commission'] ?? 0);
    $tier2Sales = (float) ($break['tier2_sales'] ?? 0);
    $tier2Comm = (float) ($break['tier2_commission'] ?? 0);

    $bonusEarned = !empty($monthly['bonus_earned']);
    $bonus = (float) ($monthly['bonus'] ?? 0);
    $totalSalary = (float) ($monthly['total_salary'] ?? 0);
@endphp

<div class="border border-glaciar-gray-200 rounded-lg p-4 font-mono text-xs text-glaciar-black bg-glaciar-gray-50/40">
    <div class="grid grid-cols-2 gap-3 mb-3">
        <div class="text-glaciar-gray-600">Basic Salary</div>
        <div class="text-right font-semibold">LKR {{ number_format($basic, 0) }}</div>

        <div class="text-glaciar-gray-600">Allowance</div>
        <div class="text-right font-semibold">LKR {{ number_format($allow, 0) }}</div>
    </div>

    <div class="border-t border-glaciar-gray-200 my-3"></div>

    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-glaciar-gray-600">
                First LKR {{ number_format($tier1Cap, 0) }} @ {{ number_format($tier1Rate * 100, 0) }}%
            </span>
            <span class="font-semibold">= LKR {{ number_format($tier1Comm, 0) }}</span>
        </div>

        <div class="flex items-center justify-between">
            <span class="text-glaciar-gray-600">
                Next LKR {{ number_format($tier2Sales, 0) }} @ {{ number_format($tier2Rate * 100, 0) }}%
            </span>
            <span class="font-semibold">= LKR {{ number_format($tier2Comm, 0) }}</span>
        </div>

        <div class="flex items-center justify-between font-semibold">
            <span>Total Commission</span>
            <span>LKR {{ number_format($commission, 0) }}</span>
        </div>
    </div>

    <div class="border-t border-glaciar-gray-200 my-3"></div>

    <div class="flex items-center justify-between">
        <span class="text-glaciar-gray-600">Target Bonus</span>

        @if($bonusEarned)
            <span class="font-semibold">LKR {{ number_format($bonus, 0) }} &nbsp;<span class="text-green-700">&#10003;</span></span>
        @else
            <span class="font-semibold">LKR 0 &nbsp;<span class="text-red-700">&#10007;</span></span>
        @endif
    </div>

    <div class="border-t border-glaciar-gray-200 my-3"></div>

    <div class="flex items-center justify-between text-base font-bold">
        <span>Total Salary</span>
        <span>LKR {{ number_format($totalSalary, 0) }}</span>
    </div>
</div>

