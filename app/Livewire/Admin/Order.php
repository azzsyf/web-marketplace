<?php

namespace App\Livewire\Admin;

use App\Models\Order as OrderModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Order extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $statusFilter = 'all';
    public string $paymentFilter = 'all';
    public int $perPage = 10;

    public ?int $selectedOrderId = null;
    public bool $showDetail = false;
    public string $statusDraft = 'pending';
    public string $paymentStatusDraft = 'unpaid';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'paymentFilter' => ['except' => 'all'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedPaymentFilter(): void
    {
        $this->resetPage();
    }

    public function openDetail(int $id): void
    {
        $order = OrderModel::with('items')->findOrFail($id);

        $this->selectedOrderId = $order->id;
        $this->statusDraft = $order->status;
        $this->paymentStatusDraft = $order->payment_status;
        $this->showDetail = true;
    }

    public function closeDetail(): void
    {
        $this->reset([
            'selectedOrderId',
            'showDetail',
            'statusDraft',
            'paymentStatusDraft',
        ]);

        $this->statusDraft = 'pending';
        $this->paymentStatusDraft = 'unpaid';
    }

    public function saveOrderStatus(): void
    {
        $this->validate([
            'selectedOrderId' => ['required', 'integer', 'exists:orders,id'],
            'statusDraft' => ['required', Rule::in([
                'pending',
                'processing',
                'shipped',
                'completed',
            ])],
        ]);

        DB::transaction(function (): void {
            $order = OrderModel::query()
                ->lockForUpdate()
                ->findOrFail($this->selectedOrderId);

            // Pembatalan sengaja tidak disediakan di menu ini karena stok
            // harus dikembalikan secara atomik ketika pesanan dibatalkan.
            if ($order->status === 'cancelled') {
                $this->addError('statusDraft', 'Pesanan yang sudah dibatalkan tidak dapat diubah.');
                return;
            }

            $order->update(['status' => $this->statusDraft]);
        });

        if (!$this->getErrorBag()->has('statusDraft')) {
            session()->flash('success', 'Status pesanan berhasil diperbarui.');
        }
    }

    public function savePaymentStatus(): void
    {
        $this->validate([
            'selectedOrderId' => ['required', 'integer', 'exists:orders,id'],
            'paymentStatusDraft' => ['required', Rule::in(['unpaid', 'paid'])],
        ]);

        $order = OrderModel::findOrFail($this->selectedOrderId);
        $order->update(['payment_status' => $this->paymentStatusDraft]);

        session()->flash('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function render()
    {
        $orders = OrderModel::query()
            ->withCount('items')
            ->when($this->search !== '', function ($query): void {
                $search = '%' . trim($this->search) . '%';

                $query->where(function ($subQuery) use ($search): void {
                    $subQuery->where('order_number', 'like', $search)
                        ->orWhere('customer_name', 'like', $search)
                        ->orWhere('customer_phone', 'like', $search);
                });
            })
            ->when($this->statusFilter !== 'all', function ($query): void {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->paymentFilter !== 'all', function ($query): void {
                $query->where('payment_status', $this->paymentFilter);
            })
            ->latest('created_at')
            ->paginate($this->perPage);

        $stats = [
            'total' => OrderModel::count(),
            'pending' => OrderModel::where('status', 'pending')->count(),
            'processing' => OrderModel::where('status', 'processing')->count(),
            'shipped' => OrderModel::where('status', 'shipped')->count(),
            'paid_total' => OrderModel::where('payment_status', 'paid')->sum('grand_total'),
        ];

        $selectedOrder = $this->showDetail && $this->selectedOrderId
            ? OrderModel::with('items')->find($this->selectedOrderId)
            : null;

        return view('livewire.admin.order', compact('orders', 'stats', 'selectedOrder'));
    }
}
