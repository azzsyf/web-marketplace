<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Admin Toko Online' }}</title>

    @livewireStyles

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Smooth Bootstrap Modal Transitions */
        .modal.fade {
            transition: opacity 0.3s ease-in-out;
        }
        .modal.fade.show {
            background: rgba(0, 0, 0, 0.5) !important;
            animation: modalFadeIn 0.3s ease-out forwards;
        }
        .modal.fade .modal-dialog {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease-out;
            transform: translateY(-40px) scale(0.98);
            opacity: 0;
        }
        .modal.fade.show .modal-dialog {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
</head>

<body>
    <livewire:admin.navigation.sidebar />

    <div class="mobile-overlay" id="overlay"></div>

    <main class="main">
        <livewire:admin.navigation.navbar />

        {{ $slot }}
    </main>

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

    @stack('scripts')
</body>

</html>
