@extends('layouts.admin')
@section('header', 'Daily Cleaning')
@section('content')
    <x-admin.reports.report-page-header title="Daily Cleaning Checklist" description="Factory area hygiene check" routeKey="daily-cleaning" />
    <div class="mt-6">
        <x-admin.data-table :columns="['Date', 'Shift', 'Status', 'Checked By', 'Actions']" :items="$records">
            @forelse($records as $index => $r)
                <tr class="table-row-hover transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $r->date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $r->shift }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($r->overall_status === 'Complete')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Complete</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">{{ $r->overall_status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $r->checked_by }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button onclick="deleteRecord({{ $r->id }})" class="text-red-500 hover:text-red-700 font-semibold transition-colors">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center bg-white">
                        <svg class="mx-auto h-12 w-12 text-glaciar-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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