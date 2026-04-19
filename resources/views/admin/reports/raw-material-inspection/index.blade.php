@extends('layouts.admin')
@section('header', 'Raw Material Inspection')
@section('content')
    <x-admin.reports.report-page-header title="Raw Material Inspection" description="Supplier material inspection" routeKey="raw-material-inspection" />
    <div class="mt-6 bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="min-w-full divide-y divide-glaciar-gray-100">
            <thead class="bg-glaciar-black"><tr><th class="px-4 py-3 text-left text-xs font-medium text-white">Date</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Supplier</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Material</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Qty</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Result</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Actions</th></tr></thead>
            <tbody class="bg-white divide-y">
                @forelse($records as $i => $r)
                <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-[#F9F9F9]' }}">
                    <td class="px-4 py-3 text-sm">{{ $r->date->format('d M Y') }}</td><td class="px-4 py-3 text-sm">{{ $r->supplier }}</td>
                    <td class="px-4 py-3 text-sm">{{ $r->material_type }}</td><td class="px-4 py-3 text-sm">{{ $r->quantity_received }} {{ $r->unit }}</td>
                    <td class="px-4 py-3 text-sm">@if($r->overall_result==='Accepted')<span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Accepted</span>@elseif($r->overall_result==='Rejected')<span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Rejected</span>@else<span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">With Condition</span>@endif</td>
                    <td class="px-4 py-3 text-sm"><button onclick="deleteRecord({{ $r->id }})" class="text-red-600">Delete</button></td>
                </tr>
                @empty<tr><td colspan="6" class="px-6 py-8 text-center">No records</td></tr>@endforelse
            </tbody>
        </table>
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