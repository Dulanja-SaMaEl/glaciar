@props([
    'chartId',
    'labels',
    'values',
    'tier1Cap',
    'bonusThreshold',
])

<div class="h-80 w-full relative">
    <canvas id="{{ $chartId }}"></canvas>
</div>

@once
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.1/dist/chartjs-plugin-annotation.min.js"></script>
@endonce

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById(@json($chartId));
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Daily Sales',
                    data: @json($values),
                    borderColor: '#000000',
                    backgroundColor: 'rgba(0, 0, 0, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 2,
                    pointHoverRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    annotation: {
                        annotations: {
                            tierChange: {
                                type: 'line',
                                yMin: @json($tier1Cap),
                                yMax: @json($tier1Cap),
                                borderColor: 'rgba(245, 158, 11, 1)',
                                borderWidth: 2,
                                borderDash: [6, 6],
                                label: {
                                    enabled: true,
                                    content: 'Tier Change (1,200,000)',
                                    position: 'end'
                                }
                            },
                            bonusTarget: {
                                type: 'line',
                                yMin: @json($bonusThreshold),
                                yMax: @json($bonusThreshold),
                                borderColor: 'rgba(34, 197, 94, 1)',
                                borderWidth: 2,
                                borderDash: [6, 6],
                                label: {
                                    enabled: true,
                                    content: 'Bonus Target (1,500,000)',
                                    position: 'end'
                                }
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#F3F4F6' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>

