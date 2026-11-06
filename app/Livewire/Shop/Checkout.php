<?php

namespace App\Livewire\Shop;

use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\RajaOngkirService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Throwable;

#[Layout('layouts.app')]
class Checkout extends Component
{
    public string $customer_name = '';
    public string $customer_phone = '';
    public string $customer_email = '';

    public string $destination_search = '';
    public array $destination_options = [];
    public ?int $shipping_destination_id = null;
    public string $shipping_destination_label = '';

    public string $shipping_province = '';
    public string $shipping_city = '';
    public string $shipping_postal_code = '';
    public string $shipping_address = '';

    public array $shipping_options = [];
    public string $selected_shipping_key = '';
    public string $shipping_courier = '';
    public string $shipping_courier_name = '';
    public string $shipping_service = '';
    public string $shipping_etd = '';
    public int $shipping_cost = 0;

    public string $payment_method = 'bank_transfer';
    public string $notes = '';

    /** Dipanggil Livewire setelah input pencarian alamat berubah (sudah debounce di Blade). */
    public function updatedDestinationSearch(): void
    {
        $this->resetDestinationAndRates();
        $keyword = trim($this->destination_search);

        if (mb_strlen($keyword) < 3) {
            $this->destination_options = [];
            return;
        }

        try {
            $this->destination_options = app(RajaOngkirService::class)
                ->searchDestinations($keyword, 10);
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('destination_search', 'Pencarian alamat sedang bermasalah. Silakan coba kembali.');
        }
    }

    public function chooseDestination(int $destinationId): void
    {
        $destination = collect($this->destination_options)
            ->first(fn ($item) => (int) ($item['id'] ?? 0) === $destinationId);

        if (!$destination) {
            $this->addError('destination_search', 'Pilihan alamat tidak valid. Silakan cari alamat kembali.');
            return;
        }

        $this->shipping_destination_id = (int) $destination['id'];
        $this->shipping_destination_label = (string) ($destination['label'] ?? '');
        $this->shipping_province = (string) ($destination['province_name'] ?? '');
        $this->shipping_city = (string) ($destination['city_name'] ?? '');
        $this->shipping_postal_code = (string) ($destination['zip_code'] ?? '');
        $this->destination_search = $this->shipping_destination_label;
        $this->destination_options = [];
        $this->resetShippingSelection();

        $this->loadShippingOptions();
    }

    public function loadShippingOptions(): void
    {
        $this->resetShippingSelection();

        if (!$this->shipping_destination_id) {
            return;
        }

        try {
            $cart = app(CartService::class);
            $items = $cart->detailedItems();

            if ($items === []) {
                $this->addError('cart', 'Keranjang masih kosong.');
                return;
            }

            $weight = $this->calculatePackageWeight($items);
            $rates = app(RajaOngkirService::class)->calculateDomestic(
                $this->shipping_destination_id,
                $weight
            );

            foreach ($rates as $index => $rate) {
                $code = strtolower((string) ($rate['code'] ?? ''));
                $service = (string) ($rate['service'] ?? '');
                $cost = (int) ($rate['cost'] ?? 0);

                if ($code === '' || $service === '' || $cost < 0) {
                    continue;
                }

                $this->shipping_options[] = [
                    'key' => sha1($code . '|' . $service . '|' . $index),
                    'name' => (string) ($rate['name'] ?? strtoupper($code)),
                    'code' => $code,
                    'service' => $service,
                    'description' => (string) ($rate['description'] ?? ''),
                    'cost' => $cost,
                    'etd' => (string) ($rate['etd'] ?? ''),
                ];
            }

            if ($this->shipping_options === []) {
                $this->addError('shipping_service', 'Tidak ada layanan ekspedisi untuk alamat tujuan ini.');
            }
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('shipping_service', 'Ongkir gagal dimuat. Periksa alamat asal, API Key, dan koneksi API.');
        }
    }

    public function chooseShippingOption(string $key): void
    {
        $option = collect($this->shipping_options)->firstWhere('key', $key);

        if (!$option) {
            $this->addError('shipping_service', 'Layanan pengiriman tidak valid. Muat ulang pilihan ongkir.');
            return;
        }

        $this->selected_shipping_key = $option['key'];
        $this->shipping_courier = $option['code'];
        $this->shipping_courier_name = $option['name'];
        $this->shipping_service = $option['service'];
        $this->shipping_etd = $option['etd'];
        $this->shipping_cost = (int) $option['cost'];
        $this->resetValidation('shipping_service');
    }

