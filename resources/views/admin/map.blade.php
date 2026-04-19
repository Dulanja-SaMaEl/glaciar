@extends('layouts.admin')

@section('header', 'Live Map')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-glaciar-gray-100 overflow-hidden">
        <div class="p-6 border-b border-glaciar-gray-100">
            <p class="text-sm text-glaciar-gray-500">
                Shows the latest recorded GPS position for each sales rep.
            </p>
        </div>

        <div class="p-6">
            <div id="liveMap" class="w-full" style="height: 520px;"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const points = @json(($latestLocations ?? collect())->map(function ($loc) {
                return [
                    'rep_id' => $loc->rep_id,
                    'name' => $loc->rep?->name ?? ('Rep #' . $loc->rep_id),
                    'zone' => $loc->rep?->zone?->name,
                    'lat' => (float) $loc->lat,
                    'lng' => (float) $loc->lng,
                    'recorded_at' => optional($loc->recorded_at)->toDateTimeString(),
                ];
            })->values());

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
                    .setContent('No rep locations recorded yet.')
                    .openOn(map);
                return;
            }

            const bounds = [];

            points.forEach((p) => {
                const label = [
                    `<div class="font-semibold">${p.name}</div>`,
                    p.zone ? `<div class="text-xs text-gray-600">${p.zone}</div>` : '',
                    p.recorded_at ? `<div class="text-xs text-gray-500 mt-1">${p.recorded_at}</div>` : ''
                ].join('');

                const marker = L.marker([p.lat, p.lng]).addTo(map);
                marker.bindPopup(label);
                bounds.push([p.lat, p.lng]);
            });

            if (bounds.length > 1) {
                map.fitBounds(bounds, { padding: [30, 30] });
            }
        });
    </script>
@endsection

