<x-app-layout>
    <div class="py-12 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen transition-all duration-300 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 dark:text-white flex items-center gap-3">
                    <i class="fas fa-tachometer-alt text-indigo-600 dark:text-indigo-400"></i>
                    Dasbor Inventaris
                </h2>
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    @if($trashedProducts > 0)
                        <a href="{{ route('products.trash') }}"
                           class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800">
                            <i class="fas fa-trash-restore mr-2"></i>
                            Kelola Produk Dihapus ({{ $trashedProducts }})
                        </a>
                    @endif
                    <div class="time-box bg-white dark:bg-gray-800/90 backdrop-blur-sm text-gray-800 dark:text-gray-200 shadow-lg rounded-xl px-6 py-4 flex items-center gap-4 border border-gray-200 dark:border-gray-700 transition-all hover:shadow-xl">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-indigo-600 dark:text-indigo-400"></i>
                            <span id="current-date" class="font-medium text-sm"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-indigo-600 dark:text-indigo-400"></i>
                            <span id="current-time" class="font-medium text-sm"></span>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div id="toast-success" class="fixed top-5 right-5 z-50 w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg dark:text-gray-400 dark:bg-gray-800 animate-fade-in-down transition-all duration-500 ease-out" role="alert">
                <div class="flex items-center">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span class="sr-only">Check icon</span>
                    </div>
                    <div class="ml-3 text-sm font-normal">
                        <span id="toast-message">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-2xl rounded-xl p-6 border border-gray-100 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Total Penjualan</h3>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalSalesOrders }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-2xl rounded-xl p-6 border border-gray-100 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400">
                            <i class="fas fa-boxes text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Total Stok</h3>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalStock }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-2xl rounded-xl p-6 border border-gray-100 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400">
                            <i class="fas fa-crown text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Produk Terlaris</h3>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $topSellingProducts->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-2xl rounded-xl p-6 border border-gray-100 dark:border-gray-700 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Stok Menipis</h3>
                            <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $productsToRestock->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-line text-blue-500"></i>
                        Tren Penjualan Harian
                    </h3>
                    <div class="w-full" style="height: 300px; position: relative;">
                        <canvas id="lineChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-pie-chart text-purple-500"></i>
                        Kontribusi Kategori Produk
                    </h3>
                    <div class="w-full" style="height: 300px; position: relative;">
                        <canvas id="pieChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border-l-4 border-red-500 p-6 transition-all hover:shadow-xl">
                <h4 class="font-bold text-lg text-gray-800 dark:text-white flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 mr-2"></i>
                    Produk yang Harus Restock Segera
                </h4>
                @if($productsToRestock->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-3 font-medium italic">
                        <i class="fas fa-check-circle mr-1"></i>
                        Tidak ada produk yang perlu restock saat ini. Bagus!
                    </p>
                @else
                    <ul class="list-disc pl-5 mt-4 space-y-2">
                        @foreach($productsToRestock as $product)
                            <li class="text-gray-800 dark:text-gray-200 text-sm font-medium flex justify-between">
                                <span>{{ $product->name }}</span>
                                <span class="text-red-600 dark:text-red-400 font-bold">Stok: {{ $product->stock }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-shadow duration-300">
                    <h4 class="font-bold text-xl text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-exchange-alt text-green-500"></i>
                        Transaksi Terbaru
                    </h4>
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800">
                                <tr class="text-xs uppercase tracking-wider">
                                    <th class="px-4 py-3 text-left font-bold text-gray-600 dark:text-gray-300 rounded-tl-lg">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-bold text-gray-600 dark:text-gray-300">Pelanggan</th>
                                    <th class="px-4 py-3 text-left font-bold text-gray-600 dark:text-gray-300">Produk</th>
                                    <th class="px-4 py-3 text-left font-bold text-gray-600 dark:text-gray-300 rounded-tr-lg">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($recentTransactions as $transaction)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $transaction->order_date->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">
                                            {{ Str::limit($transaction->customer_name, 20, '...') }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                            @if ($transaction->product)
                                                {{ Str::limit($transaction->product->name, 20, '...') }}
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                    <i class="fas fa-trash-alt mr-1"></i> Produk Dihapus
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-sm text-gray-500 text-center dark:text-gray-400 italic">
                                            <i class="fas fa-inbox mr-1"></i>
                                            Tidak ada transaksi terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-shadow duration-300">
                    <h4 class="font-bold text-xl text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-layer-group text-teal-500"></i>
                        Stok per Kategori
                    </h4>
                    <div class="w-full" style="height: 300px; position: relative;">
                        <canvas id="barChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function updateDateTime() {
            const now = new Date();
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', optionsDate);
            document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', optionsTime);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateDateTime();
            setInterval(updateDateTime, 1000);

            const successMessage = "{{ session('success') }}";
            const toast = document.getElementById('toast-success');

            if (successMessage) {
                toast.classList.remove('hidden');
                
                setTimeout(() => {
                    toast.classList.add('animate-fade-out-up');
                    toast.classList.remove('animate-fade-in-down');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 500); 
                }, 5000);
            }

            const salesData = @json($salesData);
            const categoryContribution = @json($categoryContribution);
            const stockByCategory = @json($stockByCategory);

            const salesLabels = salesData.map(item => item.date);
            const salesValues = salesData.map(item => item.total);
            const categoryLabels = categoryContribution.map(item => item.category);
            const categoryValues = categoryContribution.map(item => item.total);
            const barLabels = stockByCategory.map(item => item.category);
            const barValues = stockByCategory.map(item => item.total_stock);

            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: salesValues,
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#4f46e5',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => `Rp ${ctx.parsed.y.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => 'Rp ' + value.toLocaleString()
                            }
                        },
                        x: {
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 6
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('pieChart'), {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryValues,
                        backgroundColor: [
                            '#6366f1', '#8b5cf6', '#ec4899', '#f59e0b',
                            '#10b981', '#06b6d4', '#a855f7', '#d946ef'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 15, usePointStyle: true, boxWidth: 10 }
                        },
                        tooltip: {
                            callbacks: {
                                label: (tooltipItem) => `${tooltipItem.label}: ${tooltipItem.formattedValue}%`
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Jumlah Stok',
                        data: barValues,
                        backgroundColor: '#059669',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true },
                        x: { beginAtZero: true }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOutUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.5s ease-out forwards;
        }

        .animate-fade-out-up {
            animation: fadeOutUp 0.5s ease-in forwards;
        }
    </style>
</x-app-layout>