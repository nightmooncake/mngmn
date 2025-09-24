<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">Tambah Pergerakan Stok</h1>

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('stockmovements.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Produk</label>
                            <select name="product_id" id="product_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required onchange="updateStockInfo()">
                                <option value="" disabled selected>Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">
                                        {{ $product->name }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Jenis Pergerakan</label>
                            <select name="type" id="type" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required onchange="validateQuantity()">
                                <option value="in">Masuk (In)</option>
                                <option value="out">Keluar (Out)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Kuantitas</label>
                            <input type="number" name="quantity" id="quantity" min="1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required oninput="validateQuantity()">
                            <p id="stock-warning" class="mt-2 text-sm text-red-600 hidden"></p>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('stockmovements.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateStockInfo() {
            const select = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const warning = document.getElementById('stock-warning');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                const stock = parseInt(selectedOption.dataset.stock) || 0;
                const type = document.getElementById('type').value;

                warning.classList.add('hidden');
                quantityInput.max = type === 'out' ? stock : '';
                quantityInput.placeholder = `Maks: ${stock}`;

                if (type === 'out' && stock === 0) {
                    warning.textContent = "Stok produk ini kosong.";
                    warning.classList.remove('hidden');
                    quantityInput.disabled = true;
                } else {
                    quantityInput.disabled = false;
                }
            }
        }

        function validateQuantity() {
            const select = document.getElementById('product_id');
            const type = document.getElementById('type').value;
            const quantity = parseInt(document.getElementById('quantity').value) || 0;
            const warning = document.getElementById('stock-warning');
            const selectedOption = select.options[select.selectedIndex];

            if (!selectedOption || !selectedOption.value) return;

            const stock = parseInt(selectedOption.dataset.stock) || 0;

            warning.classList.add('hidden');

            if (type === 'out' && quantity > stock) {
                warning.textContent = `Stok tidak mencukupi! Maksimal: ${stock}`;
                warning.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateStockInfo();
        });
    </script>
</x-app-layout>