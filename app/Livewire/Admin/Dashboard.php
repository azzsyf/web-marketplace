<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public string $period = 'month';

    private function dateRange(): array
    {
        return match ($this->period) {
            'week' => [
                now()->startOfDay()->subDays(6),
                now()->endOfDay(),
            ],
            'year' => [
                now()->startOfYear(),
                now()->endOfYear(),
            ],
            default => [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ],
        };
    }

    private function previousDateRange(): array
    {
        return match ($this->period) {
            'week' => [
                now()->startOfDay()->subDays(13),
                now()->startOfDay()->subDays(7)->endOfDay(),
            ],
            'year' => [
                now()->subYear()->startOfYear(),
                now()->subYear()->endOfYear(),
            ],
            default => [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth(),
            ],
        };
    }

    private function chartData(): array
    {
        [$start, $end] = $this->dateRange();
        [$previousStart, $previousEnd] = $this->previousDateRange();

        if ($this->period === 'year') {
            $labels = [];
            $current = array_fill(0, 12, 0);
            $previous = array_fill(0, 12, 0);

            for ($i = 0; $i < 12; $i++) {
                $labels[] = Carbon::create(now()->year, $i + 1, 1)
                    ->translatedFormat('M');

                $current[$i] = (float) Order::where('payment_status', 'paid')
                    ->whereYear('placed_at', now()->year)
                    ->whereMonth('placed_at', $i + 1)
                    ->sum('grand_total');

                $previous[$i] = (float) Order::where('payment_status', 'paid')
                    ->whereYear('placed_at', now()->subYear()->year)
                    ->whereMonth('placed_at', $i + 1)
                    ->sum('grand_total');
            }
        } else {
            $days = $this->period === 'week' ? 7 : now()->day;

            $labels = [];
            $current = [];
            $previous = [];

            for ($i = 0; $i < $days; $i++) {
                if ($this->period === 'week') {
                    $date = now()->startOfDay()->subDays(6 - $i);
                    $previousDate = $date->copy()->subDays(7);
                } else {
                    $date = now()->startOfMonth()->addDays($i);
                    $previousDate = now()->subMonthNoOverflow()
                        ->startOfMonth()
                        ->addDays($i);
                }

                $labels[] = $date->format('d M');

                $current[] = (float) Order::where('payment_status', 'paid')
                    ->whereDate('placed_at', $date->toDateString())
                    ->sum('grand_total');

                $previous[] = (float) Order::where('payment_status', 'paid')
                    ->whereDate('placed_at', $previousDate->toDateString())
                    ->sum('grand_total');
            }
        }

        return [
            'labels' => $labels,
            'current' => $current,
            'previous' => $previous,
        ];
    }

    private function dashboardData(): array
    {
        [$start, $end] = $this->dateRange();

        $orders = Order::whereBetween('placed_at', [$start, $end]);

        $totalOrders = (clone $orders)->count();

        $statusCounts = (clone $orders)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusData = [
            'completed' => (int) ($statusCounts['completed'] ?? 0),
            'processing' => (int) ($statusCounts['processing'] ?? 0),
            'cancelled' => (int) ($statusCounts['cancelled'] ?? 0),
            'pending' => (int) ($statusCounts['pending'] ?? 0),
        ];

        $paidRevenue = (clone $orders)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $customers = (clone $orders)
            ->whereNotNull('customer_phone')
            ->distinct('customer_phone')
            ->count('customer_phone');

        $latestOrders = Order::withCount('items')
            ->latest('placed_at')
            ->limit(5)
            ->get();

        $topProducts = OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select(
                'order_items.product_id',
                'order_items.product_name',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->whereBetween('orders.placed_at', [$start, $end])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy(
                'order_items.product_id',
                'order_items.product_name'
            )
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $maxSold = max((int) ($topProducts->max('total_sold') ?? 0), 1);

        foreach ($topProducts as $product) {
            $product->percentage = round(
                ($product->total_sold / $maxSold) * 100
            );
        }

        return [
            'totalUsers' => User::count(),
            'totalCustomers' => $customers,
            'totalOrders' => $totalOrders,
            'paidRevenue' => (float) $paidRevenue,
            'statusData' => $statusData,
            'latestOrders' => $latestOrders,
            'topProducts' => $topProducts,
            'chartData' => $this->chartData(),
        ];
    }

    public function updatedPeriod(): void
    {
        if (!in_array($this->period, ['month', 'week', 'year'], true)) {
            $this->period = 'month';
        }

        $data = $this->dashboardData();

        $this->dispatch(
            'dashboard-updated',
            chartData: $data['chartData'],
            statusData: $data['statusData'],
            totalOrders: $data['totalOrders']
        );
    }

    public function render()
    {
        return view('livewire.admin.dashboard', $this->dashboardData())
            ->layout('components.layouts.app', [
                'title' => 'Dashboard | Toko Online',
            ]);
    }
}
