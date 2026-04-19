@extends('layouts.admin')
@section('header', 'UV Bulb Monitoring')
@section('content')
    <x-admin.reports.report-page-header title="UV Bulb Monitoring" description="UV lamp usage tracking" routeKey="uv-bulb-monitoring" />
    
    @if(!empty($bulbSummary))
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach($bulbSummary as $bulb)
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="font-bold text-lg">{{ $bulb['bulb_id'] }}</span>
                @if($bulb['status']==='Good')
                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Good</span>
                @elseif($bulb['status']==='Replace Soon')
                    <span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">Replace Soon</span>
                @else
                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Replace Now</span>
                @endif
            </div>
            <p class="text-sm text-glaciar-gray-500 mb-2">{{ $bulb['location'] }}</p>
            <div class="text-sm">{{ $bulb['remaining_percentage'] }}% remaining ({{ number_format($bulb['remaining_hours']) }} hrs)</div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="min-w-full divide-y divide-glaciar-gray-100">
            <thead class="bg-glaciar-black"><tr><th class="px-4 py-3 text-left text-xs font-medium text-white">Date</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Bulb ID</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Location</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Hours</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Cumulative</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Remaining</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Status</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Actions</th></tr></thead>
            <tbody class="bg-white divide-y">
                @forelse($records as $i => $r)
                <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-[#F9F9F9]' }}">
                    <td class="px-4 py-3 text-sm">{{ $r->date->format('d M Y') }}</td><td class="px-4 py-3 text-sm">{{ $r->bulb_id }}</td><td class="px-4 py-3 text-sm">{{ $r->bulb_location }}</td>
                    <td class="px-4 py-3 text-sm">{{ $r->running_hours }}</td><td class="px-4 py-3 text-sm">{{ $r->cumulative_hours }}</td><td class="px-4 py-3 text-sm">{{ $r->remaining_percentage }}%</td>
                    <td class="px-4 py-3 text-sm">@if($r->status==='Good')<span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Good</span>@elseif($r->status==='Replace Soon')<span class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">Replace Soon</span>@else<span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Replace Now</span>@endif</td>
                    <td class="px-4 py-3 text-sm"><button onclick="deleteRecord({{ $r->id }})" class="text-red-600">Delete</button></td>
                </tr>
                @empty<tr><td colspan="8" class="px-6 py-8 text-center">No records</td></tr>@endforelse
            </tbody>
        </table>
    </div>
    <x-admin.reports.report-entry-modal modalId="entry-modal-uv" title="UV Bulb Entry">
        <form id="entry-modal-uv-form" @submit.prevent="submitForm">
            @csrf <input type="hidden" name="_method" value="POST">
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Date</label><input type="date" name="date" value="{{ now()->format('Y-m-d') }}" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">Bulb ID</label><input type="text" name="bulb_id" placeholder="UV-01" class="w-full border rounded px-3 py-2"></div></div>
            <div class="mb-4"><label class="block text-sm mb-1">Location</label><input type="text" name="bulb_location" class="w-full border rounded px-3 py-2"></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Start Time</label><input type="time" name="start_time" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">Finish Time</label><input type="time" name="finish_time" class="w-full border rounded px-3 py-2"></div></div>
            <x-admin.reports.checked-by-field />
        </form>
    </x-admin.reports.report-entry-modal>
    <script>function submitForm(){const fd=new FormData(document.getElementById('entry-modal-uv-form'));fetch('/admin/reports/uv-bulb-monitoring',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},body:fd}).then(r=>r.json()).then(()=>location.reload())}function deleteRecord(id){if(confirm('Delete?'))fetch(`/admin/reports/uv-bulb-monitoring/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}).then(()=>location.reload())}</script>
@endsection