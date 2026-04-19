@extends('layouts.admin')

@section('header', 'Settings')

@section('content')
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif
    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <div class="p-6 border-b border-glaciar-gray-100 flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-glaciar-black">Settings</h3>
                <p class="text-sm text-glaciar-gray-500 mt-1">
                    Manage application, salary rules, and case pricing.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="{{ route('admin.settings.index', ['tab' => 'general']) }}"
                    class="px-4 py-2 rounded-lg text-sm font-semibold border border-glaciar-gray-200 {{ ($activeTab ?? 'general') === 'general' ? 'bg-glaciar-black text-white border-glaciar-black' : 'bg-white text-glaciar-black hover:bg-glaciar-gray-50' }}"
                >
                    General
                </a>
                <a
                    href="{{ route('admin.settings.index', ['tab' => 'salary_pricing']) }}"
                    class="px-4 py-2 rounded-lg text-sm font-semibold border border-glaciar-gray-200 {{ ($activeTab ?? 'general') === 'salary_pricing' ? 'bg-glaciar-black text-white border-glaciar-black' : 'bg-white text-glaciar-black hover:bg-glaciar-gray-50' }}"
                >
                    Salary & Pricing
                </a>
            </div>
        </div>

        <div class="p-6">
            @if(($activeTab ?? 'general') === 'salary_pricing')
                <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="salary_pricing">

                    <div>
                        <h4 class="text-lg font-bold text-glaciar-black mb-2">Case Prices</h4>
                        <p class="text-sm text-glaciar-gray-500 mb-4">
                            These prices are versioned by <span class="font-semibold">Effective From</span>.
                        </p>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-glaciar-gray-100">
                                <thead class="bg-glaciar-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Product Size</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Bottles/Case</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Price per Case</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Effective From</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-glaciar-gray-100">
                                    @foreach(['500ml','1000ml','1500ml','5000ml'] as $size)
                                        @php
                                            $row = $casePrices[$size] ?? [];
                                            $effectiveFrom = $row['effective_from'] ?? now()->toDateString();
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-3 text-sm font-semibold text-glaciar-black">{{ $size }}</td>
                                            <td class="px-4 py-3">
                                                <input
                                                    type="number"
                                                    step="1"
                                                    name="case_prices[{{ $size }}][bottles_per_case]"
                                                    value="{{ old('case_prices.' . $size . '.bottles_per_case', $row['bottles_per_case'] ?? 24) }}"
                                                    class="w-28 border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm"
                                                >
                                            </td>
                                            <td class="px-4 py-3">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="case_prices[{{ $size }}][price_per_case]"
                                                    value="{{ old('case_prices.' . $size . '.price_per_case', $row['price_per_case'] ?? 0) }}"
                                                    class="w-32 border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm"
                                                >
                                            </td>
                                            <td class="px-4 py-3">
                                                <input
                                                    type="date"
                                                    name="case_prices[{{ $size }}][effective_from]"
                                                    value="{{ old('case_prices.' . $size . '.effective_from', $effectiveFrom) }}"
                                                    class="w-44 border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm"
                                                >
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <select
                                                        name="case_prices[{{ $size }}][is_active]"
                                                        class="border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm"
                                                    >
                                                        <option value="1" @selected(!empty($row['is_active']))>Active</option>
                                                        <option value="0" @selected(empty($row['is_active']))>Inactive</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <button type="button" class="px-4 py-2 rounded-lg bg-glaciar-gray-100 text-glaciar-gray-500 text-sm font-semibold cursor-not-allowed" disabled>
                                Add new price (future)
                            </button>
                            <span class="text-sm text-glaciar-gray-500">Save updates below.</span>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold text-glaciar-black mb-2">Salary Rules</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-glaciar-black mb-1">Basic Salary (LKR)</label>
                                <input type="number" step="0.01" name="basic_salary" value="{{ old('basic_salary', $salaryRules['basic_salary'] ?? 20000) }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-glaciar-black mb-1">Allowance (LKR)</label>
                                <input type="number" step="0.01" name="allowance" value="{{ old('allowance', $salaryRules['allowance'] ?? 8000) }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-glaciar-black mb-1">Commission Tier 1 (%)</label>
                                <input type="number" step="0.01" name="tier1_rate" value="{{ old('tier1_rate', (float)($salaryRules['tier1_rate'] ?? 0) * 100) }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-glaciar-black mb-1">Commission Tier 1 Cap (LKR)</label>
                                <input type="number" step="0.01" name="tier1_cap" value="{{ old('tier1_cap', $salaryRules['tier1_cap'] ?? 1200000) }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-glaciar-black mb-1">Commission Tier 2 (%)</label>
                                <input type="number" step="0.01" name="tier2_rate" value="{{ old('tier2_rate', (float)($salaryRules['tier2_rate'] ?? 0) * 100) }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-glaciar-black mb-1">Bonus Threshold (LKR)</label>
                                <input type="number" step="0.01" name="bonus_threshold" value="{{ old('bonus_threshold', $salaryRules['bonus_threshold'] ?? 1500000) }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-glaciar-black mb-1">Bonus Amount (LKR)</label>
                                <input type="number" step="0.01" name="bonus_amount" value="{{ old('bonus_amount', $salaryRules['bonus_amount'] ?? 20000) }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-glaciar-black mb-1">Business Cost Ratio (%)</label>
                                <input type="number" step="0.01" name="cost_ratio" value="{{ old('cost_ratio', (float)($salaryRules['cost_ratio'] ?? 0) * 100) }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>
                        </div>

                        <div class="mt-4 p-4 rounded-lg bg-amber-50 border border-amber-200 text-amber-900 text-sm">
                            Changing rules affects future calculations only.
                        </div>
                    </div>

                    <div class="pt-2">
                        <button class="px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-[#111]">
                            Save Rules
                        </button>
                    </div>
                </form>
            @else
                <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-glaciar-black mb-1">App name</label>
                        <input name="app_name" value="{{ old('app_name', $settings['app_name'] ?? '') }}"
                               class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-glaciar-black mb-1">App URL</label>
                        <input name="app_url" value="{{ old('app_url', $settings['app_url'] ?? '') }}"
                               class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-glaciar-black mb-1">Mail from address</label>
                        <input name="mail_from" value="{{ old('mail_from', $settings['mail_from'] ?? '') }}"
                               class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" />
                    </div>

                    <div class="pt-2">
                        <button class="px-4 py-2 rounded-lg bg-glaciar-black text-white text-sm font-semibold hover:bg-[#111]">
                            Save
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

