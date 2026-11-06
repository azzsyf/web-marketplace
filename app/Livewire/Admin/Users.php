<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterRole = '';

    public ?int $userId = null;
    public string $name = '';
    public string $email = '';
    public ?string $password = '';
    public string $role = 'customer';
    public string $phone = '';
    public string $address = '';

    public bool $isModalOpen = false;

    public bool $isDeleteModalOpen = false;
    public ?int $deleteUserId = null;
    public string $deleteUserName = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['userId', 'name', 'email', 'password', 'role', 'phone', 'address']);
        $this->role = 'customer';
        $this->dispatch('open-user-modal');
    }

    public function edit(int $id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->role;
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';

        $this->dispatch('open-user-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-user-modal');
    }

    public function save()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->userId)],
            'role' => ['required', 'in:admin,customer'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ];

        if (!$this->userId) {
            $rules['password'] = ['required', 'string', 'min:8'];
        } else {
            $rules['password'] = ['nullable', 'string', 'min:8'];
        }

        $validated = $this->validate($rules);

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }
            $user->update($validated);
            session()->flash('success', 'Pengguna berhasil diperbarui!');
        } else {
            $validated['password'] = Hash::make($validated['password']);
            User::create($validated);
            session()->flash('success', 'Pengguna baru berhasil ditambahkan!');
        }

        $this->dispatch('close-user-modal');
        $this->reset(['userId', 'name', 'email', 'password', 'role', 'phone', 'address']);
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        $user->delete();
        session()->flash('success', 'Pengguna berhasil dihapus!');
    }

    public function confirmDelete(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        $this->deleteUserId = $user->id;
        $this->deleteUserName = $user->name;
        $this->dispatch('open-delete-user-modal');
    }

    public function closeDeleteModal()
    {
        $this->dispatch('close-delete-user-modal');
        $this->deleteUserId = null;
        $this->deleteUserName = '';
    }

    public function deleteConfirmed()
    {
        if (!$this->deleteUserId) {
            return;
        }

        $user = User::findOrFail($this->deleteUserId);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            $this->closeDeleteModal();
            return;
        }

        $user->delete();
        session()->flash('success', 'Pengguna berhasil dihapus!');

        $this->closeDeleteModal();
    }

    public function render()
    {
        $query = User::query();

        if (trim($this->search) !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterRole !== '') {
            $query->where('role', $this->filterRole);
        }

        return view('livewire.admin.users', [
            'users' => $query->latest()->paginate(10),
            'totalUsers' => User::count(),
            'adminCount' => User::where('role', 'admin')->count(),
            'customerCount' => User::where('role', 'customer')->count(),
        ])->layout('components.layouts.app', [
            'title' => 'Kelola Pengguna | Toko Admin',
        ]);
    }
}



