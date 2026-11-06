
(() => {
    const MAX_PRODUCT_IMAGES = 10;
    const MAX_PRODUCT_IMAGE_SIZE = 2 * 1024 * 1024;

    let selectedProductFiles = [];
    let previewUrls = [];

    function renderProductImagePreview(files, messages = []) {
        const preview = document.getElementById('product-image-preview');
        const count = document.getElementById('product-image-count');
        const error = document.getElementById('product-image-client-error');

        if (!preview || !count || !error) return;

        previewUrls.forEach(url => URL.revokeObjectURL(url));
        previewUrls = [];

        preview.replaceChildren();
        error.textContent = messages.join(' ');

        count.textContent = files.length
            ? `${files.length} foto dipilih`
            : '';

        files.forEach((file, index) => {
            const item = document.createElement('div');
            const image = document.createElement('img');
            const remove = document.createElement('button');

            const url = URL.createObjectURL(file);

            item.className = 'pa-multi-preview-item';

            image.src = url;
            image.alt = `Preview foto ${index + 1}`;

            remove.type = 'button';
            remove.className = 'pa-remove-photo';
            remove.setAttribute('aria-label', `Hapus foto ${index + 1}`);
            remove.innerHTML = '&times;';

            remove.addEventListener('click', () => {
                selectedProductFiles.splice(index, 1);
                syncProductUpload();
            });

            previewUrls.push(url);

            item.append(image, remove);
            preview.append(item);
        });
    }

    function clearLocalProductPreview(messages = []) {
        const preview = document.getElementById('product-image-preview');
        const count = document.getElementById('product-image-count');
        const error = document.getElementById('product-image-client-error');

        if (!preview || !count || !error) return;

        previewUrls.forEach(url => URL.revokeObjectURL(url));
        previewUrls = [];

        // Hapus preview lokal agar tidak duplikat dengan preview Livewire.
        preview.replaceChildren();

        // Jumlah file tetap dipertahankan.
        count.textContent = selectedProductFiles.length
            ? `${selectedProductFiles.length} foto dipilih`
            : '';

        error.textContent = messages.join(' ');
    }

    // Sinkronkan seluruh foto ke input Livewire.
    function syncProductUpload(messages = []) {
        const input = document.getElementById('product-image-input');

        if (!input) return;

        const transfer = new DataTransfer();

        selectedProductFiles.forEach(file => {
            transfer.items.add(file);
        });

        input.files = transfer.files;

        renderProductImagePreview(selectedProductFiles, messages);

        // Beritahu Livewire bahwa seluruh file harus diunggah.
        input.dispatchEvent(
            new Event('change', { bubbles: true })
        );
    }

    // Input picker hanya untuk memilih foto.
    function handleProductImageChange(event) {
        const picker = event.target;

        if (!picker || picker.id !== 'product-image-picker') {
            return;
        }

        const newlySelected = Array.from(picker.files || []);

        if (!newlySelected.length) return;

        const messages = [];

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        const invalidFiles = newlySelected.filter(file => {
            const validType = allowedTypes.includes(file.type) ||
                /\.(jpe?g|png|webp)$/i.test(file.name);

            const validSize = file.size <= MAX_PRODUCT_IMAGE_SIZE;

            return !validType || !validSize;
        });

        if (invalidFiles.length > 0) {
    messages.push(
        'Format harus JPG, JPEG, PNG, WEBP dan maksimal 2 MB per foto.'
    );

    // Jangan tampilkan ulang foto lama dari JavaScript.
    // Foto lama sudah ditampilkan oleh preview Livewire.
    clearLocalProductPreview(messages);

    picker.value = '';
    return;
}

        // Gabungkan foto sebelumnya dengan foto baru.
        const combined = [...selectedProductFiles];

        newlySelected.forEach(file => {
            const exists = combined.some(oldFile =>
                oldFile.name === file.name &&
                oldFile.size === file.size &&
                oldFile.lastModified === file.lastModified
            );

            if (!exists) {
                combined.push(file);
            }
        });

        if (combined.length > MAX_PRODUCT_IMAGES) {
    messages.push(`Maksimal ${MAX_PRODUCT_IMAGES} foto.`);

    clearLocalProductPreview(messages);

    picker.value = '';
    return;
}

        selectedProductFiles = combined;

        // Kirim seluruh foto, bukan hanya foto terakhir.
        syncProductUpload(messages);

        // Supaya foto yang sama dapat dipilih kembali.
        picker.value = '';
    }

    function initAdminUi() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        document.getElementById('menuToggle')?.addEventListener('click', function() {
            sidebar?.classList.toggle('open');
            overlay?.classList.toggle('show');
        });

        overlay?.addEventListener('click', function() {
            sidebar?.classList.remove('open');
            overlay?.classList.remove('show');
        });

        // Delegasi event untuk modal Livewire.
        if (!window.productImageChangeListener) {
            document.addEventListener('change', handleProductImageChange);
            window.productImageChangeListener = true;
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminUi, { once: true });
    } else {
        initAdminUi();
    }

    document.addEventListener('livewire:navigated', () => {
        selectedProductFiles = [];
        previewUrls = [];
    });

})();
