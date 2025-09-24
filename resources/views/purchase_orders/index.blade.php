<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-3xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">

                <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                                <i class="fas fa-shopping-cart text-indigo-600 dark:text-indigo-400"></i>
                                Daftar Pesanan Pembelian
                            </h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-1">Kelola pesanan pembelian dari supplier</p>
                        </div>
                        <a href="{{ route('purchase_orders.create') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-all shadow-md text-center">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Pembelian
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider rounded-tl-lg">
                                    No
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Nomor PO
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Supplier
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Tanggal Pemesanan
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Pengiriman Tiba
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider rounded-tr-lg">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-white">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-gray-900 dark:text-gray-100">
                                    PO-{{ str_pad($loop->iteration, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
                                    {{ $order->supplier->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ $order->order_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ $order->expected_delivery_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                    $status = $order->status;
                                    $expected = \Carbon\Carbon::parse($order->expected_delivery_date);
                                    $statusClass = match($status) {
                                    'completed' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                                    'cancelled' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
                                    'pending' => $expected->isToday()
                                    ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300'
                                    : ($expected->isFuture()
                                    ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300'
                                    : 'bg-red-200 dark:bg-red-800 text-red-800 dark:text-red-200'),
                                    default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300',
                                    };
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                    <a href="{{ route('purchase_orders.show', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-900/60 rounded-lg text-sm transition-all duration-200">
                                        <i class="fas fa-eye"></i> Tampilkan
                                    </a>
                                    <a href="{{ route('purchase_orders.edit', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300 dark:hover:bg-indigo-900/60 rounded-lg text-sm transition-all duration-200">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="openDeleteOrderModal(event, '{{ route('purchase_orders.destroy', $order->id) }}')" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-900/60 rounded-lg text-sm transition-all duration-200">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-shopping-bag text-6xl opacity-30 mb-3"></i>
                                        <p class="text-lg font-medium mb-2">Tidak ada pesanan pembelian.</p>
                                        <a href="{{ route('purchase_orders.create') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium underline">
                                            Buat yang pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteOrderModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 backdrop-blur-sm hidden transition-opacity duration-300" onclick="closeDeleteOrderModal()">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-sm w-full p-6 border border-gray-200 dark:border-gray-700" onclick="event.stopPropagation()">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white text-center mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 dark:text-gray-300 text-center mb-6">
                Apakah Anda yakin ingin menghapus pesanan pembelian ini?
            </p>
            <div class="flex justify-center gap-4">
                <button onclick="closeDeleteOrderModal()" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors duration-200">
                    Batal
                </button>
                <form id="deleteOrderForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors duration-200">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="notification-container" class="fixed top-4 right-4 z-50 w-full max-w-xs space-y-2">
    </div>

    <script>
        function openDeleteOrderModal(event, url) {
            event.preventDefault();
            document.getElementById('deleteOrderForm').action = url;
            document.getElementById('deleteOrderModal').classList.remove('hidden');
        }

        function closeDeleteOrderModal() {
            document.getElementById('deleteOrderModal').classList.add('hidden');
        }

        function showNotification(message, type) {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            notification.className = `p-4 rounded-lg shadow-lg flex items-center transition-all duration-300 transform translate-x-full opacity-0`;
            let iconClass = '';
            let colorClass = '';
            switch (type) {
                case 'success':
                    iconClass = 'fas fa-check-circle';
                    colorClass = 'bg-green-500 text-white';
                    break;
                case 'error':
                    iconClass = 'fas fa-times-circle';
                    colorClass = 'bg-red-500 text-white';
                    break;
                case 'info':
                    iconClass = 'fas fa-info-circle';
                    colorClass = 'bg-blue-500 text-white';
                    break;
                default:
                    iconClass = 'fas fa-info-circle';
                    colorClass = 'bg-gray-500 text-white';
            }
            notification.innerHTML = `
                <div class="flex-shrink-0">
                    <i class="${iconClass} text-xl"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-semibold">${message}</p>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 p-1.5 inline-flex h-8 w-8 rounded-lg ${colorClass}" onclick="this.closest('div').remove()">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times text-sm"></i>
                </button>
            `;
            notification.classList.add(colorClass);
            container.prepend(notification);
            setTimeout(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
            }, 100);
            setTimeout(() => {
                notification.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }
    </script>
</x-app-layout>