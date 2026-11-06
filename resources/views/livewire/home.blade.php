<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b0b2b">
    <meta name="description"
        content="Bakoel Jaersey - Temukan jersey bola, jersey basket, jersey retro dan perlengkapan olahraga favoritmu.">
    <title>Bakoel Jaersey — Sports Jersey Store</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --red: #e10613;
            --red-dark: #a30008;
            --red-deep: #0b0b2b;
            --navy: #0b0b2b;
            --navy-soft: #1a1a4a;
            --red-tint: #fde8ea;
            --navy-line: #c9cbe0;
            --ink: #0b0b2b;
            --gray: #6a6c85;
            --line: #e4e5ef;
            --paper: #f4f5fa;
            --white: #fff;
            --radius: 16px;
            --container: 1240px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            background: #fff;
            font-size: 14px;
            line-height: 1.5;
        }

        body.no-scroll {
            overflow: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        img {
            display: block;
            width: 100%;
            object-fit: cover;
        }

        :focus-visible {
            outline: 2px solid var(--red);
            outline-offset: 2px;
        }

        .container {
            width: min(var(--container), 92%);
            margin: 0 auto;
        }

        .display {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .2px;
            line-height: 1;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .logo-image {
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            object-fit: contain;
            border-radius: 50%;
            background: #000;
        }

        .logo-copy {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .logo-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 27px;
            font-weight: 900;
            line-height: .95;
            color: var(--red);
            text-transform: uppercase;
        }

        .logo-name span {
            color: var(--ink);
        }

        .logo small {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--gray);
        }

        .pill-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: 0 22px;
            border: 0;
            border-radius: 999px;
            background: var(--red);
            color: #fff;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 18px;
            font-weight: 800;
            text-transform: uppercase;
            transition: background .2s;
        }

        .pill-btn:hover {
            background: var(--red-dark);
        }

        .pill-btn svg {
            width: 20px;
            height: 20px;
        }

        .pill-btn.light {
            background: #fff;
            color: var(--red);
        }

        .pill-btn.light:hover {
            background: var(--red-tint);
        }

        .pill-btn.small {
            min-height: 38px;
            padding: 0 18px;
            font-size: 16px;
        }

        /* ---------- STORE TITLE ---------- */
        .store-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 0 18px;
        }

        .store-head h1 {
            font-size: clamp(34px, 4.4vw, 46px);
            color: var(--red);
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            width: min(100%, 380px);
            height: 46px;
            padding: 0 16px;
            border: 1px solid var(--navy-line);
            border-radius: 10px;
            background: #fff;
            color: var(--red);
        }

        .search-box input {
            flex: 1;
            min-width: 0;
            border: 0;
            outline: 0;
            background: transparent;
            font-size: 14px;
            color: var(--ink);
        }

        .search-box input::placeholder {
            color: #8c8ea8;
        }

        .search-box button {
            display: grid;
            place-items: center;
            border: 0;
            background: transparent;
            color: var(--red);
        }

        .search-box svg {
            width: 18px;
            height: 18px;
        }

        /* ---------- HERO SLIDER ---------- */
        .hero {
            position: relative;
            height: clamp(260px, 36vw, 420px);
            overflow: hidden;
            border-radius: var(--radius);
            background: var(--red-deep);
            color: #fff;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            visibility: hidden;
            transition: opacity .5s;
        }

        .hero-slide.active {
            opacity: 1;
            visibility: visible;
        }

        .hero-slide img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        .hero-slide::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(0deg, rgba(11, 11, 43, .9), rgba(11, 11, 43, 0) 55%),
                linear-gradient(90deg, rgba(225, 6, 19, .55), transparent 65%);
        }

        .hero-copy {
            position: absolute;
            z-index: 2;
            left: clamp(20px, 3.5vw, 48px);
            bottom: clamp(20px, 3.5vw, 40px);
        }

        .hero-copy h2 {
            font-size: clamp(38px, 6vw, 68px);
            font-weight: 900;
            margin-bottom: 12px;
        }

        .hero-arrows {
            position: absolute;
            z-index: 3;
            right: 28px;
            bottom: 28px;
            display: flex;
            gap: 8px;
        }

        .arrow-btn {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 10px;
            background: #fff;
            color: var(--red);
            transition: background .2s;
        }

        .arrow-btn:hover {
            background: var(--red-tint);
        }

        .arrow-btn svg {
            width: 18px;
            height: 18px;
        }

        /* ---------- CATEGORY TILES ---------- */
        .tiles {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 18px;
        }

        .tile {
            position: relative;
            height: clamp(170px, 18vw, 220px);
            overflow: hidden;
            border-radius: var(--radius);
            color: #fff;
            background: var(--red-deep);
        }

        .tile img {
            position: absolute;
            inset: 0;
            height: 100%;
            transition: transform .5s;
        }

        .tile:hover img {
            transform: scale(1.05);
        }

        .tile::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(11, 11, 43, .88), rgba(11, 11, 43, .1) 70%);
        }

        .tile-copy {
            position: absolute;
            z-index: 2;
            left: 22px;
            bottom: 20px;
        }

        .tile-copy h3 {
            font-size: clamp(30px, 3.2vw, 40px);
            font-weight: 800;
            margin-bottom: 12px;
        }

        /* ---------- PRODUCTS ---------- */
        .section {
            padding: 30px 0 56px;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .section-head h2 {
            font-size: clamp(34px, 4vw, 44px);
            font-weight: 900;
            color: var(--red);
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 22px;
        }

        .filter-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filter-btn {
            min-height: 38px;
            padding: 0 18px;
            border: 1px solid var(--navy-line);
            border-radius: 999px;
            background: #fff;
            color: var(--red);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 17px;
            font-weight: 800;
            text-transform: uppercase;
            transition: .2s;
        }

        .filter-btn:hover {
            background: var(--red-tint);
        }

        .filter-btn.active {
            background: var(--red);
            border-color: var(--red);
            color: #fff;
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .result-count {
            color: var(--gray);
            font-size: 13px;
        }

        .sort-select {
            height: 38px;
            padding: 0 12px;
            border: 1px solid var(--navy-line);
            border-radius: 10px;
            background: #fff;
            color: var(--ink);
            font-size: 13px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 30px 16px;
        }

        .product-card {
            position: relative;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .product-card[hidden] {
            display: none !important;
        }

        .product-image-wrap {
            position: relative;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            border-radius: 14px;
            background: var(--paper);
            margin-bottom: 12px;
        }

        .product-image {
            height: 100%;
            transition: transform .4s;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .wishlist-btn {
            position: absolute;
            top: 8px;
            left: 8px;
            width: 32px;
            height: 32px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: var(--red);
            color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .18);
            transition: .2s;
        }

        .wishlist-btn svg {
            width: 16px;
            height: 16px;
        }

        .wishlist-btn.liked {
            background: #fff;
            color: var(--red);
        }

        .product-badge {
            position: absolute;
            right: 8px;
            bottom: 8px;
            padding: 3px 9px;
            border-radius: 999px;
            background: var(--ink);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .4px;
        }

        .product-badge.red {
            background: var(--red);
        }

        .product-tag {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 4px 10px;
            border-radius: 10px;
            background: var(--navy);
            color: #fff;
            text-align: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.05;
            text-transform: uppercase;
        }

        .product-card h3 {
            margin-top: 10px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 21px;
            font-weight: 800;
            line-height: 1.05;
            text-transform: uppercase;
            color: var(--navy);
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            color: var(--gray);
            font-size: 12px;
        }

        .product-meta .star {
            color: #f2b01e;
            font-size: 13px;
        }

        .product-meta .dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #5b5d78;
        }

        .product-bottom {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 8px;
            margin-top: auto;
            padding-top: 8px;
        }

        .product-prices strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
        }

        .product-prices del {
            color: #9c9eb5;
            font-size: 11px;
        }

        .quick-add {
            flex-shrink: 0;
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border: 1px solid var(--navy-line);
            border-radius: 50%;
            background: #fff;
            color: var(--red);
            transition: .2s;
        }

        .quick-add:hover {
            background: var(--red);
            color: #fff;
        }

        .quick-add svg {
            width: 16px;
            height: 16px;
        }

        .empty-state {
            text-align: center;
            padding: 50px 15px;
            color: var(--gray);
        }

        /* ---------- WHY US (dark) ---------- */
        .dark-panel {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius);
            background: linear-gradient(100deg, #05051a 0%, #0b0b2b 50%, #a30008 100%);
            color: #fff;
            padding: 36px 0 40px 36px;
        }

        .dark-panel-grid {
            display: grid;
            grid-template-columns: minmax(240px, 300px) 1fr;
            gap: 28px;
            align-items: start;
        }

        .dark-panel h2 {
            font-size: clamp(38px, 4.4vw, 54px);
            font-weight: 900;
        }

        .dark-panel .lead {
            margin-top: 12px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
            color: #ffd9dc;
        }

        .dark-panel .promo-copy {
            margin-top: 22px;
            max-width: 280px;
            color: #d3d5ec;
            font-size: 13px;
        }

        .dark-panel .promo-copy .pill-btn {
            margin-top: 18px;
        }

        .why-track {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding-right: 36px;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
        }

        .why-track::-webkit-scrollbar {
            display: none;
        }

        .why-card {
            flex: 0 0 min(260px, 78%);
            min-height: 270px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 22px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .12);
            scroll-snap-align: start;
        }

        .why-icon {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            margin-bottom: auto;
            border-radius: 50%;
            background: var(--red);
        }

        .why-icon svg {
            width: 26px;
            height: 26px;
        }

        .why-card h3 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .why-card p {
            color: #d3d5ec;
            font-size: 13px;
        }

        .dark-arrows {
            display: flex;
            gap: 8px;
            margin-top: 26px;
        }

        /* ---------- CS BANNER ---------- */
        .cs-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-top: 40px;
            padding: 34px 36px;
            border-radius: var(--radius);
            background: var(--red);
            color: #fff;
        }

        .cs-banner h2 {
            font-size: clamp(30px, 4vw, 46px);
            font-weight: 800;
        }

        /* ---------- SOCIAL ---------- */
        .social {
            padding: 56px 0 50px;
            text-align: center;
        }

        .social h2 {
            font-size: clamp(34px, 4.2vw, 46px);
            font-weight: 900;
            color: var(--red);
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 26px;
            margin-top: 26px;
        }

        .social-icons a {
            color: var(--red);
            transition: transform .2s;
        }

        .social-icons a:hover {
            transform: translateY(-3px);
        }

        .social-icons svg {
            width: 34px;
            height: 34px;
        }

        .newsletter-form {
            display: flex;
            width: min(100%, 440px);
            margin: 34px auto 0;
            border: 1px solid var(--navy-line);
            border-radius: 999px;
            padding: 4px;
        }

        .newsletter-form input {
            flex: 1;
            min-width: 0;
            padding: 0 18px;
            border: 0;
            outline: 0;
            background: transparent;
            font-size: 14px;
        }

        .newsletter-form .pill-btn {
            min-height: 42px;
        }

        .newsletter-note {
            margin-top: 10px;
            color: var(--gray);
            font-size: 12px;
        }

        /* ---------- FOOTER ---------- */
        .footer {
            border-top: 1px solid var(--line);
            background: #fff;
        }

        .footer-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px 30px;
            min-height: 90px;
            padding: 14px 0;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 32px;
        }

        .footer-links a {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 18px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--red);
        }

        .footer-socials {
            display: flex;
            gap: 18px;
        }

        .footer-socials a {
            color: var(--red);
        }

        .footer-socials svg {
            width: 22px;
            height: 22px;
        }

        .footer-bottom {
            background: var(--navy);
            border-top: 3px solid var(--red);
            color: #fff;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .footer-bottom .container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 6px 20px;
            padding: 14px 0;
        }

        /* ---------- CART DRAWER ---------- */
        .overlay {
            position: fixed;
            inset: 0;
            z-index: 90;
            background: rgba(0, 0, 0, .5);
            opacity: 0;
            visibility: hidden;
            transition: .25s;
        }

        .overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .cart-drawer {
            position: fixed;
            z-index: 100;
            top: 0;
            right: 0;
            bottom: 0;
            width: min(430px, 100%);
            display: flex;
            flex-direction: column;
            background: #fff;
            transform: translateX(100%);
            transition: transform .3s;
        }

        .cart-drawer.open {
            transform: translateX(0);
        }

        .drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 22px;
            border-bottom: 1px solid var(--line);
        }

        .drawer-header h3 {
            font-size: 28px;
            color: var(--red);
        }

        .close-btn {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border: 1px solid var(--navy-line);
            border-radius: 50%;
            background: #fff;
            color: var(--red);
        }

        .close-btn svg {
            width: 18px;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .cart-empty {
            padding: 55px 10px;
            text-align: center;
            color: var(--gray);
        }

        .cart-empty svg {
            width: 42px;
            height: 42px;
            margin: 0 auto 15px;
            color: var(--red);
        }

        .cart-item {
            display: grid;
            grid-template-columns: 78px 1fr auto;
            gap: 13px;
            padding: 14px 0;
            border-bottom: 1px solid var(--line);
        }

        .cart-item img {
            width: 78px;
            height: 90px;
            border-radius: 10px;
            background: var(--paper);
        }

        .cart-item h4 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 18px;
            font-weight: 800;
            line-height: 1.1;
            text-transform: uppercase;
        }

        .cart-item-price {
            margin-top: 6px;
            font-size: 13px;
            font-weight: 700;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 10px;
        }

        .quantity-control button {
            width: 28px;
            height: 28px;
            border: 1px solid var(--navy-line);
            border-radius: 50%;
            background: #fff;
            color: var(--red);
        }

        .quantity-control span {
            font-size: 13px;
            font-weight: 700;
        }

        .remove-item {
            border: 0;
            background: transparent;
            color: #a2a4bb;
            padding: 4px;
        }

        .remove-item svg {
            width: 16px;
        }

        .drawer-footer {
            padding: 22px;
            border-top: 1px solid var(--line);
        }

        .subtotal {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 15px;
            font-weight: 700;
        }

        .drawer-footer .pill-btn {
            width: 100%;
        }

        .drawer-note {
            margin-top: 12px;
            color: var(--gray);
            font-size: 11px;
            text-align: center;
        }

        /* ---------- TOAST ---------- */
        .toast {
            position: fixed;
            z-index: 120;
            right: 22px;
            bottom: 22px;
            max-width: calc(100% - 44px);
            padding: 14px 20px;
            border-radius: 12px;
            background: var(--ink);
            color: #fff;
            box-shadow: 0 8px 30px #0003;
            opacity: 0;
            transform: translateY(12px);
            pointer-events: none;
            transition: .25s;
            font-size: 13px;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 1150px) {
            .product-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {

            .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .dark-panel {
                padding: 28px 0 32px 24px;
            }

            .dark-panel-grid {
                grid-template-columns: 1fr;
            }

            .why-track {
                padding-right: 24px;
            }

            .dark-arrows {
                display: none;
            }
        }

        @media (max-width: 680px) {

            .logo-image {
                width: 42px;
                height: 42px;
                flex-basis: 42px;
            }

            .logo-name {
                font-size: 22px;
            }

            .logo small {
                display: none;
            }

            .store-head {
                flex-direction: column;
                align-items: stretch;
                gap: 14px;
            }

            .search-box {
                width: 100%;
            }

            .hero-arrows {
                right: 14px;
                bottom: 14px;
            }

            .tiles {
                grid-template-columns: 1fr;
            }

            .section-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 24px 12px;
            }

            .cs-banner {
                flex-direction: column;
                align-items: flex-start;
                padding: 26px 22px;
            }

            .footer-main {
                justify-content: center;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
                gap: 8px 22px;
            }

            .footer-bottom .container {
                flex-direction: column;
                text-align: center;
            }
        }

        .product-image-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #f3f4f6;
            color: #9ca3af;
        }

        .product-image-empty i {
            width: 32px;
            height: 32px;
        }

        .product-image-empty span {
            font-size: 11px;
        }

        .product-detail-link {
            display: block;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .product-name-link {
            color: inherit;
            text-decoration: none;
            transition: color .2s ease;
        }

        .product-name-link:hover {
            color: #e11d48;
        }

        .product-detail-link img {
            transition: transform .3s ease;
        }

        .product-detail-link:hover img {
            transform: scale(1.04);
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>

    <div>
        <main id="home">

            {{-- STORE TITLE + SEARCH --}}
            <div class="container store-head">
                <h1 class="display">Bakoel Jaersey Store</h1>

                <form class="search-box" id="searchForm" role="search">
                    <input type="search" id="searchInput" placeholder="Ketik untuk mencari produk"
                        aria-label="Cari produk">
                    <button type="submit" aria-label="Cari"><i data-lucide="search"></i></button>
                </form>
            </div>

            {{-- HERO SLIDER --}}
            <section class="container">
                <div class="hero" id="hero">

                    <div class="hero-slide active">
                        <img src="{{ asset('assets/images/banner.png') }}" alt="Koleksi sportswear Bakoel Jaersey"
                            fetchpriority="high">
                        <div class="hero-copy">
                            <h2 class="display">Bakoel Jaersey</h2>
                            <a href="#produk" class="pill-btn light small">Lihat katalog</a>
                        </div>
                    </div>

                    <div class="hero-slide">
                        <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1400&q=80"
                            alt="Jersey bola" loading="lazy">
                        <div class="hero-copy">
                            <h2 class="display">Every club.<br>Every passion.</h2>
                            <a href="#produk" class="pill-btn light small" data-category-link="bola">Jersey bola</a>
                        </div>
                    </div>

                    <div class="hero-slide">
                        <img src="https://images.unsplash.com/photo-1519861531473-9200262188bf?auto=format&fit=crop&w=1400&q=80"
                            alt="Jersey basket" loading="lazy">
                        <div class="hero-copy">
                            <h2 class="display">Wear your<br>passion.</h2>
                            <a href="#produk" class="pill-btn light small" data-category-link="basket">Jersey basket</a>
                        </div>
                    </div>

                    <div class="hero-arrows">
                        <button class="arrow-btn" id="heroPrev" aria-label="Slide sebelumnya">
                            <i data-lucide="chevron-left"></i>
                        </button>
                        <button class="arrow-btn" id="heroNext" aria-label="Slide berikutnya">
                            <i data-lucide="chevron-right"></i>
                        </button>
                    </div>
                </div>
            </section>

            {{-- CATEGORY TILES --}}
            <section class="container tiles" id="kategori">

                @forelse ($categories as $category)
                    @php
                        // Ambil satu produk aktif dari kategori ini sebagai gambar thumbnail.
                        $categoryProduct = $products->firstWhere('category', $category->name);

                        $categoryImage = $categoryProduct?->primary_image;
                    @endphp

                    <a href="#produk" class="tile"
                        data-category-link="{{ \Illuminate\Support\Str::slug($category->name) }}">

                        @if ($categoryImage)
                            <img src="{{ Storage::disk('public')->url($categoryImage) }}" alt="{{ $category->name }}"
                                loading="lazy">
                        @else
                            <div class="tile-image-empty">
                                <i data-lucide="image"></i>
                            </div>
                        @endif

                        <div class="tile-copy">
                            <h3 class="display">{{ $category->name }}</h3>
                            <span class="pill-btn small">Lihat produk</span>
                        </div>

                    </a>

                @empty

                    <div class="empty-state">
                        <p>Belum ada kategori tersedia.</p>
                    </div>
                @endforelse

            </section>

            {{-- PRODUCTS --}}
            <section class="container section" id="produk">

                <div class="section-head">
                    <h2 class="display">Produk untuk kamu</h2>
                    <button class="pill-btn small" id="showAllProducts">
                        Lihat semua produk
                    </button>
                </div>

                <div class="toolbar">
                    <div class="filter-tabs" id="filterTabs">
                        <button class="filter-btn active" data-filter="semua">
                            Semua
                        </button>

                        @foreach ($categories as $category)
                            <button class="filter-btn"
                                data-filter="{{ \Illuminate\Support\Str::slug($category->name) }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>

                    <div class="toolbar-right">
                        <span class="result-count" id="resultCount">
                            {{ $products->count() }} produk
                        </span>

                        <select class="sort-select" id="sortSelect" aria-label="Urutkan produk">
                            <option value="default">Urutkan</option>
                            <option value="price-low">Harga terendah</option>
                            <option value="price-high">Harga tertinggi</option>
                            <option value="name">Nama A-Z</option>
                        </select>
                    </div>
                </div>

                <div class="product-grid" id="productGrid">

                    @forelse ($products as $product)
                        @php
                            $categorySlug = \Illuminate\Support\Str::slug($product->category ?? '');
                            $productImage = $product->primary_image;
                            $finalPrice = $product->discount_price ?? $product->price;

                            $badge = null;

                            if ($product->discount_price !== null) {
                                $badge = 'DISKON';
                            } elseif ($product->is_featured) {
                                $badge = 'UNGGULAN';
                            }

                            // Enkripsi ID untuk URL (format URL-safe)
                            $encryptedId = rtrim(
                                strtr(
                                    \Illuminate\Support\Facades\Crypt::encryptString((string) $product->id),
                                    '+/',
                                    '-_',
                                ),
                                '=',
                            );

                            $detailUrl = route('product.detail', $encryptedId);

                            $imageUrl = $productImage ? Storage::disk('public')->url($productImage) : '';
                        @endphp

                        <article class="product-card" data-id="{{ $product->id }}"
                            data-name="{{ strtolower($product->name) }}" data-category="{{ $categorySlug }}"
                            data-price="{{ $finalPrice }}">

                            {{-- FOTO PRODUK --}}
                            <div class="product-image-wrap">

                                <a href="{{ $detailUrl }}" class="product-detail-link">
                                    @if ($productImage)
                                        <img class="product-image" src="{{ $imageUrl }}"
                                            alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <div class="product-image product-image-empty">
                                            <i data-lucide="image"></i>
                                            <span>Foto belum tersedia</span>
                                        </div>
                                    @endif
                                </a>

                                {{-- WISHLIST --}}
                                <button type="button" class="wishlist-btn" data-wishlist="{{ $product->id }}"
                                    aria-label="Tambah ke favorit">
                                    <i data-lucide="heart"></i>
                                </button>

                                {{-- BADGE --}}
                                @if ($badge)
                                    <span class="product-badge {{ $badge === 'DISKON' ? 'red' : '' }}">
                                        {{ $badge }}
                                    </span>
                                @endif

                            </div>

                            {{-- KATEGORI --}}
                            <div class="product-tag">
                                Bakoel Jaersey
                                <br>
                                ({{ $product->category }})
                            </div>

                            {{-- NAMA PRODUK --}}
                            <h3>
                                <a href="{{ $detailUrl }}" class="product-name-link">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            {{-- INFORMASI PRODUK --}}
                            <div class="product-meta">
                                <span>
                                    {{ (int) ($product->total_stock ?? 0) }} stok tersedia
                                </span>

                                <span class="dot"></span>

                                {{ $product->variants_count }} varian
                            </div>

                            {{-- HARGA DAN KERANJANG --}}
                            <div class="product-bottom">

                                <div class="product-prices">

                                    @if ($product->discount_price !== null)
                                        <strong>
                                            Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                        </strong>

                                        <del>
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </del>
                                    @else
                                        <strong>
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </strong>
                                    @endif

                                </div>

                                <button type="button" class="quick-add" data-add-cart="{{ $product->id }}"
                                    data-name="{{ $product->name }}" data-price="{{ $finalPrice }}"
                                    data-image="{{ $imageUrl }}" aria-label="Tambah ke keranjang">
                                    <i data-lucide="shopping-bag"></i>
                                </button>

                            </div>

                        </article>

                    @empty

                        <div class="empty-state">
                            <i data-lucide="package-search" style="width:35px;height:35px;margin:0 auto 12px">
                            </i>

                            <p>Belum ada produk tersedia.</p>

                            <p style="font-size:12px;margin-top:5px">
                                Produk akan muncul di sini setelah ditambahkan.
                            </p>
                        </div>
                    @endforelse

                </div>

                <div class="empty-state" id="emptyState" hidden>
                    <i data-lucide="search-x" style="width:35px;height:35px;margin:0 auto 12px">
                    </i>

                    <p>Produk tidak ditemukan.</p>

                    <p style="font-size:12px;margin-top:5px">
                        Coba kata kunci atau kategori lain.
                    </p>
                </div>

            </section>
            {{-- WHY US / PROMO --}}
            <section class="container" id="keunggulan">
                <div class="dark-panel" id="promo">
                    <div class="dark-panel-grid">

                        <div>
                            <h2 class="display">Kenapa<br>Bakoel Jaersey</h2>
                            <p class="lead">Gear up. Save more.</p>

                            <div class="promo-copy">
                                <p>Temukan produk favorit dan siapkan dirimu untuk pertandingan berikutnya.</p>
                                <a href="#produk" class="pill-btn small">Belanja sekarang</a>
                            </div>

                            <div class="dark-arrows">
                                <button class="arrow-btn" id="whyPrev" aria-label="Geser ke kiri">
                                    <i data-lucide="chevron-left"></i>
                                </button>
                                <button class="arrow-btn" id="whyNext" aria-label="Geser ke kanan">
                                    <i data-lucide="chevron-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="why-track" id="whyTrack">
                            <div class="why-card">
                                <span class="why-icon"><i data-lucide="truck"></i></span>
                                <h3 class="display">Pengiriman aman</h3>
                                <p>Dikirim ke seluruh Indonesia dengan kemasan rapi.</p>
                            </div>

                            <div class="why-card">
                                <span class="why-icon"><i data-lucide="badge-check"></i></span>
                                <h3 class="display">Produk berkualitas</h3>
                                <p>Pilihan jersey untuk setiap penggemar olahraga.</p>
                            </div>

                            <div class="why-card">
                                <span class="why-icon"><i data-lucide="credit-card"></i></span>
                                <h3 class="display">Pembayaran mudah</h3>
                                <p>Proses checkout praktis dan nyaman.</p>
                            </div>

                            <div class="why-card">
                                <span class="why-icon"><i data-lucide="headset"></i></span>
                                <h3 class="display">Layanan pelanggan</h3>
                                <p>Tim kami siap membantu pesananmu.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {{-- CUSTOMER SERVICE --}}
            <section class="container" id="kontak">
                <div class="cs-banner">
                    <h2 class="display">Hubungi tim customer service kami</h2>
                    <a href="#" class="pill-btn light">
                        <i data-lucide="message-circle"></i>
                        Customer service
                    </a>
                </div>
            </section>

            {{-- SOCIAL + NEWSLETTER --}}
            <section class="container social">
                <h2 class="display">Social media Bakoel Jaersey</h2>

                <div class="social-icons">
                    <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                    <a href="#" aria-label="YouTube"><i data-lucide="youtube"></i></a>
                    <a href="#" aria-label="WhatsApp"><i data-lucide="message-circle"></i></a>
                </div>

                <form class="newsletter-form" id="newsletterForm">
                    <input type="email" placeholder="Masukkan email kamu" aria-label="Email kamu" required>
                    <button type="submit" class="pill-btn small">Gabung</button>
                </form>
                <p class="newsletter-note">Dapatkan info koleksi baru dan promo terbaru.</p>
            </section>

        </main>

        {{-- FOOTER --}}
        <footer class="footer">
            <div class="container footer-main">
                <a href="{{ url('/') }}" class="logo" aria-label="Bakoel Jaersey - Sports Jersey Store">
                    <img class="logo-image" src="{{ asset('assets/images/bakoel-jaersey-logo.png') }}"
                        alt="Logo Bakoel Jaersey">
                    <span class="logo-copy">
                        <strong class="logo-name">BAKOEL <span>JAERSEY</span></strong>
                    </span>
                </a>

                <nav class="footer-links" aria-label="Footer">
                    <a href="#produk">Semua Produk</a>
                    <a href="#kategori">Kategori</a>
                    <a href="#">Cara Pemesanan</a>
                    <a href="#">Panduan Ukuran</a>
                    <a href="#">Pengiriman</a>
                </nav>

                <div class="footer-socials">
                    <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                    <a href="#" aria-label="YouTube"><i data-lucide="youtube"></i></a>
                    <a href="#" aria-label="WhatsApp"><i data-lucide="message-circle"></i></a>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <span>© {{ date('Y') }} Bakoel Jaersey.</span>
                    <span>Developed by: ZADEV.ID</span>
                </div>
            </div>
        </footer>

        {{-- CART OVERLAY --}}
        <div class="overlay" id="cartOverlay"></div>

        {{-- CART DRAWER --}}
        <aside class="cart-drawer" id="cartDrawer" aria-label="Keranjang belanja">

            <div class="drawer-header">
                <h3 class="display">Keranjang belanja</h3>
                <button class="close-btn" id="closeCart" aria-label="Tutup keranjang">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <div class="cart-items" id="cartItems"></div>

            <div class="drawer-footer">
                <div class="subtotal">
                    <span>Subtotal</span>
                    <span id="cartSubtotal">Rp 0</span>
                </div>

                <button class="pill-btn" id="checkoutButton">
                    Lanjut ke checkout
                </button>

                <p class="drawer-note">
                    Ongkos kirim dan diskon dihitung pada tahap berikutnya.
                </p>
            </div>

        </aside>

        <div class="toast" id="toast" role="status" aria-live="polite"></div>
    </div>

    {{-- JAVASCRIPT --}}
    {{-- Versi dipatok karena Lucide terbaru sudah menghapus ikon brand (instagram, facebook, youtube) --}}
    <script src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            lucide.createIcons();

            const $ = (selector, parent = document) => parent.querySelector(selector);
            const $$ = (selector, parent = document) => [...parent.querySelectorAll(selector)];

            const searchInput = $('#searchInput');
            const searchForm = $('#searchForm');
            const filterTabs = $('#filterTabs');
            const productGrid = $('#productGrid');
            const resultCount = $('#resultCount');
            const emptyState = $('#emptyState');
            const sortSelect = $('#sortSelect');

            const cartDrawer = $('#cartDrawer');
            const cartOverlay = $('#cartOverlay');
            const cartItems = $('#cartItems');
            const cartCount = $('#cartCount');
            const cartSubtotal = $('#cartSubtotal');
            const toast = $('#toast');

            let activeFilter = 'semua';
            let favorites = new Set();
            let toastTimer;

            // FORMAT RUPIAH
            function rupiah(value) {
                return 'Rp ' + Number(value).toLocaleString('id-ID');
            }

            // TOAST
            function showToast(message) {
                toast.textContent = message;
                toast.classList.add('show');
                clearTimeout(toastTimer);
                toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
            }

            // LOCAL STORAGE
            function readStorage(key, fallback) {
                try {
                    const value = JSON.parse(localStorage.getItem(key));
                    return value ?? fallback;
                } catch (error) {
                    return fallback;
                }
            }

            let cart = readStorage('kickoff_cart', []);
            if (!Array.isArray(cart)) cart = [];

            function saveCart() {
                localStorage.setItem('kickoff_cart', JSON.stringify(cart));
            }

            // HERO SLIDER
            const slides = $$('.hero-slide');
            let slideIndex = 0;
            let slideTimer;

            function showSlide(index) {
                slideIndex = (index + slides.length) % slides.length;
                slides.forEach((slide, i) => slide.classList.toggle('active', i === slideIndex));
            }

            function startAutoSlide() {
                clearInterval(slideTimer);
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                slideTimer = setInterval(() => showSlide(slideIndex + 1), 6000);
            }

            $('#heroPrev').addEventListener('click', () => {
                showSlide(slideIndex - 1);
                startAutoSlide();
            });

            $('#heroNext').addEventListener('click', () => {
                showSlide(slideIndex + 1);
                startAutoSlide();
            });

            startAutoSlide();

            // WHY US CAROUSEL
            const whyTrack = $('#whyTrack');

            $('#whyPrev').addEventListener('click', () => whyTrack.scrollBy({
                left: -280,
                behavior: 'smooth'
            }));

            $('#whyNext').addEventListener('click', () => whyTrack.scrollBy({
                left: 280,
                behavior: 'smooth'
            }));

            // FILTER AND SEARCH
            function filterProducts() {
                const keyword = searchInput.value.trim().toLowerCase();
                const cards = $$('.product-card', productGrid);

                let visible = 0;

                cards.forEach(card => {
                    const matchesCategory = activeFilter === 'semua' || card.dataset.category ===
                        activeFilter;
                    const matchesSearch = card.dataset.name.includes(keyword);
                    const matches = matchesCategory && matchesSearch;

                    card.hidden = !matches;

                    if (matches) visible++;
                });

                resultCount.textContent = visible + ' produk';
                emptyState.hidden = visible !== 0;
            }

            function setActiveFilter(filter) {
                activeFilter = filter;

                $$('.filter-btn', filterTabs).forEach(button => {
                    button.classList.toggle('active', button.dataset.filter === filter);
                });

                filterProducts();
            }

            filterTabs.addEventListener('click', function(event) {
                const button = event.target.closest('[data-filter]');
                if (!button) return;
                setActiveFilter(button.dataset.filter);
            });

            searchInput.addEventListener('input', filterProducts);

            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                $('#produk').scrollIntoView({
                    behavior: 'smooth'
                });
                filterProducts();
            });

            // CLICK CATEGORY LINKS (tiles + hero buttons)
            $$('[data-category-link]').forEach(link => {
                link.addEventListener('click', function() {
                    setActiveFilter(link.dataset.categoryLink);
                });
            });

            // SORT PRODUCTS
            sortSelect.addEventListener('change', function() {
                const cards = $$('.product-card', productGrid);

                cards.sort((a, b) => {
                    const priceA = Number(a.dataset.price);
                    const priceB = Number(b.dataset.price);

                    if (sortSelect.value === 'price-low') return priceA - priceB;
                    if (sortSelect.value === 'price-high') return priceB - priceA;
                    if (sortSelect.value === 'name') return a.dataset.name.localeCompare(b.dataset
                        .name);

                    return Number(a.dataset.id) - Number(b.dataset.id);
                });

                cards.forEach(card => productGrid.appendChild(card));
                filterProducts();
            });

            // CART DRAWER
            function openCart() {
                cartDrawer.classList.add('open');
                cartOverlay.classList.add('show');
                document.body.classList.add('no-scroll');
                renderCart();
            }

            function closeCart() {
                cartDrawer.classList.remove('open');
                cartOverlay.classList.remove('show');
                document.body.classList.remove('no-scroll');
            }

            $('#openCart').addEventListener('click', openCart);
            $('#closeCart').addEventListener('click', closeCart);
            cartOverlay.addEventListener('click', closeCart);

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeCart();
                    closeMenu();
                }
            });

            // ADD TO CART
            productGrid.addEventListener('click', function(event) {
                const button = event.target.closest('[data-add-cart]');
                if (!button) return;

                const id = Number(button.dataset.addCart);
                const name = button.dataset.name;
                const price = Number(button.dataset.price);
                const image = button.dataset.image;

                const existing = cart.find(item => item.id === id);

                if (existing) {
                    existing.quantity += 1;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        image,
                        quantity: 1
                    });
                }

                saveCart();
                updateCartCount();
                showToast(name + ' ditambahkan ke keranjang.');
            });

            function updateCartCount() {
                cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            }

            // RENDER CART
            function renderCart() {
                if (cart.length === 0) {
                    cartItems.innerHTML = `
                        <div class="cart-empty">
                            <i data-lucide="shopping-bag"></i>
                            <h3 style="font-size:16px;color:#0b0b2b">Keranjang masih kosong</h3>
                            <p style="font-size:12px;margin-top:7px">Yuk, temukan jersey favoritmu!</p>
                            <button class="pill-btn small" id="startShopping" style="margin-top:20px">
                                Mulai belanja
                            </button>
                        </div>
                    `;

                    cartSubtotal.textContent = rupiah(0);
                    lucide.createIcons();

                    $('#startShopping').addEventListener('click', () => {
                        closeCart();
                        $('#produk').scrollIntoView({
                            behavior: 'smooth'
                        });
                    });

                    return;
                }

                cartItems.innerHTML = cart.map(item => `
                    <div class="cart-item">
                        <img src="https://images.unsplash.com/${item.image}?auto=format&fit=crop&w=200&q=75"
                            alt="${escapeHTML(item.name)}">

                        <div>
                            <h4>${escapeHTML(item.name)}</h4>
                            <div class="cart-item-price">${rupiah(item.price)}</div>

                            <div class="quantity-control">
                                <button data-quantity="-1" data-id="${item.id}" aria-label="Kurangi jumlah">−</button>
                                <span>${item.quantity}</span>
                                <button data-quantity="1" data-id="${item.id}" aria-label="Tambah jumlah">+</button>
                            </div>
                        </div>

                        <button class="remove-item" data-remove="${item.id}" aria-label="Hapus produk">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </div>
                `).join('');

                const subtotal = cart.reduce((total, item) => total + item.price * item.quantity, 0);
                cartSubtotal.textContent = rupiah(subtotal);

                lucide.createIcons();
            }

            function escapeHTML(value) {
                return String(value).replace(/[&<>"']/g, character => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                })[character]);
            }

            cartItems.addEventListener('click', function(event) {
                const quantityButton = event.target.closest('[data-quantity]');
                const removeButton = event.target.closest('[data-remove]');

                if (quantityButton) {
                    const id = Number(quantityButton.dataset.id);
                    const change = Number(quantityButton.dataset.quantity);
                    const item = cart.find(product => product.id === id);

                    if (!item) return;

                    item.quantity += change;

                    if (item.quantity <= 0) {
                        cart = cart.filter(product => product.id !== id);
                    }

                    saveCart();
                    updateCartCount();
                    renderCart();
                }

                if (removeButton) {
                    const id = Number(removeButton.dataset.remove);
                    cart = cart.filter(product => product.id !== id);

                    saveCart();
                    updateCartCount();
                    renderCart();
                    showToast('Produk dihapus dari keranjang.');
                }
            });

            // WISHLIST
            const storedFavorites = readStorage('kickoff_favorites', []);

            if (Array.isArray(storedFavorites)) {
                storedFavorites.forEach(id => favorites.add(Number(id)));
            }

            function renderFavorites() {
                $$('[data-wishlist]').forEach(button => {
                    const id = Number(button.dataset.wishlist);
                    const isLiked = favorites.has(id);

                    button.classList.toggle('liked', isLiked);

                    button.innerHTML = isLiked ?
                        '<i data-lucide="heart" fill="currentColor"></i>' :
                        '<i data-lucide="heart"></i>';

                    button.setAttribute('aria-label', isLiked ? 'Hapus dari favorit' : 'Tambah ke favorit');
                });

                lucide.createIcons();
            }

            productGrid.addEventListener('click', function(event) {
                const button = event.target.closest('[data-wishlist]');
                if (!button) return;

                const id = Number(button.dataset.wishlist);

                if (favorites.has(id)) {
                    favorites.delete(id);
                    showToast('Produk dihapus dari favorit.');
                } else {
                    favorites.add(id);
                    showToast('Produk ditambahkan ke favorit.');
                }

                localStorage.setItem('kickoff_favorites', JSON.stringify([...favorites]));
                renderFavorites();
            });

            $('#wishlistHeader').addEventListener('click', function() {
                if (favorites.size === 0) {
                    showToast('Kamu belum memiliki produk favorit.');
                    return;
                }

                activeFilter = 'semua';
                searchInput.value = '';

                $$('.filter-btn', filterTabs).forEach(button => {
                    button.classList.toggle('active', button.dataset.filter === 'semua');
                });

                $$('.product-card', productGrid).forEach(card => {
                    card.hidden = !favorites.has(Number(card.dataset.id));
                });

                resultCount.textContent = favorites.size + ' produk favorit';
                emptyState.hidden = favorites.size !== 0;

                $('#produk').scrollIntoView({
                    behavior: 'smooth'
                });
            });

            // SHOW ALL PRODUCTS
            $('#showAllProducts').addEventListener('click', function() {
                searchInput.value = '';
                sortSelect.value = 'default';

                const cards = $$('.product-card', productGrid).sort(
                    (a, b) => Number(a.dataset.id) - Number(b.dataset.id)
                );

                cards.forEach(card => productGrid.appendChild(card));

                setActiveFilter('semua');

                $('#produk').scrollIntoView({
                    behavior: 'smooth'
                });
            });

            // NEWSLETTER DEMO
            $('#newsletterForm').addEventListener('submit', function(event) {
                event.preventDefault();
                showToast('Terima kasih! Form newsletter belum terhubung ke backend.');
                this.reset();
            });

            // CHECKOUT DEMO
            $('#checkoutButton').addEventListener('click', function() {
                if (cart.length === 0) {
                    showToast('Keranjang kamu masih kosong.');
                    return;
                }

                showToast('Keranjang siap! Halaman checkout perlu diintegrasikan.');

                // Nantinya arahkan ke route checkout Laravel:
                // window.location.href = "{{ route('checkout.index') }}";
            });

            // INITIALIZE
            updateCartCount();
            renderCart();
            renderFavorites();
            filterProducts();

        });
    </script>

</body>

</html>
