<?php use App\Models\User; ?>
<div class="product-admin">
    <div class="pa-header">
        <div>
            <h1>Pengguna</h1>
            <p>Kelola data akun administrator dan pelanggan toko.</p>
        </div>
        <button type="button" class="pa-btn pa-primary" wire:click="create" data-bs-toggle="modal" data-bs-target="#userModal">
            <i class="fa-solid fa-plus"></i> Tambah Pengguna
        </button>
    </div>

    @if (session()->has('success'))
        <div class="pa-alert" role="status">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="pa-alert pa-alert-error" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <div class="pa-stats">
        <div class="pa-stat">
            <div class="pa-stat-icon"><i class="fa-solid fa-users"></i></div>
            <div><span>Total Pengguna</span><strong>{{ number_format($totalUsers) }}</strong></div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon" style="background: #eef2ff; color: #4f46e5;"><i class="fa-solid fa-user-shield"></i></div>
            <div><span>Administrator</span><strong>{{ number_format($adminCount) }}</strong></div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon" style="background: #ecfdf5; color: #059669;"><i class="fa-solid fa-user-tag"></i></div>
            <div><span>Pelanggan</span><strong>{{ number_format($customerCount) }}</strong></div>
        </div>
    </div>
    <div class="pa-card">
        <div class="pa-toolbar">
            <div>
                <h2>Daftar Pengguna</h2>
                <p>Cari dan kelola akses pengguna sistem.</p>
            </div>
            <div class="pa-filters">
                <input type="search" class="pa-input pa-search" placeholder="Cari nama, email..."
                    wire:model.live.debounce.350ms="search">
                <select class="pa-select" wire:model.live="filterRole">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                </select>
            </div>
        </div>

        <div class="pa-table-wrap">
            <table class="pa-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Kontak</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td>
                                <div>
                                    <strong>{{ $user->name }}</strong><br>
                                    <small class="pa-muted">{{ $user->email }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="pa-badge" style="{{ $user->role === 'admin' ? 'background: #eef2ff; color: #4f46e5;' : 'background: #ecfdf5; color: #059669;' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <div>{{ $user->phone ?: '-' }}</div>
                            </td>
                            <td class="pa-muted">
                                {{ $user->created_at?->format('d M Y') }}
                            </td>
                            <td>
                                <div class="pa-actions">
                                    <button type="button" class="pa-icon-btn" title="Edit"
                                        wire:click="edit({{ $user->id }})" data-bs-toggle="modal" data-bs-target="#userModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    @if ($user->id !== auth()->id())
                                        <button type="button" class="pa-icon-btn pa-danger-btn" title="Hapus"
                                            wire:click="confirmDelete({{ $user->id }})" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px;">Tidak ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $userId ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Tutup" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body">
                        <div style="margin-bottom: 15px;">
                            <label style="display:block; font-weight:700; margin-bottom:5px;">Nama</label>
                            <input type="text" wire:model="name" class="pa-input" style="width:100%" required>
                            @error('name') <span style="color:#e10613; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display:block; font-weight:700; margin-bottom:5px;">Email</label>
                            <input type="email" wire:model="email" class="pa-input" style="width:100%" required>
                            @error('email') <span style="color:#e10613; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display:block; font-weight:700; margin-bottom:5px;">Role</label>
                            <select wire:model="role" class="pa-select" style="width:100%">
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <span style="color:#e10613; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display:block; font-weight:700; margin-bottom:5px;">Password {{ $userId ? '(Opsional)' : '*' }}</label>
                            <input type="password" wire:model="password" class="pa-input" style="width:100%" {{ $userId ? '' : 'required' }}>
                            @error('password') <span style="color:#e10613; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <div class="fs-1 text-danger mb-3">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <h5 class="modal-title mb-2 fw-bold">Konfirmasi Hapus</h5>
                    <p class="text-muted mb-4">
                        Apakah Anda yakin ingin menghapus pengguna <strong>{{ $deleteUserName }}</strong>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary px-4" wire:click="closeDeleteModal" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger px-4" wire:click="deleteConfirmed">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="pa-pagination-wrap">
            {{ $users->links() }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function initUserComponent() {
            const userModalEl = document.getElementById('userModal');
            const deleteUserModalEl = document.getElementById('deleteUserModal');

            const userModal = userModalEl ? bootstrap.Modal.getOrCreateInstance(userModalEl) : null;
            const deleteUserModal = deleteUserModalEl ? bootstrap.Modal.getOrCreateInstance(deleteUserModalEl) : null;

            Livewire.on('open-user-modal', () => userModal?.show());
            Livewire.on('close-user-modal', () => userModal?.hide());
            Livewire.on('open-delete-user-modal', () => deleteUserModal?.show());
            Livewire.on('close-delete-user-modal', () => deleteUserModal?.hide());
        }

        if (window.Livewire) {
            initUserComponent();
        } else {
            document.addEventListener('livewire:init', initUserComponent);
        }
    </script>
@endpush