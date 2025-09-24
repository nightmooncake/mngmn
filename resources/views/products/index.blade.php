<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl p-6 lg:p-10">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 pb-6 border-b border-gray-200 gap-4">
                    <h1 class="text-3xl sm:text-4xl font-semibold text-gray-800">Daftar Produk</h1>
                    <div class="flex flex-col lg:flex-row gap-2">
                        <a href="{{ route('products.create') }}"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-all shadow-md text-center">
                            <i class="fas fa-plus mr-2"></i>Tambah Produk Baru
                        </a>

                        <a href="{{ route('products.exportExcel') }}"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-all shadow-md text-center">
                            <i class="fas fa-file-excel mr-2"></i>Export Excel
                        </a>
                        <button onclick="openImportModal()"
                                class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-all shadow-md text-center">
                            <i class="fas fa-file-import mr-2"></i>Import Excel
                        </button>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl mb-8 shadow-inner grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-gray-700 mb-1">Cari Produk</label>
                        <input type="text"
                               id="search"
                               placeholder="Cari berdasarkan nama..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                               onkeyup="filterProducts()">
                    </div>

                    <div>
                        <label for="categoryFilter" class="block text-sm font-semibold text-gray-700 mb-1">Filter Kategori</label>
                        <select id="categoryFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" onchange="filterProducts()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ strtolower($category->name) }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden
                                    transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 product-card"
                             data-name="{{ strtolower($product->name) }}"
                             data-category="{{ strtolower($product->category->name ?? '') }}">
                            <div class="relative h-48 w-full cursor-pointer group"
                                 onclick="openImageModal('{{ $product->image && \Storage::disk('public')->exists($product->image) ? asset('storage/' . $product->image) : '' }}', '{{ $product->name }}')">
                                @if($product->image && \Storage::disk('public')->exists($product->image))
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 text-sm">
                                        <span>Gambar Tidak Tersedia</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-50"></div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <i class="fas fa-search-plus text-white text-3xl"></i>
                                </div>
                            </div>

                            <div class="p-5">
                                <h3 class="text-xl font-bold text-gray-900 truncate mb-1">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-2 h-10 overflow-hidden">
                                    {{ Str::limit($product->description, 60, '...') }}
                                </p>

                                <div class="w-full px-4 py-2 rounded-lg text-center font-bold text-lg text-gray-800 bg-gray-100 mb-3">
                                    {{ $product->price !== null ? 'Rp ' . number_format($product->price, 0, ',', '.') : 'Harga tidak tersedia' }}
                                </div>

                                <div class="flex flex-col space-y-1 text-sm text-gray-600 mb-4">
                                    <p class="flex items-center">
                                        <i class="fas fa-tag w-4 mr-2 text-blue-500"></i>
                                        {{ $product->category->name ?? 'N/A' }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-truck-moving w-4 mr-2 text-blue-500"></i>
                                        {{ $product->supplier->name ?? 'N/A' }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-box-open w-4 mr-2 text-blue-500"></i>
                                        Stok: {{ $product->stock ?? 0 }}
                                    </p>
                                </div>

                                <div class="flex justify-between items-center mt-4 border-t pt-4">
                                    <button
                                        onclick="openDetailModal(
                                                '{{ addslashes($product->name) }}',
                                                '{{ addslashes($product->category->name ?? 'N/A') }}',
                                                '{{ addslashes($product->supplier->name ?? 'N/A') }}',
                                                '{{ $product->price !== null ? 'Rp ' . number_format($product->price, 0, ',', '.') : 'N/A' }}',
                                                '{{ $product->stock ?? 0 }}',
                                                '{{ $product->image && \Storage::disk('public')->exists($product->image) ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}',
                                                '{{ addslashes($product->description ?? 'Deskripsi tidak tersedia.') }}'
                                            )"
                                        class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                        <i class="fas fa-eye text-lg"></i>
                                    </button>

                                    <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-800 transition-colors duration-200">
                                        <i class="fas fa-edit text-lg"></i>
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                            <i class="fas fa-trash-alt text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>

                <div id="noResults" class="text-center py-10 text-gray-500 hidden">
                    <p class="text-xl font-semibold">Tidak ada produk yang cocok dengan pencarian Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4" onclick="closeDetailModal(event)">
        <div class="bg-white rounded-2xl shadow-xl max-w-xl w-full max-h-screen overflow-y-auto" onclick="event.stopPropagation()">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200">
                    <h2 id="modalTitle" class="text-2xl font-extrabold text-gray-800">Detail Produk</h2>
                    <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-800 text-3xl leading-none font-light">&times;</button>
                </div>
                <div id="modalBody" class="space-y-4"></div>
            </div>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden flex items-center justify-center z-50 p-4" onclick="closeImageModal()">
        <img id="modalImage" class="max-w-full max-h-full object-contain rounded-lg shadow-lg transform transition-all duration-300" alt="Gambar Produk">
    </div>

    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
            <h3 class="text-xl font-bold mb-4 text-center">Konfirmasi Hapus</h3>
            <p class="text-gray-700 mb-6 text-center">Apakah Anda yakin ingin menghapus produk ini?</p>
            <div class="flex justify-center space-x-4">
                <button onclick="closeConfirmModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                <button onclick="confirmDeleteAction()" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Hapus</button>
            </div>
        </div>
    </div>
    
    <div id="importModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200">
                <h2 class="text-2xl font-extrabold text-gray-800">Import Produk dari Excel</h2>
                <button onclick="closeImportModal()" class="text-gray-500 hover:text-gray-800 text-3xl leading-none font-light">&times;</button>
            </div>
            <form id="importForm" action="{{ route('products.importExcel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <input type="file" name="excel_file" id="excel_file" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeImportModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" id="importButton" class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-all shadow-md text-center">
                        <span id="buttonText">Import</span>
                    </button> 
                </div>
            </form>
        </div>
    </div>

    <script>
        let formToDelete = null;

        function filterProducts() {
            const searchText = document.getElementById('search').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const category = card.getAttribute('data-category');

                const matchesSearch = name.includes(searchText);
                const matchesCategory = categoryFilter === '' || category.includes(categoryFilter);

                if (matchesSearch && matchesCategory) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResults');
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }
        function openDetailModal(name, category, supplier, price, stock, imageUrl, description) {
            const modalBody = document.getElementById('modalBody');
            const modalTitle = document.getElementById('modalTitle');
            modalTitle.textContent = name;
            modalBody.innerHTML = `
                <div class="text-center">
                    <img src="${imageUrl}" alt="${name}" class="w-full max-h-72 object-contain rounded-lg mx-auto mb-4">
                </div>
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="font-semibold text-lg text-blue-600">Harga: ${price}</p>
                    <div class="flex items-center">
                        <i class="fas fa-tag text-blue-500 mr-2"></i>
                        <span>Kategori: <span class="font-medium">${category}</span></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-truck-moving text-blue-500 mr-2"></i>
                        <span>Supplier: <span class="font-medium">${supplier}</span></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-box-open text-blue-500 mr-2"></i>
                        <span>Stok: <span class="font-medium">${stock}</span></span>
                    </div>
                    <p class="mt-4 font-semibold text-gray-700">Deskripsi:</p>
                    <p class="bg-gray-100 p-4 rounded-md whitespace-pre-wrap text-sm">${description}</p>
                </div>
            `;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal(event) {
            if (event && event.target.id === 'detailModal') {
                document.getElementById('detailModal').classList.add('hidden');
            } else if (!event) {
                document.getElementById('detailModal').classList.add('hidden');
            }
        }

        function openImageModal(imageUrl, productName) {
            if (!imageUrl) {
                showInfoModal('Gambar tidak tersedia.', 'Informasi');
                return;
            }
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        function confirmDelete(event) {
            event.preventDefault();
            formToDelete = event.target;
            document.getElementById('confirmModal').classList.remove('hidden');
            return false;
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
            formToDelete = null;
        }

        function confirmDeleteAction() {
            if (formToDelete) {
                formToDelete.submit();
            }
            closeConfirmModal();
        }
        
        function showInfoModal(message, title = 'Info') {
            const modalHtml = `
                <div id="infoModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
                        <h3 class="text-xl font-bold mb-4 text-center">${title}</h3>
                        <p class="text-gray-700 mb-6 text-center">${message}</p>
                        <div class="flex justify-center">
                            <button onclick="closeInfoModal()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">OK</button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        function closeInfoModal() {
            const modal = document.getElementById('infoModal');
            if (modal) {
                modal.remove();
            }
        }

        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
        }
        
        document.getElementById('importForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const importButton = document.getElementById('importButton');
            const buttonText = document.getElementById('buttonText');

            importButton.disabled = true;
            buttonText.textContent = 'Mengimpor...';
            
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(result => {
                closeImportModal();
                if (result.status === 200) {
                    showInfoModal('Import berhasil! Halaman akan dimuat ulang untuk menampilkan produk baru.', 'Berhasil');
                    setTimeout(() => location.reload(), 2000); 
                } else {
                    showInfoModal(result.body.message || 'Terjadi kesalahan saat mengimpor.', 'Gagal');
                }
            })
            .catch(error => {
                closeImportModal();
                showInfoModal('Terjadi kesalahan jaringan atau server.', 'Gagal');
                console.error('Error:', error);
            })
            .finally(() => {
                importButton.disabled = false;
                buttonText.textContent = 'Import';
            });
        });
    </script>
</x-app-layout>