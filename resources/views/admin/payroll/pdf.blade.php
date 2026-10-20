<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Paysheet - {{ $paysheet->rep->name }} - {{ $paysheet->year }}-{{ $paysheet->month }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 13px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #0f172a;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #64748b;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            background: #f1f5f9;
            padding: 8px;
            border: 1px solid #cbd5e1;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-table td {
            padding: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #475569;
            width: 150px;
        }
        .breakdown-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .breakdown-table th, .breakdown-table td {
            border: 1px solid #e2e8f0;
            padding: 10px;
        }
        .breakdown-table th {
            background-color: #f8fafc;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            color: #475569;
            text-align: left;
        }
        .breakdown-table .amount {
            text-align: right;
            font-family: monospace;
            font-size: 14px;
        }
        .section-title {
            font-weight: bold;
            background-color: #f1f5f9;
            text-transform: uppercase;
        }
        .total-row {
            font-weight: bold;
            background-color: #e2e8f0;
        }
        .net-salary-box {
            border: 2px solid #0f172a;
            background-color: #f8fafc;
            padding: 15px;
            text-align: center;
            margin-bottom: 40px;
        }
        .net-salary-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #475569;
            margin-bottom: 5px;
        }
        .net-salary-amount {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
        }
        .footer {
            margin-top: 50px;
        }
        .signatures {
            width: 100%;
            margin-top: 50px;
        }
        .signatures td {
            text-align: center;
            width: 50%;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
            padding-top: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Glaciar Water</h1>
        <p>Premium Drinking Water Company</p>
        <p>123 Glaciar Avenue, Colombo, Sri Lanka | +94 11 234 5678</p>
    </div>

    <div class="title">Paysheet for {{ \Carbon\Carbon::create($paysheet->year, $paysheet->month, 1)->format('F Y') }}</div>

    <table class="info-table">
        <tr>
            <td class="info-label">Employee Name:</td>
            <td><b>{{ $paysheet->rep->name }}</b></td>
            <td class="info-label">Paysheet No:</td>
            <td>#PS-{{ str_pad($paysheet->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="info-label">Employee ID:</td>
            <td>{{ $paysheet->rep->employee_id ?? 'REP-'.$paysheet->rep->id }}</td>
            <td class="info-label">Designation:</td>
            <td>Sales Representative</td>
        </tr>
        <tr>
            <td class="info-label">Department:</td>
            <td>Sales & Distribution</td>
            <td class="info-label">Generated Date:</td>
            <td>{{ \Carbon\Carbon::parse($paysheet->created_at)->format('Y-m-d') }}</td>
        </tr>
    </table>

    <table class="breakdown-table">
        <thead>
            <tr>
                <th style="width: 70%;">Description</th>
                <th style="width: 30%; text-align: right;">Amount (LKR)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Earnings -->
            <tr>
                <td colspan="2" class="section-title">Earnings</td>
            </tr>
            <tr>
                <td>Basic Salary</td>
                <td class="amount">{{ number_format($paysheet->basic_salary, 2) }}</td>
            </tr>
            <tr>
                <td>Fixed Allowance</td>
                <td class="amount">{{ number_format($paysheet->attendance_allowance, 2) }}</td>
            </tr>
            <tr>
                <td>Sales Commission</td>
                <td class="amount">{{ number_format($paysheet->sales_commission, 2) }}</td>
            </tr>
            @if($paysheet->performance_bonus > 0)
            <tr>
                <td>Performance Bonus</td>
                <td class="amount">{{ number_format($paysheet->performance_bonus, 2) }}</td>
            </tr>
            @endif
            @if($paysheet->incentives > 0)
            <tr>
                <td>Incentives</td>
                <td class="amount">{{ number_format($paysheet->incentives, 2) }}</td>
            </tr>
            @endif
            @if(!empty($paysheet->other_earnings) && is_array($paysheet->other_earnings))
                @foreach($paysheet->other_earnings as $oe)
                <tr>
                    <td>{{ $oe['name'] }}</td>
                    <td class="amount">{{ number_format($oe['amount'], 2) }}</td>
                </tr>
                @endforeach
            @endif
            <tr class="total-row">
                <td>Total Earnings (A)</td>
                <td class="amount">{{ number_format($paysheet->total_earnings, 2) }}</td>
            </tr>

            <!-- Deductions -->
            <tr>
                <td colspan="2" class="section-title">Deductions</td>
            </tr>
            <tr>
                <td>Absent Days Deduction</td>
                <td class="amount">{{ number_format($paysheet->absent_deduction, 2) }}</td>
            </tr>
            <tr>
                <td>Late Arrivals Deduction</td>
                <td class="amount">{{ number_format($paysheet->late_deduction, 2) }}</td>
            </tr>
            <tr>
                <td>EPF/ETF Contribution</td>
                <td class="amount">{{ number_format($paysheet->epf_deduction, 2) }}</td>
            </tr>
            @if($paysheet->salary_advances > 0)
            <tr>
                <td>Salary Advances / Loans</td>
                <td class="amount">{{ number_format($paysheet->salary_advances, 2) }}</td>
            </tr>
            @endif
            @if(!empty($paysheet->other_deductions) && is_array($paysheet->other_deductions))
                @foreach($paysheet->other_deductions as $od)
                <tr>
                    <td>{{ $od['name'] }}</td>
                    <td class="amount">{{ number_format($od['amount'], 2) }}</td>
                </tr>
                @endforeach
            @endif
            <tr class="total-row">
                <td>Total Deductions (B)</td>
                <td class="amount">{{ number_format($paysheet->total_deductions, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="net-salary-box">
        <div class="net-salary-title">Net Salary (A - B)</div>
        <div class="net-salary-amount">LKR {{ number_format($paysheet->net_salary, 2) }}</div>
    </div>

    <div class="footer">
        <p><i>* This is a computer-generated document and does not require a physical signature if distributed electronically.</i></p>
    </div>

    <table class="signatures">
        <tr>
            <td>
                <br><br><br>
                <div class="signature-line">Employer / Authorized Signature</div>
            </td>
            <td>
                <br><br><br>
                <div class="signature-line">Employee Signature</div>
            </td>
        </tr>
    </table>

</div>

</body>
</html>
