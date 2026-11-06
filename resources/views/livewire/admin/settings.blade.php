<div class="product-admin">
    <div class="pa-header">
        <div>
            <h1>Pengaturan & Profil</h1>
            <p>Kelola informasi profil Administrator dan ubah kata sandi akun.</p>
        </div>
    </div>

    @if ($successMessage)
        <div class="pa-alert" role="status">
            <i class="fa-solid fa-circle-check"></i> {{ $successMessage }}
        </div>
    @endif
    @if ($passwordSuccessMessage)
        <div class="pa-alert" role="status">
            <i class="fa-solid fa-circle-check"></i> {{ $passwordSuccessMessage }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start;">
        {{-- Update Profile Form --}}
        <div class="pa-card" style="padding: 24px;">
            <div style="margin-bottom: 20px;">
                <h2>Informasi Profil</h2>
                <p style="color: #6a6c85; font-size: 13px;">Perbarui informasi profil dan kontak admin Anda.</p>
            </div>

            <form wire:submit="updateProfile">
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #151b2d;">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="pa-input" style="width: 100%; padding: 10px 14px; border: 1px solid #e4e5ef; border-radius: 8px;" required>
                    @error('name') <span style="color: #e10613; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #151b2d;">Email</label>
                    <input type="email" wire:model="email" class="pa-input" style="width: 100%; padding: 10px 14px; border: 1px solid #e4e5ef; border-radius: 8px;" required>
                    @error('email') <span style="color: #e10613; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #151b2d;">Nomor Telepon / WhatsApp</label>
                    <input type="text" wire:model="phone" class="pa-input" style="width: 100%; padding: 10px 14px; border: 1px solid #e4e5ef; border-radius: 8px;">
                    @error('phone') <span style="color: #e10613; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #151b2d;">Alamat</label>
                    <textarea wire:model="address" rows="3" class="pa-input" style="width: 100%; padding: 10px 14px; border: 1px solid #e4e5ef; border-radius: 8px;"></textarea>
                    @error('address') <span style="color: #e10613; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="pa-btn pa-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Profil
                </button>
            </form>
        </div>

        {{-- Update Password Form --}}
        <div class="pa-card" style="padding: 24px;">
            <div style="margin-bottom: 20px;">
                <h2>Ubah Password</h2>
                <p style="color: #6a6c85; font-size: 13px;">Pastikan akun Anda menggunakan kata sandi yang aman.</p>
            </div>

            <form wire:submit="updatePassword">
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #151b2d;">Password Saat Ini</label>
                    <input type="password" wire:model="current_password" class="pa-input" style="width: 100%; padding: 10px 14px; border: 1px solid #e4e5ef; border-radius: 8px;" required>
                    @error('current_password') <span style="color: #e10613; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #151b2d;">Password Baru</label>
                    <input type="password" wire:model="password" class="pa-input" style="width: 100%; padding: 10px 14px; border: 1px solid #e4e5ef; border-radius: 8px;" required>
                    @error('password') <span style="color: #e10613; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #151b2d;">Konfirmasi Password Baru</label>
                    <input type="password" wire:model="password_confirmation" class="pa-input" style="width: 100%; padding: 10px 14px; border: 1px solid #e4e5ef; border-radius: 8px;" required>
                    @error('password_confirmation') <span style="color: #e10613; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="pa-btn pa-primary" style="background: #0b0b2b;">
                    <i class="fa-solid fa-key"></i> Perbarui Password
                </button>
            </form>
        </div>
    </div>
</div>
