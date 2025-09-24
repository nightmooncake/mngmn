<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs"></script>
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
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen transition-all duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                        <i class="fas fa-tags text-indigo-600 dark:text-indigo-400"></i>
                        Daftar Kategori
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Kelola kategori produk Anda</p>
                </div>
                <a href="{{ route('categories.create') }}"
                   class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-all shadow-md text-center">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah kategori
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-800 dark:text-green-300 p-5 rounded-xl shadow-sm fade-in flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-3"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
                @forelse($categories as $category)
                    <div class="p-5 sm:p-6 border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center flex-shrink-0 text-lg">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $category->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        ID: <span class="font-mono">{{ $category->id }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex space-x-3">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-900/60 rounded-lg text-sm font-medium transition-all duration-200">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <div x-data="{ openModal: false }">
                                    <button @click="openModal = true"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-900/60 rounded-lg text-sm font-medium transition-all duration-200">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>

                                    <div x-show="openModal"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 backdrop-blur-sm"
                                         @click.away="openModal = false">
                                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full p-6 border border-gray-200 dark:border-gray-700">
                                            <h3 class="text-lg font-bold text-gray-800 dark:text-white text-center mb-4">
                                                Konfirmasi Hapus
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-300 text-center mb-6">
                                                Apakah Anda yakin ingin menghapus kategori ini?
                                            </p>
                                            <div class="flex justify-center gap-4">
                                                <button @click="openModal = false"
                                                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors duration-200">
                                                    Batal
                                                </button>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors duration-200">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 px-6">
                        <div class="text-gray-300 dark:text-gray-600 mb-6">
                            <i class="fas fa-folder-open text-8xl opacity-50"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-3">Belum Ada Kategori</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto leading-relaxed">
                            Anda belum menambahkan kategori. Mulailah dengan menambahkan kategori pertama Anda.
                        </p>
                        <a href="{{ route('categories.create') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <i class="fas fa-plus-circle"></i> Tambah Kategori
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
