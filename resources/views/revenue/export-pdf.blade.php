<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue & Expense Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .summary h2 {
            color: #007bff;
            margin-top: 0;
            font-size: 18px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 15px;
        }
        .summary-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .summary-item h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
        }
        .summary-item .amount {
            font-size: 20px;
            font-weight: bold;
        }
        .revenue { color: #28a745; }
        .expense { color: #dc3545; }
        .net { color: #007bff; }
        .section {
            margin-bottom: 40px;
        }
        .section h2 {
            color: #007bff;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .amount {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        @media print {
            body { margin: 0; }
            .header { page-break-after: avoid; }
            .section { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Revenue & Expense Report</h1>
        <p><strong>Date Range:</strong> {{ $dateRange }}</p>
        <p><strong>Generated:</strong> {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <h2>Summary</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <h3>Total Revenue</h3>
                <div class="amount revenue">₹{{ number_format($totalRevenue, 2) }}</div>
            </div>
            <div class="summary-item">
                <h3>Total Expenses</h3>
                <div class="amount expense">₹{{ number_format($totalExpense, 2) }}</div>
            </div>
            <div class="summary-item">
                <h3>Net {{ $net >= 0 ? 'Income' : 'Loss' }}</h3>
                <div class="amount net">₹{{ number_format($net, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Revenue Records</h2>
        @if($revenues->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revenues as $index => $revenue)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $revenue->r_name ?? '-' }}</td>
                            <td>{{ $revenue->category }}</td>
                            <td>{{ $revenue->subcategory ?? '-' }}</td>
                            <td>{{ $revenue->payment_method ?? '-' }}</td>
                            <td class="amount revenue">₹{{ number_format($revenue->amount, 2) }}</td>
                            <td>{{ $revenue->entry_date ? \Carbon\Carbon::parse($revenue->entry_date)->format('d-m-Y') : $revenue->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #666; font-style: italic;">No revenue records found for the selected period.</p>
        @endif
    </div>

    <div class="section">
        <h2>Expense Records</h2>
        @if($expenses->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $index => $expense)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $expense->e_name ?? '-' }}</td>
                            <td>{{ $expense->category }}</td>
                            <td>{{ $expense->subcategory ?? '-' }}</td>
                            <td>{{ $expense->payment_method ?? '-' }}</td>
                            <td class="amount expense">₹{{ number_format($expense->amount, 2) }}</td>
                            <td>{{ $expense->entry_date ? \Carbon\Carbon::parse($expense->entry_date)->format('d-m-Y') : $expense->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #666; font-style: italic;">No expense records found for the selected period.</p>
        @endif
    </div>

    <div class="footer">
        <p>This report was generated on {{ now()->format('d-m-Y H:i:s') }} from the Revenue & Expense Management System.</p>
    </div>
</body>
</html>
