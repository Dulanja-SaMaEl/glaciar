@extends('layouts.admin')
@section('header', 'Raw Water Testing')
@section('content')
    <x-admin.reports.report-page-header title="Raw Water Testing" description="Incoming water quality record" routeKey="raw-water-testing" />
    <div class="mt-6 bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="min-w-full divide-y divide-glaciar-gray-100">
            <thead class="bg-glaciar-black"><tr><th class="px-4 py-3 text-left text-xs font-medium text-white">Date</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Time</th><th class="px-4 py-3 text-left text-xs font-medium text-white">TDS</th><th class="px-4 py-3 text-left text-xs font-medium text-white">pH</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Taste</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Odor</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Result</th><th class="px-4 py-3 text-left text-xs font-medium text-white">Actions</th></tr></thead>
            <tbody class="bg-white divide-y">
                @forelse($records as $i => $r)
                <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-[#F9F9F9]' }}">
                    <td class="px-4 py-3 text-sm">{{ $r->date->format('d M Y') }}</td><td class="px-4 py-3 text-sm">{{ $r->test_time }}</td>
                    <td class="px-4 py-3 text-sm @if($r->tds < 500)text-green-600@elseif($r->tds >= 1000)text-red-600@else text-amber-600 @endif">{{ $r->tds }} ppm</td>
                    <td class="px-4 py-3 text-sm @if($r->ph >= 6.5 && $r->ph <= 8.5)text-green-600@else text-red-600 @endif">{{ $r->ph }}</td>
                    <td class="px-4 py-3 text-sm">{{ $r->taste }}</td><td class="px-4 py-3 text-sm">{{ $r->odor }}</td>
                    <td class="px-4 py-3 text-sm">@if($r->result === 'Pass')<span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Pass</span>@else<span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Fail</span>@endif</td>
                    <td class="px-4 py-3 text-sm"><button onclick="deleteRecord({{ $r->id }})" class="text-red-600">Delete</button></td>
                </tr>
                @empty<tr><td colspan="8" class="px-6 py-8 text-center">No records</td></tr>@endforelse
            </tbody>
        </table>
    </div>
    <x-admin.reports.report-entry-modal modalId="entry-modal-raw" title="Raw Water Test Entry">
        <form id="entry-modal-raw-form" @submit.prevent="submitForm">
            @csrf <input type="hidden" name="_method" id="raw-method" value="POST">
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Date</label><input type="date" name="date" value="{{ now()->format('Y-m-d') }}" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">Time</label><input type="time" name="test_time" value="{{ now()->format('H:i') }}" class="w-full border rounded px-3 py-2"></div></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">TDS (ppm)</label><input type="number" name="tds" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">pH</label><input type="number" step="0.01" name="ph" class="w-full border rounded px-3 py-2"></div></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Taste</label><select name="taste" class="w-full border rounded px-3 py-2"><option>Normal</option><option>Abnormal</option></select></div><div><label class="block text-sm mb-1">Odor</label><select name="odor" class="w-full border rounded px-3 py-2"><option>Normal</option><option>Abnormal</option></select></div></div>
            <div class="mb-4"><label class="block text-sm mb-1">Appearance</label><select name="appearance" class="w-full border rounded px-3 py-2"><option>Clear</option><option>Turbid</option><option>Colored</option><option>Other</option></select></div>
            <x-admin.reports.checked-by-field />
        </form>
    </x-admin.reports.report-entry-modal>
    <script>function submitForm(){const fd=new FormData(document.getElementById('entry-modal-raw-form'));fetch('/admin/reports/raw-water-testing',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},body:fd}).then(r=>r.json()).then(()=>location.reload())}function deleteRecord(id){if(confirm('Delete?'))fetch(`/admin/reports/raw-water-testing/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}).then(()=>location.reload())}</script>
@endsection