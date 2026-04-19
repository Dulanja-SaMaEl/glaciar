<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Salary Statement</title>
</head>
<body style="font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111;">
    @php
        $monthLabel = \Carbon\Carbon::create($year, $month, 1)->format('F Y');

        $basic = (float) ($monthly['basic_salary'] ?? 0);
        $allow = (float) ($monthly['allowance'] ?? 0);
        $commission = (float) ($monthly['commission'] ?? 0);
        $commissionBreakdown = $monthly['commission_breakdown'] ?? [];

        $tier1Cap = (float) config('salary.tier1_cap');
        $tier1Rate = (float) config('salary.tier1_rate');
        $tier2Rate = (float) config('salary.tier2_rate');

        $tier1Sales = (float) ($commissionBreakdown['tier1_sales'] ?? 0);
        $tier1Comm = (float) ($commissionBreakdown['tier1_commission'] ?? 0);
        $tier2Sales = (float) ($commissionBreakdown['tier2_sales'] ?? 0);
        $tier2Comm = (float) ($commissionBreakdown['tier2_commission'] ?? 0);

        $bonusEarned = !empty($monthly['bonus_earned']);
        $bonus = (float) ($monthly['bonus'] ?? 0);
    @endphp

    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:flex-end;">
        <div style="font-size: 18px; font-weight: 800;">GLACIAR WATER</div>
        <div style="font-size: 14px; font-weight: 800;">SALARY STATEMENT</div>
    </div>

    <div style="margin-top: 6px;">
        For the month of <b>{{ $monthLabel }}</b>
    </div>
    <div>
        Generated date: <b>{{ ($generatedAt ?? now())->format('Y-m-d H:i') }}</b>
    </div>

    <hr style="border:none; border-top:1px solid #999; margin: 12px 0;">

    <!-- Rep Details -->
    <div style="margin-bottom: 14px;">
        <div><b>{{ $rep->name }}</b></div>
        <div>Employee ID: {{ $rep->employee_id ?? ('REP-' . $rep->id) }}</div>
        <div>Zone: {{ $rep->zone->name ?? '—' }}</div>
        <div>Phone: {{ $rep->phone ?? '—' }}</div>
    </div>

    <!-- Sales Summary -->
    <div style="margin-bottom: 14px;">
        <div style="font-weight: 800; margin-bottom: 6px;">Sales Summary</div>
        <table width="100%" cellpadding="6" cellspacing="0" border="1" style="border-collapse:collapse;">
            <thead>
                <tr style="background:#f2f2f2;">
                    <th align="left">Product</th>
                    <th align="left">Cases</th>
                    <th align="left">Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach(['500ml'=>'500ml','1000ml'=>'1L','1500ml'=>'1.5L','5000ml'=>'5L'] as $key => $label)
                    @php
                        $row = $monthly['revenue_by_product'][$key] ?? ['cases'=>0,'revenue'=>0];
                    @endphp
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ (int) $row['cases'] }}</td>
                        <td>{{ number_format((float)$row['revenue'], 2) }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:800;">
                    <td>Total</td>
                    <td></td>
                    <td>{{ number_format((float)($monthly['total_sales'] ?? 0), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Salary Calculation -->
    <div style="margin-bottom: 14px;">
        <div style="font-weight: 800; margin-bottom: 6px;">Salary Calculation</div>
        <table width="100%" cellpadding="6" cellspacing="0" border="0" style="border-collapse:collapse;">
            <tr>
                <td style="width:60%;">Basic Salary</td>
                <td style="width:40%; text-align:left;">LKR {{ number_format($basic, 2) }}</td>
            </tr>
            <tr>
                <td>Allowance</td>
                <td style="text-align:left;">LKR {{ number_format($allow, 2) }}</td>
            </tr>
            <tr>
                <td><b>Commission</b></td>
                <td style="text-align:left;"><b>LKR {{ number_format($commission, 2) }}</b></td>
            </tr>
            <tr>
                <td style="padding-left: 24px;">
                    First LKR {{ number_format($tier1Cap, 0) }} @ {{ number_format($tier1Rate * 100, 0) }}%
                </td>
                <td style="text-align:left;">
                    LKR {{ number_format($tier1Comm, 2) }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 24px;">
                    Next LKR {{ number_format($tier2Sales, 0) }} @ {{ number_format($tier2Rate * 100, 0) }}%
                </td>
                <td style="text-align:left;">
                    LKR {{ number_format($tier2Comm, 2) }}
                </td>
            </tr>

            <tr>
                <td><b>Bonus</b></td>
                <td style="text-align:left;">
                    @if($bonusEarned)
                        <b>LKR {{ number_format($bonus, 2) }}</b> (Earned)
                    @else
                        <b>LKR 0.00</b> (Not earned)
                    @endif
                </td>
            </tr>

            <tr>
                <td style="border-top:1px solid #999; padding-top:8px; font-weight:800;">Total Salary</td>
                <td style="border-top:1px solid #999; padding-top:8px; font-weight:800; text-align:left;">
                    LKR {{ number_format((float)($monthly['total_salary'] ?? 0), 2) }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Profitability -->
    <div style="margin-bottom: 18px;">
        <div style="font-weight: 800; margin-bottom: 6px;">Profitability</div>
        <table width="100%" cellpadding="6" cellspacing="0" border="0" style="border-collapse:collapse;">
            <tr>
                <td style="width:60%;">Total Sales</td>
                <td style="width:40%; text-align:left;">LKR {{ number_format((float)($monthly['total_sales'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td>Less: Cost ({{ (float) config('salary.cost_ratio') * 100 }}%)</td>
                <td style="text-align:left;">LKR {{ number_format((float)($monthly['total_cost'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td>Gross Profit</td>
                <td style="text-align:left;">LKR {{ number_format((float)($monthly['gross_profit'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td>Less: Salary Paid</td>
                <td style="text-align:left;">LKR {{ number_format((float)($monthly['total_salary'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td style="border-top:1px solid #999; padding-top:8px; font-weight:800;">Net Profit</td>
                <td style="border-top:1px solid #999; padding-top:8px; font-weight:800; text-align:left;">
                    LKR {{ number_format((float)($monthly['net_profit'] ?? 0), 2) }}
                </td>
            </tr>
        </table>
    </div>

    <div style="font-size: 11px; color:#444;">
        <div style="margin-bottom: 4px;">This is a system-generated document — Glaciar Water</div>
        <div>Printed: {{ ($generatedAt ?? now())->format('Y-m-d H:i') }}</div>
    </div>
</body>
</html>

