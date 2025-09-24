<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Pesanan Pembelian</h1>

                    <div class="mb-4">
                        <strong>Supplier:</strong> {{ $purchaseOrder->supplier->name }}
                    </div>
                    <div class="mb-4">
                        <strong>Tanggal Pemesanan:</strong> {{ $purchaseOrder->order_date->format('d M Y') }}
                    </div>
                    <div class="mb-4">
                        <strong>Perkiraan Tanggal Pengiriman:</strong> {{ $purchaseOrder->expected_delivery_date->format('d M Y') }}
                    </div>
                    <div class="mb-4">
                        <stCatatanrong>Catatan:</stCatatanrong> {{ $purchaseOrder->notes }}
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('purchase_orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>