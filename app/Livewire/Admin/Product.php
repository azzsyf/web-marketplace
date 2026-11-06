<?php

namespace App\Livewire\Admin;

use App\Models\Category as CategoryModel;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Throwable;

class Product extends Component
{
    use WithFileUploads, WithPagination;

    private const DEFAULT_SIZES = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

    public string $search = '';
    public string $filterCategory = '';
    public string $filterStatus = '';

    public bool $showForm = false;
    public ?int $productId = null;

    public bool $isDeleteModalOpen = false;
    public ?int $deleteProductId = null;
    public string $deleteProductName = '';

    public string $name = '';
    public string $sku = '';
    public string $category = '';
    public string $description = '';
    public string $price = '';
    public string $discount_price = '';
    public $image = null;
    public ?string $currentImage = null;
    public bool $is_active = true;
    public bool $is_featured = false;
    public array $newImages = [];
    public array $currentImages = [];

    /** @var array<int, array{sku:string,size:string,color:string,stock:int|string}> */
    public array $variants = [];

    public function mount(): void
    {
        $this->resetVariantRows();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $product = ProductModel::with('variants')->findOrFail($id);

        $this->resetForm();

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku ?? '';
        $this->category = $product->category ?? '';
        $this->description = $product->description ?? '';
        $this->price = (string) $product->price;
        $this->discount_price = $product->discount_price !== null
            ? (string) $product->discount_price
            : '';
        $this->currentImages = $this->normalizeImages($product->image);

        $this->newImages = [];
        $this->currentImage = $product->primary_image;
        $this->is_active = (bool) $product->is_active;
        $this->is_featured = (bool) $product->is_featured;

        $this->variants = $product->variants->map(fn($variant) => [
            'id' => $variant->id,
            'sku' => $variant->sku ?? '',
            'size' => $variant->size,
            'color' => $variant->color,
            'stock' => (int) $variant->stock,
        ])->values()->all();

        if ($this->variants === []) {
            $this->resetVariantRows();
        }

        $this->newImages = [];

        $this->showForm = true;
    }

    public function addVariant(): void
    {
        $this->variants[] = [
            'sku' => '',
            'size' => 'M',
            'color' => 'Default',
            'stock' => 0,
        ];
    }

    public function removeVariant(int $index): void
    {
        if (isset($this->variants[$index])) {
            unset($this->variants[$index]);
            $this->variants = array_values($this->variants);
        }

        if ($this->variants === []) {
            $this->resetVariantRows();
        }
    }

    public function closeForm(): void
    {
        $this->reset(['newImages', 'currentImages']);
        $this->showForm = false;
        $this->resetForm();
    }


    public function save(): void
    {
        $isUpdate = $this->productId !== null;

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($this->productId),
            ],
            'category' => [
                'required',
                'string',
                'max:100',
                Rule::exists('categories', 'name'),
            ],
            'description' => ['nullable', 'string', 'max:10000'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],

            'variants' => ['required', 'array', 'min:1'],
            'variants.*.sku' => ['nullable', 'string', 'max:100'],
            'variants.*.size' => ['required', 'string', 'max:20'],
            'variants.*.color' => ['required', 'string', 'max:50'],
            'variants.*.stock' => ['required', 'integer', 'min:0'],

            // Foto utama lama, jika masih digunakan.
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // Multiple foto galeri.
            'newImages' => ['nullable', 'array', 'max:10'],
            'newImages.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'sku.unique' => 'SKU produk sudah digunakan.',
            'category.required' => 'Kategori wajib dipilih.',
            'category.exists' => 'Kategori yang dipilih tidak tersedia.',
            'price.required' => 'Harga normal wajib diisi.',
            'discount_price.lt' => 'Harga diskon harus lebih rendah dari harga normal.',

            'variants.required' => 'Tambahkan minimal satu varian produk.',
            'variants.min' => 'Tambahkan minimal satu varian produk.',
            'variants.*.size.required' => 'Ukuran varian wajib diisi.',
            'variants.*.color.required' => 'Warna varian wajib diisi.',
            'variants.*.stock.required' => 'Stok varian wajib diisi.',
            'variants.*.stock.integer' => 'Stok harus berupa bilangan bulat.',
            'variants.*.stock.min' => 'Stok tidak boleh negatif.',

            'image.image' => 'File foto utama harus berupa gambar.',
            'image.mimes' => 'Format foto utama harus JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto utama maksimal 2 MB.',

