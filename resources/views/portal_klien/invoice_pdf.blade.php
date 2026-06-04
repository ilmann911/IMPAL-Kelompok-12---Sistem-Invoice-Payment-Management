<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->no_invoice }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.5; font-size: 14px; }
        .header { width: 100%; margin-bottom: 40px; }
        .header td { vertical-align: top; }
        .logo-text { font-size: 32px; font-weight: bold; color: #1b254b; letter-spacing: -1px; }
        .badge-status { 
            display: inline-block; padding: 6px 14px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; text-transform: uppercase; margin-top: 5px;
        }
        /* Pewarnaan Status Dinamis */
        .bg-paid { background-color: #48bb78; }
        .bg-pending { background-color: #ed8936; }
        .bg-sent { background-color: #4299e1; }
        .bg-overdue { background-color: #e53e3e; }
        .bg-draft { background-color: #a0aec0; }

        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .info-table td { width: 50%; padding: 0; }
        .info-title { font-size: 11px; color: #718096; text-transform: uppercase; font-weight: bold; margin-bottom: 5px; }
        
        .item-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .item-table th { background-color: #5b80ff; color: white; text-align: left; padding: 12px; font-size: 12px; text-transform: uppercase; }
        .item-table td { border-bottom: 1px solid #e2e8f0; padding: 12px; font-size: 13px; }
        .total-row td { border-top: 2px solid #5b80ff; font-size: 16px; font-weight: bold; color: #1b254b; padding-top: 15px; }
        
        .footer { margin-top: 50px; text-align: center; color: #718096; font-size: 12px; border-top: 1px solid #e2e8f0; padding-top: 20px; }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td>
                <div class="logo-text">InvoPay</div>
                <div style="margin-top: 5px; color: #718096;">Sistem Invoice & Payment Management</div>
            </td>
            <td style="text-align: right;">
                <h2 style="margin: 0; color: #1b254b; font-size: 24px;">INVOICE</h2>
                <div style="font-size: 16px; font-weight: bold; color: #4a5568; margin-top: 5px;">{{ $invoice->no_invoice }}</div>
                
                @php
                    $bgClass = 'bg-draft';
                    $displayStatus = $invoice->status;
                    if($invoice->status == 'Paid') { $bgClass = 'bg-paid'; }
                    elseif($invoice->status == 'Pending') { $bgClass = 'bg-pending'; }
                    elseif($invoice->status == 'Sent') { $bgClass = 'bg-sent'; $displayStatus = 'Unpaid'; }
                    elseif($invoice->status == 'Overdue') { $bgClass = 'bg-overdue'; }
                @endphp
                <div class="badge-status {{ $bgClass }}">{{ strtoupper($displayStatus) }}</div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td>
                <div class="info-title">Ditagihkan Kepada:</div>
                <div style="font-weight: bold; font-size: 16px; color: #1b254b;">{{ $invoice->nama_klien }}</div>
                <div style="color: #4a5568;">{{ $invoice->email_klien }}</div>
            </td>
            <td style="text-align: right;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="text-align: right; padding-bottom: 8px; color: #718096; font-size: 12px;">TANGGAL TERBIT</td>
                        <td style="text-align: right; font-weight: bold; padding-bottom: 8px;">{{ \Carbon\Carbon::parse($invoice->tanggal_buat)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right; color: #718096; font-size: 12px;">JATUH TEMPO</td>
                        <td style="text-align: right; font-weight: bold; color: #e53e3e;">{{ \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo)->format('d F Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th>Deskripsi Layanan</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Harga Satuan</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($details as $item)
            <tr>
                <td><strong>{{ $item->nama_produk }}</strong></td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->harga_jual_saat_ini, 0, ',', '.') }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->quantity * $item->harga_jual_saat_ini, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #a0aec0; padding: 20px;">Detail produk tidak ditemukan.</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="2"></td>
                <td style="text-align: right; color: #718096; font-size: 14px;">TOTAL TAGIHAN:</td>
                <td style="text-align: right; color: #5b80ff;">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p style="font-weight: bold; color: #1b254b; font-size: 14px;">InvoPay</p>
        <p>Terima kasih atas kepercayaan Anda menggunakan layanan kami.<br>
        Mohon lakukan pelunasan ke rekening resmi kami sebelum tanggal jatuh tempo yang tertera.</p>
    </div>

</body>
</html>