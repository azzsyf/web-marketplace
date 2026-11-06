<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b0b2b">

    <title>BAKOEL JAERSEY - Sports Jersey Store</title>

    {{-- GLOBAL FONT --}}
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @livewireStyles
</head>

<body>

    {{-- NAVBAR DAN CART DRAWER GLOBAL --}}
    <livewire:shop.navbar />
    <livewire:shop.cart-drawer />

    {{-- CONTENT HALAMAN --}}
    {{ $slot }}

    @livewireScripts

    {{-- LUCIDE ICON --}}
    <script src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"></script>

    <script>
        function renderLucideIcons() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        document.addEventListener('DOMContentLoaded', renderLucideIcons);
        document.addEventListener('livewire:initialized', renderLucideIcons);
        document.addEventListener('livewire:navigated', renderLucideIcons);
    </script>

</body>

</html>
