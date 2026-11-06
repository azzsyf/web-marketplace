<div class="bj-checkout-success-page">
    <style>
        .bj-checkout-success-page {
            --success-red: #e10613;
            --success-ink: #0b0b2b;
            min-height: calc(100vh - 84px);
            padding: 50px 0 70px;
            background: #f5f6fa;
            color: var(--success-ink);
            font-family: 'DM Sans', sans-serif;
        }
        .bj-success-container { width: min(760px, 92%); margin: 0 auto; }
        .bj-success-card {
            padding: 34px;
            border: 1px solid #e5e6ee;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(11, 11, 43, .05);
        }
        .bj-success-icon {
            width: 64px; height: 64px; display: grid; place-items: center;
            margin: 0 auto 18px; border-radius: 50%; background: #e9f8ef; color: #168447;
        }
        .bj-success-icon svg { width: 32px; height: 32px; }
        .bj-success-heading { text-align: center; }
        .bj-success-heading h1 {
            margin: 0 0 8px; font: 900 38px/1 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
        }
        .bj-success-heading p { margin: 0; color: #73758a; font-size: 14px; line-height: 1.6; }
        .bj-success-number {
            margin: 25px 0; padding: 16px; border-radius: 12px; background: #fff5f6; text-align: center;
        }
        .bj-success-number small { display: block; color: #73758a; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .bj-success-number strong { display: block; margin-top: 5px; color: var(--success-red); font-size: 23px; letter-spacing: .5px; }
        .bj-success-info { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 24px; }
        .bj-success-info div { padding: 13px; border: 1px solid #e8e9ef; border-radius: 10px; }
        .bj-success-info small { display: block; margin-bottom: 5px; color: #73758a; font-size: 11px; }
        .bj-success-info strong { font-size: 13px; }
        .bj-success-items { margin-top: 20px; border-top: 1px solid #e8e9ef; }
        .bj-success-item { display: flex; justify-content: space-between; gap: 15px; padding: 13px 0; border-bottom: 1px solid #e8e9ef; font-size: 13px; }
        .bj-success-item span:last-child { white-space: nowrap; font-weight: 700; }
        .bj-success-total { display: flex; justify-content: space-between; gap: 15px; padding-top: 18px; font-size: 15px; font-weight: 800; }
        .bj-success-total strong { color: var(--success-red); font-size: 20px; }
        .bj-success-warning { margin: 20px 0 0; padding: 12px 14px; border-radius: 9px; background: #fff8e8; color: #805b15; font-size: 12px; line-height: 1.6; }
        .bj-success-home { display: flex; justify-content: center; margin-top: 25px; }
        .bj-success-home a { display: inline-flex; padding: 13px 25px; border-radius: 999px; background: var(--success-red); color: #fff; font: 800 19px 'Barlow Condensed', sans-serif; text-decoration: none; text-transform: uppercase; }
        @media(max-width:560px) {
            .bj-success-card { padding: 22px 18px; }
            .bj-success-info { grid-template-columns: 1fr; }
            .bj-success-heading h1 { font-size: 32px; }
        }
    </style>

    <div class="bj-success-container">
        <div class="bj-success-card">
            <div class="bj-success-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m5 12 4 4L19 6" />
                </svg>
            </div>

            <div class="bj-success-heading">
                <h1>Pesanan Berhasil Dibuat!</h1>
                <p>Terima kasih sudah berbelanja di Bakoel Jaersey. Simpan nomor pesanan berikut untuk pengecekan selanjutnya.</p>
            </div>

            <div class="bj-success-number">
                <small>Nomor pesanan</small>
                <strong>{{ $order->order_number }}</strong>
            </div>

            <div class="bj-success-info">
                <div>
                    <small>Nama penerima</small>
                    <strong>{{ $order->customer_name }}</strong>
                </div>
                <div>
                    <small>Nomor telepon</small>
                    <strong>{{ $order->customer_phone }}</strong>
                </div>
                <div>
                    <small>Metode pembayaran</small>
                    <strong>{{ $order->payment_method === 'bank_transfer' ? 'Transfer bank' : 'COD / Bayar di tempat' }}</strong>
                </div>
                <div>
                    <small>Status pesanan</small>
                    <strong>Menunggu konfirmasi</strong>
                </div>
            </div>

            <strong>Ringkasan item</strong>
            <div class="bj-success-items">
                @foreach ($order->items as $item)
                    <div class="bj-success-item">
                        <span>{{ $item->product_name }} ({{ $item->variant_size }} / {{ $item->variant_color }}) × {{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->line_total, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="bj-success-total">
                <span>Total sementara</span>
                <strong>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</strong>
            </div>

            <p class="bj-success-warning">
                Ongkos kirim belum termasuk dalam total ini. Admin akan menghubungi penerima untuk mengonfirmasi ongkir dan instruksi pembayaran. Status pembayaran saat ini: belum dibayar.
            </p>

            <div class="bj-success-home">
                <a href="{{ route('home') }}">Kembali ke toko</a>
            </div>
        </div>
    </div>
</div>
