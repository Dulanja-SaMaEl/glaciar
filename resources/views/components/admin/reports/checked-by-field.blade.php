@props(['name' => 'checked_by', 'value' => ''])

<div class="mb-4">
    <label class="block text-sm font-medium text-glaciar-black mb-2">Checked By</label>
    <input 
        type="text" 
        name="{{ $name }}" 
        value="{{ $value ?: (Auth::user()?->name ?? '') }}"
        class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-glaciar-black focus:border-glaciar-black transition-colors"
        placeholder="Enter name"
    >
    <p class="mt-1 text-xs text-glaciar-gray-400">Auto-filled from your login</p>
</div>