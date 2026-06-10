<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk</title>
    <style>
    :root {
        /* DIBESARKAN & DITEBALKAN LAGI */
        --scale: 2.2; /* dari 2.0 -> 2.2 (ubah ke 2.3 kalau masih kurang) */
        --font-base: calc(20px * var(--scale));
        --font-small: calc(18px * var(--scale));
        --font-large: calc(64px * var(--scale));
        --font-title: calc(60px * var(--scale));
    }
    * { font-family: "Courier New", monospace; box-sizing: border-box; }
    html, body { width:100%; height:100%; margin:0; padding:0; background:#fff; }
    @page { size: A4 portrait; margin:0; }
    .receipt { width:100%; max-width:100%; padding:40px 5px 52px; font-size:var(--font-base); margin:0 auto; }
    .receipt * { font-weight:850; }
    .header { text-align:center; margin-bottom:32px; }
    .header .title { font-size:var(--font-title); font-weight:900; text-transform:uppercase; line-height:1; margin:10px 0 4px; letter-spacing:1.5px; }
    .header .subtitle { font-size:var(--font-small); margin-top:10px; line-height:1.25; font-weight:700; }
    .line { border-top:7px dashed #000; margin:12px 0; }
    .meta { font-size:var(--font-small); margin-bottom:16px; font-weight:900; }
    .meta div { display:flex; justify-content:space-between; padding:6px 0; }
    table { width:100%; border-collapse:collapse; table-layout:fixed; }
    .items th { text-align:left; font-size:calc(var(--font-base) * 1.1); border-bottom:7px dashed #000; padding-bottom:18px; font-weight:900; letter-spacing:1px; }
    .items td { padding:12px 0 10px; font-size:var(--font-base); font-weight:900; vertical-align:top; }
    /* Kolom: tambah ruang antar Harga & Total supaya tidak mepet */
    .items .name { width:65%; word-break:break-word; overflow-wrap:anywhere; padding-right:16px; }
    .items .name .qtyprice { font-size:calc(var(--font-small) * 0.9); }
    .items .qty  { width:12%; text-align:center; padding-left:12px; padding-right:12px; }
    .items .price { width:24%; text-align:right; padding-left:24px; padding-right:24px; white-space:nowrap; font-weight:900; }
    .items .total { width:35%; text-align:right; padding-right:0; white-space:nowrap; font-weight:900; }
    .totals { margin-top:40px; font-size:calc(var(--font-base) * 1.06); font-weight:900; table-layout:auto; }
    .totals td { padding:4px 0; }
    .totals .label { text-align:left; padding-right:60px; font-weight: 900; }
    .totals .value { text-align:right; padding-left:60px; min-width:250px; padding-right:0; }
    .footer { text-align:center; margin-top:68px; font-size:var(--font-small); font-weight:900; letter-spacing:1px; }
    .qrcode { text-align:center; margin-top:10px; }
    .qrcode svg { width:250px; height:250px; }
    @media print { body { margin:0; } .no-print { display:none; } }
    .no-print { margin-top:24px; text-align:center; }
    .no-print button { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 40px; font-size: 16px; font-weight: bold; border-radius: 10px; cursor: pointer; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); transition: all 0.3s ease; font-family: 'Courier New', monospace; text-transform: uppercase; letter-spacing: 1px; margin: 5px; }
    .no-print button:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6); }
    .no-print button:active { transform: translateY(0); }
    .no-print .btn-back { background: linear-gradient(135deg, #64748b 0%, #475569 100%); }
    </style>
</head>
<body>
<div class="receipt">
    <div class="header">
        <div class="title">{{ $restaurant['name'] ?? 'BeePOS' }}</div>
        <div class="subtitle">
            {{ $restaurant['address'] ?? 'Alamat Restoran' }}<br>
            Telp: {{ $restaurant['phone'] ?? '-' }}
        </div>
    </div>
    <div class="meta">
        <div><span>No. Order</span><span>{{ $order->number ?? $order->order_id ?? '-' }}</span></div>
        <div><span>Tanggal</span><span>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span></div>
        <div><span>Kasir</span><span>{{ $order->cashier_name ?? 'Kasir' }}</span></div>
        @if(!empty($order->customer))
        <div><span>Customer</span><span>{{ $order->customer ?? '-' }}</span></div>
        @endif
    </div>
    <div class="line"></div>
    <table class="items">
        <thead>
            <tr>
                <th class="name">Item</th>
                <th class="total">Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($order->items as $index => $item)
            <tr>
                <td class="name">
                   {{ $index + 1 }}. {{ $item->name }}<br>
                    <span class="qtyprice">{{ $item->qty }} x Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                    @if(!empty($item->note))
                    <br><small style="font-size:calc(var(--font-small) * 0.85); font-style:italic;">Catatan: {{ $item->note }}</small>
                    @endif
                </td>
                <td class="total">Rp{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="line"></div>
    @php
        $subtotal = $order->subtotal ?? 0;
        $discount = $order->discount ?? 0;
        $grandTotal = $order->grand_total ?? $order->total_price ?? 0;
        $paid = $order->paid ?? $order->cash_received ?? 0;
        $change = $order->change ?? $order->change_amount ?? 0;
        $paymentMethod = $order->payment_method ?? 'Cash';
    @endphp
    <table class="totals">
        @if($subtotal > 0)
        <tr><td class="label">Subtotal</td><td class="value">Rp{{ number_format($subtotal, 0, ',', '.') }}</td></tr>
        @endif
        @if($discount > 0)
        <tr><td class="label">Diskon</td><td class="value">- Rp{{ number_format($discount, 0, ',', '.') }}</td></tr>
        @endif
        <tr>
            <td class="label">TOTAL</td>
            <td class="value">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
        </tr>
        @if ($paymentMethod === 'qris')
        <tr><td class="label">Payment (QRIS)</td><td class="value">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td></tr>
        @endif
        @if($paid > 0)
        <tr><td class="label">Bayar ({{ ucfirst($paymentMethod) }})</td><td class="value">Rp{{ number_format($paid, 0, ',', '.') }}</td></tr>
        @endif
        @if($change > 0 && strtolower($paymentMethod) === 'cash')
        <tr><td class="label">Kembalian</td><td class="value">Rp{{ number_format($change, 0, ',', '.') }}</td></tr>
        @endif
    </table>
    @if(!empty($restaurant['receipt_id']) || !empty($order->number))
    <div class="qrcode">
        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($restaurant['receipt_id'] ?? $order->number ?? 'NO-ORDER') !!}
    </div>
    @endif
    <div class="footer">
        <div>TERIMA KASIH</div>
        <div>Silakan Datang Kembali! 🙏</div>
    </div>
    <div class="no-print">
        <button onclick="window.print()">🖨️ CETAK STRUK</button>
        <button class="btn-back" onclick="window.history.back()">← KEMBALI</button>
    </div>
</div>
<script>
	// Auto-print if requested
	const urlParams = new URLSearchParams(window.location.search);
	if (urlParams.get('autoprint') === '1') {
		// Untuk mobile: tunggu load komplit + delay lebih lama
		if (document.readyState === 'complete') {
			// Sudah loaded
			setTimeout(() => {
				window.print();
			}, 800); // delay lebih lama untuk mobile
		} else {
			// Tunggu sampai fully loaded
			window.addEventListener('load', () => {
				setTimeout(() => {
					window.print();
				}, 800);
			});
		}
	}
</script>
</body>
</html>
