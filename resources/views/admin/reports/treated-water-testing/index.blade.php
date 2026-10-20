@extends('layouts.admin')
@section('header', 'Treated Water Testing')
@section('content')
    <x-admin.reports.report-page-header title="Treated Water Testing" description="Post-treatment quality record" routeKey="treated-water-testing" />
    <div class="mt-6">
        <x-admin.data-table :columns="['Date', 'TDS', 'pH', 'Foreign Imp.', 'Sealing', 'Result', 'Actions']" :items="$records">
            @forelse($records as $index => $r)
                <tr class="table-row-hover transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $r->date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm @if($r->tds < 500)text-emerald-600 font-bold @elseif($r->tds >= 1000)text-red-600 font-bold @else text-amber-600 font-bold @endif">{{ $r->tds }} ppm</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm @if($r->ph >= 6.5 && $r->ph <= 8.5)text-emerald-600 font-bold @else text-red-600 font-bold @endif">{{ $r->ph }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $r->foreign_impurities }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $r->sealing_quality }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($r->result === 'Pass')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Pass</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Fail</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button onclick="deleteRecord({{ $r->id }})" class="text-red-500 hover:text-red-700 font-semibold transition-colors">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center bg-white">
                        <svg class="mx-auto h-12 w-12 text-glaciar-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
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
    <x-admin.reports.report-entry-modal modalId="entry-modal-treated" title="Treated Water Test">
        <form id="entry-modal-treated-form" @submit.prevent="submitForm">
            @csrf <input type="hidden" name="_method" value="POST">
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Date</label><input type="date" name="date" value="{{ now()->format('Y-m-d') }}" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">Time</label><input type="time" name="test_time" value="{{ now()->format('H:i') }}" class="w-full border rounded px-3 py-2"></div></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">TDS</label><input type="number" name="tds" class="w-full border rounded px-3 py-2"></div><div><label class="block text-sm mb-1">pH</label><input type="number" step="0.01" name="ph" class="w-full border rounded px-3 py-2"></div></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Taste</label><select name="taste" class="w-full border rounded px-3 py-2"><option>Normal</option><option>Abnormal</option></select></div><div><label class="block text-sm mb-1">Odor</label><select name="odor" class="w-full border rounded px-3 py-2"><option>Normal</option><option>Abnormal</option></select></div></div>
            <div class="grid grid-cols-2 gap-4 mb-4"><div><label class="block text-sm mb-1">Foreign Impurities</label><select name="foreign_impurities" class="w-full border rounded px-3 py-2"><option>None</option><option>Present</option></select></div><div><label class="block text-sm mb-1">Sealing Quality</label><select name="sealing_quality" class="w-full border rounded px-3 py-2"><option>Good</option><option>Defective</option><option>N/A</option></select></div></div>
            <x-admin.reports.checked-by-field />
        </form>
    </x-admin.reports.report-entry-modal>
    <script>function submitForm(){const fd=new FormData(document.getElementById('entry-modal-treated-form'));fetch('/admin/reports/treated-water-testing',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},body:fd}).then(r=>r.json()).then(()=>location.reload())}function deleteRecord(id){if(confirm('Delete?'))fetch(`/admin/reports/treated-water-testing/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}).then(()=>location.reload())}</script>
@endsection