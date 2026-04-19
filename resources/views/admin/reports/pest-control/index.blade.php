@extends('layouts.admin')

@section('header', 'Pest Control Daily Monitoring')

@section('content')
    <x-admin.reports.report-page-header 
        title="Pest Control Daily Monitoring" 
        description="Daily zone monitoring record"
        routeKey="pest-control"
    />

    <div class="mt-6 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-glaciar-gray-100">
                <thead class="bg-glaciar-black">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">TW</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">STA</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">FR</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">FlR</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">RMS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">FPS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">19L</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">OA</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">FE</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">LR</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Checked By</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-glaciar-gray-100">
                    @forelse($records as $index => $record)
                        <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#F9F9F9]' }}">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-glaciar-black">{{ $record->date->format('d M Y') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->tube_well === 'Clear') text-green-600 font-semibold @elseif($record->tube_well === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->tube_well }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->storage_tank_area === 'Clear') text-green-600 font-semibold @elseif($record->storage_tank_area === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->storage_tank_area }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->filter_room === 'Clear') text-green-600 font-semibold @elseif($record->filter_room === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->filter_room }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->filling_room === 'Clear') text-green-600 font-semibold @elseif($record->filling_room === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->filling_room }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->raw_material_store === 'Clear') text-green-600 font-semibold @elseif($record->raw_material_store === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->raw_material_store }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->finish_product_store === 'Clear') text-green-600 font-semibold @elseif($record->finish_product_store === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->finish_product_store }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->washing_area_19l === 'Clear') text-green-600 font-semibold @elseif($record->washing_area_19l === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->washing_area_19l }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->office_area === 'Clear') text-green-600 font-semibold @elseif($record->office_area === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->office_area }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->factory_entrance === 'Clear') text-green-600 font-semibold @elseif($record->factory_entrance === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->factory_entrance }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <span class="@if($record->lunch_room === 'Clear') text-green-600 font-semibold @elseif($record->lunch_room === 'Issue') text-red-600 font-semibold @else text-gray-400 @endif">{{ $record->lunch_room }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if(str_contains($record->overall_status, 'Issues'))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Issues Found</span>
                                @elseif($record->overall_status === 'Partial')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Partial</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">All Clear</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $record->checked_by }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <button onclick="editRecord({{ $record->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                <button onclick="deleteRecord({{ $record->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-glaciar-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-glaciar-gray-500">No records found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-admin.reports.report-entry-modal modalId="entry-modal-pest-control" title="Pest Control Entry">
        <form id="entry-modal-pest-control-form" x-data="pestControlForm()" @submit.prevent="submitForm">
            @csrf
            <input type="hidden" name="_method" id="pest-control-method" value="POST">
            <input type="hidden" name="id" id="pest-control-id" value="">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-glaciar-black mb-2">Date</label>
                <input type="date" name="date" id="pest-control-date" value="{{ now()->format('Y-m-d') }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-glaciar-black focus:border-glaciar-black" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-glaciar-black mb-2">Area Status</label>
                <p class="text-xs text-glaciar-gray-500 mb-3">Select status for each monitored area</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                    $areas = [
                        'tube_well' => 'Tube Well',
                        'storage_tank_area' => 'Storage Tank Area',
                        'filter_room' => 'Filter Room',
                        'filling_room' => 'Filling Room',
                        'raw_material_store' => 'Raw Material Store',
                        'finish_product_store' => 'Finish Product Store',
                        'washing_area_19l' => '19L Washing Area',
                        'office_area' => 'Office Area',
                        'factory_entrance' => 'Factory Entrance',
                        'lunch_room' => 'Lunch Room',
                    ];
                    @endphp
                    
                    @foreach($areas as $field => $label)
                    <div class="border border-glaciar-gray-100 rounded-lg p-3">
                        <label class="block text-sm font-medium text-glaciar-black mb-2">{{ $label }}</label>
                        <select name="{{ $field }}" id="pest-control-{{ $field }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-glaciar-black focus:border-glaciar-black" required>
                            <option value="Clear">Clear</option>
                            <option value="Issue">Issue</option>
                            <option value="N/A">N/A</option>
                        </select>
                        <div x-show="$el.previousElementSibling.value === 'Issue'" x-transition class="mt-2">
                            <input type="text" name="{{ $field }}_note" placeholder="Describe the issue..." class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-glaciar-black mb-2">Comments</label>
                <textarea name="comments" id="pest-control-comments" rows="3" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-glaciar-black focus:border-glaciar-black"></textarea>
            </div>

            <x-admin.reports.checked-by-field name="checked_by" />
        </form>
    </x-admin.reports.report-entry-modal>

    <script>
        function pestControlForm() {
            return {
                submitForm() {
                    const form = document.getElementById('entry-modal-pest-control-form');
                    const formData = new FormData(form);
                    const method = document.getElementById('pest-control-method').value;
                    const id = document.getElementById('pest-control-id').value;
                    const url = method === 'PUT' 
                        ? `/admin/reports/pest-control/${id}`
                        : '/admin/reports/pest-control';
                    
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('entry-modal-pest-control').classList.add('hidden');
                        location.reload();
                    })
                    .catch(error => {
                        alert('Error saving record');
                    });
                }
            };
        }

        function editRecord(id) {
            fetch(`/admin/reports/pest-control/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('pest-control-id').value = data.id;
                    document.getElementById('pest-control-method').value = 'PUT';
                    document.getElementById('pest-control-date').value = data.date;
                    
                    const fields = ['tube_well', 'storage_tank_area', 'filter_room', 'filling_room', 'raw_material_store', 'finish_product_store', 'washing_area_19l', 'office_area', 'factory_entrance', 'lunch_room'];
                    fields.forEach(field => {
                        document.getElementById(`pest-control-${field}`).value = data[field];
                    });
                    
                    document.getElementById('pest-control-comments').value = data.comments || '';
                    document.querySelector('input[name="checked_by"]').value = data.checked_by;
                    
                    document.getElementById('entry-modal-pest-control').classList.remove('hidden');
                });
        }

        function deleteRecord(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                fetch(`/admin/reports/pest-control/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    location.reload();
                });
            }
        }
    </script>
@endsection