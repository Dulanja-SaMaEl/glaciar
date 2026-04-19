<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Treated Water</title><style>body{font-family:DejaVu Sans,sans-serif;font-size:9px}.header{background:#000;color:#fff;padding:16px}.brand{font-size:20px;font-weight:bold;letter-spacing:4px}table{width:100%;border-collapse:collapse}thead tr{background:#000;color:#fff}th,td{padding:6px;border-bottom:0.5px solid #E5E5E5}</style></head><body>
<div class="header"><div class="brand">GLACIAR</div><div>TREATED WATER TESTING RECORDS</div><div>{{ $monthLabel }}</div></div>
<table><thead><tr><th>Date</th><th>TDS</th><th>pH</th><th>Taste</th><th>Odor</th><th>Foreign</th><th>Sealing</th><th>Result</th></tr></thead><tbody>
@foreach($records as $r)
<tr><td>{{ $r->date->format('d M') }}</td><td>{{ $r->tds }}</td><td>{{ $r->ph }}</td><td>{{ $r->taste }}</td><td>{{ $r->odor }}</td><td>{{ $r->foreign_impurities }}</td><td>{{ $r->sealing_quality }}</td><td>{{ $r->result }}</td></tr>
@endforeach
</tbody></table></body></html>