@extends('layouts.admin')

@section('header', 'Live GPS Tracking')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-glaciar-black dark:text-white tracking-tight">Active Sales Rep Positions</h2>
            <p class="text-sm text-glaciar-gray-500 dark:text-slate-400 mt-1">
                Real-time telemetry and last recorded GPS pings from field sales delivery fleet.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-mono font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ count($locationsData ?? []) }} REPS REPORTING</span>
            </span>
        </div>
    </div>

    <div class="bg-white dark:bg-[#0d1522] rounded-2xl shadow-soft dark:shadow-2xl border border-glaciar-gray-100/80 dark:border-white/10 overflow-hidden">
        <div class="p-6 border-b border-glaciar-gray-100 dark:border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-cyan-500/10 text-cyan-500 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-glaciar-black dark:text-white">Interactive Fleet Map</h3>
                    <p class="text-xs text-glaciar-gray-400 dark:text-slate-400 font-mono">TILE SERVER: OpenStreetMap High-DPI</p>
                </div>
            </div>
            <button onclick="window.location.reload()" class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-white/10 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Refresh Pins</span>
            </button>
        </div>

        <div class="p-4 sm:p-6">
            <div id="liveMap" class="w-full rounded-xl overflow-hidden border border-slate-200/60 dark:border-white/10" style="height: 560px;"></div>
        </div>
    </div>

    <style>
        .dark #liveMap .leaflet-tile {
            filter: brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) brightness(0.7);
        }
        .dark .leaflet-container {
            background: #06090e !important;
        }
        .dark .leaflet-popup-content-wrapper, .dark .leaflet-popup-tip {
            background: #0f172a !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .dark .leaflet-bar a {
            background-color: #0f172a !important;
            color: #94a3b8 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .dark .leaflet-bar a:hover {
            background-color: #1e293b !important;
            color: #f8fafc !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const points = @json($locationsData ?? []);

            const defaultLat = points.length ? points[0].lat : 6.9271; // Colombo
            const defaultLng = points.length ? points[0].lng : 79.8612;

            const map = L.map('liveMap').setView([defaultLat, defaultLng], points.length ? 12 : 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            if (!points.length) {
                L.popup()
                    .setLatLng([defaultLat, defaultLng])
                    .setContent('<div class="p-2 text-center text-xs font-sans"><strong>No Active Telemetry</strong><br>No rep GPS signals recorded today.</div>')
                    .openOn(map);
                return;
            }

            const bounds = [];

            points.forEach((p) => {
                const label = [
                    '<div class="p-2 font-sans">',
                    `<div class="font-bold text-sm text-slate-900">${p.name}</div>`,
                    p.zone ? `<div class="text-xs text-sky-600 font-semibold mt-0.5">${p.zone}</div>` : '',
                    p.recorded_at ? `<div class="text-[10px] text-slate-500 font-mono mt-1">Recorded: ${p.recorded_at}</div>` : '',
                    '</div>'
                ].join('');

                const marker = L.marker([p.lat, p.lng]).addTo(map);
                marker.bindPopup(label);
                bounds.push([p.lat, p.lng]);
            });

            if (bounds.length > 1) {
                map.fitBounds(bounds, { padding: [40, 40] });
            }
        });
    </script>
@endsection
