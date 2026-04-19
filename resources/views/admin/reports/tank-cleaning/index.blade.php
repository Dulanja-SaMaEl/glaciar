@extends('layouts.admin')

@section('header', 'Tank Cleaning')

@section('content')
    <x-admin.reports.report-page-header title="Tank Cleaning Checklist" description="Per-tank cleaning verification" routeKey="tank-cleaning" />

    <div class="mt-6 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-glaciar-gray-100">
            <thead class="bg-glaciar-black">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Tank No.</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Frequency</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Cleaned</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Method</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Checked By</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-glaciar-gray-100">
                @forelse($records as $i => $r)
                <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-[#F9F9F9]' }}">
                    <td class="px-4 py-3 text-sm">{{ $r->date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-sm font-medium">{{ $r->tank_number }}</td>
                    <td class="px-4 py-3 text-sm">{{ $r->frequency }}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($r->cleaned === 'Yes')
                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Yes</span>
                        @elseif($r->cleaned === 'No')
                            <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">No</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">Partial</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $r->cleaning_method }}</td>
                    <td class="px-4 py-3 text-sm">{{ $r->checked_by }}</td>
                    <td class="px-4 py-3 text-sm">
                        <button onclick="deleteRecord({{ $r->id }})" class="text-red-600">Delete</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-glaciar-gray-500">No records</td></tr>
                @endforelse
            </tbody>
        </table>
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