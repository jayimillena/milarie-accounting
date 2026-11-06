<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Income Statement</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 12px; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h2 { margin: 0; font-size: 18px; color: #111; }
        .header p { margin: 4px 0 0; color: #666; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; border-bottom: 1px solid #ddd; font-weight: bold; }
        td.right, th.right { text-align: right; }
        .section-title { font-size: 14px; font-weight: bold; color: #333; border-bottom: 2px solid #333; padding-bottom: 4px; margin-top: 15px; margin-bottom: 10px; }
        .total-row { font-weight: bold; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; }
        .net-income { background-color: #f1f5f9; padding: 10px; font-size: 14px; font-weight: bold; text-align: right; margin-top: 20px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Company Name</h2>
        <p><strong>Income Statement</strong></p>
        <p>For the period from {{ $startDate }} to {{ $endDate }}</p>
    </div>

    <div class="section-title">Revenues</div>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Account Name</th>
                <th class="right">Amount (₱)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($revenues as $rev)
                <tr>
                    <td>{{ $rev['code'] }}</td>
                    <td>{{ $rev['name'] }}</td>
                    <td class="right">{{ number_format($rev['balance'], 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No revenues recorded.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2">Total Revenue</td>
                <td class="right">₱{{ number_format($totalRevenue, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="section-title">Operating Expenses</div>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Account Name</th>
                <th class="right">Amount (₱)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $exp)
                <tr>
                    <td>{{ $exp['code'] }}</td>
                    <td>{{ $exp['name'] }}</td>
                    <td class="right">{{ number_format($exp['balance'], 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No expenses recorded.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2">Total Expenses</td>
                <td class="right">₱{{ number_format($totalExpense, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="net-income">
        Net Income / (Loss): ₱{{ number_format($netIncome, 2) }}
    </div>

    <div class="mb-4 flex justify-end">
        <a href="{{ route('accounting.reports.income-statement.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md shadow hover:bg-red-700">
            Download PDF Report
        </a>
    </div>
</body>
</html>