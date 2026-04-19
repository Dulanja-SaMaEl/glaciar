@props(['name', 'label', 'value' => ''])

<div class="mb-4">
    <label class="block text-sm font-medium text-glaciar-black mb-2">{{ $label }}</label>
    <select 
        name="{{ $name }}" 
        class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-glaciar-black focus:border-glaciar-black transition-colors
        {{ $value === 'Yes' || $value === 'Pass' || $value === 'Clear' || $value === 'Done' || $value === 'Normal' ? 'border-green-500 bg-green-50' : '' }}
        {{ $value === 'No' || $value === 'Fail' || $value === 'Issue' || $value === 'Not Done' || $value === 'Abnormal' ? 'border-red-500 bg-red-50' : '' }}"
    >
        <option value="">Select...</option>
        <option value="Yes" {{ $value === 'Yes' ? 'selected' : '' }}>Yes</option>
        <option value="No" {{ $value === 'No' ? 'selected' : '' }}>No</option>
        <option value="N/A" {{ $value === 'N/A' ? 'selected' : '' }}>N/A</option>
    </select>
</div>