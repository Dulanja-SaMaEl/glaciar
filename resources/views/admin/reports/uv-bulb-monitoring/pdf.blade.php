<!DOCTYPE html><html><head><meta charset="UTF-8"><title>UV Bulb Monitoring</title><style>body{font-family:DejaVu Sans,sans-serif;font-size:9px}.header{background:#000;color:#fff;padding:16px}.brand{font-size:20px;font-weight:bold;letter-spacing:4px}table{width:100%;border-collapse:collapse}thead tr{background:#000;color:#fff}th,td{padding:6px;border-bottom:0.5px solid #E5E5E5}</style></head><body>
<div class="header"><div class="brand">GLACIAR</div><div>UV BULB MONITORING RECORD</div><div>{{ $monthLabel }}</div></div>
<table><thead><tr><th>Date</th><th>Bulb</th><th>Location</th><th>Hours</th><th>Cumulative</th><th>Remaining</th><th>Status</th></tr></thead><tbody>
@foreach($records as $r)
<tr><td>{{ $r->date->format('d M') }}</td><td>{{ $r->bulb_id }}</td><td>{{ $r->bulb_location }}</td><td>{{ $r->running_hours }}</td><td>{{ $r->cumulative_hours }}</td><td>{{ $r->remaining_percentage }}%</td><td>{{ $r->status }}</td></tr>
@endforeach
</tbody></table></body></html>