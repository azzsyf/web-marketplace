<aside class="sidebar" id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <i class="fa-solid fa-cubes brand-icon"></i>
        <span>TokoAdmin</span>
    </a>

    <nav class="nav-menu">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.users') }}"
            class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span>Pengguna</span>
        </a>

        {{-- <a href="#" class="nav-link">
            <i class="fa-solid fa-user-tag"></i>
            <span>Pelanggan</span>
        </a> --}}

        <a href="{{ route('admin.orders') }}" class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
            <i class="fa-solid fa-receipt"></i>
            <span>Pesanan</span>
        </a>

        <a href="{{ route('admin.products') }}"
            class="nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Produk</span>
        </a>

        <a href="{{ route('admin.categories') }}"
            class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
            <i class="fa-solid fa-tags"></i>
            <span>Kategori</span>
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-chart-line"></i>
            <span>Laporan</span>
        </a>

        <a href="{{ route('admin.settings') }}"
            class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="fa-solid fa-gear"></i>
            <span>Pengaturan</span>
        </a>
    </nav>

    <div class="sidebar-user" style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
            <div class="avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div style="min-width: 0;">
                <strong style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name ?? 'Administrator' }}</strong>
                <small style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->email ?? 'Admin Toko' }}</small>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" title="Keluar">
            @csrf
            <button type="submit" style="background: transparent; border: none; color: #ff6b6b; cursor: pointer; padding: 6px; border-radius: 6px;" aria-label="Keluar">
                <i class="fa-solid fa-right-from-bracket" style="font-size: 16px;"></i>
            </button>
        </form>
    </div>
</aside>

