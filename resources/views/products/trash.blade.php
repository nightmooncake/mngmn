<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                    <svg class="h-8 w-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Produk Dihapus
                </h2>
                <a href="{{ url()->previous() ?? route('dashboard') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            @if($trashedProducts->isEmpty())
                <div
                    class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 text-center border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada produk yang dihapus.</p>
                </div>
            @else
                <form id="massDeleteForm" action="{{ route('products.mass-force-delete') }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus permanen produk yang dipilih? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')

                    <div class="flex items-center justify-between mb-4">
                        <label class="inline-flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" id="selectAll" class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold select-none">Pilih Semua</span>
                        </label>

                        <button type="submit" id="massDeleteButton"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus Semua Permanen
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($trashedProducts as $product)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700 relative">
                                <div class="absolute top-3 left-3 z-10">
                                    <input type="checkbox" name="ids[]" value="{{ $product->id }}"
                                           class="product-checkbox form-checkbox h-5 w-5 text-indigo-600">
                                </div>

                                <div class="relative h-40 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover transform hover:scale-105 transition duration-300">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                                            <svg class="h-16 w-16 text-gray-400 dark:text-gray-500" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <span
                                        class="absolute top-3 right-3 px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full shadow-md">Dihapus</span>
                                </div>

                                <div class="p-5">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white truncate">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        <span class="font-semibold">Kategori:</span> {{ $product->category?->name ?? 'Tidak ada' }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        <span class="font-semibold">Stok:</span> <span
                                            class="font-bold text-red-500">{{ $product->stock }}</span>
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        <span class="font-semibold">Harga:</span>
                                        <span
                                            class="font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </p>
                                </div>

                                <div class="p-5 border-t border-gray-200 dark:border-gray-700 space-y-3">
                                    <form action="{{ route('products.restore', $product->id) }}" method="POST" onsubmit="return confirm('Pulihkan produk ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800">
                                            <i class="fas fa-undo mr-2"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('products.force-delete', $product->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus permanen produk ini? Tindakan ini tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 hover:shadow-xl">
                                            <i class="fas fa-trash-alt mr-2"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        const selectAllCheckbox = document.getElementById('selectAll');
        const productCheckboxes = document.querySelectorAll('.product-checkbox');

        selectAllCheckbox.addEventListener('change', function () {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        productCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
    </script>
</x-app-layout>