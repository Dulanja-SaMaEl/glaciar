@props(['status'])

@php
    $classes = match (strtolower($status)) {
        'active', 'delivered', 'completed', 'verified', 'resolved' => 'bg-green-100 text-green-800',
        'pending', 'submitted', 'in_progress', 'open', 'amber', 'on leave' => 'bg-amber-100 text-amber-800',
        'cancelled', 'issue', 'failed', 'high', 'closed', 'absent' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
