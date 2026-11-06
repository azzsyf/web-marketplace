<div class="bj-checkout-page">
    <style>
        .bj-checkout-page {
            --co-red: #e10613;
            --co-dark: #0b0b2b;
            --co-gray: #73758a;
            --co-line: #e5e6ee;
            min-height: 100vh;
            padding: 34px 0 64px;
            background: #f5f6fa;
            color: var(--co-dark);
            font-family: 'DM Sans', sans-serif;
        }

        .bj-checkout-page *,
        .bj-checkout-page *::before,
        .bj-checkout-page *::after {
            box-sizing: border-box;
        }

        .bj-checkout-container {
            width: min(1180px, 92%);
            margin: 0 auto;
        }

        .bj-checkout-heading {
            margin-bottom: 24px;
        }

        .bj-checkout-heading h1 {
            margin: 0 0 6px;
            color: var(--co-dark);
            font: 900 clamp(34px, 4vw, 46px)/1 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
        }

        .bj-checkout-heading p {
            margin: 0;
            color: var(--co-gray);
            font-size: 14px;
        }

        .bj-checkout-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(310px, .75fr);
            align-items: start;
            gap: 24px;
        }

        .bj-checkout-card {
            padding: 26px;
            border: 1px solid var(--co-line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(11, 11, 43, .035);
        }

        .bj-checkout-section+.bj-checkout-section {
            margin-top: 26px;
            padding-top: 24px;
            border-top: 1px solid var(--co-line);
        }

        .bj-checkout-section h2,
        .bj-summary-title {
            margin: 0 0 18px;
            color: var(--co-dark);
            font: 800 26px/1 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
        }

        .bj-checkout-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .bj-checkout-field {
            min-width: 0;
        }

        .bj-checkout-field.full {
            grid-column: 1 / -1;
        }

        .bj-checkout-field label {
            display: block;
            margin-bottom: 7px;
            color: #38394d;
            font-size: 13px;
            font-weight: 700;
        }

        .bj-checkout-field input,
        .bj-checkout-field select,
        .bj-checkout-field textarea {
            display: block;
            width: 100%;
            min-height: 46px;
            padding: 11px 13px;
            border: 1px solid #d9dbe5;
            border-radius: 9px;
            outline: none;
            background: #fff;
            color: var(--co-dark);
            font: 14px 'DM Sans', sans-serif;
            transition: border-color .2s, box-shadow .2s;
        }

        .bj-checkout-field textarea {
            min-height: 105px;
            resize: vertical;
        }

        .bj-checkout-field input:focus,
        .bj-checkout-field select:focus,
        .bj-checkout-field textarea:focus {
            border-color: var(--co-red);
            box-shadow: 0 0 0 3px rgba(225, 6, 19, .09);
        }

        .bj-checkout-error {
            display: block;
            margin-top: 6px;
            color: #c1122b;
            font-size: 12px;
        }

        .bj-destination-results {
            position: relative;
            z-index: 5;
            display: grid;
            gap: 6px;
            max-height: 260px;
            margin-top: 7px;
            padding: 6px;
            overflow-y: auto;
            border: 1px solid var(--co-line);
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 10px 24px rgba(11, 11, 43, .08);
        }

        .bj-destination-result {
            width: 100%;
            padding: 10px 11px;
            border: 0;
            border-radius: 7px;
            background: #fff;
            color: var(--co-dark);
            text-align: left;
            cursor: pointer;
        }

        .bj-destination-result:hover {
            background: #fff5f6;
        }

        .bj-destination-result strong {
            display: block;
            margin-bottom: 3px;
            font-size: 12px;
        }

        .bj-destination-result small {
            color: var(--co-gray);
            font-size: 11px;
        }

        .bj-destination-selected {
            margin-top: 9px;
            padding: 11px 13px;
            border: 1px solid #cfe8d7;
            border-radius: 9px;
            background: #f2fbf5;
            color: #176534;
            font-size: 12px;
            line-height: 1.6;
        }

        .bj-shipping-options {
            display: grid;
            gap: 9px;
            margin-top: 10px;
        }

        .bj-shipping-option {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px;
            border: 1px solid #d9dbe5;
            border-radius: 10px;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .bj-shipping-option.is-selected {
            border-color: var(--co-red);
            background: #fff5f6;
        }

        .bj-shipping-option input {
            margin-top: 3px;
            accent-color: var(--co-red);
        }

        .bj-shipping-option-main {
            flex: 1;
            min-width: 0;
        }

        .bj-shipping-option-head {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .bj-shipping-option strong {
            display: block;
            color: var(--co-dark);
            font-size: 13px;
        }

        .bj-shipping-option-price {
            white-space: nowrap;
            color: var(--co-red);
            font-size: 13px;
            font-weight: 800;
        }

        .bj-shipping-option small {
            display: block;
            margin-top: 4px;
            color: var(--co-gray);
            font-size: 11px;
            line-height: 1.5;
        }

        .bj-shipping-loading {
            padding: 12px;
            border-radius: 8px;
            background: #f5f6fa;
            color: var(--co-gray);
            font-size: 12px;
        }

        .bj-shipping-empty {
            padding: 12px;
            border-radius: 8px;
            background: #fff8e8;
            color: #805b15;
            font-size: 12px;
            line-height: 1.6;
        }

        .bj-weight-note {
            margin-top: 8px;
            color: var(--co-gray);
            font-size: 11px;
        }

        .bj-payment-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .bj-payment-option {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            min-height: 86px;
            padding: 14px;
            border: 1px solid #d9dbe5;
            border-radius: 10px;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .bj-payment-option:has(input:checked) {
            border-color: var(--co-red);
            background: #fff5f6;
        }

        .bj-payment-option input {
            margin-top: 3px;
            accent-color: var(--co-red);
        }

        .bj-payment-option strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .bj-payment-option small {
            display: block;
            color: var(--co-gray);
            font-size: 11px;
            line-height: 1.5;
        }

        .bj-checkout-summary {
            position: sticky;
            top: 104px;
        }

        .bj-summary-items {
            display: grid;
            gap: 15px;
        }

        .bj-summary-item {
            display: grid;
            grid-template-columns: 62px minmax(0, 1fr) auto;
            align-items: center;
            gap: 11px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--co-line);
        }

        .bj-summary-image {
            width: 62px;
            height: 70px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border-radius: 8px;
            background: #f1f2f7;
            color: #999bad;
        }

        .bj-summary-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .bj-summary-name {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.35;
        }

        .bj-summary-variant {
            color: var(--co-gray);
            font-size: 11px;
        }

        .bj-summary-qty {
            color: var(--co-gray);
            font-size: 11px;
        }

        .bj-summary-line-total {
            white-space: nowrap;
            color: var(--co-dark);
            font-size: 12px;
            font-weight: 800;
        }

        .bj-summary-calculation {
            display: grid;
            gap: 11px;
            margin-top: 20px;
        }

        .bj-summary-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            color: var(--co-gray);
            font-size: 13px;
        }

        .bj-summary-row strong {
            color: var(--co-dark);
            text-align: right;
        }

        .bj-summary-row.total {
            margin-top: 4px;
            padding-top: 15px;
            border-top: 1px solid var(--co-line);
            color: var(--co-dark);
            font-size: 15px;
            font-weight: 800;
        }

        .bj-summary-row.total strong {
            color: var(--co-red);
            font-size: 22px;
        }

        .bj-shipping-warning {
            margin: 16px 0 0;
            padding: 11px 12px;
            border-radius: 8px;
            background: #fff8e8;
            color: #805b15;
            font-size: 11px;
            line-height: 1.6;
        }

        .bj-checkout-submit {
            width: 100%;
            min-height: 50px;
            margin-top: 18px;
            padding: 12px 18px;
            border: 0;
            border-radius: 999px;
            background: var(--co-red);
            color: #fff;
            font: 800 20px 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
            cursor: pointer;
            transition: background .2s, transform .2s;
        }

        .bj-checkout-submit:hover {
            background: #a30008;
            transform: translateY(-1px);
        }

        .bj-checkout-submit:disabled {
            opacity: .6;
            cursor: wait;
            transform: none;
        }

        .bj-checkout-back {
            display: block;
            margin-top: 13px;
            color: var(--co-gray);
            font-size: 12px;
            text-align: center;
            text-decoration: none;
        }

        .bj-checkout-back:hover {
            color: var(--co-red);
        }

        .bj-checkout-alert {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 9px;
            background: #fff1f2;
            color: #be123c;
            font-size: 13px;
        }

        .bj-empty-checkout {
            padding: 50px 20px;
            text-align: center;
        }

        .bj-empty-checkout h2 {
            margin: 0 0 8px;
            font: 800 28px 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
        }

        .bj-empty-checkout p {
            color: var(--co-gray);
        }

        .bj-empty-checkout a {
            display: inline-flex;
            margin-top: 14px;
            padding: 12px 22px;
            border-radius: 99px;
            background: var(--co-red);
            color: #fff;
            text-decoration: none;
            font-weight: 800;
        }

        @media (max-width: 850px) {
            .bj-checkout-grid {
                grid-template-columns: 1fr;
            }

            .bj-checkout-summary {
                position: static;
            }
        }

        @media (max-width: 560px) {
            .bj-checkout-page {
                padding-top: 24px;
            }

            .bj-checkout-card {
                padding: 18px;
            }

            .bj-checkout-fields,
            .bj-payment-options {
                grid-template-columns: 1fr;
            }

            .bj-checkout-field.full {
                grid-column: auto;
            }
        }


        /* =========================================
   FIX RADIO BUTTON EKSPEDISI DAN PEMBAYARAN
========================================= */

        /* Label pilihan ekspedisi dan pembayaran */
        .bj-checkout-field label.bj-shipping-option,
        .bj-checkout-field label.bj-payment-option {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin: 0;
            font-weight: 400;
        }

        /* Ukuran radio button ekspedisi */
        .bj-checkout-page .bj-checkout-field .bj-shipping-option input[type="radio"],
        .bj-checkout-page .bj-checkout-field .bj-payment-option input[type="radio"] {
            appearance: auto;
            -webkit-appearance: radio;

            display: inline-block;
            flex: 0 0 19px;

            width: 19px !important;
            min-width: 19px;
            max-width: 19px;

            height: 19px;
            min-height: 19px !important;

            margin: 3px 0 0;
            padding: 0 !important;

            border: 0;
            border-radius: 50%;
            background: transparent;

            box-shadow: none;
            accent-color: var(--co-red);
            cursor: pointer;
        }

        /* Hilangkan efek input text saat radio difokuskan */
        .bj-checkout-page .bj-checkout-field .bj-shipping-option input[type="radio"]:focus,
        .bj-checkout-page .bj-checkout-field .bj-payment-option input[type="radio"]:focus {
            outline: none;
            box-shadow: none;
        }

        /* Kartu ekspedisi */
        .bj-shipping-option {
            display: flex;
            align-items: flex-start;
            gap: 12px;

            min-height: 80px;
            padding: 16px;

            border: 1px solid #d9dbe5;
            border-radius: 12px;

            background: #fff;
            transition: all .2s ease;
        }

        .bj-shipping-option:hover {
            border-color: var(--co-red);
            background: #fffafa;
        }

        .bj-shipping-option.is-selected {
            border-color: var(--co-red);
            background: #fff5f6;
            box-shadow: 0 0 0 1px rgba(225, 6, 19, .05);
        }

        /* Isi kartu ekspedisi */
        .bj-shipping-option-main {
            flex: 1;
            min-width: 0;
        }

        .bj-shipping-option-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .bj-shipping-option strong {
            color: var(--co-dark);
            font-size: 14px;
            font-weight: 800;
        }

        .bj-shipping-option-price {
            color: var(--co-red);
            font-size: 15px;
            font-weight: 800;
            white-space: nowrap;
        }

        .bj-shipping-option small {
            display: block;
            margin-top: 5px;
            color: var(--co-gray);
            font-size: 12px;
            line-height: 1.5;
        }

        /* Mobile */
        @media (max-width: 560px) {
            .bj-shipping-option {
                padding: 13px;
            }

            .bj-shipping-option-head {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
            }

            .bj-shipping-option-price {
                font-size: 14px;
            }
        }
    </style>

    <div class="bj-checkout-container">
        <div class="bj-checkout-heading">
            <h1>Checkout</h1>
            <p>Lengkapi data penerima dan periksa kembali pesananmu.</p>
        </div>

        @if (count($cartItems) === 0)
            <div class="bj-checkout-card bj-empty-checkout">
                <h2>Keranjang masih kosong</h2>
                <p>Tambahkan produk terlebih dahulu sebelum melanjutkan checkout.</p>
                <a href="{{ route('home') }}#produk">Kembali belanja</a>
            </div>
        @else
            <form wire:submit="placeOrder">
                <div class="bj-checkout-grid">
                    <div class="bj-checkout-card">
                        @error('cart')
                            <div class="bj-checkout-alert">{{ $message }}</div>
                        @enderror

                        <section class="bj-checkout-section">
                            <h2>Informasi Penerima</h2>
                            <div class="bj-checkout-fields">
                                <div class="bj-checkout-field">
                                    <label for="customer_name">Nama lengkap *</label>
                                    <input id="customer_name" type="text" wire:model="customer_name"
                                        autocomplete="name" placeholder="Nama penerima">
                                    @error('customer_name')
                                        <span class="bj-checkout-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="bj-checkout-field">
                                    <label for="customer_phone">Nomor WhatsApp / Telepon *</label>
                                    <input id="customer_phone" type="tel" wire:model="customer_phone"
                                        autocomplete="tel" placeholder="08xxxxxxxxxx">
                                    @error('customer_phone')
                                        <span class="bj-checkout-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="bj-checkout-field full">
                                    <label for="customer_email">Email (opsional)</label>
                                    <input id="customer_email" type="email" wire:model="customer_email"
                                        autocomplete="email" placeholder="email@contoh.com">
                                    @error('customer_email')
                                        <span class="bj-checkout-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section class="bj-checkout-section">
                            <h2>Alamat Pengiriman</h2>
                            <div class="bj-checkout-fields">
                                <div class="bj-checkout-field full">
                                    <label for="destination_search">Cari kecamatan / kelurahan / kode pos *</label>
                                    <input id="destination_search" type="search"
                                        wire:model.live.debounce.600ms="destination_search" autocomplete="off"
                                        placeholder="Contoh: Kedungwaru, Tulungagung">
                                    <small class="bj-weight-note">Ketik minimal 3 karakter, kemudian pilih alamat yang
                                        sesuai dari hasil pencarian.</small>
                                    @error('destination_search')
                                        <span class="bj-checkout-error">{{ $message }}</span>
                                    @enderror
                                    @if (mb_strlen(trim($destination_search)) >= 3 &&
                                            empty($destination_options) &&
                                            !$shipping_destination_id &&
                                            !$errors->has('destination_search'))
                                        <small class="bj-checkout-error">Alamat belum ditemukan. Coba nama kecamatan,
                                            kelurahan, atau kode pos yang lebih spesifik.</small>
                                    @endif

                                    @if (!empty($destination_options))
                                        <div class="bj-destination-results">
                                            @foreach ($destination_options as $destination)
                                                <button type="button" class="bj-destination-result"
                                                    wire:key="destination-{{ $destination['id'] }}"
                                                    wire:click="chooseDestination({{ (int) $destination['id'] }})">
                                                    <strong>{{ $destination['label'] ?? 'Alamat tujuan' }}</strong>
                                                    <small>{{ $destination['subdistrict_name'] ?? '' }} ·
                                                        {{ $destination['district_name'] ?? '' }} ·
                                                        {{ $destination['city_name'] ?? '' }} ·
                                                        {{ $destination['province_name'] ?? '' }}
                                                        {{ $destination['zip_code'] ?? '' }}</small>
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($shipping_destination_id)
                                        <div class="bj-destination-selected">
                                            <strong>Alamat tujuan dipilih</strong><br>
                                            {{ $shipping_destination_label }}
                                        </div>
                                    @endif
                                    @error('shipping_destination_id')
                                        <span class="bj-checkout-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="bj-checkout-field full">
                                    <label>Pilih ekspedisi dan layanan *</label>
                                    @if ($shipping_destination_id)
                                        <div wire:loading wire:target="chooseDestination,loadShippingOptions"
                                            class="bj-shipping-loading">
                                            Menghitung ongkos kirim...
                                        </div>

                                        @if (!empty($shipping_options))
                                            <div class="bj-shipping-options">
                                                @foreach ($shipping_options as $option)
                                                    <label
                                                        class="bj-shipping-option {{ $selected_shipping_key === $option['key'] ? 'is-selected' : '' }}"
                                                        wire:key="shipping-option-{{ $option['key'] }}">
                                                        <input type="radio" name="shipping_option"
                                                            value="{{ $option['key'] }}"
                                                            wire:click="chooseShippingOption('{{ $option['key'] }}')"
                                                            @checked($selected_shipping_key === $option['key'])>
                                                        <span class="bj-shipping-option-main">
                                                            <span class="bj-shipping-option-head">
                                                                <strong>{{ $option['name'] }}
                                                                    {{ $option['service'] }}</strong>
                                                                <span class="bj-shipping-option-price">Rp
                                                                    {{ number_format($option['cost'], 0, ',', '.') }}</span>
                                                            </span>
                                                            <small>{{ $option['description'] }}</small>
                                                            <small>Estimasi:
                                                                {{ $option['etd'] !== '' ? $option['etd'] : 'Tidak tersedia' }}</small>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif (!$errors->has('shipping_service'))
                                            <div class="bj-shipping-empty">Pilih alamat tujuan untuk menampilkan tarif
                                                ekspedisi.</div>
                                        @endif
                                    @else
                                        <div class="bj-shipping-empty">Pilih alamat tujuan terlebih dahulu untuk melihat
                                            ongkos kirim.</div>
                                    @endif
                                    @error('shipping_service')
                                        <span class="bj-checkout-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="bj-checkout-field full">
                                    <label for="shipping_address">Alamat lengkap *</label>
                                    <textarea id="shipping_address" wire:model="shipping_address" autocomplete="street-address"
                                        placeholder="Nama jalan, nomor rumah, RT/RW, dan patokan"></textarea>
                                    @error('shipping_address')
                                        <span class="bj-checkout-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="bj-checkout-field full">
                                    <label for="notes">Catatan pesanan (opsional)</label>
                                    <textarea id="notes" wire:model="notes" placeholder="Catatan untuk penjual atau kurir" style="min-height:78px"></textarea>
                                    @error('notes')
                                        <span class="bj-checkout-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        <section class="bj-checkout-section">
                            <h2>Metode Pembayaran</h2>
                            <div class="bj-payment-options">
                                <label class="bj-payment-option">
                                    <input type="radio" value="bank_transfer" wire:model="payment_method">
                                    <span>
                                        <strong>Transfer bank</strong>
                                        <small>Instruksi rekening dan konfirmasi pembayaran akan diberikan
                                            admin.</small>
                                    </span>
                                </label>
                                <label class="bj-payment-option">
                                    <input type="radio" value="cod" wire:model="payment_method">
                                    <span>
                                        <strong>COD / Bayar di tempat</strong>
                                        <small>Diproses setelah ketersediaan layanan COD dikonfirmasi toko.</small>
                                    </span>
                                </label>
                            </div>
                            @error('payment_method')
                                <span class="bj-checkout-error">{{ $message }}</span>
                            @enderror
                        </section>
                    </div>

                    <aside class="bj-checkout-card bj-checkout-summary">
                        <h2 class="bj-summary-title">Ringkasan Pesanan</h2>
                        <div class="bj-summary-items">
                            @foreach ($cartItems as $item)
                                <div class="bj-summary-item" wire:key="checkout-item-{{ $item['key'] }}">
                                    <div class="bj-summary-image">
                                        @if ($item['image_url'])
                                            <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                                        @else
                                            <span>Foto</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="bj-summary-name">{{ $item['name'] }}</span>
                                        <span class="bj-summary-variant">{{ $item['size'] }} /
                                            {{ $item['color'] }}</span><br>
                                        <span class="bj-summary-qty">{{ $item['quantity'] }} × Rp
                                            {{ number_format($item['unit_price'], 0, ',', '.') }}</span>
                                    </div>
                                    <span class="bj-summary-line-total">Rp
                                        {{ number_format($item['line_total'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="bj-summary-calculation">
                            <div class="bj-summary-row">
                                <span>Subtotal produk</span>
                                <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                            </div>
                            <div class="bj-summary-row">
                                <span>Ongkos kirim</span>
                                <strong>{{ $selected_shipping_key ? 'Rp ' . number_format($shipping_cost, 0, ',', '.') : 'Pilih layanan' }}</strong>
                            </div>
                            <div class="bj-summary-row total">
                                <span>Total pembayaran</span>
                                <strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <p class="bj-shipping-warning">
                            Berat estimasi paket {{ number_format($packageWeight) }} gram. Ongkir dihitung berdasarkan
                            alamat tujuan, berat paket, dan layanan yang dipilih. Tarif akan diverifikasi kembali saat
                            pesanan dibuat.
                        </p>

                        <button type="submit" class="bj-checkout-submit" wire:loading.attr="disabled"
                            wire:target="placeOrder" @disabled(!$selected_shipping_key || !$shipping_destination_id)>
                            <span wire:loading.remove wire:target="placeOrder">Buat Pesanan</span>
                            <span wire:loading wire:target="placeOrder">Memproses Pesanan...</span>
                        </button>
                        <a href="{{ route('home') }}#produk" class="bj-checkout-back">Kembali belanja</a>
                    </aside>
                </div>
            </form>
        @endif
    </div>
</div>
