<div>
    @if ($isOpen)
        <div class="bj-cart-layer" wire:keydown.escape.window="closeCart">
            <div class="bj-cart-overlay" wire:click="closeCart"></div>

            <aside class="bj-cart-drawer" role="dialog" aria-modal="true" aria-label="Keranjang belanja">
                <style>
                    .bj-cart-layer,
                    .bj-cart-layer * {
                        box-sizing: border-box;
                    }

                    .bj-cart-overlay {
                        position: fixed;
                        inset: 0;
                        z-index: 1100;
                        background: rgba(5, 5, 26, .52);
                    }

                    .bj-cart-drawer {
                        --cart-red: #e10613;
                        --cart-ink: #0b0b2b;
                        --cart-gray: #77798d;
                        --cart-line: #e8e8ef;
                        position: fixed;
                        z-index: 1101;
                        top: 0;
                        right: 0;
                        bottom: 0;
                        width: min(460px, 100%);
                        display: flex;
                        flex-direction: column;
                        background: #fff;
                        box-shadow: -12px 0 35px rgba(0, 0, 0, .12);
                        font-family: 'DM Sans', sans-serif;
                        color: var(--cart-ink);
                        animation: bj-cart-in .22s ease-out;
                    }

                    @keyframes bj-cart-in {
                        from {
                            transform: translateX(24px);
                            opacity: .75;
                        }

                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }

                    .bj-cart-head {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        gap: 16px;
                        padding: 22px 24px;
                        border-bottom: 1px solid var(--cart-line);
                    }

                    .bj-cart-title {
                        margin: 0;
                        font-family: 'Barlow Condensed', sans-serif;
                        font-size: 30px;
                        font-weight: 900;
                        line-height: 1;
                        text-transform: uppercase;
                    }

                    .bj-cart-title span {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        min-width: 25px;
                        height: 25px;
                        margin-left: 5px;
                        padding: 0 7px;
                        border-radius: 99px;
                        background: #fde8ea;
                        color: var(--cart-red);
                        font: 700 12px 'DM Sans', sans-serif;
                        vertical-align: middle;
                    }

                    .bj-cart-close {
                        width: 38px;
                        height: 38px;
                        display: grid;
                        place-items: center;
                        border: 1px solid var(--cart-line);
                        border-radius: 50%;
                        background: #fff;
                        color: var(--cart-ink);
                        cursor: pointer;
                    }

                    .bj-cart-close svg {
                        width: 19px;
                        height: 19px;
                    }

                    .bj-cart-content {
                        flex: 1;
                        overflow-y: auto;
                        padding: 8px 24px 24px;
                    }

                    .bj-cart-empty {
                        min-height: 100%;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        padding: 40px 15px;
                        text-align: center;
                        color: var(--cart-gray);
                    }

                    .bj-cart-empty svg {
                        width: 54px;
                        height: 54px;
                        margin-bottom: 15px;
                        color: var(--cart-red);
                    }

                    .bj-cart-empty strong {
                        margin-bottom: 6px;
                        color: var(--cart-ink);
                        font-size: 17px;
                    }

                    .bj-cart-item {
                        display: grid;
                        grid-template-columns: 88px minmax(0, 1fr) auto;
                        gap: 13px;
                        padding: 18px 0;
                        border-bottom: 1px solid var(--cart-line);
                    }

                    .bj-cart-item-image {
                        width: 88px;
                        height: 100px;
                        display: grid;
                        place-items: center;
                        overflow: hidden;
                        border-radius: 10px;
                        background: #f4f5fa;
                        color: #a0a2b4;
                    }

                    .bj-cart-item-image img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }

                    .bj-cart-item-name {
                        display: block;
                        margin: 1px 0 5px;
                        font-family: 'Barlow Condensed', sans-serif;
                        font-size: 20px;
                        font-weight: 800;
                        line-height: 1.05;
                        text-transform: uppercase;
                    }

                    .bj-cart-item-variant {
                        color: var(--cart-gray);
                        font-size: 12px;
                    }

                    .bj-cart-item-price {
                        margin-top: 8px;
                        color: var(--cart-red);
                        font-size: 14px;
                        font-weight: 800;
                    }

                    .bj-cart-item-actions {
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        margin-top: 10px;
                    }

                    .bj-cart-qty {
                        display: inline-flex;
                        align-items: center;
                        gap: 12px;
                        min-height: 30px;
                        padding: 2px 8px;
                        border: 1px solid var(--cart-line);
                        border-radius: 99px;
                    }

                    .bj-cart-qty button,
                    .bj-cart-remove {
                        display: grid;
                        place-items: center;
                        width: 22px;
                        height: 22px;
                        padding: 0;
                        border: 0;
                        background: transparent;
                        color: var(--cart-ink);
                        cursor: pointer;
                    }

                    .bj-cart-qty button:disabled {
                        opacity: .3;
                        cursor: not-allowed;
                    }

                    .bj-cart-qty svg,
                    .bj-cart-remove svg {
                        width: 15px;
                        height: 15px;
                    }

                    .bj-cart-qty span {
                        min-width: 12px;
                        text-align: center;
                        font-size: 12px;
                        font-weight: 700;
                    }

                    .bj-cart-remove {
                        color: #a0a2b4;
                    }

                    .bj-cart-remove:hover {
                        color: var(--cart-red);
                    }

                    .bj-cart-error {
                        margin: 14px 0 0;
                        padding: 10px 12px;
                        border-radius: 8px;
                        background: #fff1f2;
                        color: #be123c;
                        font-size: 12px;
                    }

                    .bj-cart-clear {
                        margin-top: 16px;
                        padding: 0;
                        border: 0;
                        background: transparent;
                        color: var(--cart-gray);
                        font-size: 12px;
                        text-decoration: underline;
                        cursor: pointer;
                    }

                    .bj-cart-footer {
                        padding: 20px 24px 24px;
                        border-top: 1px solid var(--cart-line);
                        background: #fff;
                    }

                    .bj-cart-subtotal {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        gap: 12px;
                        margin-bottom: 8px;
                        font-size: 14px;
                        font-weight: 700;
                    }

                    .bj-cart-subtotal strong {
                        color: var(--cart-red);
                        font-size: 20px;
                    }

                    .bj-cart-note {
                        margin: 0;
                        color: var(--cart-gray);
                        font-size: 11px;
                        line-height: 1.5;
                    }

                    .bj-cart-checkout {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 100%;
                        min-height: 48px;
                        margin-top: 16px;
                        padding: 12px 18px;
                        border: 0;
                        border-radius: 999px;
                        background: var(--cart-red);
                        color: #fff;
                        font-family: 'Barlow Condensed', sans-serif;
                        font-size: 20px;
                        font-weight: 800;
                        letter-spacing: .3px;
                        text-align: center;
                        text-decoration: none;
                        text-transform: uppercase;
                        cursor: pointer;
                        transition: background .2s ease, transform .2s ease;
                    }

                    .bj-cart-checkout:hover {
                        background: #a30008;
                        color: #fff;
                        transform: translateY(-1px);
                    }

                    .bj-cart-checkout.is-disabled {
                        background: #d7d7df;
                        color: #858595;
                        cursor: not-allowed;
                        pointer-events: none;
                        transform: none;
                    }

                    @media (max-width: 480px) {
                        .bj-cart-head {
                            padding: 18px;
                        }

                        .bj-cart-content {
                            padding: 4px 18px 18px;
                        }

                        .bj-cart-footer {
                            padding: 18px;
                        }

                        .bj-cart-item {
                            grid-template-columns: 72px minmax(0, 1fr) auto;
                            gap: 10px;
                        }

                        .bj-cart-item-image {
                            width: 72px;
                            height: 86px;
                        }

                        .bj-cart-item-name {
                            font-size: 18px;
                        }
                    }
                </style>

                <div class="bj-cart-head">
                    <h2 class="bj-cart-title">Keranjang <span>{{ $cartCount }}</span></h2>
                    <button type="button" class="bj-cart-close" wire:click="closeCart" aria-label="Tutup keranjang">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="bj-cart-content">
                    @forelse ($cartItems as $item)
                        <article class="bj-cart-item" wire:key="cart-item-{{ $item['key'] }}">
                            <div class="bj-cart-item-image">
                                @if ($item['image_url'])
                                    <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <path d="m21 15-5-5L5 21" />
                                    </svg>
                                @endif
                            </div>

                            <div>
                                <strong class="bj-cart-item-name">{{ $item['name'] }}</strong>
                                <div class="bj-cart-item-variant">
                                    {{ $item['size'] }} / {{ $item['color'] }}
                                </div>
                                <div class="bj-cart-item-price">
                                    Rp {{ number_format($item['unit_price'], 0, ',', '.') }}
                                </div>

                                <div class="bj-cart-item-actions">
                                    <div class="bj-cart-qty">
                                        <button type="button" wire:click="decrease('{{ $item['key'] }}')"
                                            @disabled($item['quantity'] <= 1) aria-label="Kurangi jumlah">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round">
                                                <path d="M5 12h14" />
                                            </svg>
                                        </button>
                                        <span>{{ $item['quantity'] }}</span>
                                        <button type="button" wire:click="increase('{{ $item['key'] }}')"
                                            @disabled($item['quantity'] >= $item['stock']) aria-label="Tambah jumlah">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round">
                                                <path d="M12 5v14M5 12h14" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="bj-cart-remove" wire:click="remove('{{ $item['key'] }}')"
                                aria-label="Hapus {{ $item['name'] }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18M8 6V4h8v2m3 0-1 14H6L5 6m4 4v6m6-6v6" />
                                </svg>
                            </button>
                        </article>
                    @empty
                        <div class="bj-cart-empty">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 7h12l1 14H5L6 7Z" />
                                <path d="M9 7V6a3 3 0 0 1 6 0v1" />
                            </svg>
                            <strong>Keranjang masih kosong</strong>
                            <span>Yuk, temukan jersey favoritmu.</span>
                        </div>
                    @endforelse

                    @if ($cartMessage)
                        <p class="bj-cart-error">{{ $cartMessage }}</p>
                    @endif

                    @if (count($cartItems) > 0)
                        <button type="button" class="bj-cart-clear" wire:click="clearCart"
                            wire:confirm="Kosongkan seluruh keranjang?">
                            Kosongkan keranjang
                        </button>
                    @endif
                </div>

                <div class="bj-cart-footer">
                    <div class="bj-cart-subtotal">
                        <span>Subtotal</span>
                        <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <p class="bj-cart-note">Ongkos kirim dan diskon akan dihitung pada tahap checkout.</p>

                    @if ($cartCount > 0)
                        <a href="{{ route('checkout.index') }}" class="bj-cart-checkout">
                            Lanjut ke Checkout
                        </a>
                    @else
                        <button type="button" class="bj-cart-checkout is-disabled" disabled>
                            Lanjut ke Checkout
                        </button>
                    @endif
                </div>
            </aside>
        </div>
    @endif
</div>
