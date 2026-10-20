@extends('layouts.admin')

@section('header', 'Tank Cleaning')

@section('content')
    <x-admin.reports.report-page-header title="Tank Cleaning Checklist" description="Per-tank cleaning verification" routeKey="tank-cleaning" />

    <div class="mt-6">
        <x-admin.data-table :columns="['Date', 'Tank No.', 'Frequency', 'Cleaned', 'Method', 'Checked By', 'Actions']" :items="$records">
            @forelse($records as $index => $r)
                <tr class="table-row-hover transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $r->date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $r->tank_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $r->frequency }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($r->cleaned === 'Yes')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Yes</span>
                        @elseif($r->cleaned === 'No')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">No</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Partial</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $r->cleaning_method }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $r->checked_by }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button onclick="deleteRecord({{ $r->id }})" class="text-red-500 hover:text-red-700 font-semibold transition-colors">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center bg-white">
                        <svg class="mx-auto h-12 w-12 text-glaciar-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-glaciar-gray-500 font-medium">No records found for this period</p>
                    </td>
                </tr>
            @endforelse
        </x-admin.data-table>
        
        <div class="mt-4">
            {{ $records->links() }}
        </div>
    </div>

    <x-admin.reports.report-entry-modal modalId="entry-modal-tank" title="Tank Cleaning Entry">
        <form id="entry-modal-tank-form" @submit.prevent="submitForm">
            @csrf <input type="hidden" name="_method" id="tank-method" value="POST">
            <input type="hidden" name="id" id="tank-id" value="">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><label class="block text-sm mb-1">Date</label><input type="date" name="date" value="{{ now()->format('Y-m-d') }}" class="w-full border rounded px-3 py-2" required></div>
                <div><label class="block text-sm mb-1">Tank Number</label><input type="text" name="tank_number" placeholder="T-01" class="w-full border rounded px-3 py-2" required></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><label class="block text-sm mb-1">Frequency</label>
                    <select name="frequency" class="w-full border rounded px-3 py-2"><option>Daily</option><option>Weekly</option><option>Monthly</option><option>Quarterly</option><option>As Needed</option></select>
                </div>
                <div><label class="block text-sm mb-1">Cleaned</label>
                    <select name="cleaned" class="w-full border rounded px-3 py-2"><option value="Yes">Yes</option><option value="No">No</option><option value="Partial">Partial</option></select>
                </div>
            </div>
            <div class="mb-4"><label class="block text-sm mb-1">Cleaning Method</label><input type="text" name="cleaning_method" class="w-full border rounded px-3 py-2"></div>
            <div class="mb-4"><label class="block text-sm mb-1">Chemical Used</label><input type="text" name="chemical_used" class="w-full border rounded px-3 py-2"></div>
            <x-admin.reports.checked-by-field />
        </form>
    </x-admin.reports.report-entry-modal>

    <script>
    function submitForm() {
        const fd = new FormData(document.getElementById('entry-modal-tank-form'));
        fetch('/admin/reports/tank-cleaning', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: fd })
        .then(r => r.json()).then(() => location.reload());
    }
    function deleteRecord(id) { if(confirm('Delete?')) fetch(`/admin/reports/tank-cleaning/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).then(() => location.reload()); }
    </script>
@endsection