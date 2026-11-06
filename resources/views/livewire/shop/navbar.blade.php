<div x-data="{ menuOpen: false }">
    <style>
        /* =========================================
           BAKOEL JAERSEY - GLOBAL NAVBAR
           CSS dibuat mandiri, tidak bergantung pada style.css Home
        ========================================= */

        .bj-header {
            --bj-red: #e10613;
            --bj-red-dark: #a30008;
            --bj-red-tint: #fde8ea;
            --bj-ink: #0b0b2b;
            --bj-gray: #6a6c85;
            --bj-line: #e4e5ef;

            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            width: 100%;
            background: #fff;
            border-bottom: 1px solid var(--bj-line);
            box-shadow: 0 2px 0 var(--bj-red-tint);
            font-family: 'DM Sans', sans-serif;
            isolation: isolate;
        }

        .bj-header,
        .bj-header * {
            box-sizing: border-box;
        }

        .bj-header a {
            color: inherit;
            text-decoration: none;
        }

        .bj-header-inner {
            width: min(1760px, 92%);
            min-height: 84px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 24px;
        }

        /* LOGO */
        .bj-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            white-space: nowrap;
            flex-shrink: 0;
            text-decoration: none !important;
        }

        .bj-logo-image {
            display: block;
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            object-fit: contain;
            border-radius: 50%;
            background: #000;
        }

        .bj-logo-copy {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .bj-logo-name {
            display: block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 27px;
            font-weight: 900;
            line-height: .95;
            color: var(--bj-red);
            text-transform: uppercase;
        }

        .bj-logo-name span {
            color: var(--bj-ink);
        }

        .bj-logo-copy small {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--bj-gray);
        }

        /* NAVIGATION */
        .bj-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 0;
        }

        .bj-nav a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 999px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 800;
            line-height: 1;
            text-transform: uppercase;
            white-space: nowrap;
            color: var(--bj-red);
            text-decoration: none !important;
            transition: background .2s ease, color .2s ease;
        }

        .bj-nav a:hover {
            background: var(--bj-red-tint);
            color: var(--bj-red-dark);
        }

        .bj-nav a.active {
            background: var(--bj-red);
            color: #fff;
        }

        /* HEADER ACTIONS */
        .bj-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .bj-icon-button {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            min-width: 46px;
            min-height: 46px;
            padding: 0;
            border: 0;
            border-radius: 50%;
            background: var(--bj-red);
            color: #fff;
            cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }

        .bj-icon-button:hover {
            background: var(--bj-red-dark);
            transform: translateY(-1px);
        }

        .bj-icon-button svg {
            display: block;
            width: 20px;
            height: 20px;
            stroke-width: 2;
        }

        .bj-cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            display: grid;
            place-items: center;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border-radius: 20px;
            background: var(--bj-ink);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
        }

        .bj-menu-toggle {
            display: none;
        }

        /* TABLET */
        @media (max-width: 1150px) {
            .bj-header-inner {
                gap: 14px;
            }

            .bj-nav {
                gap: 2px;
            }

            .bj-nav a {
                padding: 9px 11px;
                font-size: 18px;
            }
        }

        /* MOBILE NAVIGATION */
        @media (max-width: 900px) {
            .bj-header-inner {
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 12px;
            }

            .bj-menu-toggle {
                display: inline-flex;
            }

            .bj-nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 1001;
                flex-direction: column;
                align-items: stretch;
                justify-content: flex-start;
                gap: 4px;
                padding: 12px 4% 18px;
                background: #fff;
                border-bottom: 1px solid var(--bj-line);
                box-shadow: 0 12px 20px #0000000d;
            }

            .bj-nav.open {
                display: flex;
            }

            .bj-nav a {
                justify-content: flex-start;
                width: 100%;
                padding: 12px 16px;
                font-size: 20px;
            }
        }

        /* SMALL MOBILE */
        @media (max-width: 680px) {
            .bj-header-inner {
                min-height: 70px;
                gap: 8px;
            }

            .bj-logo {
                gap: 8px;
            }

            .bj-logo-image {
                width: 42px;
                height: 42px;
                flex-basis: 42px;
            }

            .bj-logo-name {
                font-size: 22px;
            }

            .bj-logo-copy small {
                display: none;
            }

            .bj-header-actions {
                gap: 7px;
            }

            .bj-icon-button {
                width: 40px;
                height: 40px;
                min-width: 40px;
                min-height: 40px;
            }

            .bj-icon-button svg {
                width: 18px;
                height: 18px;
            }
        }

        @media (max-width: 380px) {
            .bj-logo-name {
                font-size: 19px;
            }

            .bj-logo-image {
                width: 38px;
                height: 38px;
                flex-basis: 38px;
            }

            .bj-icon-button {
                width: 37px;
                height: 37px;
                min-width: 37px;
                min-height: 37px;
            }
        }
    </style>

    <header class="bj-header">
        <div class="bj-header-inner">

            {{-- LOGO --}}
            <a href="{{ url('/') }}" class="bj-logo" aria-label="Bakoel Jaersey - Sports Jersey Store">
                <img class="bj-logo-image" src="{{ asset('assets/images/bakoel-jaersey-logo.png') }}"
                    alt="Logo Bakoel Jaersey">

                <span class="bj-logo-copy">
                    <strong class="bj-logo-name">
                        BAKOEL <span>JAERSEY</span>
                    </strong>
                    <small>SPORTS JERSEY STORE</small>
                </span>
            </a>

            {{-- NAVIGATION --}}
            <nav class="bj-nav" id="mainNav" aria-label="Navigasi utama" :class="{ 'open': menuOpen }"
                @click="menuOpen = false">
                <a href="{{ url('/') }}#home" class="{{ request()->routeIs('home') ? 'active' : '' }}"
                    @if (request()->routeIs('home')) aria-current="page" @endif>
                    Beranda
                </a>
                <a href="{{ url('/') }}#kategori">Kategori</a>
                <a href="{{ url('/') }}#produk">Semua Produk</a>
                <a href="{{ url('/') }}#keunggulan">Keunggulan</a>
                <a href="{{ url('/') }}#kontak">Kontak</a>
            </nav>

            {{-- HEADER ACTIONS --}}
            <div class="bj-header-actions flex items-center gap-3">
                @auth
                    <div class="relative" x-data="{ userMenu: false }">
                        <button type="button" @click="userMenu = !userMenu" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-[#0b0b2b] transition">
                            <svg class="w-4 h-4 text-[#e10613]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span class="max-w-[120px] truncate font-['DM_Sans']">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="userMenu" @click.away="userMenu = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 text-sm font-['DM_Sans']">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-red-50 hover:text-[#e10613] font-medium">Dashboard Admin</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-red-600 hover:bg-red-50 font-medium">Keluar (Logout)</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-3.5 py-2 text-xs font-bold uppercase font-['Barlow_Condensed'] text-[#0b0b2b] hover:text-[#e10613] transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-full bg-[#e10613] hover:bg-[#a30008] text-white text-xs font-bold uppercase font-['Barlow_Condensed'] tracking-wider shadow-sm transition">Daftar</a>
                    </div>
                @endauth

                <button type="button" class="bj-icon-button" id="wishlistHeader" aria-label="Lihat produk favorit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path
                            d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z" />
                    </svg>
                </button>

                <button type="button" class="bj-icon-button" id="openCart" aria-label="Buka keranjang"
                    wire:click="$dispatch('open-cart')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 7h12l1 14H5L6 7Z" />
                        <path d="M9 7V6a3 3 0 0 1 6 0v1" />
                    </svg>
                    <span class="bj-cart-count" id="cartCount">
                        {{ $cartCount }}
                    </span>
                </button>

                <button type="button" class="bj-icon-button bj-menu-toggle" id="menuToggle" aria-label="Buka navigasi"
                    :aria-expanded="menuOpen.toString()" aria-controls="mainNav" @click="menuOpen = !menuOpen">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Spacer agar konten tidak tertutup navbar fixed --}}
    <div class="bj-header-spacer" aria-hidden="true"></div>

    <style>
        .bj-header-spacer {
            height: 84px;
        }

        @media (max-width: 680px) {
            .bj-header-spacer {
                height: 70px;
            }
        }
    </style>
</div>
