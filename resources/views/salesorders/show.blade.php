<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all hover:shadow-xl">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                    <h2 class="text-2xl font-bold flex items-center gap-3">
                        <i class="fas fa-file-invoice"></i>
                        Detail Pesanan Penjualan
                    </h2>
                    <p class="text-blue-100 mt-1">Informasi lengkap tentang pesanan pelanggan</p>
                </div>

                <div class="p-6 sm:p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Informasi Pesanan
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Nomor SO:</span>
                                    <span class="font-medium text-gray-800 dark:text-white">SO-{{ str_pad($salesorder->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Nama Pelanggan:</span>
                                    <span class="font-medium text-gray-800 dark:text-white">{{ $salesorder->customer_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Tanggal Order:</span>
                                    <span class="font-medium text-gray-800 dark:text-white">{{ $salesorder->order_date->format('d M, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Ringkasan Keuangan
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Harga Satuan:</span>
                                    <span class="font-medium text-gray-800 dark:text-white">Rp {{ number_format($salesorder->unit_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Jumlah:</span>
                                    <span class="font-medium text-gray-800 dark:text-white">{{ $salesorder->quantity }}</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-gray-700 dark:text-gray-200">Total:</span>
                                    <span class="text-blue-600 dark:text-blue-400">Rp {{ number_format($salesorder->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            Produk
                        </h3>
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                            <p class="font-medium text-gray-800 dark:text-white">{{ $salesorder->product->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Stok tersedia: {{ $salesorder->product->stock }}</p>
                        </div>
                    </div>

                    @if($salesorder->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                Catatan
                            </h3>
                            <p class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300">
                                {{ $salesorder->notes }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                    <a href="{{ route('salesorders.index') }}"
                       class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 rounded-lg font-medium transition">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>