@extends('layouts.admin')
@section('header', 'Suppliers')

@section('content')
<div class="mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-glaciar-black">Suppliers</h2>
        <p class="text-sm text-gray-500 mt-1">Manage suppliers and vendors.</p>
    </div>
    <button onclick="document.getElementById('createSupplierModal').classList.remove('hidden')" class="px-4 py-2 bg-glaciar-black text-white font-bold rounded-lg text-sm hover:bg-gray-900 transition-colors shadow-sm">
        + Add Supplier
    </button>
</div>

<!-- Search -->
<div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
    <form method="GET" action="{{ route('admin.inventory.suppliers.index') }}" class="flex gap-4">
        <input type="text" name="search" value="{{ $search }}" placeholder="Company Name, Contact, Email..." class="flex-1 border-gray-200 rounded-lg text-sm">
        <button type="submit" class="px-4 py-2 bg-gray-100 text-glaciar-black font-bold rounded-lg text-sm hover:bg-gray-200 transition-colors">Search</button>
        @if($search)
            <a href="{{ route('admin.inventory.suppliers.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-glaciar-black font-bold flex items-center">Clear</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">Company Name</th>
                    <th class="px-6 py-4">Contact Info</th>
                    <th class="px-6 py-4 text-center">Products</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-glaciar-black">{{ $supplier->company_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div>{{ $supplier->contact_person ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $supplier->email ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $supplier->phone ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-glaciar-black">{{ $supplier->products_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($supplier->status === 'active')
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-bold uppercase">Active</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-800 text-[10px] font-bold uppercase">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="editSupplier({{ $supplier->id }}, '{{ addslashes($supplier->company_name) }}', '{{ addslashes($supplier->contact_person) }}', '{{ addslashes($supplier->phone) }}', '{{ addslashes($supplier->email) }}', '{{ addslashes($supplier->address) }}', '{{ $supplier->status }}')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                            <form action="{{ route('admin.inventory.suppliers.destroy', $supplier->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this supplier?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">No suppliers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($suppliers->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $suppliers->links() }}
        </div>
    @endif
</div>

<!-- Create Modal -->
<div id="createSupplierModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl border w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-glaciar-black">Add Supplier</h3>
            <button onclick="document.getElementById('createSupplierModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form action="{{ route('admin.inventory.suppliers.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Company Name <span class="text-red-500">*</span></label>
                        <input type="text" name="company_name" class="w-full rounded-lg border-gray-300" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Contact Person</label>
                        <input type="text" name="contact_person" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-lg border-gray-300">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Address</label>
                        <textarea name="address" rows="2" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('createSupplierModal').classList.add('hidden')" class="px-4 py-2 bg-white border rounded-lg text-gray-600 font-bold hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-glaciar-black text-white rounded-lg font-bold hover:bg-gray-900">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editSupplierModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl border w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-glaciar-black">Edit Supplier</h3>
            <button onclick="document.getElementById('editSupplierModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form id="editSupplierForm" method="POST">
            @csrf @method('PUT')
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Company Name <span class="text-red-500">*</span></label>
                        <input type="text" name="company_name" id="edit_company_name" class="w-full rounded-lg border-gray-300" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Contact Person</label>
                        <input type="text" name="contact_person" id="edit_contact_person" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" id="edit_phone" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="edit_email" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                        <select name="status" id="edit_status" class="w-full rounded-lg border-gray-300">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Address</label>
                        <textarea name="address" id="edit_address" rows="2" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('editSupplierModal').classList.add('hidden')" class="px-4 py-2 bg-white border rounded-lg text-gray-600 font-bold hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-glaciar-black text-white rounded-lg font-bold hover:bg-gray-900">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function editSupplier(id, company, contact, phone, email, address, status) {
    document.getElementById('editSupplierForm').action = '/admin/inventory/suppliers/' + id;
    document.getElementById('edit_company_name').value = company;
    document.getElementById('edit_contact_person').value = contact;
    document.getElementById('edit_phone').value = phone;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_address').value = address;
    document.getElementById('edit_status').value = status;
    document.getElementById('editSupplierModal').classList.remove('hidden');
}
</script>
@endsection
