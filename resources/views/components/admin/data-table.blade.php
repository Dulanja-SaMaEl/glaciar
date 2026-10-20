@props(['columns', 'items', 'emptyMessage' => 'No records found.'])

<div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-slate-200/80 dark:border-white/10 overflow-hidden" x-data="dataTable()">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full divide-y divide-slate-100 dark:divide-white/10">
            <thead class="bg-slate-50/80 dark:bg-white/[0.03] backdrop-blur-md sticky top-0 z-10">
                <tr>
                    @foreach($columns as $key => $label)
                        <th scope="col" 
                            @if($key !== 'actions' && $label !== '') @click="sortBy({{ $loop->index }})" class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider cursor-pointer hover:text-cyan-500 dark:hover:text-cyan-400 transition-colors" @else class="px-6 py-4 text-left text-xs font-mono font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider" @endif>
                            <div class="flex items-center space-x-2">
                                <span>{{ $label }}</span>
                                @if($key !== 'actions' && $label !== '')
                                    <template x-if="sortCol === {{ $loop->index }}">
                                        <svg x-show="sortAsc" class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                                    </template>
                                    <template x-if="sortCol === {{ $loop->index }}">
                                        <svg x-show="!sortAsc" class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                    </template>
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-white/5 bg-white dark:bg-[#0d1522]">
                {{ $slot }}
                
                @if(method_exists($items, 'isEmpty') ? $items->isEmpty() : empty($items))
                    <tr>
                        <td colspan="{{ count($columns) }}" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-12 h-12 mb-3 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-sm font-medium">{{ $emptyMessage }}</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    @if($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="px-6 py-4 border-t border-slate-200/80 dark:border-white/10 bg-slate-50/50 dark:bg-white/[0.02]">
            {{ $items->links() }}
        </div>
    @endif
</div>

<style>
    /* Styling injected rows to match hover effects */
    tbody tr:not(.no-hover) {
        transition: all 0.15s ease-in-out;
    }
    tbody tr:not(.no-hover):hover {
        background-color: rgba(248, 250, 252, 0.8);
    }
    .dark tbody tr:not(.no-hover):hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }
</style>

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
