@props(['records' => collect([]), 'columns' => []])

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-glaciar-gray-100">
        <thead class="bg-glaciar-black">
            <tr>
                @foreach($columns as $column)
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider whitespace-nowrap">
                        {{ $column }}
                    </th>
                @endforeach
                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-glaciar-gray-100">
            @forelse($records as $index => $record)
                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#F9F9F9]' }}">
                    {{ $slot }}
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + 1 }}" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-glaciar-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-glaciar-gray-500">No records found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>