            'newImages.array' => 'Format upload foto tidak valid.',
            'newImages.max' => 'Maksimal 10 foto baru dalam sekali penyimpanan.',
            'newImages.*.image' => 'Setiap file galeri harus berupa gambar.',
            'newImages.*.mimes' => 'Foto galeri harus berformat JPG, JPEG, PNG, atau WEBP.',
            'newImages.*.max' => 'Ukuran setiap foto galeri maksimal 2 MB.',
        ]);

        // Normalisasi dan validasi kombinasi ukuran + warna.
        $normalizedVariants = [];
        $combinations = [];
        $variantSkus = [];

        foreach ($this->variants as $index => $variant) {
            $size = trim((string) ($variant['size'] ?? ''));
            $color = trim((string) ($variant['color'] ?? ''));
            $variantSku = trim((string) ($variant['sku'] ?? ''));
            $stock = (int) ($variant['stock'] ?? 0);

            $combination = mb_strtolower($size . '|' . $color);

            if (isset($combinations[$combination])) {
                $this->addError(
                    "variants.$index.size",
                    'Kombinasi ukuran dan warna tidak boleh duplikat.'
                );
                return;
            }

            $combinations[$combination] = true;

            if ($variantSku !== '') {
                $skuKey = mb_strtolower($variantSku);

                if (isset($variantSkus[$skuKey])) {
                    $this->addError(
                        "variants.$index.sku",
                        'SKU varian tidak boleh duplikat.'
                    );
                    return;
                }

                $variantSkus[$skuKey] = true;
            }

            $normalizedVariants[] = [
                'sku' => $variantSku !== '' ? $variantSku : null,
                'size' => $size,
                'color' => $color,
                'stock' => $stock,
            ];
        }

        // Cek SKU varian yang sudah digunakan produk lain.
        foreach ($normalizedVariants as $index => $variant) {
            if (!$variant['sku']) {
                continue;
            }

            $skuExists = DB::table('product_variants')
                ->where('sku', $variant['sku'])
                ->when($this->productId, function ($query) {
                    $query->where('product_id', '!=', $this->productId);
                })
                ->exists();

            if ($skuExists) {
                $this->addError(
                    "variants.$index.sku",
                    'SKU varian sudah digunakan.'
                );
                return;
            }
        }

        $product = $this->productId
            ? ProductModel::findOrFail($this->productId)
            : new ProductModel();

        $oldImages = $this->normalizeImages($product->image);
        $newImage = null;
        $uploadedGalleryImages = [];

        try {
            // Upload foto utama jika input image masih digunakan.
            if ($this->image) {
                $newImage = $this->image->store('products', 'public');

                if (!$newImage) {
                    $this->addError(
                        'image',
                        'Gagal mengunggah foto utama. Silakan coba lagi.'
                    );
                    return;
                }
            }

            // Upload seluruh foto galeri.
            foreach ($this->newImages ?? [] as $uploadedImage) {
                $path = $uploadedImage->store('products', 'public');

                if (!$path) {
                    throw new \RuntimeException('Gagal mengunggah salah satu foto galeri.');
                }

                $uploadedGalleryImages[] = $path;
            }

            DB::transaction(function () use (
                $product,
                $normalizedVariants,
                $newImage,
                $uploadedGalleryImages,
                $oldImages
            ) {
                $product->name = trim($this->name);
                $product->slug = ProductModel::uniqueSlug(
                    trim($this->name),
                    $product->id
                );
                $product->sku = trim($this->sku) !== ''
                    ? trim($this->sku)
                    : null;
                $product->category = $this->category;
                $product->description = trim($this->description) !== ''
                    ? trim($this->description)
                    : null;
                $product->price = $this->price;
                $product->discount_price = trim($this->discount_price) !== ''
                    ? $this->discount_price
                    : null;
                $product->is_active = $this->is_active;
                $product->is_featured = $this->is_featured;

                // Ambil hanya foto lama yang masih dipertahankan.
                $keptImages = array_values(array_intersect(
                    $this->normalizeImages($this->currentImages),
                    $oldImages
                ));

                // Gabungkan foto lama yang dipertahankan dengan foto baru.
                $storedImages = array_values(array_unique(array_merge(
                    $keptImages,
                    $newImage ? [$newImage] : [],
                    $uploadedGalleryImages
                )));

                $product->image = $storedImages;

                $product->save();

                // Simpan atau perbarui varian.
                $keptIds = [];

                foreach ($normalizedVariants as $index => $variant) {
                    $existing = null;
                    $variantId = $this->variants[$index]['id'] ?? null;

                    if ($variantId) {
                        $existing = $product->variants()
                            ->whereKey($variantId)
                            ->first();
                    }

                    if ($existing) {
                        $existing->update($variant);
                        $keptIds[] = $existing->id;
                    } else {
                        $created = $product->variants()->create($variant);
                        $keptIds[] = $created->id;
                    }
                }

                $product->variants()
                    ->whereNotIn('id', $keptIds)
                    ->delete();
            });
        } catch (\Throwable $e) {
            // Hapus file yang baru diunggah jika penyimpanan gagal.
            $filesToDelete = array_filter([
                $newImage,
                ...$uploadedGalleryImages,
            ]);

            foreach ($filesToDelete as $path) {
                Storage::disk('public')->delete($path);
            }

            report($e);

            \Illuminate\Support\Facades\Log::error(
                'Gagal menyimpan produk Bakoel Jersey',
                [
                    'product_id' => $this->productId,
                    'exception' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            $this->addError(
                'name',
                'Produk gagal disimpan. Periksa storage/logs/laravel.log.'
            );

            return;
        }

        // Bersihkan file lama yang sudah tidak tercatat di galeri.
        foreach (array_diff($oldImages, $this->normalizeImages($product->image)) as $oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        $this->closeForm();
        $this->resetPage();

        session()->flash(
            'success',
            $isUpdate
                ? 'Produk berhasil diperbarui.'
                : 'Produk berhasil ditambahkan.'
        );
    }


    public function removeNewImage(int $index): void
    {
        if (isset($this->newImages[$index])) {
            unset($this->newImages[$index]);

            $this->newImages = array_values($this->newImages);
        }
    }

    public function removeCurrentImage(int $index): void
    {
        if (!isset($this->currentImages[$index])) {
            return;
        }

        unset($this->currentImages[$index]);

        $this->currentImages = array_values($this->currentImages);
    }

    public function delete(int $id): void
    {
        $product = ProductModel::findOrFail($id);
        $images = $this->normalizeImages($product->image);

        $product->delete();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        $this->resetPage();
        session()->flash('success', 'Produk berhasil dihapus.');
    }

    public function confirmDelete(int $id): void
    {
        $product = ProductModel::findOrFail($id);
        $this->deleteProductId = $product->id;
        $this->deleteProductName = $product->name;
        $this->dispatch('open-delete-product-modal');
    }

    public function closeDeleteModal(): void
    {
        $this->dispatch('close-delete-product-modal');
        $this->deleteProductId = null;
        $this->deleteProductName = '';
    }

    public function deleteConfirmed(): void
    {
        if (!$this->deleteProductId) {
            return;
        }

        $product = ProductModel::findOrFail($this->deleteProductId);
        $images = $this->normalizeImages($product->image);

        $product->delete();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        $this->resetPage();
        session()->flash('success', 'Produk berhasil dihapus.');
        $this->closeDeleteModal();
    }

    public function toggleStatus(int $id): void
    {
        $product = ProductModel::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        session()->flash(
            'success',
            $product->is_active ? 'Produk berhasil diaktifkan.' : 'Produk berhasil dinonaktifkan.'
        );
    }

    public function resetForm(): void
    {
        $this->reset([
            'productId',
            'name',
            'sku',
            'description',
            'price',
            'discount_price',
            'image',
            'currentImage',
            'newImages',
            'currentImages',
        ]);

        $this->category = '';
        $this->is_active = true;
        $this->is_featured = false;
        $this->resetVariantRows();
        $this->resetValidation();
    }

    /**
     * Ubah nilai kolom image (null / JSON string / array / Collection)
     * menjadi array path yang aman dipakai.
     *
     * @return array<int, string>
     */
    private function normalizeImages(mixed $value): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if ($value instanceof \Illuminate\Support\Collection) {
            $value = $value->all();
        }

        if (!is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, fn($path) => is_string($path) && $path !== ''));
    }

    private function resetVariantRows(): void
    {
        $this->variants = [
            ['sku' => '', 'size' => 'M', 'color' => 'Default', 'stock' => 0],
        ];
    }

    public function render()
    {
        $query = ProductModel::query()
            ->withSum('variants as total_variant_stock', 'stock')
            ->withCount('variants');

        if (trim($this->search) !== '') {
            $search = trim($this->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhereHas('variants', fn($variantQuery) => $variantQuery->where('sku', 'like', "%{$search}%"));
            });
        }

        if ($this->filterCategory !== '') {
            $query->where('category', $this->filterCategory);
        }

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $products = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10);

        $allProducts = ProductModel::query()
            ->withSum('variants as total_variant_stock', 'stock')
            ->get();

        return view('livewire.admin.product', [
            'products' => $products,
            'totalProducts' => ProductModel::count(),
            'activeProducts' => ProductModel::where('is_active', true)->count(),
            'inactiveProducts' => ProductModel::where('is_active', false)->count(),
            'lowStockProducts' => $allProducts->filter(
                fn($item) => (int) ($item->total_variant_stock ?? 0) <= 5
            )->count(),
            'categories' => CategoryModel::query()->orderBy('name')->pluck('name'),
        ]);
    }
}
