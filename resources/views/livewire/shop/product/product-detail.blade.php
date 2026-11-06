<div>
    <style>
        .product-detail-page {
            min-height: 100vh;
            padding-bottom: 60px;
            background: #f5f5f5;
            color: #222;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 14px;
        }

        .product-detail-page *,
        .product-detail-page *::before,
        .product-detail-page *::after {
            box-sizing: border-box;
        }

        /* Samakan seluruh tipografi halaman dengan navbar Bakoel Jaersey */
        .product-detail-page,
        .product-detail-page * {
            font-family: 'Barlow Condensed', sans-serif;
        }

        .product-detail-page button {
            font: inherit;
        }

        /* CONTAINER */

        .product-detail-page .container {
            width: min(1320px, calc(100% - 40px));
            margin: 0 auto;
        }

        /* BREADCRUMB */

        .detail-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 22px 0;
            color: #999;
            font-size: 13px;
        }

        .detail-breadcrumb a {
            color: #2673c9;
            text-decoration: none;
        }

        .detail-breadcrumb a:hover {
            color: #e11d48;
        }

        .detail-breadcrumb .current {
            color: #333;
        }

        /* MAIN WRAPPER */

        .detail-wrapper {
            display: grid;
            grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
            gap: 45px;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .035);
        }

        /* GALLERY */

        .detail-gallery {
            min-width: 0;
        }

        .detail-main-image {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            border-radius: 8px;
            background: #f7f7f7;
        }

        .detail-main-image img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .detail-no-image {
            display: flex;
            height: 100%;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 12px;
            color: #999;
        }

        .detail-no-image i {
            width: 45px;
            height: 45px;
        }

        .detail-featured-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 8px 12px;
            background: #e11d48;
            color: #fff;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
        }

        .detail-thumbnails {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            padding-bottom: 5px;
            overflow-x: auto;
        }

        .detail-thumbnails button {
            flex: 0 0 76px;
            width: 76px;
            height: 76px;
            padding: 3px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 7px;
            cursor: pointer;
        }

        .detail-thumbnails button.active {
            border: 2px solid #e11d48;
        }

        .detail-thumbnails img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        .detail-share {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
            color: #777;
            font-size: 13px;
        }

        .detail-share button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border: 1px solid #eee;
            background: #fff;
            border-radius: 50%;
            color: #e11d48;
            cursor: pointer;
        }

        /* PRODUCT INFORMATION */

        .detail-information {
            min-width: 0;
        }

        .detail-category {
            display: inline-block;
            padding: 6px 11px;
            background: #fff1f2;
            color: #e11d48;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .detail-information h1 {
            margin: 13px 0;
            color: #222;
            font-size: 27px;
            line-height: 1.4;
            font-weight: 700;
        }

        .detail-statistics {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            color: #888;
            font-size: 12px;
        }

        .detail-statistics div {
            display: flex;
            gap: 5px;
        }

        .detail-statistics strong {
            color: #333;
        }

        .detail-stat-divider {
            width: 1px;
            height: 17px;
            background: #ddd;
        }

        /* PRICE */

        .detail-price-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 25px;
            padding: 24px;
            background: #fafafa;
        }

        .detail-price {
            color: #e11d48;
            font-size: 32px;
            font-weight: 800;
        }

        .detail-price-old {
            color: #999;
            font-size: 14px;
            text-decoration: line-through;
        }

        .detail-discount-label {
            padding: 5px 9px;
            background: #ffe4e6;
            color: #e11d48;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
        }

        /* SHIPPING */

        .detail-shipping {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 25px;
        }

        .detail-shipping-icon {
            color: #0d9488;
        }

        .detail-shipping-icon i {
            width: 25px;
            height: 25px;
        }

        .detail-shipping strong {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .detail-shipping p {
            margin: 0;
            color: #888;
            font-size: 12px;
        }

        /* DIVIDER */

        .detail-divider {
            height: 1px;
            margin: 25px 0;
            background: #eee;
        }

        /* VARIANTS */

        .detail-option-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .detail-option-label strong {
            color: #e11d48;
            font-size: 12px;
        }

        .detail-variant-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .detail-variant {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            min-width: 90px;
            padding: 11px 15px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 7px;
            cursor: pointer;
            transition: .2s;
        }

        .detail-variant:hover {
            border-color: #e11d48;
        }

        .detail-variant strong {
            font-size: 14px;
        }

        .detail-variant span {
            color: #888;
            font-size: 11px;
        }

        .detail-variant.active {
            color: #e11d48;
            background: #fff1f2;
            border-color: #e11d48;
        }

        .detail-variant.active span {
            color: #e11d48;
        }

        .detail-variant.out-of-stock {
            opacity: .4;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .detail-variant small {
            color: #e11d48;
            font-size: 10px;
        }

        /* QUANTITY */

        .detail-quantity-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .detail-quantity-control {
            display: flex;
            align-items: center;
            height: 38px;
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: 7px;
        }

        .detail-quantity-control button {
            width: 38px;
            height: 100%;
            border: 0;
            background: #f5f5f5;
            cursor: pointer;
            font-size: 18px;
        }

        .detail-quantity-control button:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .detail-quantity-control span {
            min-width: 45px;
            text-align: center;
        }

        .detail-stock {
            color: #888;
            font-size: 12px;
        }

        .detail-error {
            margin-top: 9px;
            color: #e11d48;
            font-size: 12px;
        }

        /* ACTION BUTTONS */

        .detail-action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .detail-action-buttons button {
            display: flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 49px;
            padding: 0 20px;
            border-radius: 7px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .detail-button-cart {
            color: #e11d48;
            background: #fff1f2;
            border: 1px solid #e11d48;
        }

        .detail-button-cart:hover {
            background: #ffe4e6;
        }

        .detail-button-buy {
            color: #fff;
            background: #e11d48;
            border: 1px solid #e11d48;
        }

        .detail-button-buy:hover {
            background: #be123c;
        }

        .detail-action-buttons button:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        /* DESCRIPTION */

        .detail-description h3 {
            margin: 0 0 15px;
            font-size: 17px;
        }

        .detail-description-content {
            color: #666;
            font-size: 13px;
            line-height: 1.9;
            overflow-wrap: anywhere;
        }

        /* BOTTOM INFORMATION */

        .detail-bottom-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 25px;
            padding: 25px;
            background: #fff;
            border-radius: 10px;
        }

        .detail-bottom-info>div {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .detail-bottom-info i {
            flex-shrink: 0;
            width: 27px;
            height: 27px;
            color: #e11d48;
        }

        .detail-bottom-info strong,
        .detail-bottom-info span {
            display: block;
        }

        .detail-bottom-info strong {
            margin-bottom: 5px;
            font-size: 13px;
        }

        .detail-bottom-info span {
            color: #888;
            font-size: 11px;
        }

        /* RESPONSIVE TABLET */

        @media (max-width: 900px) {
            .detail-wrapper {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .detail-gallery {
                width: 100%;
                max-width: 550px;
                margin: auto;
            }
        }

        /* RESPONSIVE MOBILE */

        @media (max-width: 600px) {
            .product-detail-page .container {
                width: calc(100% - 24px);
            }

            .detail-breadcrumb {
                gap: 7px;
                padding: 16px 0;
                font-size: 11px;
            }

            .detail-wrapper {
                padding: 14px;
                border-radius: 8px;
            }

            .detail-information h1 {
                font-size: 21px;
            }

            .detail-price {
                font-size: 26px;
            }

            .detail-price-container {
                padding: 17px;
            }

            .detail-statistics {
                gap: 10px;
            }

            .detail-action-buttons {
                flex-direction: column;
            }

            .detail-bottom-info {
                grid-template-columns: 1fr;
                padding: 20px;
            }
        }
    </style>
    <div class="product-detail-page">

        {{-- BREADCRUMB --}}
        <div class="container">
            <div class="detail-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>›</span>
                <a href="{{ route('home') }}#produk">Produk</a>
                <span>›</span>
                <a href="{{ route('home') }}#kategori">{{ $product->category }}</a>
                <span>›</span>
                <span class="current">{{ $product->name }}</span>
            </div>
        </div>

        {{-- PRODUCT DETAIL --}}
        <section class="container detail-wrapper">

            {{-- LEFT: PRODUCT GALLERY --}}
            <div class="detail-gallery">

                <div class="detail-main-image">

                    @if (isset($images[$activeImage]))
                        <img src="{{ Storage::disk('public')->url($images[$activeImage]) }}" alt="{{ $product->name }}"
                            wire:key="main-image-{{ $activeImage }}">
                    @else
                        <div class="detail-no-image">
                            <i data-lucide="image"></i>
                            <span>Foto belum tersedia</span>
                        </div>
                    @endif

                    @if ($product->is_featured)
                        <span class="detail-featured-badge">
                            PRODUK UNGGULAN
                        </span>
                    @endif

                </div>

                {{-- THUMBNAILS --}}
                @if (count($images) > 1)
                    <div class="detail-thumbnails">

                        @foreach ($images as $index => $image)
                            <button type="button" wire:click="selectImage({{ $index }})"
                                wire:key="thumbnail-{{ $index }}"
                                class="{{ $activeImage === $index ? 'active' : '' }}">
                                <img src="{{ Storage::disk('public')->url($image) }}" alt="Foto {{ $index + 1 }}">
                            </button>
                        @endforeach

                    </div>
                @endif

                <div class="detail-share">
                    <span>Bagikan produk:</span>

                    <button type="button" onclick="shareProduct()">
                        <i data-lucide="share-2"></i>
                    </button>
                </div>

            </div>

            {{-- RIGHT: PRODUCT INFORMATION --}}
            <div class="detail-information">

                <div class="detail-category">
                    {{ $product->category }}
                </div>

                <h1>{{ $product->name }}</h1>

                <div class="detail-statistics">
                    <div>
                        <span>SKU</span>
                        <strong>{{ $product->sku ?: '-' }}</strong>
                    </div>

                    <span class="detail-stat-divider"></span>

                    <div>
                        <span>Varian</span>
                        <strong>{{ $product->variants->count() }}</strong>
                    </div>

                    <span class="detail-stat-divider"></span>

                    <div>
                        <span>Stok</span>
                        <strong>
                            {{ $product->variants->sum('stock') }}
                        </strong>
                    </div>
                </div>

                {{-- PRICE --}}
                <div class="detail-price-container">

                    @if ($product->discount_price !== null)
                        <div class="detail-price">
                            Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                        </div>

                        <div class="detail-price-old">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <span class="detail-discount-label">
                            DISKON
                        </span>
                    @else
                        <div class="detail-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    @endif

                </div>

                {{-- SHIPPING --}}
                <div class="detail-shipping">
                    <div class="detail-shipping-icon">
                        <i data-lucide="truck"></i>
                    </div>

                    <div>
                        <strong>Pengiriman</strong>
                        <p>
                            Pengiriman tersedia ke seluruh Indonesia.
                        </p>
                    </div>
                </div>

                <div class="detail-divider"></div>

                {{-- VARIANTS --}}
                <div class="detail-option">

                    <div class="detail-option-label">
                        <span>Ukuran & Warna</span>

                        @if ($selectedVariant)
                            @php
                                $selected = $product->variants->firstWhere('id', $selectedVariant);
                            @endphp

                            <strong>
                                {{ $selected?->size }} / {{ $selected?->color }}
                            </strong>
                        @endif
                    </div>

                    <div class="detail-variant-list">

                        @foreach ($product->variants as $variant)
                            <button type="button" wire:click="selectVariant({{ $variant->id }})"
                                wire:key="variant-{{ $variant->id }}"
                                class="
                                detail-variant
                                {{ $selectedVariant === $variant->id ? 'active' : '' }}
                                {{ $variant->stock < 1 ? 'out-of-stock' : '' }}
                            "
                                @disabled($variant->stock < 1)>
                                <strong>{{ $variant->size }}</strong>
                                <span>{{ $variant->color }}</span>

                                @if ($variant->stock < 1)
                                    <small>Habis</small>
                                @endif
                            </button>
                        @endforeach

                    </div>

                    @error('selectedVariant')
                        <p class="detail-error">{{ $message }}</p>
                    @enderror

                </div>

                <div class="detail-divider"></div>

                {{-- QUANTITY --}}
                <div class="detail-quantity-section">

                    <div class="detail-option-label">
                        <span>Jumlah</span>
                    </div>

                    <div class="detail-quantity-row">

                        <div class="detail-quantity-control">
                            <button type="button" wire:click="decreaseQuantity" @disabled($quantity <= 1)>
                                −
                            </button>

                            <span>{{ $quantity }}</span>

                            <button type="button" wire:click="increaseQuantity" @disabled(!$selectedVariant)>
                                +
                            </button>
                        </div>

                        @if ($selectedVariant)
                            <span class="detail-stock">
                                Stok tersedia:
                                {{ $product->variants->firstWhere('id', $selectedVariant)?->stock ?? 0 }}
                            </span>
                        @else
                            <span class="detail-stock">
                                Pilih ukuran dan warna terlebih dahulu
                            </span>
                        @endif

                    </div>

                    @error('quantity')
                        <p class="detail-error">{{ $message }}</p>
                    @enderror

                </div>

                {{-- ACTION BUTTONS --}}
                <div class="detail-action-buttons">

                    <button type="button" class="detail-button-cart" wire:click="addToCart"
                        wire:loading.attr="disabled" wire:target="addToCart">
                        <i data-lucide="shopping-cart"></i>
                        <span>Tambah ke Keranjang</span>
                    </button>

                    <button type="button" class="detail-button-buy" wire:click="addToCart">
                        Beli Sekarang
                    </button>

                </div>

                <div class="detail-divider"></div>

                {{-- DESCRIPTION --}}
                <div class="detail-description">

                    <h3>Deskripsi Produk</h3>

                    <div class="detail-description-content">
                        {!! nl2br(e($product->description ?: 'Belum ada deskripsi produk.')) !!}
                    </div>

                </div>

            </div>

        </section>

        {{-- PRODUCT FOOTER --}}
        <section class="container detail-bottom-info">

            <div>
                <i data-lucide="shield-check"></i>

                <div>
                    <strong>Produk Berkualitas</strong>
                    <span>Produk pilihan Bakoel Jaersey.</span>
                </div>
            </div>

            <div>
                <i data-lucide="package-check"></i>

                <div>
                    <strong>Stok Terpantau</strong>
                    <span>Informasi stok berdasarkan varian produk.</span>
                </div>
            </div>

            <div>
                <i data-lucide="headset"></i>

                <div>
                    <strong>Layanan Pelanggan</strong>
                    <span>Siap membantu kebutuhan jersey kamu.</span>
                </div>
            </div>

        </section>

    </div>
</div>
@script
    <script>
        window.shareProduct = function() {
            if (navigator.share) {
                navigator.share({
                    title: @js($product->name),
                    url: window.location.href
                });
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(window.location.href);
                alert('Link produk berhasil disalin!');
            }
        };
    </script>
@endscript
