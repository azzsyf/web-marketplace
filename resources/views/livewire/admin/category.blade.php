<div class="product-admin">
    <div class="pa-header">
        <div>
            <h1>Kategori</h1>
            <p>Kelola kelompok produk agar katalog lebih rapi dan mudah ditemukan.</p>
        </div>
        <button type="button" class="pa-btn pa-primary" wire:click="create" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
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
            <div class="pa-stat-icon"><i class="fa-solid fa-tags"></i></div>
            <div><span>Total Kategori</span><strong>{{ number_format($totalCategories) }}</strong></div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div><span>Kategori Aktif</span><strong>{{ number_format($activeCategories) }}</strong></div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div><span>Dipakai Produk</span><strong>{{ number_format($usedCategories) }}</strong></div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon"><i class="fa-solid fa-folder-open"></i></div>
            <div><span>Belum Dipakai</span><strong>{{ number_format($emptyCategories) }}</strong></div>
        </div>
    </div>

    <div class="pa-card">
        <div class="pa-toolbar">
            <div>
                <h2>Daftar Kategori</h2>
                <p>Kategori aktif akan tersedia pada form produk.</p>
            </div>
            <div class="pa-filters">
                <input type="search" class="pa-input pa-search" placeholder="Cari nama kategori..."
                    wire:model.live.debounce.350ms="search">
                <select class="pa-select" wire:model.live="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
        </div>

        <div class="pa-table-wrap">
            <table class="pa-table category-table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Slug</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr wire:key="category-{{ $category->id }}">
                            <td>
                                <div class="category-name-cell">
                                    <span class="category-mark"><i class="fa-solid fa-tag"></i></span>
                                    <div>
                                        <div class="pa-product-name">{{ $category->name }}</div>
                                        <div class="pa-muted">{{ $category->description ?: 'Tanpa deskripsi' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><code class="category-slug">{{ $category->slug }}</code></td>
                            <td>
                                <strong class="category-count">{{ number_format($category->products_count) }}</strong>
                                <span class="pa-muted">produk</span>
                            </td>
                            <td>
                                <button type="button"
                                    class="pa-badge pa-status-button {{ $category->is_active ? 'pa-badge-active' : 'pa-badge-inactive' }}"
                                    wire:click="toggleStatus({{ $category->id }})"
                                    wire:confirm="Ubah status kategori ini?">
                                    {{ $category->is_active ? '● Aktif' : '● Nonaktif' }}
                                </button>
                            </td>
                            <td>
                                <div class="pa-actions">
                                    <button type="button" class="pa-icon-btn" title="Edit kategori"
                                        wire:click="edit({{ $category->id }})" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="pa-icon-btn delete" title="Hapus kategori"
                                        wire:click="confirmDelete({{ $category->id }})" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="pa-empty">
                                    <div class="pa-empty-icon"><i class="fa-solid fa-tags"></i></div>
                                    <strong class="pa-empty-title">Kategori belum ditemukan</strong>
                                    <span>Tambahkan kategori baru atau ubah kata kunci pencarian.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="pa-pagination">{{ $categories->links() }}</div>
        @endif
    </div>

    <div wire:ignore.self class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $categoryId ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeForm" aria-label="Tutup" data-bs-dismiss="modal"></button>
                </div>

                <form wire:submit="save" class="pa-form" wire:loading.class="pa-loading" wire:target="save">
                    <div class="modal-body">
                        <div class="pa-form-grid category-form-grid" style="overflow-y: visible; max-height: none; padding: 0;">
                            <div class="pa-field full">
                                <label>Nama Kategori <em>*</em></label>
                                <input class="pa-input" type="text" wire:model="name"
                                    placeholder="Contoh: Jersey Bola">
                                <span class="pa-help">Nama ini akan tampil pada produk dan filter katalog.</span>
                                @error('name')
                                    <span class="pa-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pa-field full">
                                <label>Deskripsi</label>
                                <textarea class="pa-textarea category-description" wire:model="description"
                                    placeholder="Contoh: Koleksi jersey sepak bola dari berbagai klub."></textarea>
                                @error('description')
                                    <span class="pa-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pa-field full">
                                <label>Status Kategori</label>
                                <label class="pa-check">
                                    <input type="checkbox" wire:model="is_active">
                                    Kategori aktif dan dapat dipilih pada form produk
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeForm" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target="save">
                            <span wire:loading.remove wire:target="save">
                                ✓ {{ $categoryId ? 'Simpan Perubahan' : 'Simpan Kategori' }}
                            </span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <div class="fs-1 text-danger mb-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h5 class="modal-title mb-2 fw-bold">Konfirmasi Hapus</h5>
                    <p class="text-muted mb-4">Apakah Anda yakin ingin menghapus kategori <strong>{{ $deleteCategoryName }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary px-4" wire:click="closeDeleteModal" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger px-4" wire:click="deleteConfirmed">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function initCategoryComponent() {
            const categoryModalEl = document.getElementById('categoryModal');
            const deleteCategoryModalEl = document.getElementById('deleteCategoryModal');

            const categoryModal = categoryModalEl ? bootstrap.Modal.getOrCreateInstance(categoryModalEl) : null;
            const deleteCategoryModal = deleteCategoryModalEl ? bootstrap.Modal.getOrCreateInstance(deleteCategoryModalEl) : null;

            Livewire.on('open-category-modal', () => categoryModal?.show());
            Livewire.on('close-category-modal', () => categoryModal?.hide());
            Livewire.on('open-delete-category-modal', () => deleteCategoryModal?.show());
            Livewire.on('close-delete-category-modal', () => deleteCategoryModal?.hide());
        }

        if (window.Livewire) {
            initCategoryComponent();
        } else {
            document.addEventListener('livewire:init', initCategoryComponent);
        }
    </script>
@endpush