    public function placeOrder(
        CheckoutService $checkout,
        CartService $cart,
        RajaOngkirService $rajaOngkir
    ) {
        $this->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:150'],
            'shipping_destination_id' => ['required', 'integer', 'min:1'],
            'shipping_destination_label' => ['required', 'string', 'max:255'],
            'shipping_province' => ['required', 'string', 'max:100'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['nullable', 'string', 'max:10'],
            'shipping_address' => ['required', 'string', 'max:2000'],
            'shipping_courier' => ['required', 'string', 'max:30'],
            'shipping_service' => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'in:bank_transfer,cod'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'customer_name.required' => 'Nama penerima wajib diisi.',
            'customer_phone.required' => 'Nomor WhatsApp/telepon wajib diisi.',
            'customer_email.email' => 'Format email tidak valid.',
            'shipping_destination_id.required' => 'Pilih kecamatan atau kelurahan tujuan.',
            'shipping_address.required' => 'Alamat lengkap wajib diisi.',
            'shipping_courier.required' => 'Pilih ekspedisi pengiriman.',
            'shipping_service.required' => 'Pilih layanan pengiriman.',
        ]);

        try {
            // Hitung ulang di server. Nominal ongkir dari browser tidak pernah dipercaya.
            $items = $cart->detailedItems();
            if ($items === []) {
                throw ValidationException::withMessages([
                    'cart' => 'Keranjang kosong atau produk sudah tidak tersedia.',
                ]);
            }

            $rates = $rajaOngkir->calculateDomestic(
                (int) $this->shipping_destination_id,
                $this->calculatePackageWeight($items),
                $this->shipping_courier
            );

            $selectedRate = collect($rates)->first(function ($rate) {
                return strtolower((string) ($rate['code'] ?? '')) === strtolower($this->shipping_courier)
                    && (string) ($rate['service'] ?? '') === $this->shipping_service;
            });

            if (!$selectedRate) {
                $this->loadShippingOptions();
                throw ValidationException::withMessages([
                    'shipping_service' => 'Tarif layanan berubah atau tidak tersedia. Silakan pilih layanan pengiriman kembali.',
                ]);
            }

            $verifiedShippingCost = (int) ($selectedRate['cost'] ?? 0);
            if ($verifiedShippingCost < 0) {
                throw ValidationException::withMessages([
                    'shipping_service' => 'Tarif pengiriman dari ekspedisi tidak valid.',
                ]);
            }

            $order = $checkout->place([
                'customer_name' => $this->customer_name,
                'customer_phone' => $this->customer_phone,
                'customer_email' => $this->customer_email,
                'shipping_province' => $this->shipping_province,
                'shipping_city' => $this->shipping_city,
                'shipping_postal_code' => $this->shipping_postal_code,
                'shipping_address' => $this->shipping_address,
                'shipping_destination_id' => $this->shipping_destination_id,
                'shipping_destination_label' => $this->shipping_destination_label,
                'shipping_courier' => strtolower($this->shipping_courier),
                'shipping_courier_name' => (string) ($selectedRate['name'] ?? $this->shipping_courier_name),
                'shipping_service' => $this->shipping_service,
                'shipping_etd' => (string) ($selectedRate['etd'] ?? $this->shipping_etd),
                'shipping_cost' => $verifiedShippingCost,
                'payment_method' => $this->payment_method,
                'notes' => $this->notes,
            ]);

            $cart->clear();
            session(['last_shop_order_id' => $order->id]);
            $this->dispatch('cart-updated');

            return redirect()->route('checkout.success');
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('shipping_service', 'Gagal memproses ongkir. Silakan muat ulang pilihan ekspedisi dan coba lagi.');
        }
    }

    public function render()
    {
        $cartItems = app(CartService::class)->detailedItems();
        $subtotal = (float) collect($cartItems)->sum('line_total');

        return view('livewire.shop.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'grandTotal' => $subtotal + $this->shipping_cost,
            'packageWeight' => $this->calculatePackageWeight($cartItems),
        ]);
    }

    private function calculatePackageWeight(array $items): int
    {
        $itemsWeight = collect($items)->sum(function ($item) {
            return max(1, (int) ($item['weight_grams'] ?? 500))
                * max(1, (int) ($item['quantity'] ?? 1));
        });

        $packagingWeight = max(0, (int) config('services.rajaongkir.packaging_weight_grams', 100));

        return max(1, (int) $itemsWeight + $packagingWeight);
    }

    private function resetDestinationAndRates(): void
    {
        $this->shipping_destination_id = null;
        $this->shipping_destination_label = '';
        $this->shipping_province = '';
        $this->shipping_city = '';
        $this->shipping_postal_code = '';
        $this->destination_options = [];
        $this->resetShippingSelection();
        $this->resetValidation('destination_search');
    }

    private function resetShippingSelection(): void
    {
        $this->shipping_options = [];
        $this->selected_shipping_key = '';
        $this->shipping_courier = '';
        $this->shipping_courier_name = '';
        $this->shipping_service = '';
        $this->shipping_etd = '';
        $this->shipping_cost = 0;
        $this->resetValidation('shipping_service');
    }
}
