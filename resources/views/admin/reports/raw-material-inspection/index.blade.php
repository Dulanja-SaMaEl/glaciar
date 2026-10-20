@extends('layouts.admin')
@section('header', 'Raw Material Inspection')
@section('content')
    <x-admin.reports.report-page-header title="Raw Material Inspection" description="Supplier material inspection" routeKey="raw-material-inspection" />
    <div class="mt-6">
        <x-admin.data-table :columns="['Date', 'Supplier', 'Material', 'Qty', 'Result', 'Actions']" :items="$records">
            @forelse($records as $index => $r)
                <tr class="table-row-hover transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $r->date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $r->supplier }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $r->material_type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $r->quantity_received }} {{ $r->unit }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($r->overall_result === 'Accepted')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Accepted</span>
                        @elseif($r->overall_result === 'Rejected')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">With Condition</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button onclick="deleteRecord({{ $r->id }})" class="text-red-500 hover:text-red-700 font-semibold transition-colors">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center bg-white">
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
    <x-admin.reports.report-entry-modal modalId="entry-modal-material" title="Material Inspection Entry">
        <form id="entry-modal-material-form" @submit.prevent="submitForm">
            @csrf <input type="hidden" name="_method" id="material-method" value="POST">
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Date</label><input type="date" name="date" value="{{ now()->format('Y-m-d') }}" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">Supplier</label><input type="text" name="supplier" class="w-full border rounded px-3 py-2"></div></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Material Type</label><input type="text" name="material_type" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">Quantity</label><input type="number" name="quantity_received" class="w-full border rounded px-3 py-2"></div></div>
            <div class="mb-4"><label class="block text-sm mb-1">Unit</label><input type="text" name="unit" placeholder="cartons" class="w-full border rounded px-3 py-2"></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Clearness</label><select name="clearness" class="w-full border rounded px-3 py-2"><option>Pass</option><option>Fail</option></select></div><div><label class="block text-sm mb-1">Odor</label><select name="odor" class="w-full border rounded px-3 py-2"><option>Normal</option><option>Abnormal</option></select></div></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Without Damages</label><select name="without_damages" class="w-full border rounded px-3 py-2"><option value="Yes">Yes</option><option value="No">No</option></select></div><div><label class="block text-sm mb-1">Free from Particles</label><select name="free_from_particles" class="w-full border rounded px-3 py-2"><option value="Yes">Yes</option><option value="No">No</option></select></div></div>
            <div class="mb-4"><label class="block text-sm mb-1">Overall Result</label><select name="overall_result" class="w-full border rounded px-3 py-2"><option>Accepted</option><option>Rejected</option><option>Accepted with condition</option></select></div>
            <x-admin.reports.checked-by-field />
        </form>
    </x-admin.reports.report-entry-modal>
    <script>function submitForm(){const fd=new FormData(document.getElementById('entry-modal-material-form'));fetch('/admin/reports/raw-material-inspection',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},body:fd}).then(r=>r.json()).then(()=>location.reload())}function deleteRecord(id){if(confirm('Delete?'))fetch(`/admin/reports/raw-material-inspection/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}).then(()=>location.reload())}</script>
@endsection