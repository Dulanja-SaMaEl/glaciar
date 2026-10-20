@extends('customer.account.layout')

@section('account_content')
<div class="space-y-8">
    
    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-[#0b1226]/85 backdrop-blur-xl p-6 rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex items-center justify-between">
            <div>
                <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block mb-1">TOTAL ORDERS</span>
                <span class="text-3xl font-black text-white font-mono">
                    {{ Auth::user()->orders()->count() }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-400/10 border border-cyan-400/20 text-cyan-300 flex items-center justify-center font-mono font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
        </div>

        <div class="bg-[#0b1226]/85 backdrop-blur-xl p-6 rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex items-center justify-between">
            <div>
                <span class="text-[10px] font-mono uppercase tracking-widest text-slate-400 block mb-1">DELIVERY ZONE</span>
                <span class="text-lg font-bold text-white font-mono">
                    {{ Auth::user()->zone->name ?? 'Zone Unassigned' }}
                </span>
                <span class="text-xs text-cyan-400 block mt-1 font-mono">Dispatch Scheduled</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-400/10 border border-cyan-400/20 text-cyan-300 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Profile Details Card -->
    <div class="bg-[#0b1226]/85 backdrop-blur-xl p-6 sm:p-8 rounded-2xl border border-white/15 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
        <h3 class="text-xs font-mono uppercase tracking-widest font-bold text-white mb-6 pb-3 border-b border-white/10">
            CLIENT PROFILE MANIFEST
        </h3>

        <dl class="divide-y divide-white/10 text-xs font-mono">
            <div class="py-3.5 sm:grid sm:grid-cols-3">
                <dt class="text-slate-400 uppercase">FULL NAME</dt>
                <dd class="sm:col-span-2 font-bold text-white">{{ Auth::user()->name }}</dd>
            </div>
            <div class="py-3.5 sm:grid sm:grid-cols-3">
                <dt class="text-slate-400 uppercase">EMAIL ADDRESS</dt>
                <dd class="sm:col-span-2 font-bold text-white">{{ Auth::user()->email }}</dd>
            </div>
            <div class="py-3.5 sm:grid sm:grid-cols-3">
                <dt class="text-slate-400 uppercase">PHONE NUMBER</dt>
                <dd class="sm:col-span-2 font-bold text-white">{{ Auth::user()->phone ?? 'Not provided' }}</dd>
            </div>
            <div class="py-3.5 sm:grid sm:grid-cols-3">
                <dt class="text-slate-400 uppercase">DELIVERY ADDRESS</dt>
                <dd class="sm:col-span-2 font-bold text-white">{{ Auth::user()->address ?? 'Not configured yet' }}</dd>
            </div>
        </dl>
    </div>

</div>
@endsection
