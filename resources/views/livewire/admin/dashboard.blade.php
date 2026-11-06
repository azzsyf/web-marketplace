<div class="content">
    <div class="page-heading">
        <div>
            <h1>Dashboard</h1>
            <p>Selamat datang kembali, Administrator! 👋</p>
        </div>

        <select class="period-select" id="periodSelect">
            <option value="month">Bulan Ini</option>
            <option value="week">7 Hari Terakhir</option>
            <option value="year">Tahun Ini</option>
        </select>
    </div>

    <div class="stats-grid">
        <article class="card stat-card">
            <div class="stat-icon blue">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-value">
                    {{ number_format($totalUsers, 0, ',', '.') }}
                </div>
            </div>
        </article>

        <article class="card stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div>
                <div class="stat-label">Pelanggan</div>
                <div class="stat-value">
                    {{ number_format($totalCustomers, 0, ',', '.') }}
                </div>
            </div>
        </article>

        <article class="card stat-card">
            <div class="stat-icon purple">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div>
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">
                    {{ number_format($totalOrders, 0, ',', '.') }}
                </div>
            </div>
        </article>

        <article class="card stat-card">
            <div class="stat-icon orange">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <div class="stat-label">Pendapatan</div>
                <div class="stat-value">
                    Rp {{ number_format($paidRevenue, 0, ',', '.') }}
                </div>
            </div>
        </article>
    </div>

    <div class="middle-grid">
        <section class="card panel">
            <div class="panel-heading">
                <h2>Ringkasan Pendapatan</h2>

                <div class="legend">
                    <span><i></i> Bulan Ini</span>
                    <span><i class="last"></i> Bulan Lalu</span>
                </div>
            </div>

            <div class="chart-wrap" wire:ignore>
                <canvas id="revenueChart"></canvas>
            </div>
        </section>

        <section class="card panel">
            <div class="panel-heading">
                <h2>Status Pesanan</h2>
            </div>

            <div class="order-status-layout" wire:ignore>
                <div class="donut-wrap">
                    <canvas id="orderChart"></canvas>

                    <div class="donut-center">
                        <strong id="orderChartTotal">
                            {{ number_format($totalOrders, 0, ',', '.') }}
                        </strong>
                        <span>Pesanan</span>
                    </div>
                </div>

                <div class="status-legend">
                    <div class="status-row">
                        <span class="status-dot dot-green"></span>
                        Selesai
                        <strong id="statusCompleted">{{ $statusData['completed'] }}</strong>
                    </div>

                    <div class="status-row">
                        <span class="status-dot dot-blue"></span>
                        Diproses
                        <strong id="statusProcessing">{{ $statusData['processing'] }}</strong>
                    </div>

                    <div class="status-row">
                        <span class="status-dot dot-red"></span>
                        Dibatalkan
                        <strong id="statusCancelled">{{ $statusData['cancelled'] }}</strong>
                    </div>

                    <div class="status-row">
                        <span class="status-dot dot-orange"></span>
                        Menunggu
                        <strong id="statusPending">{{ $statusData['pending'] }}</strong>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="bottom-grid">
        <section class="card panel">
            <div class="panel-heading">
                <h2>Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders') }}" class="view-all">Lihat Semua →</a>
            </div>

            <div class="table-wrap">
                <table id="ordersTable">
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($latestOrders as $order)
                            <tr wire:key="dashboard-order-{{ $order->id }}">
                                <td class="order-id">{{ $order->order_number }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>
                                    Rp {{ number_format((float) $order->grand_total, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $statusClass =
                                            [
                                                'completed' => 'completed',
                                                'processing' => 'processing',
                                                'pending' => 'pending',
                                                'cancelled' => 'cancelled',
                                                'shipped' => 'processing',
                                            ][$order->status] ?? 'pending';

                                        $statusName =
                                            [
                                                'completed' => 'Selesai',
                                                'processing' => 'Diproses',
                                                'pending' => 'Menunggu',
                                                'cancelled' => 'Dibatalkan',
                                                'shipped' => 'Dikirim',
                                            ][$order->status] ?? ucfirst($order->status);
                                    @endphp

                                    <span class="badge-status {{ $statusClass }}">
                                        {{ $statusName }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Belum ada pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card panel">
            <a href="{{ route('admin.orders') }}" class="view-all">
                Lihat Semua →
            </a>

            @forelse ($topProducts as $product)
                <div class="product-row" wire:key="top-product-{{ $product->product_id }}">
                    <div class="product-thumb">
                        <i class="fa-solid fa-shirt"></i>
                    </div>

                    <div class="product-info">
                        <div class="product-name">
                            {{ $product->product_name }}
                        </div>

                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $product->percentage }}%"></div>
                        </div>
                    </div>

                    <div class="product-sales">
                        {{ number_format($product->total_sold) }} terjual
                    </div>
                </div>
            @empty
                <div class="text-center">
                    Belum ada produk terjual pada periode ini.
                </div>
            @endforelse
        </section>
    </div>
</div>

@push('scripts')
    <script>
        (function() {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js belum dimuat!');
                return;
            }

            let revenueChart = null;
            let orderChart = null;

            const initialChartData = @js($chartData);
            const initialStatusData = @js($statusData);
            const initialTotalOrders = @js($totalOrders);

            function formatRupiah(value) {
                return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
            }

            function renderCharts(chartData, statusData, totalOrders) {
                const revenueCanvas = document.getElementById('revenueChart');
                const orderCanvas = document.getElementById('orderChart');

                if (!revenueCanvas || !orderCanvas) {
                    console.error('Canvas grafik tidak ditemukan!');
                    return;
                }

                // Hancurkan grafik sebelumnya jika ada.
                if (revenueChart) {
                    revenueChart.destroy();
                }

                if (orderChart) {
                    orderChart.destroy();
                }

                // Grafik pendapatan.
                const ctx = revenueCanvas.getContext('2d');

                const gradient = ctx.createLinearGradient(0, 0, 0, 225);
                gradient.addColorStop(0, 'rgba(112, 83, 245, .25)');
                gradient.addColorStop(1, 'rgba(112, 83, 245, .01)');

                revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                                label: 'Periode Ini',
                                data: chartData.current,
                                borderColor: '#7957f5',
                                backgroundColor: gradient,
                                fill: true,
                                tension: 0.35,
                                borderWidth: 2.5,
                                pointRadius: 0
                            },
                            {
                                label: 'Periode Sebelumnya',
                                data: chartData.previous,
                                borderColor: '#c2b4ff',
                                borderDash: [6, 5],
                                fill: false,
                                tension: 0.35,
                                borderWidth: 2,
                                pointRadius: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: context => formatRupiah(context.raw)
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#edf0f7'
                                },
                                ticks: {
                                    callback: value => {
                                        if (value >= 1000000) {
                                            return (value / 1000000).toFixed(1) + ' jt';
                                        }

                                        return value.toLocaleString('id-ID');
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 8,
                                    maxRotation: 0
                                }
                            }
                        }
                    }
                });

                // Grafik status pesanan.
                const statusValues = [
                    statusData.completed,
                    statusData.processing,
                    statusData.cancelled,
                    statusData.pending
                ];

                orderChart = new Chart(orderCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Selesai', 'Diproses', 'Dibatalkan', 'Menunggu'],
                        datasets: [{
                            data: statusValues,
                            backgroundColor: [
                                '#40bd91',
                                '#6198ff',
                                '#f45a77',
                                '#ffb54f'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Update angka status.
                document.getElementById('orderChartTotal').textContent =
                    Number(totalOrders || 0).toLocaleString('id-ID');

                document.getElementById('statusCompleted').textContent =
                    statusData.completed;

                document.getElementById('statusProcessing').textContent =
                    statusData.processing;

                document.getElementById('statusCancelled').textContent =
                    statusData.cancelled;

                document.getElementById('statusPending').textContent =
                    statusData.pending;
            }

            // Render grafik pertama kali.
            renderCharts(
                initialChartData,
                initialStatusData,
                initialTotalOrders
            );

            // Listener perubahan periode dari Livewire.
            Livewire.on('dashboard-updated', event => {
                console.log('Dashboard updated:', event.detail);

                renderCharts(
                    event.detail.chartData,
                    event.detail.statusData,
                    event.detail.totalOrders
                );
            });

        })();
    </script>
@endpush
