@props(['status'])

@php
    $statusLower = strtolower($status);
    $config = match ($statusLower) {
        'active', 'delivered', 'completed', 'verified', 'resolved' => [
            'bg' => 'bg-emerald-50 border-emerald-200/60',
            'text' => 'text-emerald-700',
            'dot' => 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]'
        ],
        'pending', 'submitted', 'in_progress', 'open', 'amber', 'on leave' => [
            'bg' => 'bg-amber-50 border-amber-200/60',
            'text' => 'text-amber-700',
            'dot' => 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.6)]'
        ],
        'cancelled', 'issue', 'failed', 'high', 'closed', 'absent' => [
            'bg' => 'bg-rose-50 border-rose-200/60',
            'text' => 'text-rose-700',
            'dot' => 'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.6)]'
        ],
        default => [
            'bg' => 'bg-slate-50 border-slate-200/60',
            'text' => 'text-slate-700',
            'dot' => 'bg-slate-400'
        ],
    };
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $config['bg'] }} {{ $config['text'] }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }} mr-1.5 animate-pulse-slow"></span>
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
