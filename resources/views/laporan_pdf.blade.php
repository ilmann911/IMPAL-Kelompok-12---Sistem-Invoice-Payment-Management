<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan InvoPay</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #1b254b; margin: 0; padding: 25px; }
        .header { border-bottom: 2px solid #5b80ff; padding-bottom: 20px; margin-bottom: 25px; text-align: center;}
        h1 { margin: 0; font-size: 24px; color: #1b254b; }
        p.date { margin: 8px 0 0 0; color: #6b7280; font-size: 12px; }
        
        /* Summary Grid */
        .summary-grid { width: 100%; border-collapse: separate; border-spacing: 8px; margin-bottom: 20px; }
        .summary-grid td { width: 25%; padding: 15px; text-align: center; border-radius: 10px; color: white; }
        .bg-blue { background-color: #5b80ff; }
        .bg-green { background-color: #48bb78; }
        .bg-gray { background-color: #a0aec0; }
        .bg-red { background-color: #fc8181; }
        .box-title { font-size: 9px; text-transform: uppercase; margin-bottom: 4px; font-weight: bold; opacity: 0.9; }
        .box-val { font-size: 18px; font-weight: bold; margin: 0; }

        /* Revenue Containers */
        .revenue-grid { width: 100%; border-collapse: separate; border-spacing: 8px; margin-bottom: 20px; }
        .rev-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 15px; text-align: center; }
        .rev-title { color: #64748b; font-size: 10px; margin-bottom: 6px; font-weight: bold; text-transform: uppercase; }
        .rev-val { font-size: 16px; font-weight: bold; margin: 0; }

        /* Grand Total Box */
        .grand-total { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 20px; text-align: center; margin-bottom: 30px; }
        .gt-title { color: #1e40af; font-size: 12px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .gt-val { font-size: 26px; font-weight: 800; color: #1e3a8a; margin: 0; }

        h2 { font-size: 14px; color: #1b254b; margin-bottom: 12px; border-left: 4px solid #5b80ff; padding-left: 10px; margin-top: 30px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
        table.data-table th, table.data-table td { padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        table.data-table th { background-color: #f8fafc; color: #475569; font-weight: bold; text-transform: uppercase; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan InvoPay</h1>
        <p class="date">Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->format('d F Y, H:i') }}</p>
    </div>

    <table class="summary-grid">
        <tr>
            <td class="bg-blue"><div class="box-title">Total Invoice</div><div class="box-val">{{ $totalInvoice }}</div></td>
            <td class="bg-green"><div class="box-title">Paid</div><div class="box-val">{{ $paid }}</div></td>
            <td class="bg-gray"><div class="box-title">Unpaid</div><div class="box-val">{{ $unpaid }}</div></td>
            <td class="bg-red"><div class="box-title">Overdue</div><div class="box-val">{{ $overdue }}</div></td>
        </tr>
    </table>

    <table class="revenue-grid">
        <tr>
            <td class="rev-box">
                <div class="rev-title">Pendapatan (Lunas)</div>
                <p class="rev-val" style="color: #48bb78;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </td>
            <td class="rev-box">
                <div class="rev-title">Piutang (Belum Lunas)</div>
                <p class="rev-val" style="color: #a0aec0;">Rp {{ number_format($totalOutstanding, 0, ',', '.') }}</p>
            </td>
            <td class="rev-box">
                <div class="rev-title">Piutang Macet (Overdue)</div>
                <p class="rev-val" style="color: #fc8181;">Rp {{ number_format($totalOverdueNominal, 0, ',', '.') }}</p>
            </td>
        </tr>
    </table>
    
    <div class="grand-total">
        <div class="gt-title">Total Invoice (Keseluruhan)</div>
        <p class="gt-val">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</p>
    </div>

    <h2>Top Klien</h2>
    <table class="data-table">
        <tr>
            <th class="text-center" width="5%">No.</th>
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
            <td style="color: #e53e3e; font-weight: bold;">{{ $inv->days_late }} hari terlambat</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Tidak ada invoice menunggak.</td>
        </tr>
        @endforelse
    </table>
</body>
</html>