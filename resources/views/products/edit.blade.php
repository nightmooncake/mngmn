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

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                
                <div class="bg-white border-b border-gray-200 px-6 py-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-edit mr-3 text-indigo-600"></i>
                            Edit Produk
                        </h2>
                        <a href="{{ route('products.index') }}" 
                           class="text-gray-500 hover:text-gray-800 text-lg transition">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>

                <form id="productForm" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="space-y-6">
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-3">Gambar Produk</label>
                                <input type="file"
                                       name="image"
                                       id="image"
                                       accept="image/*"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                                @if($product->image)
                                    <div class="mt-4 text-center">
                                        <p class="text-xs text-gray-500 mb-2">Gambar Saat Ini:</p>
                                        <img src="{{ Storage::url($product->image) }}" 
                                             alt="Current Product" 
                                             class="w-32 h-32 object-cover rounded-lg mx-auto border border-gray-300">
                                    </div>
                                @else
                                    <div class="mt-4 text-center text-gray-400 text-sm">
                                        <i class="fas fa-image text-3xl mb-2"></i>
                                        <p>Tidak ada gambar yang diunggah</p>
                                    </div>
                                @endif
                                @error('image')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $product->name) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                       required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                                <input type="text"
                                       id="price"
                                       placeholder="Rp 0"
                                       value="{{ old('price', $product->price) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                <input type="hidden" name="price" id="priceHidden" value="{{ old('price', $product->price) }}">
                                @error('price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="5"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categori</label>
                                <select name="category_id" 
                                        id="category_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                    <option value="" disabled>Pilih Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                                <select name="supplier_id" 
                                        id="supplier_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                    <option value="" disabled>Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" 
                                                {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('products.index') }}" 
                           class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium transition">
                            <i class=""></i>Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition flex items-center shadow-md hover:shadow-lg">
                            <i class="fas fa-save mr-2"></i>Perbarui Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const priceInput = document.getElementById('price');
        const priceHiddenInput = document.getElementById('priceHidden');

        const formatRupiah = (value) => {
            if (value === null || isNaN(value)) {
                return '';
            }
            const formattedValue = new Intl.NumberFormat('id-ID').format(value);
            return `Rp ${formattedValue}`;
        };

        const initialPrice = priceHiddenInput.value;
        if (initialPrice) {
            priceInput.value = formatRupiah(parseInt(initialPrice, 10));
        }

        priceInput.addEventListener('input', function(e) {
            let rawValue = this.value.replace(/[^0-9]/g, '');
            let numberValue = parseInt(rawValue, 10);

            if (isNaN(numberValue)) {
                this.value = '';
                priceHiddenInput.value = 0;
            } else {
                this.value = formatRupiah(numberValue);
                priceHiddenInput.value = numberValue;
            }
        });
    </script>
</x-app-layout>
