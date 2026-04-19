@extends('layouts.admin')

@section('header', 'Rep Attendance & Leave')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <x-admin.page-header title="Leave Requests" buttonText="Log Manual Leave" buttonRoute="#" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Attendance Overview -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 p-6 flex flex-col justify-center">
            <h3 class="text-sm font-bold text-glaciar-gray-500 uppercase tracking-wider mb-4">Today's Roster</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-glaciar-gray-100">
                    <span class="text-sm font-medium text-glaciar-black">Present</span>
                    <span class="text-lg font-bold text-green-600">22</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-glaciar-gray-100">
                    <span class="text-sm font-medium text-glaciar-black">On Leave</span>
                    <span class="text-lg font-bold text-amber-600">3</span>
                </div>
                <div class="flex justify-between items-center pt-1">
                    <span class="text-sm font-medium text-glaciar-black">Not Checked In</span>
                    <span class="text-lg font-bold text-red-600">1</span>
                </div>
            </div>
            
            <div class="mt-6 p-3 bg-red-50 border border-red-100 rounded-lg flex items-start">
                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="text-sm text-red-800">
                    <span class="font-bold block mb-1">Coverage Alert: Gampaha</span>
                    Primary rep on leave. Only 1 backup rep available for 24 deliveries.
                </div>
            </div>
            
            <button class="w-full mt-4 py-2 px-4 border border-glaciar-gray-300 rounded-md text-sm font-medium text-glaciar-black hover:bg-glaciar-gray-50 transition-colors">Generate Payroll Report</button>
        </div>

        <!-- Leave Requests Table -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden flex flex-col h-full">
            <div class="p-4 border-b border-glaciar-gray-100 flex justify-between items-center bg-glaciar-gray-50">
                <h3 class="font-bold text-glaciar-black">Pending Leave Requests</h3>
                <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2 py-0.5 rounded-full">3 Requires Action</span>
            </div>
            
            <div class="flex-1 overflow-x-auto">
                <table class="min-w-full divide-y divide-glaciar-gray-100">
                    <thead class="bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Rep</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Dates</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Reason</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-glaciar-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-glaciar-gray-100 bg-white">
                        <!-- Demo placeholder data -->
                        @foreach([
                            ['id' => 1, 'rep' => 'Kamal Perera', 'zone' => 'Colombo Suburbs', 'date' => 'Oct 20 - Oct 22 (3 Days)', 'reason' => 'Family Event', 'urgent' => false],
                            ['id' => 2, 'rep' => 'Sunil Fernando', 'zone' => 'Gampaha', 'date' => 'Oct 18 (1 Day)', 'reason' => 'Medical / Sick Leave', 'urgent' => true],
                            ['id' => 3, 'rep' => 'Ajith Kumara', 'zone' => 'Kalutara', 'date' => 'Nov 01 - Nov 05 (5 Days)', 'reason' => 'Annual Leave', 'urgent' => false],
                        ] as $r)
                            <tr class="hover:bg-glaciar-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                            {{ substr($r['rep'], 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-glaciar-black">{{ $r['rep'] }}</div>
                                            <div class="text-xs text-glaciar-gray-500">{{ $r['zone'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-glaciar-black flex items-center">
                                        {{ $r['date'] }}
                                        @if($r['urgent'])
                                            <span class="ml-2 w-2 h-2 rounded-full bg-red-500" title="Starting soon"></span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 bg-glaciar-gray-100 text-glaciar-black rounded-md text-xs font-semibold">{{ $r['reason'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="px-3 py-1.5 bg-glaciar-black text-white rounded text-xs hover:bg-glaciar-gray-900 transition-colors mr-2">Approve</button>
                                    <button class="px-3 py-1.5 border border-glaciar-gray-300 text-glaciar-gray-700 rounded text-xs hover:bg-glaciar-gray-100 transition-colors">Deny</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-glaciar-gray-100 bg-white text-center">
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">View Leave History Archive</a>
            </div>
        </div>
    </div>
@endsection
