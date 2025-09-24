<x-app-layout>
        <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Purchase Order</h1>
                    <form action="{{ route('purchase_orders.update', $purchaseOrder->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                            <select id="supplier_id" name="supplier_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md" required>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ $supplier->id == $purchaseOrder->supplier_id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="order_date" class="block text-sm font-medium text-gray-700">Tanggal Pesanan</label>
                            <input type="date" id="order_date" name="order_date" value="{{ $purchaseOrder->order_date->format('Y-m-d') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="expected_delivery_date" class="block text-sm font-medium text-gray-700">Tanggal Pengiriman Diharapkan</label>
                            <input type="date" id="expected_delivery_date" name="expected_delivery_date" value="{{ $purchaseOrder->expected_delivery_date->format('Y-m-d') }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md">{{ $purchaseOrder->notes }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md" required>
                                <option value="pending" {{ $purchaseOrder->status == 'pending' ? 'selected' : '' }}>Tertunda</option>
                                <option value="completed" {{ $purchaseOrder->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $purchaseOrder->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('purchase_orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Batal
                            </a>
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Edit Purchase Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>