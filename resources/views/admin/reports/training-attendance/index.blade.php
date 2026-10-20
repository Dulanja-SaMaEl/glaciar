@extends('layouts.admin')

@section('header', 'Training Attendance')

@section('content')
    <x-admin.reports.report-page-header 
        title="Training Attendance" 
        description="Daily staff training log"
        routeKey="training-attendance"
    />

    <div class="mt-6">
        <x-admin.data-table :columns="['Date', 'Session Title', 'Trainer', 'Duration', 'Attendees', 'Actions']" :items="$records">
            @forelse($records as $index => $record)
                <tr class="table-row-hover transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">{{ $record->session_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-glaciar-black">{{ $record->session_title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $record->trainer_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">{{ $record->session_duration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-600">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            {{ $record->entries->count() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-3">
                            <button onclick="editRecord({{ $record->id }})" class="text-glaciar-accent hover:text-glaciar-accent-dark font-semibold transition-colors">Edit</button>
                            <button onclick="deleteRecord({{ $record->id }})" class="text-red-500 hover:text-red-700 font-semibold transition-colors">Delete</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center bg-white">
                        <svg class="mx-auto h-12 w-12 text-glaciar-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path>
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

    <x-admin.reports.report-entry-modal modalId="entry-modal-training" title="Training Session Entry">
        <form id="entry-modal-training-form" x-data="trainingForm()" @submit.prevent="submitForm">
            @csrf
            <input type="hidden" name="_method" id="training-method" value="POST">
            <input type="hidden" name="id" id="training-id" value="">

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-glaciar-black mb-2">Session Date</label>
                    <input type="date" name="session_date" id="training-session_date" value="{{ now()->format('Y-m-d') }}" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-glaciar-black mb-2">Duration</label>
                    <input type="text" name="session_duration" id="training-duration" placeholder="e.g. 2 hours" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-glaciar-black mb-2">Session Title</label>
                <input type="text" name="session_title" id="training-title" placeholder="Topic of training" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-glaciar-black mb-2">Trainer Name</label>
                <input type="text" name="trainer_name" id="training-trainer" class="w-full border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-glaciar-black mb-2">Attendees</label>
                <div id="attendees-container">
                    <template x-for="(attendee, index) in attendees" :key="index">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="'attendees[' + index + '][name]'" x-model="attendee.name" placeholder="Name" class="flex-1 border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" required>
                            <input type="text" :name="'attendees[' + index + '][designation]'" x-model="attendee.designation" placeholder="Designation" class="flex-1 border border-glaciar-gray-200 rounded-lg px-3 py-2 text-sm" required>
                            <button type="button" @click="removeAttendee(index)" class="px-2 py-1 text-red-600 hover:bg-red-50 rounded">×</button>
                        </div>
                    </template>
                </div>
                <button type="button" @click="addAttendee()" class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Add Attendee</button>
            </div>

            <x-admin.reports.checked-by-field />
        </form>
    </x-admin.reports.report-entry-modal>

    <script>
        function trainingForm() {
            return {
                attendees: [{name: '', designation: ''}],
                addAttendee() { this.attendees.push({name: '', designation: ''}); },
                removeAttendee(index) { this.attendees.splice(index, 1); },
                submitForm() {
                    const form = document.getElementById('entry-modal-training-form');
                    const formData = new FormData(form);
                    const method = document.getElementById('training-method').value;
                    const id = document.getElementById('training-id').value;
                    const url = method === 'PUT' ? `/admin/reports/training-attendance/${id}` : '/admin/reports/training-attendance';
                    
                    fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: formData })
                    .then(r => r.json()).then(data => { document.getElementById('entry-modal-training').classList.add('hidden'); location.reload(); })
                    .catch(e => alert('Error saving record'));
                }
            };
        }

        function editRecord(id) {
            fetch(`/admin/reports/training-attendance/${id}`).then(r => r.json()).then(data => {
                document.getElementById('training-id').value = data.id;
                document.getElementById('training-method').value = 'PUT';
                document.getElementById('training-session_date').value = data.session_date;
                document.getElementById('training-title').value = data.session_title;
                document.getElementById('training-trainer').value = data.trainer_name;
                document.getElementById('training-duration').value = data.session_duration;
                document.getElementById('entry-modal-training').classList.remove('hidden');
            });
        }

        function deleteRecord(id) {
            if (confirm('Delete this record?')) {
                fetch(`/admin/reports/training-attendance/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } })
                .then(() => location.reload());
            }
        }
    </script>
@endsection