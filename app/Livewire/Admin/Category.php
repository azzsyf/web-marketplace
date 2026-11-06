<?php

namespace App\Livewire\Admin;

use App\Models\Category as CategoryModel;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public bool $showForm = false;
    public ?int $categoryId = null;

    public bool $isDeleteModalOpen = false;
    public ?int $deleteCategoryId = null;
    public string $deleteCategoryName = '';

    public string $name = '';
    public string $description = '';
    public bool $is_active = true;

    public function updatingSearch(): void
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
        $this->dispatch('open-category-modal');
    }

    public function edit(int $id): void
    {
        $category = CategoryModel::findOrFail($id);

        $this->resetForm();
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description ?? '';
        $this->is_active = (bool) $category->is_active;
        $this->showForm = true;
        $this->dispatch('open-category-modal');
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->resetForm();
        $this->dispatch('close-category-modal');
    }

    public function save(): void
    {
        $isUpdate = $this->categoryId !== null;
        $oldName = null;
        $this->name = trim($this->name);
        $this->description = trim($this->description);

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')->ignore($this->categoryId),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
        ]);

        $category = $this->categoryId
            ? CategoryModel::findOrFail($this->categoryId)
            : new CategoryModel();

        if ($category->exists) {
            $oldName = $category->name;
        }

        $newName = trim($this->name);
        $category->name = $newName;
        $category->slug = CategoryModel::uniqueSlug($newName, $category->id);
        $category->description = trim($this->description) !== ''
            ? trim($this->description)
            : null;
        $category->is_active = (bool) $this->is_active;

        DB::transaction(function () use ($category, $oldName): void {
            $category->save();

            if ($oldName !== null && $oldName !== $category->name) {
                ProductModel::where('category', $oldName)
                    ->update(['category' => $category->name]);
            }
        });

        $this->closeForm();
        $this->resetPage();

        session()->flash(
            'success',
            $isUpdate
                ? 'Kategori berhasil diperbarui.'
                : 'Kategori berhasil ditambahkan.'
        );
    }

    public function delete(int $id): void
    {
        $category = CategoryModel::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            session()->flash(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan oleh produk.'
            );

            return;
        }

        $category->delete();
        $this->resetPage();
        session()->flash('success', 'Kategori berhasil dihapus.');
    }
    public function confirmDelete(int $id): void
    {
        $category = CategoryModel::findOrFail($id);
        $this->deleteCategoryId = $category->id;
        $this->deleteCategoryName = $category->name;
        $this->dispatch('open-delete-category-modal');
    }

    public function closeDeleteModal(): void
    {
        $this->dispatch('close-delete-category-modal');
        $this->deleteCategoryId = null;
        $this->deleteCategoryName = '';
    }

    public function deleteConfirmed(): void
    {
        if (!$this->deleteCategoryId) {
            return;
        }

        $category = CategoryModel::withCount('products')->findOrFail($this->deleteCategoryId);

        if ($category->products_count > 0) {
            session()->flash(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan oleh produk.'
            );
            $this->closeDeleteModal();
            return;
        }

        $category->delete();
        $this->resetPage();
        session()->flash('success', 'Kategori berhasil dihapus.');
        $this->closeDeleteModal();
    }

    public function toggleStatus(int $id): void
    {
        $category = CategoryModel::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        session()->flash(
            'success',
            $category->is_active
                ? 'Kategori berhasil diaktifkan.'
                : 'Kategori berhasil dinonaktifkan.'
        );
    }

    public function resetForm(): void
    {
        $this->reset([
            'categoryId',
            'name',
            'description',
        ]);

        $this->is_active = true;
        $this->resetValidation();
    }

    public function render()
    {
        $query = CategoryModel::query()->withCount('products');

        if (trim($this->search) !== '') {
            $search = trim($this->search);

            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        return view('livewire.admin.category', [
            'categories' => $query->orderBy('name')->paginate(10),
            'totalCategories' => CategoryModel::count(),
            'activeCategories' => CategoryModel::where('is_active', true)->count(),
            'usedCategories' => CategoryModel::has('products')->count(),
            'emptyCategories' => CategoryModel::doesntHave('products')->count(),
        ]);
    }
}
