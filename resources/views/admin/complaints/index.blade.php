@extends('layouts.admin')

@section('header', 'Customer Support')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <x-admin.page-header title="Complaints & Issues" buttonText="Log New Issue" buttonRoute="#" />
        
        <!-- Filter Toggle -->
        <div class="flex bg-glaciar-gray-100 rounded-lg p-1">
            <a href="{{ route('admin.complaints.index') }}" class="px-4 py-1.5 rounded-md text-sm font-medium {{ !request()->has('status') ? 'bg-white text-glaciar-black shadow-sm' : 'text-glaciar-gray-500 hover:text-glaciar-black' }}">All Active</a>
            <a href="{{ route('admin.complaints.index', ['status' => 'pending']) }}" class="px-4 py-1.5 rounded-md text-sm font-medium {{ request('status') === 'pending' ? 'bg-white text-glaciar-black shadow-sm' : 'text-glaciar-gray-500 hover:text-glaciar-black' }}">New <span class="bg-red-100 text-red-600 rounded-full px-2 py-0.5 ml-1 text-xs">3</span></a>
            <a href="{{ route('admin.complaints.index', ['status' => 'resolved']) }}" class="px-4 py-1.5 rounded-md text-sm font-medium {{ request('status') === 'resolved' ? 'bg-white text-glaciar-black shadow-sm' : 'text-glaciar-gray-500 hover:text-glaciar-black' }}">Resolved</a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-red-50 rounded-xl border border-red-100 p-4">
            <p class="text-xs font-bold text-red-800 uppercase tracking-wider">Unassigned</p>
            <p class="text-2xl font-black text-red-600 mt-1">3</p>
        </div>
        <div class="bg-amber-50 rounded-xl border border-amber-100 p-4">
            <p class="text-xs font-bold text-amber-800 uppercase tracking-wider">In Progress</p>
            <p class="text-2xl font-black text-amber-600 mt-1">8</p>
        </div>
        <div class="bg-blue-50 rounded-xl border border-blue-100 p-4">
            <p class="text-xs font-bold text-blue-800 uppercase tracking-wider">Avg Resolution</p>
            <p class="text-2xl font-black text-blue-600 mt-1">4.2h</p>
        </div>
        <div class="bg-green-50 rounded-xl border border-green-100 p-4">
            <p class="text-xs font-bold text-green-800 uppercase tracking-wider">Resolved Today</p>
            <p class="text-2xl font-black text-green-600 mt-1">12</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <x-admin.data-table :columns="['Ticket ID', 'Customer', 'Category', 'Subject', 'Date Logged', 'Status', 'Actions']" :items="$complaints ?? []" emptyMessage="No complaints found.">
            @forelse($complaints ?? [] as $complaint)
                <!-- Add implementation when ready based on real data structure -->
            @empty
                <!-- Demo placeholder data -->
                @php
                    $demoComplaints = [
                        ['id' => 1042, 'customer' => 'Sampath Bank HQ', 'type' => 'b2b', 'type_label' => 'B2B Priority', 'cat' => 'Delivery Delay', 'subject' => 'Missed scheduled delivery window by 3 hours', 'date' => 'Today, 10:15 AM', 'status' => 'Pending'],
                        ['id' => 1041, 'customer' => 'Nilantha Wijesinghe', 'type' => 'b2c', 'type_label' => 'Standard', 'cat' => 'Product Quality', 'subject' => 'Damaged seal on 19L bottle', 'date' => 'Today, 09:30 AM', 'status' => 'In Progress'],
                        ['id' => 1040, 'customer' => 'Cafe Veda', 'type' => 'b2b', 'type_label' => 'B2B Priority', 'cat' => 'Billing Issue', 'subject' => 'Incorrect invoice amount for October', 'date' => 'Yesterday, 04:20 PM', 'status' => 'In Progress'],
                        ['id' => 1039, 'customer' => 'Tech Solutions Ltd', 'type' => 'b2b', 'type_label' => 'B2B Priority', 'cat' => 'Driver Conduct', 'subject' => 'Driver parked in executive spot', 'date' => 'Yesterday, 11:05 AM', 'status' => 'Resolved'],
                        ['id' => 1038, 'customer' => 'Sunil Perera', 'type' => 'b2c', 'type_label' => 'Standard', 'cat' => 'App Issue', 'subject' => 'Cannot reset password on the mobile app', 'date' => 'Oct 14, 2024', 'status' => 'Resolved'],
                    ];
                @endphp
                @foreach($demoComplaints as $c)
                    <tr class="{{ $c['status'] === 'Pending' ? 'bg-red-50/30' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-glaciar-black">
                            <a href="#" class="hover:text-blue-600">#TKT-{{ $c['id'] }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-glaciar-black">{{ $c['customer'] }}</div>
                            <div class="text-[10px] uppercase font-bold tracking-wider {{ $c['type'] === 'b2b' ? 'text-indigo-600' : 'text-gray-500' }} mt-0.5">{{ $c['type_label'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2.5 py-1 bg-glaciar-gray-100 text-glaciar-black rounded-md text-xs font-semibold">{{ $c['cat'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-glaciar-gray-600 max-w-sm truncate" title="{{ $c['subject'] }}">
                            {{ Str::limit($c['subject'], 40) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-glaciar-gray-500">
                            {{ $c['date'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = match (strtolower($c['status'])) {
                                    'resolved' => 'bg-green-100 text-green-800',
                                    'in progress' => 'bg-amber-100 text-amber-800',
                                    'pending' => 'bg-red-100 text-red-800 animate-pulse',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                                {{ $c['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">View Details</a>
                            @if($c['status'] !== 'Resolved')
                                <a href="#" class="text-green-600 hover:text-green-900">Resolve</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforelse
        </x-admin.data-table>
        
        <div class="px-6 py-3 border-t border-glaciar-gray-100 bg-white text-xs text-glaciar-gray-400 text-center">
            Service Level Agreement (SLA) requires B2B Priority issues to be addressed within 2 hours.
        </div>
    </div>
@endsection
