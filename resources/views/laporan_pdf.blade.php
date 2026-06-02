<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan InvoPay</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #1b254b; margin: 0; padding: 20px; }
        .header { border-bottom: 3px solid #5b80ff; padding-bottom: 15px; margin-bottom: 25px; text-align: center;}
        h1 { margin: 0; font-size: 26px; color: #1b254b; }
        p.date { margin: 5px 0 0 0; color: #6b7280; font-size: 13px; }
        
        /* Summary Table */
        .summary-table { width: 100%; margin-bottom: 20px; border-collapse: separate; border-spacing: 10px 0; }
        .summary-table td { width: 25%; padding: 15px; text-align: center; border-radius: 8px; color: white; }
        .bg-blue { background-color: #5b80ff; }
        .bg-green { background-color: #48bb78; }
        .bg-gray { background-color: #a0aec0; }
        .bg-red { background-color: #fc8181; }
        .bg-orange { background-color: #f6ad55; }
        .box-title { font-size: 10px; text-transform: uppercase; margin-bottom: 5px; font-weight: bold; }
        .box-val { font-size: 20px; font-weight: bold; margin: 0; }

        /* Revenue Box */
        .revenue-container { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .rev-box { width: 48%; background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; text-align: center; }
        .rev-title { color: #6b7280; font-size: 12px; margin-bottom: 5px; font-weight: bold; text-transform: uppercase; }
        .rev-val { font-size: 24px; font-weight: bold; margin: 0; }

        h2 { font-size: 16px; color: #1b254b; margin-bottom: 12px; border-left: 4px solid #5b80ff; padding-left: 8px; margin-top: 30px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
        table.data-table th, table.data-table td { padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        table.data-table th { background-color: #f4f7fe; color: #1b254b; font-weight: bold; text-transform: uppercase; font-size: 11px;}
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan InvoPay</h1>
        <p class="date">Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->format('d F Y, H:i') }}</p>
    </div>

    <table class="summary-table">
        <tr>
            <td class="bg-blue"><div class="box-title">Total Inv</div><div class="box-val">{{ $totalInvoice }}</div></td>
            <td class="bg-green"><div class="box-title">Paid</div><div class="box-val">{{ $paid }}</div></td>
            <td class="bg-gray"><div class="box-title">Pending</div><div class="box-val">{{ $unpaid }}</div></td>
            <td class="bg-red"><div class="box-title">Overdue</div><div class="box-val">{{ $overdue }}</div></td>
        </tr>
    </table>

    <div class="revenue-container">
        <div class="rev-box">
            <div class="rev-title">Total Pendapatan (Lunas)</div>
            <p class="rev-val" style="color: #48bb78;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="rev-box">
            <div class="rev-title">Total Outstanding</div>
            <p class="rev-val" style="color: #f6ad55;">Rp {{ number_format($totalOutstanding, 0, ',', '.') }}</p>
        </div>
    </div>

    <h2>Top Klien</h2>
    <table class="data-table">
        <tr>
            <th class="text-center" width="10%">No.</th>
            <th>Nama Klien</th>
            <th class="text-right">Total Pendapatan</th>
        </tr>
        @foreach($topKliens as $index => $tk)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $tk->nama_klien }}</td>
            <td class="text-right">Rp {{ number_format($tk->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <h2>Riwayat Transaksi (Lunas)</h2>
    <table class="data-table">
        <tr>
            <th>No. Invoice</th>
            <th>Klien</th>
            <th>Tanggal Lunas</th>
            <th class="text-right">Total</th>
        </tr>
        @foreach($recentInvoices as $inv)
        <tr>
            <td><strong>{{ $inv->no_invoice }}</strong></td>
            <td>{{ $inv->nama_klien }}</td>
            <td>{{ \Carbon\Carbon::parse($inv->updated_at)->format('d M Y') }}</td>
            <td class="text-right">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <h2>Aging Report (Invoice Overdue)</h2>
    <table class="data-table">
        <tr>
            <th>No. Invoice</th>
            <th>Klien</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
        </tr>
        @forelse($overdueInvoices as $inv)
        <tr>
            <td>{{ $inv->no_invoice }}</td>
            <td>{{ $inv->nama_klien }}</td>
            <td>{{ \Carbon\Carbon::parse($inv->due_date)->format('d M Y') }}</td>
            <td style="color: #fc8181; font-weight: bold;">{{ $inv->days_late }} hari terlambat</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Tidak ada invoice menunggak.</td>
        </tr>
        @endforelse
    </table>
</body>
</html>