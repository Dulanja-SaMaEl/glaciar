@extends('layouts.admin')
@section('header', 'Daily Cleaning')
@section('content')
    <x-admin.reports.report-page-header title="Daily Cleaning Checklist" description="Factory area hygiene check" routeKey="daily-cleaning" />
    <div class="mt-6 bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="min-w-full divide-y divide-glaciar-gray-100">
            <thead class="bg-glaciar-black"><tr><th class="px-4 py-3 text-left text-xs font-medium text-white">Date</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Shift</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Status</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Checked By</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Actions</th></tr></thead>
            <tbody class="bg-white divide-y">
                @forelse($records as $i => $r)
                <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-[#F9F9F9]' }}">
                    <td class="px-4 py-3 text-sm">{{ $r->date->format('d M Y') }}</td><td class="px-4 py-3 text-sm">{{ $r->shift }}</td>
                    <td class="px-4 py-3 text-sm">@if($r->overall_status==='Complete')<span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Complete</span>@else<span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">{{ $r->overall_status }}</span>@endif</td>
                    <td class="px-4 py-3 text-sm">{{ $r->checked_by }}</td>
                    <td class="px-4 py-3 text-sm"><button onclick="deleteRecord({{ $r->id }})" class="text-red-600">Delete</button></td>
                </tr>
                @empty<tr><td colspan="5" class="px-6 py-8 text-center">No records</td></tr>@endforelse
            </tbody>
        </table>
    </div>
    <x-admin.reports.report-entry-modal modalId="entry-modal-cleaning" title="Daily Cleaning Entry">
        <form id="entry-modal-cleaning-form" @submit.prevent="submitForm">
            @csrf <input type="hidden" name="_method" value="POST">
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Date</label><input type="date" name="date" value="{{ now()->format('Y-m-d') }}" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">Shift</label><select name="shift" class="w-full border rounded px-3 py-2"><option>Morning</option><option>Afternoon</option><option>Evening</option><option>Night</option></select></div></div>
            <p class="text-sm font-medium mb-2">Factory Entrance</p>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <select name="fe_floor" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fe_windows" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fe_door" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fe_cupboard" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fe_foot_bath" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
            </div>
            <p class="text-sm font-medium mb-2">Filter Area</p>
            <div class="grid grid-cols-3 gap-2 mb-4">
                <select name="fa_wall" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fa_floor" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fa_roof" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
            </div>
            <p class="text-sm font-medium mb-2">Filling Area</p>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <select name="fill_wall" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fill_floor" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fill_roof" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fill_table" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fill_taps" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
                <select name="fill_pipes" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select>
            </div>
            <div class="mb-4"><select name="st_wall" class="border rounded px-2 py-1 text-sm"><option>Done</option><option>Not Done</option><option>N/A</option></select></div>
            <x-admin.reports.checked-by-field />
        </form>
    </x-admin.reports.report-entry-modal>
    <script>function submitForm(){const fd=new FormData(document.getElementById('entry-modal-cleaning-form'));fetch('/admin/reports/daily-cleaning',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},body:fd}).then(r=>r.json()).then(()=>location.reload())}function deleteRecord(id){if(confirm('Delete?'))fetch(`/admin/reports/daily-cleaning/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}).then(()=>location.reload())}</script>
@endsection