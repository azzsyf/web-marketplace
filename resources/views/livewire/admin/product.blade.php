<div class="product-admin">
    <style>
        /* Modal produk mengikuti pola modal detail pesanan:
           header dan tombol aksi tetap, hanya isi form yang scroll. */
        .product-admin .pa-overlay {
            box-sizing: border-box;
            padding: 24px;
        }

        .product-admin .pa-modal {
            box-sizing: border-box;
            display: flex !important;
            flex-direction: column !important;
            width: min(1140px, calc(100vw - 48px)) !important;
            max-width: 1140px !important;
            height: auto;
            max-height: calc(100vh - 48px) !important;
            min-height: 0;
            padding: 0 !important;
            overflow: hidden !important;
            border-radius: 24px !important;
            background: #fff;
        }

        .product-admin .pa-modal>.pa-modal-header {
            position: relative;
            z-index: 2;
            flex: 0 0 auto !important;
            padding: 28px 38px !important;
            border-bottom: 1px solid #e8eaf2;
            background: #fff;
        }

        .product-admin .pa-modal>.pa-form {
            display: flex !important;
            flex: 1 1 auto !important;
            flex-direction: column !important;
            min-height: 0 !important;
            overflow: hidden !important;
            gap: 0 !important;
        }

        .product-admin .pa-modal .pa-form-grid {
            box-sizing: border-box;
            flex: 1 1 auto !important;
            min-height: 0 !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
            overscroll-behavior: contain;
            padding: 28px 38px !important;
            align-content: start;
            scrollbar-width: thin;
            scrollbar-color: #c8cad5 #f5f6fa;
        }

        .product-admin .pa-modal .pa-form-grid::-webkit-scrollbar {
            width: 7px;
        }

        .product-admin .pa-modal .pa-form-grid::-webkit-scrollbar-track {
            background: #f5f6fa;
        }

        .product-admin .pa-modal .pa-form-grid::-webkit-scrollbar-thumb {
            background: #c8cad5;
            border-radius: 10px;
        }

        .product-admin .pa-modal .pa-modal-footer {
            position: relative;
            z-index: 2;
            display: flex;
            flex: 0 0 auto !important;
            justify-content: flex-end;
            gap: 10px;
            padding: 18px 38px !important;
            border-top: 1px solid #e8eaf2;
            background: #fff;
        }

        @media (max-width: 700px) {
            .product-admin .pa-overlay {
                padding: 12px;
            }

            .product-admin .pa-modal {
                width: calc(100vw - 24px) !important;
                max-height: calc(100vh - 24px) !important;
                border-radius: 17px !important;
            }

            .product-admin .pa-modal>.pa-modal-header {
                padding: 20px !important;
            }

            .product-admin .pa-modal .pa-form-grid {
                padding: 20px !important;
            }

            .product-admin .pa-modal .pa-modal-footer {
                padding: 14px 20px !important;
            }
        }
    </style>
    <div class="pa-header">
        <div>
            <h1>Produk</h1>
            <p>Kelola katalog jersey Bakoel Jersey dalam satu tempat.</p>
        </div>
        <button type="button" class="pa-btn pa-primary" wire:click="create" data-bs-toggle="modal" data-bs-target="#productModal">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </button>
    </div>

    @if (session()->has('success'))
        <div class="pa-alert" role="status">✓ {{ session('success') }}</div>
    @endif

    <div class="pa-stats">
        <div class="pa-stat">
            <div class="pa-stat-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div><span>Total Produk</span><strong>{{ number_format($totalProducts) }}</strong></div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div><span>Produk Aktif</span><strong>{{ number_format($activeProducts) }}</strong></div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div><span>Stok Menipis</span><strong>{{ number_format($lowStockProducts) }}</strong></div>
        </div>
        <div class="pa-stat">
            <div class="pa-stat-icon"><i class="fa-solid fa-circle-xmark"></i></div>
            <div><span>Produk Nonaktif</span><strong>{{ number_format($inactiveProducts) }}</strong></div>
        </div>
    </div>

    <div class="pa-card">
        <div class="pa-toolbar">
            <div>
                <h2>Daftar Produk</h2>
                <p>Stok dihitung otomatis dari seluruh varian ukuran dan warna.</p>
            </div>
            <div class="pa-filters">
                <input type="search" class="pa-input pa-search" placeholder="Cari produk atau SKU..."
                    wire:model.live.debounce.350ms="search">
                <select class="pa-select" wire:model.live="filterCategory">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $categoryOption)
                        <option value="{{ $categoryOption }}">{{ $categoryOption }}</option>
                    @endforeach
                </select>
                <select class="pa-select" wire:model.live="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
        </div>

        <div class="pa-table-wrap">
            <table class="pa-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Varian</th>
                        <th>Total Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        @php($totalStock = (int) ($product->total_variant_stock ?? 0))
                        <tr wire:key="product-{{ $product->id }}">
                            <td>
                                <div class="pa-product">
                                    @if ($product->primary_image)
                                        <img class="pa-product-img"
                                            src="{{ Storage::disk('public')->url($product->primary_image) }}"
                                            alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <div class="pa-product-img pa-product-placeholder">👕</div>
                                    @endif
                                    <div>
                                        <div class="pa-product-name">{{ $product->name }}</div>
                                        <div class="pa-muted">SKU: {{ $product->sku ?: '-' }}</div>
                                        @if ($product->is_featured)
                                            <span class="pa-badge pa-badge-featured">Unggulan</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->category }}</td>
                            <td>
                                <span class="pa-price">
                                    Rp{{ number_format((float) ($product->discount_price ?? $product->price), 0, ',', '.') }}
                                </span>
                                @if ($product->discount_price !== null)
                                    <span class="pa-discount">
                                        Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $product->variants_count }}</td>
                            <td>
                                <span class="pa-stock {{ $totalStock <= 5 ? 'pa-stock-low' : '' }}">
                                    {{ number_format($totalStock) }}
                                </span>
                                @if ($totalStock <= 5)
                                    <div class="pa-muted">Stok menipis</div>
                                @endif
                            </td>
                            <td>
                                <button type="button"
                                    class="pa-badge pa-status-button {{ $product->is_active ? 'pa-badge-active' : 'pa-badge-inactive' }}"
                                    wire:click="toggleStatus({{ $product->id }})"
                                    wire:confirm="Ubah status produk ini?">
                                    {{ $product->is_active ? '● Aktif' : '● Nonaktif' }}
                                </button>
                            </td>
                            <td>
                                <div class="pa-actions">
                                    <button type="button" class="pa-icon-btn" title="Edit produk"
                                        wire:click="edit({{ $product->id }})" data-bs-toggle="modal" data-bs-target="#productModal">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="pa-icon-btn delete" title="Hapus produk"
                                        wire:click="confirmDelete({{ $product->id }})" data-bs-toggle="modal" data-bs-target="#deleteProductModal">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="pa-empty">
                                    <div class="pa-empty-icon"><i class="fa-solid fa-box-open"></i></div>
                                    <strong class="pa-empty-title">Produk belum ditemukan</strong>
                                    <span>Tambahkan produk baru atau ubah kata kunci pencarian.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="pa-pagination">{{ $products->links() }}</div>
        @endif
    </div>

    <div wire:ignore.self class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $productId ? 'Edit Produk' : 'Tambah Produk Baru' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeForm"
                        aria-label="Tutup formulir" data-bs-dismiss="modal"></button>
                </div>

                <form wire:submit="save" class="pa-form" wire:loading.class="pa-loading" wire:target="save">
                    <div class="pa-form-grid">
                        <div class="pa-field">
                            <label>Nama Produk <em>*</em></label>
                            <input class="pa-input" type="text" wire:model="name"
                                placeholder="Contoh: Jersey Home Barcelona">
                            @error('name')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pa-field">
                            <label>SKU / Kode Produk</label>
                            <input class="pa-input" type="text" wire:model="sku" placeholder="BJ-BAR-001">
                            @error('sku')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pa-field">
                            <label>Kategori <em>*</em></label>
                            <select class="pa-select" wire:model="category">
                                <option value="">Pilih kategori</option>
                                @foreach ($categories as $categoryOption)
                                    <option value="{{ $categoryOption }}">{{ $categoryOption }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pa-field">
                            <label>Harga Normal (Rp) <em>*</em></label>
                            <input class="pa-input" type="number" min="0" step="1" wire:model="price"
                                placeholder="150000">
                            @error('price')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pa-field">
                            <label>Harga Diskon (Rp)</label>
                            <input class="pa-input" type="number" min="0" step="1"
                                wire:model="discount_price" placeholder="Kosongkan jika tidak diskon">
                            @error('discount_price')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pa-field full">
                            <label>Deskripsi Produk</label>
                            <textarea class="pa-textarea" wire:model="description"
                                placeholder="Bahan, kualitas, detail produk, dan informasi lainnya..."></textarea>
                            @error('description')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pa-field full">
                            <div class="pa-variant-heading">
                                <div>
                                    <label>Varian Produk <em>*</em></label>
                                    <span class="pa-help">Setiap kombinasi ukuran dan warna memiliki stok sendiri.
                                        Jangan buat kombinasi duplikat.</span>
                                </div>
                                <button type="button" class="pa-btn pa-secondary" wire:click="addVariant">
                                    <i class="fa-solid fa-plus"></i> Tambah Varian
                                </button>
                            </div>

                            <div class="pa-variant-list">
                                @foreach ($variants as $index => $variant)
                                    <div class="pa-variant-row" wire:key="variant-row-{{ $index }}">
                                        <div class="pa-field">
                                            <label>Ukuran <em>*</em></label>
                                            <input class="pa-input" type="text"
                                                wire:model="variants.{{ $index }}.size" placeholder="M">
                                            @error("variants.$index.size")
                                                <span class="pa-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="pa-field">
                                            <label>Warna <em>*</em></label>
                                            <input class="pa-input" type="text"
                                                wire:model="variants.{{ $index }}.color" placeholder="Hitam">
                                            @error("variants.$index.color")
                                                <span class="pa-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="pa-field">
                                            <label>SKU Varian</label>
                                            <input class="pa-input" type="text"
                                                wire:model="variants.{{ $index }}.sku" placeholder="Opsional">
                                            @error("variants.$index.sku")
                                                <span class="pa-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="pa-field">
                                            <label>Stok <em>*</em></label>
                                            <input class="pa-input" type="number" min="0" step="1"
                                                wire:model.lazy="variants.{{ $index }}.stock" placeholder="0">
                                            @error("variants.$index.stock")
                                                <span class="pa-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="button" class="pa-icon-btn delete" title="Hapus varian"
                                            wire:click="removeVariant({{ $index }})"
                                            @if (count($variants) <= 1) disabled @endif>
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            @error('variants')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror

                            <div class="pa-size-stock-total">
                                <div><span>Total Stok</span><small>Jumlah stok seluruh varian</small></div>
                                <strong>{{ collect($variants)->sum(fn($variant) => max(0, (int) ($variant['stock'] ?? 0))) }}
                                    <small>pcs</small></strong>
                            </div>
                        </div>


                        <div class="pa-field full">
                            <label>Foto Produk</label>

                            {{-- Input untuk memilih foto --}}
                            <input id="product-image-picker" type="file" class="pa-input"
                                accept="image/jpeg,image/png,image/webp">

                            {{-- Input khusus upload Livewire --}}
                            <input id="product-image-input" type="file" wire:model="newImages" multiple hidden>

                            <p class="pa-help">
                                Pilih foto satu per satu atau beberapa sekaligus.
                                Maksimal 10 foto, maksimal 2 MB per foto.
                            </p>

                            {{-- Status upload --}}
                            <div wire:loading wire:target="newImages" class="pa-help-loading">
                                Mengunggah foto ke server...
                            </div>

                            {{-- Validasi Livewire --}}
                            @error('newImages')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror

                            @error('newImages.*')
                                <span class="pa-error">{{ $message }}</span>
                            @enderror

                            {{-- Jumlah foto dan error dari JavaScript --}}
                            <p id="product-image-count" class="pa-help"></p>

                            <p id="product-image-client-error" class="pa-error"></p>

                            {{-- Preview sementara sebelum upload selesai --}}
                            <div wire:loading.remove wire:target="newImages" id="product-image-preview-wrapper">
                                <div id="product-image-preview" class="pa-multi-preview"></div>
                            </div>

                            {{-- Preview foto yang sudah diterima Livewire --}}
                            @if (count($newImages) > 0)
                                <div wire:loading.remove wire:target="newImages">
                                    <p class="pa-help">
                                        {{ count($newImages) }} foto diterima Livewire.
                                    </p>

                                    <div class="pa-multi-preview">
                                        @foreach ($newImages as $index => $photo)
                                            <div class="pa-multi-preview-item"
                                                wire:key="livewire-photo-{{ $index }}">
                                                <img src="{{ $photo->temporaryUrl() }}"
                                                    alt="Foto {{ $index + 1 }}">

                                                <button type="button" class="pa-remove-photo"
                                                    wire:click="removeNewImage({{ $index }})">
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Foto yang sudah tersimpan --}}
                            @if (!empty($currentImages))
                                <p class="pa-help">Foto tersimpan</p>

                                <div class="pa-multi-preview">
                                    @foreach ($currentImages as $index => $path)
                                        <div class="pa-multi-preview-item"
                                            wire:key="existing-photo-{{ $index }}">

                                            <img src="{{ Storage::disk('public')->url($path) }}"
                                                alt="Foto {{ $index + 1 }}" onerror="this.style.display='none'">

                                            <button type="button" class="pa-remove-photo"
                                                wire:click="removeCurrentImage({{ $index }})"
                                                wire:confirm="Hapus foto ini dari produk?" title="Hapus foto">
                                                ×
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>


                        <div class="pa-field full">
                            <label>Pengaturan Produk</label>
                            <div class="pa-checks">
                                <label class="pa-check"><input type="checkbox" wire:model="is_active"> Produk
                                    aktif</label>
                                <label class="pa-check"><input type="checkbox" wire:model="is_featured"> Produk
                                    unggulan</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeForm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target="save,newImages">
                            <span wire:loading.remove wire:target="save">✓
                                {{ $productId ? 'Simpan Perubahan' : 'Simpan Produk' }}</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <div class="fs-1 text-danger mb-3">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <h5 class="modal-title mb-2 fw-bold">Konfirmasi Hapus</h5>
                    <p class="text-muted mb-4">Apakah Anda yakin ingin menghapus produk <strong>{{ $deleteProductName }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
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
        function initProductComponent() {
            const productModalEl = document.getElementById('productModal');
            const deleteProductModalEl = document.getElementById('deleteProductModal');

            const productModal = productModalEl ? bootstrap.Modal.getOrCreateInstance(productModalEl) : null;
            const deleteProductModal = deleteProductModalEl ? bootstrap.Modal.getOrCreateInstance(deleteProductModalEl) : null;

            Livewire.on('open-product-modal', () => productModal?.show());
            Livewire.on('close-product-modal', () => productModal?.hide());
            Livewire.on('open-delete-product-modal', () => deleteProductModal?.show());
            Livewire.on('close-delete-product-modal', () => deleteProductModal?.hide());
        }

        if (window.Livewire) {
            initProductComponent();
        } else {
            document.addEventListener('livewire:init', initProductComponent);
        }
    </script>
@endpush
