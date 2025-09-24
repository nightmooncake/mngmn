<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .sidebar-container {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f3f4f6;
        }
        
        .sidebar-container::-webkit-scrollbar {
            width: 8px;
        }
        
        .sidebar-container::-webkit-scrollbar-track {
            background: #f3f4f6;
        }
        
        .sidebar-container::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 9999px;
            border: 2px solid #ffffff;
        }
        
        .active-link {
            background-color: #e5e7eb;
            color: #3b82f6;
            font-weight: 600;
        }
        
        .active-link .fa-solid {
            color: #3b82f6;
        }
        
        .dark .sidebar-container {
            scrollbar-color: #4b5563 #1f2937;
        }

        .dark .sidebar-container::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .dark .sidebar-container::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border: 2px solid #1f2937;
        }

        .dark .active-link {
            background-color: #374151;
            color: #60a5fa;
        }

        .dark .active-link .fa-solid {
            color: #60a5fa;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <div x-data="{ sidebarOpen: window.innerWidth > 1024 }" class="flex h-screen">
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            class="fixed inset-y-0 left-0 z-50 w-64 transform bg-white dark:bg-gray-800 shadow-xl transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 lg:shadow-none flex flex-col">
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-700">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-box-open text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Inventaris Barang</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto mt-4 px-4 sidebar-container">
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center p-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('dashboard') ? 'active-link' : 'text-gray-700' }}">
                        <i class="fa-solid fa-tachometer-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                        <span>Dashboard</span>
                    </a>
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('users.index') }}" 
                       class="flex items-center p-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('users.index') ? 'active-link' : 'text-gray-700' }}">
                        <i class="fa-solid fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                        <span>Pengguna</span>
                    </a>
                    @endif
                    <a href="{{ route('suppliers.index') }}" 
                       class="flex items-center p-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('suppliers.index') ? 'active-link' : 'text-gray-700' }}">
                        <i class="fa-solid fa-truck w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                        <span>Supplier</span>
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="flex items-center p-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('products.index') ? 'active-link' : 'text-gray-700' }}">
                        <i class="fa-solid fa-box w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                        <span>Produk</span>
                    </a>
                    <a href="{{ route('categories.index') }}" 
                       class="flex items-center p-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('categories.index') ? 'active-link' : 'text-gray-700' }}">
                        <i class="fa-solid fa-tags w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                        <span>Kategori</span>
                    </a>
                    @php
                        $transaksiRoutes = ['purchase_orders.index', 'salesorders.index', 'stockmovements.index'];
                        $isTransaksiActive = in_array(request()->route()->getName(), $transaksiRoutes);
                    @endphp
                    <div x-data="{ open: {{ $isTransaksiActive ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" 
                                class="flex items-center w-full p-3 text-sm font-medium text-left rounded-lg transition-all duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ $isTransaksiActive ? 'active-link' : 'text-gray-700' }}">
                            <i class="fa-solid fa-exchange-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            <span>Transaksi</span>
                            <svg class="ml-auto h-4 w-4 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse.duration.300ms class="space-y-1 pl-8">
                            <a href="{{ route('purchase_orders.index') }}" 
                               class="flex items-center p-2 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('purchase_orders.index') ? 'active-link' : '' }}">
                                <i class="fa-solid fa-shopping-cart w-5 mr-3"></i>
                                <span>Pesanan Pembelian</span>
                            </a>
                            <a href="{{ route('salesorders.index') }}" 
                               class="flex items-center p-2 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('salesorders.index') ? 'active-link' : '' }}">
                                <i class="fa-solid fa-shopping-bag w-5 mr-3"></i>
                                <span>Pesanan Penjualan</span>
                            </a>
                            <a href="{{ route('stockmovements.index') }}" 
                               class="flex items-center p-2 text-sm font-medium rounded-lg transition-colors duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('stockmovements.index') ? 'active-link' : '' }}">
                                <i class="fa-solid fa-warehouse w-5 mr-3"></i>
                                <span>Pergerakan Stok</span>
                            </a>
                        </div>
                    </div>
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('activity-logs.index') }}" 
                       class="flex items-center p-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-gray-100 hover:text-blue-500 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400 {{ request()->routeIs('activity-logs.index') ? 'active-link' : 'text-gray-700' }}">
                        <i class="fa-solid fa-history w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                        <span>Log Aktivitas</span>
                    </a>
                    @endif
                </nav>
            </div>
            @auth
            <div class="p-4 mt-auto border-t border-gray-200 dark:border-gray-700 relative" x-data="{ dropdownOpen: false }" @click.away="dropdownOpen = false">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center w-full justify-between p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <div class="flex items-center space-x-3">
                        <img
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff&size=32' }}"
                            alt="Avatar"
                            class="w-8 h-8 rounded-full object-cover">
                        <div>
                            <div class="text-sm font-semibold text-gray-800 dark:text-gray-200 text-left">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 text-left">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                    </div>
                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': dropdownOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute bottom-full left-0 right-0 mb-2 w-full origin-bottom-right rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-user-circle w-5 mr-3"></i>
                            <span>Profil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30">
                                <i class="fa-solid fa-right-from-bracket w-5 mr-3"></i>
                                <span>Keluar</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        </aside>
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white dark:bg-gray-800 shadow-sm z-40">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    </div>
            </header>
            <main class="flex-1 overflow-x-hidden">
                <div class="container mx-auto">
                    @isset($header)
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                    @endisset
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>