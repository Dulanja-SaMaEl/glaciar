@props(['columns', 'items', 'emptyMessage' => 'No records found.'])

<div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden" x-data="dataTable()">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-glaciar-gray-100">
            <thead class="bg-glaciar-gray-50">
                <tr>
                    @foreach($columns as $key => $label)
                        <th scope="col" 
                            @if($key !== 'actions' && $label !== '') @click="sortBy({{ $loop->index }})" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider cursor-pointer hover:bg-glaciar-gray-100 transition-colors" @else class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider" @endif>
                            <div class="flex items-center space-x-1">
                                <span>{{ $label }}</span>
                                @if($key !== 'actions' && $label !== '')
                                    <template x-if="sortCol === {{ $loop->index }}">
                                        <svg x-show="sortAsc" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    </template>
                                    <template x-if="sortCol === {{ $loop->index }}">
                                        <svg x-show="!sortAsc" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </template>
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-glaciar-gray-100">
                {{ $slot }}
                
                @if(method_exists($items, 'isEmpty') ? $items->isEmpty() : empty($items))
                    <tr>
                        <td colspan="{{ count($columns) }}" class="px-6 py-8 text-center text-glaciar-gray-500">
                            {{ $emptyMessage }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    @if($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="px-6 py-3 border-t border-glaciar-gray-100 bg-glaciar-gray-50">
            {{ $items->links() }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dataTable', () => ({
            sortCol: null,
            sortAsc: true,
            
        sortBy(colIndex) {
            if (this.sortCol === colIndex) {
                    this.sortAsc = !this.sortAsc;
                } else {
                this.sortCol = colIndex;
                    this.sortAsc = true;
                }
                
                // Extremely simple DOM-based sorting for all Alpine js data tables
                // Assumes rows have data-sort-val-* attributes or uses innerText
                const tbody = this.$el.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr:not(.no-sort)'));
                
                if (rows.length <= 1) return;

                rows.sort((a, b) => {
                const aCell = a.children[colIndex];
                const bCell = b.children[colIndex];
                    
                    if (!aCell || !bCell) return 0;
                    
                    let aVal = aCell.getAttribute('data-sort') || aCell.innerText.trim();
                    let bVal = bCell.getAttribute('data-sort') || bCell.innerText.trim();
                    
                    // Simple number detection
                    if (!isNaN(parseFloat(aVal)) && isFinite(aVal)) aVal = parseFloat(aVal);
                    if (!isNaN(parseFloat(bVal)) && isFinite(bVal)) bVal = parseFloat(bVal);
                    
                    if (aVal < bVal) return this.sortAsc ? -1 : 1;
                    if (aVal > bVal) return this.sortAsc ? 1 : -1;
                    return 0;
                });
                
                rows.forEach(row => tbody.appendChild(row));
                
                // Fix zebra striping classes manually if using CSS :nth-child
                // Here we let CSS handle it because the DOM order changed
            }
        }))
    });
</script>
