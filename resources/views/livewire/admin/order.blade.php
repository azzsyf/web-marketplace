<div class="product-admin order-admin">
    <style>
        /* ==============================
           STATISTIK
        ============================== */
        .order-admin .order-stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .order-admin .order-stat-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background: #f0edff;
            color: #6654dc;
            font-size: 17px;
        }

        .order-admin .order-stat-icon.red {
            background: #fff0f1;
            color: #e10613;
        }

        .order-admin .order-stat-icon.orange {
            background: #fff6e7;
            color: #c17b0b;
        }

        .order-admin .order-stat-icon.blue {
            background: #edf4ff;
            color: #376ac5;
        }

        .order-admin .order-stat-icon.green {
            background: #eaf8ef;
            color: #23804b;
        }

        .order-admin .order-stat-content {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .order-admin .order-stat-content span {
            display: block;
            color: #73758a;
            font-size: 11px;
            font-weight: 700;
        }

        .order-admin .order-stat-content strong {
            display: block;
            margin-top: 5px;
            color: #11122f;
            font-size: 21px;
            line-height: 1.1;
            font-weight: 900;
            overflow-wrap: anywhere;
        }

        .order-admin .order-stat-content strong.red-text {
            color: #e10613;
            font-size: 18px;
        }

        /* ==============================
           HEADER DAN FILTER
        ============================== */
        .order-admin .order-toolbar-copy h2 {
            margin: 0 0 5px;
        }

        .order-admin .order-toolbar-copy p {
            margin: 0;
            color: #77798d;
            font-size: 12px;
            line-height: 1.5;
        }

        .order-admin .pa-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .order-admin .order-toolbar-copy {
            flex: 0 0 30%;
            min-width: 190px;
        }

        .order-admin .order-filters {
            display: grid;
            flex: 1 1 auto;
            min-width: 0;
            grid-template-columns:
                minmax(180px, 1.35fr) minmax(140px, .8fr) minmax(155px, .95fr);
            align-items: center;
            gap: 10px;
        }

        .order-admin .order-search,
        .order-admin .order-select {
            width: 100% !important;
            min-width: 0;
            max-width: 100%;
            height: 44px;
        }

        /* ==============================
           TABEL
        ============================== */
        .order-admin .order-table {
            min-width: 920px;
        }

        .order-admin .pa-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .order-admin .pa-table {
            width: 100%;
        }

        .order-admin .pa-card {
            min-width: 0;
        }

        .order-admin .order-detail-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            white-space: nowrap;
        }

        .order-admin .order-number {
            display: block;
            color: #11122f;
            font-weight: 900;
        }

        .order-admin .order-customer {
            display: block;
            color: #11122f;
            font-weight: 800;
        }

        .order-admin .order-muted {
            display: block;
            margin-top: 4px;
            color: #77798d;
            font-size: 11px;
        }

        .order-admin .order-amount {
            white-space: nowrap;
            color: #11122f;
            font-weight: 900;
        }

        .order-admin .order-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .order-admin .order-status.pending {
            background: #fff5df;
            color: #956100;
        }

        .order-admin .order-status.processing {
            background: #eaf2ff;
            color: #2458a6;
        }

        .order-admin .order-status.shipped {
            background: #f0eaff;
            color: #6841a5;
        }

        .order-admin .order-status.completed,
        .order-admin .order-status.paid {
            background: #e8f8ee;
            color: #167341;
        }

        .order-admin .order-status.unpaid {
            background: #fff1f1;
            color: #c12836;
        }

        .order-admin .order-status.cancelled,
        .order-admin .order-status.failed,
        .order-admin .order-status.refunded {
            background: #f1f1f4;
            color: #666879;
        }

        /* ==============================
           EMPTY STATE DAN ALERT
        ============================== */
        .order-admin .order-empty {
            padding: 48px 20px;
            text-align: center;
            color: #77798d;
        }

        .order-admin .order-empty-icon {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            margin: 0 auto 12px;
            border-radius: 16px;
            background: #f2f1fb;
            color: #6654dc;
            font-size: 22px;
        }

        .order-admin .order-empty strong {
            display: block;
            margin-bottom: 5px;
            color: #11122f;
            font-size: 14px;
        }

        .order-admin .order-empty span {
            font-size: 12px;
        }

        .order-admin .order-alert {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            padding: 12px 14px;
            border: 1px solid #ccebd6;
            border-radius: 9px;
            background: #effaf2;
            color: #17683b;
            font-size: 12px;
        }

        .order-admin .order-alert-error {
            border-color: #f4cbd0;
            background: #fff2f3;
            color: #b42332;
        }

        /* ==============================
           MODAL DETAIL PESANAN
        ============================== */
        .order-admin .order-modal {
            width: min(760px, calc(100vw - 32px)) !important;
            max-width: 760px !important;
            max-height: 88vh;
            padding: 0 !important;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: 20px;
            background: #fff;
        }

        /* Header modal tetap */
        .order-admin .order-modal .pa-modal-header {
            flex: 0 0 auto;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            padding: 22px 28px;
            border-bottom: 1px solid #e9eaf1;
        }

        .order-admin .order-modal-topline h2 {
            margin: 0 0 5px;
        }

        .order-admin .order-modal-order-number {
            color: #77798d;
            font-size: 12px;
        }

        .order-admin .order-modal .pa-close {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 12px;
        }

        /* Bagian ini saja yang scroll */
        .order-admin .order-modal-body {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: #c9cad5 #f5f6fa;
        }

        .order-admin .order-modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .order-admin .order-modal-body::-webkit-scrollbar-track {
            background: #f5f6fa;
        }

        .order-admin .order-modal-body::-webkit-scrollbar-thumb {
            background: #c9cad5;
            border-radius: 10px;
        }

        /* Section modal */
        .order-admin .order-modal-section {
            padding: 22px 28px;
            border-bottom: 1px solid #e9eaf1;
        }

        .order-admin .order-modal-section:last-child {
            border-bottom: 0;
        }

        .order-admin .order-modal-section h3 {
            margin: 0 0 16px;
            color: #11122f;
            font-size: 15px;
            font-weight: 900;
        }

        /* Grid informasi */
        .order-admin .order-detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 24px;
        }

        .order-admin .order-detail-item {
            min-width: 0;
        }

        .order-admin .order-detail-item.full {
            grid-column: 1 / -1;
        }

        .order-admin .order-detail-label {
            display: block;
            margin-bottom: 6px;
            color: #85879b;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .order-admin .order-detail-value {
            display: block;
            color: #171832;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        /* Item pesanan */
        .order-admin .order-item-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            padding: 13px 0;
            border-bottom: 1px solid #eff0f5;
            color: #11122f;
            font-size: 12px;
        }

        .order-admin .order-item-row:last-child {
            border-bottom: 0;
        }

        .order-admin .order-item-row small {
            display: block;
            margin-top: 4px;
            color: #77798d;
            font-size: 11px;
            line-height: 1.7;
        }

        .order-admin .order-item-total {
            white-space: nowrap;
            font-weight: 900;
        }

        /* Total pembayaran */
        .order-admin .order-total-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 8px;
            padding-top: 16px;
            border-top: 1px solid #e9eaf1;
            color: #11122f;
            font-size: 13px;
            font-weight: 900;
        }

        .order-admin .order-total-row strong {
            color: #e10613;
            font-size: 17px;
        }

        /* Form update status */
        .order-admin .order-update-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: end;
            gap: 14px;
            margin-top: 13px;
        }

        .order-admin .order-update-grid .pa-field {
            min-width: 0;
        }

        .order-admin .order-update-grid .pa-select {
            width: 100%;
        }

        .order-admin .order-update-grid .pa-error {
            display: block;
            margin-top: 5px;
        }

        .order-admin .order-update-grid .pa-btn {
            min-height: 44px;
            white-space: nowrap;
        }

        /* Footer modal tetap */
        .order-admin .order-modal .pa-modal-footer {
            flex: 0 0 auto;
            padding: 16px 28px;
            border-top: 1px solid #e9eaf1;
            background: #fff;
        }

        /* ==============================
           RESPONSIVE
        ============================== */
        @media (max-width: 1200px) {
            .order-admin .order-stats {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1000px) {
            .order-admin .pa-toolbar {
                align-items: stretch;
                flex-direction: column;
                gap: 16px;
            }

            .order-admin .order-toolbar-copy {
                flex-basis: auto;
            }

            .order-admin .order-filters {
                grid-template-columns:
                    minmax(0, 1.3fr) minmax(145px, .8fr) minmax(155px, .9fr);
            }
        }

        @media (max-width: 800px) {
            .order-admin .order-filters {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .order-admin .order-search {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 600px) {
            .order-admin .order-modal {
                width: calc(100vw - 24px) !important;
                max-height: 90vh;
                border-radius: 15px;
            }

            .order-admin .order-modal .pa-modal-header,
            .order-admin .order-modal-section,
            .order-admin .order-modal .pa-modal-footer {
                padding-left: 18px;
                padding-right: 18px;
            }

            .order-admin .order-detail-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .order-admin .order-detail-item.full {
                grid-column: auto;
            }

            .order-admin .order-update-grid {
                grid-template-columns: 1fr;
            }

            .order-admin .order-update-grid .pa-btn {
                width: 100%;
            }
        }

        @media (max-width: 560px) {
            .order-admin .order-filters {
                grid-template-columns: 1fr;
            }

            .order-admin .order-search {
                grid-column: auto;
            }

            .order-admin .pa-header {
                align-items: flex-start;
            }

            .order-admin .order-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 9px;
            }

            .order-admin .pa-stat {
                padding: 13px;
            }

            .order-admin .order-stat-content {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
            }

            .order-admin .order-stat-content strong {
                font-size: 19px;
            }

            .order-admin .order-stat-content strong.red-text {
                font-size: 15px;
            }
        }

        /* ==========================================
           ORDER STATISTICS - FINAL LAYOUT
           Ikon dan teks sejajar, tidak terpotong
        ========================================== */

        .order-admin .order-stats {
            display: grid !important;
            grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
            align-items: stretch;
            gap: 18px !important;
            width: 100%;
            margin: 0 0 26px !important;
        }

        .order-admin .order-stats>.pa-stat {
            box-sizing: border-box !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            width: 100%;
            min-width: 0 !important;
            min-height: 138px !important;
            padding: 22px 20px !important;
            overflow: visible !important;
            background: #fff !important;
            border: 1px solid #e5e8f2 !important;
            border-radius: 24px !important;
            box-shadow: 0 5px 20px rgba(20, 30, 70, .035) !important;
        }

        .order-admin .order-stat-content {
            box-sizing: border-box !important;
            display: grid !important;
            grid-template-columns: 64px minmax(0, 1fr) !important;
            align-items: center !important;
            gap: 14px !important;
            width: 100% !important;
            min-width: 0 !important;
        }

        .order-admin .order-stat-icon {
            box-sizing: border-box !important;
            display: grid !important;
            place-items: center !important;
            width: 64px !important;
            min-width: 64px !important;
            max-width: 64px !important;
            height: 64px !important;
            min-height: 64px !important;
            margin: 0 !important;
            border-radius: 17px !important;
            font-size: 21px !important;
            line-height: 1 !important;
        }

        .order-admin .order-stat-icon:not(.red):not(.orange):not(.blue):not(.green) {
            background: #eeeaff !important;
            color: #6654dc !important;
        }

        .order-admin .order-stat-icon.orange {
            background: #fff3df !important;
            color: #d28a0b !important;
        }

        .order-admin .order-stat-icon.blue {
            background: #eaf2ff !important;
            color: #376ac5 !important;
        }

        .order-admin .order-stat-icon.green {
            background: #e5f7ed !important;
            color: #079b61 !important;
        }

        .order-admin .order-stat-icon.red {
            background: #ffedf0 !important;
            color: #e63b5d !important;
        }

        .order-admin .order-stat-content>div {
            display: block !important;
            width: auto !important;
            min-width: 0 !important;
            max-width: none !important;
            overflow: visible !important;
        }

        .order-admin .order-stat-content>div>span {
            display: block !important;
            max-width: 100%;
            margin: 0 !important;
            color: #77798d !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            line-height: 1.35 !important;
            white-space: normal !important;
            overflow: visible !important;
            overflow-wrap: break-word !important;
            word-break: normal !important;
        }

        .order-admin .order-stat-content strong {
            display: block !important;
            max-width: 100%;
            margin-top: 7px !important;
            color: #11122f !important;
            font-size: 32px !important;
            font-weight: 900 !important;
            line-height: 1.08 !important;
            white-space: normal !important;
            overflow-wrap: normal !important;
        }

        .order-admin .order-stat-content strong.red-text {
            color: #e10613 !important;
            font-size: clamp(19px, 1.55vw, 26px) !important;
            white-space: nowrap !important;
        }

        /* Laptop / layar sedang */
        @media (max-width: 1350px) {
            .order-admin .order-stats {
                gap: 13px !important;
            }

            .order-admin .order-stats>.pa-stat {
                min-height: 128px !important;
                padding: 18px 14px !important;
                border-radius: 20px !important;
            }

            .order-admin .order-stat-content {
                grid-template-columns: 56px minmax(0, 1fr) !important;
                gap: 11px !important;
            }

            .order-admin .order-stat-icon {
                width: 56px !important;
                min-width: 56px !important;
                max-width: 56px !important;
                height: 56px !important;
                min-height: 56px !important;
                border-radius: 15px !important;
                font-size: 19px !important;
            }

            .order-admin .order-stat-content>div>span {
                font-size: 12px !important;
            }

            .order-admin .order-stat-content strong {
                font-size: 27px !important;
            }

            .order-admin .order-stat-content strong.red-text {
                font-size: clamp(17px, 1.4vw, 22px) !important;
            }
        }

        /* Tablet */
        @media (max-width: 1050px) {
            .order-admin .order-stats {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                gap: 14px !important;
            }

            .order-admin .order-stats>.pa-stat {
                min-height: 126px !important;
                padding: 18px !important;
            }

            .order-admin .order-stat-content {
                grid-template-columns: 58px minmax(0, 1fr) !important;
                gap: 12px !important;
            }

            .order-admin .order-stat-icon {
                width: 58px !important;
                min-width: 58px !important;
                max-width: 58px !important;
                height: 58px !important;
                min-height: 58px !important;
            }

            .order-admin .order-stat-content>div>span {
                font-size: 13px !important;
            }

            .order-admin .order-stat-content strong {
                font-size: 29px !important;
            }
        }

        /* Mobile */
        @media (max-width: 600px) {
            .order-admin .order-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 11px !important;
            }

            .order-admin .order-stats>.pa-stat {
                min-height: 105px !important;
                padding: 13px !important;
                border-radius: 16px !important;
            }

            .order-admin .order-stat-content {
                grid-template-columns: 43px minmax(0, 1fr) !important;
                gap: 9px !important;
            }

            .order-admin .order-stat-icon {
                width: 43px !important;
                min-width: 43px !important;
                max-width: 43px !important;
                height: 43px !important;
                min-height: 43px !important;
                border-radius: 12px !important;
                font-size: 16px !important;
            }

            .order-admin .order-stat-content>div>span {
                font-size: 10px !important;
                line-height: 1.3 !important;
            }

            .order-admin .order-stat-content strong {
                margin-top: 5px !important;
                font-size: 23px !important;
            }

            .order-admin .order-stat-content strong.red-text {
                font-size: 15px !important;
            }
        }

        @media (max-width: 360px) {
            .order-admin .order-stats {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    {{-- HEADER --}}
    <div class="pa-header">
        <div>
            <h1>Manajemen Pesanan</h1>
            <p>Kelola pesanan, pembayaran, dan proses pengiriman Bakoel Jaersey.</p>
        </div>
    </div>

    {{-- ALERT --}}
    @if (session()->has('success'))
        <div class="order-alert" role="status">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="order-alert order-alert-error" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    @php
        $statusLabels = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'shipped' => 'Dalam Pengiriman',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $paymentLabels = [
            'unpaid' => 'Belum Dibayar',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan',
        ];
    @endphp

    {{-- STATISTIK --}}
    <div class="order-stats">
        <div class="pa-stat">
            <div class="order-stat-content">
                <span class="order-stat-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                </span>
                <div>
                    <span>Total Pesanan</span>
                    <strong>{{ number_format($stats['total'], 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <div class="pa-stat">
            <div class="order-stat-content">
                <span class="order-stat-icon orange">
                    <i class="fa-solid fa-clock"></i>
                </span>
                <div>
                    <span>Menunggu</span>
                    <strong>{{ number_format($stats['pending'], 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <div class="pa-stat">
            <div class="order-stat-content">
                <span class="order-stat-icon blue">
                    <i class="fa-solid fa-box"></i>
                </span>
                <div>
                    <span>Diproses</span>
                    <strong>{{ number_format($stats['processing'], 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <div class="pa-stat">
            <div class="order-stat-content">
                <span class="order-stat-icon green">
                    <i class="fa-solid fa-truck-fast"></i>
                </span>
                <div>
                    <span>Dalam Pengiriman</span>
                    <strong>{{ number_format($stats['shipped'], 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <div class="pa-stat">
            <div class="order-stat-content">
                <span class="order-stat-icon red">
                    <i class="fa-solid fa-wallet"></i>
                </span>
                <div>
                    <span>Total Pembayaran Lunas</span>
                    <strong class="red-text">
                        Rp {{ number_format((float) $stats['paid_total'], 0, ',', '.') }}
                    </strong>
                </div>
            </div>
        </div>
    </div>

    {{-- DAFTAR PESANAN --}}
    <div class="pa-card">
        <div class="pa-toolbar">
            <div class="order-toolbar-copy">
                <h2>Daftar Pesanan</h2>
                <p>Pantau status pesanan dan pembayaran pelanggan.</p>
            </div>

            <div class="order-filters">
                <input type="search" class="pa-input order-search" placeholder="Cari nomor, nama, telepon..."
                    wire:model.live.debounce.400ms="search">

                <select class="pa-select order-select" wire:model.live="statusFilter"
                    aria-label="Filter status pesanan">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="processing">Diproses</option>
                    <option value="shipped">Dalam Pengiriman</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>

                <select class="pa-select order-select" wire:model.live="paymentFilter" aria-label="Filter pembayaran">
                    <option value="all">Semua Pembayaran</option>
                    <option value="unpaid">Belum Dibayar</option>
                    <option value="paid">Lunas</option>
                    <option value="failed">Gagal</option>
                    <option value="refunded">Dikembalikan</option>
                </select>
            </div>
        </div>

        <div class="pa-table-wrap">
            <table class="pa-table order-table">
                <thead>
                    <tr>
                        <th>Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr wire:key="admin-order-{{ $order->id }}">
                            <td>
                                <div class="order-number">{{ $order->order_number }}</div>
                                <span class="order-muted">
                                    {{ number_format($order->items_count) }} item
                                </span>
                            </td>

                            <td>
                                <div class="order-customer">{{ $order->customer_name }}</div>
                                <span class="order-muted">{{ $order->customer_phone }}</span>
                            </td>

                            <td>
                                <div>
                                    {{ ($order->placed_at ?? $order->created_at)?->format('d M Y') ?? '-' }}
                                </div>
                                <span class="order-muted">
                                    {{ ($order->placed_at ?? $order->created_at)?->format('H:i') ?? '' }}
                                </span>
                            </td>

                            <td>
                                <strong class="order-amount">
                                    Rp {{ number_format((float) $order->grand_total, 0, ',', '.') }}
                                </strong>
                            </td>

                            <td>
                                <span class="order-status {{ $order->payment_status }}">
                                    {{ $paymentLabels[$order->payment_status] ?? ucfirst($order->payment_status) }}
                                </span>
                            </td>

                            <td>
                                <span class="order-status {{ $order->status }}">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="pa-actions">
                                    <button type="button" class="pa-icon-btn order-detail-btn"
                                        title="Lihat detail pesanan" wire:click="openDetail({{ $order->id }})">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="order-empty">
                                    <div class="order-empty-icon">
                                        <i class="fa-solid fa-box-open"></i>
                                    </div>
                                    <strong>Pesanan belum ditemukan</strong>
                                    <span>
                                        Ubah kata kunci pencarian atau filter yang digunakan.
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="pa-pagination">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL DETAIL PESANAN --}}
    @if ($selectedOrder)
        <div class="pa-overlay" wire:click.self="closeDetail" wire:keydown.escape.window="closeDetail"
            wire:key="order-detail-overlay">
            <section class="pa-modal order-modal" role="dialog" aria-modal="true" aria-labelledby="order-modal-title"
                wire:click.stop>
                {{-- HEADER MODAL: TETAP --}}
                <div class="pa-modal-header order-modal-topline">
                    <div>
                        <h2 id="order-modal-title">Detail Pesanan</h2>
                        <span class="order-modal-order-number">
                            {{ $selectedOrder->order_number }}
                        </span>
                    </div>

                    <button type="button" class="pa-close" wire:click="closeDetail" aria-label="Tutup detail">
                        ×
                    </button>
                </div>

                {{-- BODY MODAL: BAGIAN INI YANG SCROLL --}}
                <div class="order-modal-body">

                    {{-- INFORMASI PELANGGAN --}}
                    <div class="order-modal-section">
                        <h3>Informasi Pelanggan</h3>

                        <div class="order-detail-grid">
                            <div class="order-detail-item">
                                <span class="order-detail-label">Nama Penerima</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->customer_name }}
                                </span>
                            </div>

                            <div class="order-detail-item">
                                <span class="order-detail-label">Nomor Telepon</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->customer_phone }}
                                </span>
                            </div>

                            <div class="order-detail-item">
                                <span class="order-detail-label">Email</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->customer_email ?: '-' }}
                                </span>
                            </div>

                            <div class="order-detail-item">
                                <span class="order-detail-label">Metode Pembayaran</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->payment_method === 'bank_transfer'
                                        ? 'Transfer Bank'
                                        : strtoupper($selectedOrder->payment_method) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- ALAMAT DAN PENGIRIMAN --}}
                    <div class="order-modal-section">
                        <h3>Alamat dan Pengiriman</h3>

                        <div class="order-detail-grid">
                            <div class="order-detail-item full">
                                <span class="order-detail-label">Tujuan</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->shipping_destination_label ?:
                                        trim(($selectedOrder->shipping_city ?? '') . ', ' . ($selectedOrder->shipping_province ?? ''), ', ') }}
                                </span>
                            </div>

                            <div class="order-detail-item">
                                <span class="order-detail-label">Ekspedisi / Layanan</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->shipping_courier_name ?: ($selectedOrder->shipping_courier ?: '-') }}
                                    {{ $selectedOrder->shipping_service ?: '' }}

                                    @if ($selectedOrder->shipping_etd)
                                        <br>Estimasi: {{ $selectedOrder->shipping_etd }}
                                    @endif
                                </span>
                            </div>

                            <div class="order-detail-item">
                                <span class="order-detail-label">Kode Pos</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->shipping_postal_code ?: '-' }}
                                </span>
                            </div>

                            <div class="order-detail-item">
                                <span class="order-detail-label">Ongkos Kirim</span>
                                <span class="order-detail-value">
                                    Rp {{ number_format((float) $selectedOrder->shipping_cost, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="order-detail-item full">
                                <span class="order-detail-label">Alamat Lengkap</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->shipping_address }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- ITEM PESANAN --}}
                    <div class="order-modal-section">
                        <h3>Item Pesanan</h3>

                        @foreach ($selectedOrder->items as $item)
                            <div class="order-item-row" wire:key="admin-order-item-{{ $item->id }}">
                                <div>
                                    <strong>{{ $item->product_name }}</strong>
                                    <small>
                                        {{ $item->variant_size ?: '-' }}
                                        /
                                        {{ $item->variant_color ?: '-' }}
                                        ·
                                        {{ $item->quantity }}
                                        ×
                                        Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                    </small>
                                </div>

                                <strong class="order-item-total">
                                    Rp {{ number_format((float) $item->line_total, 0, ',', '.') }}
                                </strong>
                            </div>
                        @endforeach

                        <div class="order-item-row">
                            <span>Subtotal Produk</span>
                            <strong>
                                Rp {{ number_format((float) $selectedOrder->subtotal, 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="order-item-row">
                            <span>Ongkos Kirim</span>
                            <strong>
                                Rp {{ number_format((float) $selectedOrder->shipping_cost, 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="order-total-row">
                            <span>Total Pembayaran</span>
                            <strong>
                                Rp {{ number_format((float) $selectedOrder->grand_total, 0, ',', '.') }}
                            </strong>
                        </div>

                        @if ($selectedOrder->notes)
                            <div style="margin-top:14px">
                                <span class="order-detail-label">Catatan Pesanan</span>
                                <span class="order-detail-value">
                                    {{ $selectedOrder->notes }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- PERBARUI STATUS --}}
                    <div class="order-modal-section">
                        <h3>Perbarui Pesanan</h3>

                        @if ($selectedOrder->status === 'cancelled')
                            <div class="order-alert order-alert-error">
                                Pesanan ini sudah dibatalkan.
                                Perubahan status pesanan dinonaktifkan.
                            </div>
                        @else
                            <div class="order-update-grid">
                                <div class="pa-field">
                                    <label for="statusDraft">Status Pesanan</label>

                                    <select id="statusDraft" class="pa-select" wire:model="statusDraft">
                                        <option value="pending">Menunggu</option>
                                        <option value="processing">Diproses</option>
                                        <option value="shipped">Dalam Pengiriman</option>
                                        <option value="completed">Selesai</option>
                                    </select>

                                    @error('statusDraft')
                                        <span class="pa-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="button" class="pa-btn pa-primary" wire:click="saveOrderStatus"
                                    wire:loading.attr="disabled" wire:target="saveOrderStatus">
                                    <span wire:loading.remove wire:target="saveOrderStatus">
                                        Simpan Status
                                    </span>
                                    <span wire:loading wire:target="saveOrderStatus">
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        @endif

                        <div class="order-update-grid">
                            <div class="pa-field">
                                <label for="paymentStatusDraft">Status Pembayaran</label>

                                <select id="paymentStatusDraft" class="pa-select" wire:model="paymentStatusDraft">
                                    <option value="unpaid">Belum Dibayar</option>
                                    <option value="paid">Lunas</option>
                                </select>

                                @error('paymentStatusDraft')
                                    <span class="pa-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="button" class="pa-btn pa-primary" wire:click="savePaymentStatus"
                                wire:loading.attr="disabled" wire:target="savePaymentStatus">
                                <span wire:loading.remove wire:target="savePaymentStatus">
                                    Simpan Pembayaran
                                </span>
                                <span wire:loading wire:target="savePaymentStatus">
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </div>

                </div>
                {{-- END BODY MODAL --}}

                {{-- FOOTER MODAL: TETAP --}}
                <div class="pa-modal-footer">
                    <button type="button" class="pa-btn pa-secondary" wire:click="closeDetail">
                        Tutup
                    </button>
                </div>
            </section>
        </div>
    @endif
</div>
