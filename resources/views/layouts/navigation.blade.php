<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --bs-sidebar-bg: #ffffff;
            --bs-sidebar-text: #212529;
            --bs-sidebar-link-active-bg: #e9ecef;
            --bs-sidebar-link-active-color: #0d6efd;
            --bs-scroll-track-bg: #f8f9fa;
            --bs-scroll-thumb-bg: #adb5bd;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bs-sidebar-bg: #212529;
                --bs-sidebar-text: #f8f9fa;
                --bs-sidebar-link-active-bg: #343a40;
                --bs-sidebar-link-active-color: #0d6efd;
                --bs-scroll-track-bg: #343a40;
                --bs-scroll-thumb-bg: #495057;
            }
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bs-light);
        }
        
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .sidebar-bg {
            background-color: var(--bs-sidebar-bg);
            color: var(--bs-sidebar-text);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .sidebar-container {
            scrollbar-width: thin;
            scrollbar-color: var(--bs-scroll-thumb-bg) var(--bs-scroll-track-bg);
            padding-right: 0.75rem;
        }
        
        .sidebar-container::-webkit-scrollbar {
            width: 8px;
        }
        
        .sidebar-container::-webkit-scrollbar-track {
            background: var(--bs-scroll-track-bg);
        }
        
        .sidebar-container::-webkit-scrollbar-thumb {
            background-color: var(--bs-scroll-thumb-bg);
            border-radius: 9999px;
            border: 2px solid var(--bs-sidebar-bg);
        }
        
        .active-link {
            background-color: var(--bs-sidebar-link-active-bg);
            color: var(--bs-sidebar-link-active-color) !important;
            font-weight: 600;
        }
        
        .active-link .fa-solid {
            color: var(--bs-sidebar-link-active-color);
        }
        
        .transition-transform {
            transition-property: transform;
            transition-duration: 0.2s;
            transition-timing-function: ease-in-out;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>

<body class="bg-light" data-bs-theme="light">
    <div x-data="{ sidebarOpen: window.innerWidth > 768 }" class="d-flex vh-100">
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
               class="sidebar-bg position-fixed top-0 start-0 bottom-0 z-3 w-72 shadow-lg d-md-flex flex-column"
               style="max-width: 288px;">
            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                    <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                        <i class="fas fa-box-open fs-5"></i>
                    </div>
                    <span class="ms-3 fs-5 fw-bold text-dark">Inventaris Barang</span>
                </a>
                <button @click="sidebarOpen = false" class="d-md-none btn btn-link text-secondary p-1">
                    <i class="fas fa-times fs-4"></i>
                </button>
            </div>
            
            <div class="flex-grow-1 overflow-y-auto mt-3 sidebar-container">
                <nav class="nav flex-column px-3">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link d-flex align-items-center py-3 px-3 rounded-3 mb-2 {{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-tachometer-alt me-3 text-secondary"></i>
                        <span>Dashboard</span>
                    </a>
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('users.index') }}" 
                       class="nav-link d-flex align-items-center py-3 px-3 rounded-3 mb-2 {{ request()->routeIs('users.index') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-users me-3 text-secondary"></i>
                        <span>Pengguna</span>
                    </a>
                    @endif
                    <a href="{{ route('suppliers.index') }}" 
                       class="nav-link d-flex align-items-center py-3 px-3 rounded-3 mb-2 {{ request()->routeIs('suppliers.index') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-truck me-3 text-secondary"></i>
                        <span>Supplier</span>
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="nav-link d-flex align-items-center py-3 px-3 rounded-3 mb-2 {{ request()->routeIs('products.index') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-box me-3 text-secondary"></i>
                        <span>Produk</span>
                    </a>
                    <a href="{{ route('categories.index') }}" 
                       class="nav-link d-flex align-items-center py-3 px-3 rounded-3 mb-2 {{ request()->routeIs('categories.index') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-tags me-3 text-secondary"></i>
                        <span>Kategori</span>
                    </a>
                    <div x-data="{ open: false }" class="mb-2">
                        <button @click="open = !open" 
                                :class="{'active-link': ['purchase_orders.index', 'salesorders.index', 'stockmovements.index'].some(route => request()->routeIs(route))}"
                                class="nav-link d-flex align-items-center justify-content-between py-3 px-3 rounded-3 w-100 text-start">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-exchange-alt me-3 text-secondary"></i>
                                <span>Transaksi</span>
                            </div>
                            <i class="fas fa-chevron-down ms-2 transition-transform duration-200" 
                               :class="{'rotate-180': open}"></i>
                        </button>
                        <div x-show="open" x-collapse.duration.300ms class="ps-4 mt-1">
                            <a href="{{ route('purchase_orders.index') }}" 
                               class="nav-link d-flex align-items-center py-2 px-3 rounded-2 {{ request()->routeIs('purchase_orders.index') ? 'active-link' : '' }}">
                                <i class="fa-solid fa-shopping-cart me-3"></i>
                                <span>Pesanan Pembelian</span>
                            </a>
                            <a href="{{ route('salesorders.index') }}" 
                               class="nav-link d-flex align-items-center py-2 px-3 rounded-2 {{ request()->routeIs('salesorders.index') ? 'active-link' : '' }}">
                                <i class="fa-solid fa-shopping-bag me-3"></i>
                                <span>Pesanan Penjualan</span>
                            </a>
                            <a href="{{ route('stockmovements.index') }}" 
                               class="nav-link d-flex align-items-center py-2 px-3 rounded-2 {{ request()->routeIs('stockmovements.index') ? 'active-link' : '' }}">
                                <i class="fa-solid fa-warehouse me-3"></i>
                                <span>Pergerakan Stok</span>
                            </a>
                        </div>
                    </div>
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('activity-logs.index') }}" 
                       class="nav-link d-flex align-items-center py-3 px-3 rounded-3 mb-2 {{ request()->routeIs('activity-logs.index') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-history me-3 text-secondary"></i>
                        <span>Log Aktivitas</span>
                    </a>
                    @endif
                </nav>
            </div>

            <div class="p-3 mt-auto border-top">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0d6efd&color=fff&size=32' }}"
                             alt="Avatar" class="rounded-circle me-3" style="width: 32px; height: 32px; object-fit: cover;">
                        <div>
                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                            <div class="text-muted small">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             @click="sidebarOpen = false" 
             class="position-fixed top-0 start-0 end-0 bottom-0 bg-dark bg-opacity-50 z-2 d-md-none"></div>

        <div class="flex-grow-1 d-flex flex-column overflow-hidden">
            <header class="bg-white shadow-sm z-2">
                <div class="container-fluid px-4 py-3 d-flex align-items-center justify-content-between">
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="btn btn-link text-secondary d-md-none p-1">
                        <i class="fas fa-bars fs-4"></i>
                    </button>
                    <div class="d-none d-md-block"></div>
                    @auth
                    <div class="dropdown">
                        <button class="btn btn-link text-decoration-none dropdown-toggle p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0d6efd&color=fff&size=32' }}"
                                 alt="Avatar" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-circle me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endauth
                </div>
            </header>

            <main class="flex-grow-1 overflow-auto bg-light p-4">
                <div class="container-fluid">
                    @isset($header)
                    <div class="mb-4">
                        {{ $header }}
                    </div>
                    @endisset
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>