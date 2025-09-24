<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <div class="py-12 bg-gray-50 min-h-screen px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all hover:shadow-xl">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                    <h2 class="text-2xl font-bold flex items-center gap-3">
                        <i class="fas fa-shopping-cart"></i>
                        Buat Pesanan Penjualan
                    </h2>
                    <p class="text-blue-100 mt-1">Isi formulir untuk membuat pesanan baru</p>
                </div>

                <form action="{{ route('salesorders.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-5">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fas fa-user text-gray-500 dark:text-gray-400 mr-1"></i>
                                    Nama Pelanggan
                                </label>
                                <input type="text"
                                       name="customer_name"
                                       id="customer_name"
                                       value="{{ old('customer_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition-colors duration-200"
                                       placeholder="Masukkan nama pelanggan"
                                       required>
                                @error('customer_name')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="order_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fas fa-calendar-alt text-gray-500 dark:text-gray-400 mr-1"></i>
                                    Tanggal Order
                                </label>
                                <input type="date"
                                       name="order_date"
                                       id="order_date"
                                       value="{{ old('order_date', now()->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition-colors duration-200"
                                       required>
                                @error('order_date')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fas fa-box-open text-gray-500 dark:text-gray-400 mr-1"></i>
                                    Pilih Produk
                                </label>
                                <select name="product_id" id="product_id"
                                        onchange="updateProductInfo()"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition-colors duration-200"
                                        required>
                                    <option value="" disabled selected>Pilih Produk</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                                data-price="{{ $product->price }}"
                                                data-stock="{{ $product->stock }}">
                                            {{ $product->name }} (Stok: {{ $product->stock }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Jumlah
                                </label>
                                <input type="number"
                                       name="quantity"
                                       id="quantity"
                                       min="1"
                                       oninput="updateTotal()"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition-colors duration-200"
                                       placeholder="Masukkan jumlah"
                                       required>
                                <p id="stock-warning" class="text-red-600 dark:text-red-400 text-xs mt-1 hidden"></p>
                            </div>

                            <div>
                                <label for="unit_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fas fa-tag text-gray-500 dark:text-gray-400 mr-1"></i>
                                    Harga Satuan
                                </label>
                                <input type="text" id="unit_price_display"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white font-medium"
                                       readonly>
                                <input type="hidden" name="unit_price" id="unit_price_hidden">
                            </div>

                            <div>
                                <label for="total_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    <i class="fas fa-coins text-gray-500 dark:text-gray-400 mr-1"></i>
                                    Total (Rp)
                                </label>
                                <input type="text"
                                       id="total_display"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white font-bold"
                                       readonly>
                                <input type="hidden" name="total" id="total_hidden">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                        <a href="{{ route('salesorders.index') }}"
                           class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Simpan Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateProductInfo() {
            const select = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const unitPriceDisplay = document.getElementById('unit_price_display');
            const unitPriceHidden = document.getElementById('unit_price_hidden');
            const stockWarning = document.getElementById('stock-warning');

            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption) return;

            const price = parseInt(selectedOption.dataset.price) || 0;
            const stock = parseInt(selectedOption.dataset.stock) || 0;

            unitPriceDisplay.value = formatRupiah(price);
            unitPriceHidden.value = price;

            quantityInput.value = '';
            stockWarning.classList.add('hidden');

            if (stock === 0) {
                stockWarning.textContent = "Stok habis!";
                stockWarning.classList.remove('hidden');
                quantityInput.disabled = true;
            } else {
                quantityInput.disabled = false;
            }

            updateTotal();
        }

        function updateTotal() {
            const select = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const stockWarning = document.getElementById('stock-warning');
            const totalDisplay = document.getElementById('total_display');
            const totalHidden = document.getElementById('total_hidden');

            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption) return;

            const price = parseInt(selectedOption.dataset.price) || 0;
            const stock = parseInt(selectedOption.dataset.stock) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            if (quantity > stock && stock > 0) {
                stockWarning.textContent = `Jumlah melebihi stok! Maksimal: ${stock}`;
                stockWarning.classList.remove('hidden');
            } else {
                stockWarning.classList.add('hidden');
            }

            const total = price * quantity;
            totalDisplay.value = formatRupiah(total);
            totalHidden.value = total;
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateProductInfo();
        });
    </script>
</x-app-layout>