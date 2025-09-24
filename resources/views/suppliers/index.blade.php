<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
        .animate-slide-in-right {
            animation: slideInRight 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
        .animate-slide-out-right {
            animation: slideOutRight 0.5s cubic-bezier(0.55, 0.085, 0.68, 0.53) forwards;
        }
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }
    </style>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen transition-all duration-300 font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                        <i class="fas fa-truck-ramp-box text-indigo-600 dark:text-indigo-400"></i>
                        Daftar Supplier
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Kelola mitra pemasok Anda dengan mudah.</p>
                </div>
                <a href="{{ route('suppliers.create') }}"
                   class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-all shadow-md text-center hover-scale">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Supplier Baru
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
                @if($suppliers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                <tr>
                                    <th class="py-4 px-6 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider rounded-tl-lg">Nama Supplier</th>
                                    <th class="py-4 px-6 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Kontak Person</th>
                                    <th class="py-4 px-6 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Email</th>
                                    <th class="py-4 px-6 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Telepon</th>
                                    <th class="py-4 px-6 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Alamat</th>
                                    <th class="py-4 px-6 text-center text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($suppliers as $supplier)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 ease-in-out transform hover:scale-[1.005] fade-in">
                                        <td class="py-5 px-6 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $supplier->name }}</td>
                                        <td class="py-5 px-6 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $supplier->contact_person ?? '–' }}</td>
                                        <td class="py-5 px-6 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $supplier->email ?? '–' }}</td>
                                        <td class="py-5 px-6 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $supplier->phone ?? '–' }}</td>
                                        <td class="py-5 px-6 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate" title="{{ $supplier->address }}">{{ $supplier->address ?? '–' }}</td>
                                        <td class="py-5 px-6 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('suppliers.edit', $supplier) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 dark:hover:bg-blue-900/60 rounded-lg text-sm font-medium transition-all duration-200">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-btn inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:text-red-300 dark:hover:bg-red-900/60 rounded-lg text-sm font-medium transition-all duration-200">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        {{ $suppliers->links() }}
                    </div>
                @else
                    <div class="text-center py-16 px-6">
                        <div class="text-gray-300 dark:text-gray-600 mb-6">
                            <i class="fas fa-building text-8xl opacity-50"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-3">Belum Ada Supplier</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto leading-relaxed">
                            Anda belum menambahkan supplier. Mulailah dengan menambahkan mitra pemasok pertama Anda.
                        </p>
                        <a href="{{ route('suppliers.create') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <i class="fas fa-plus-circle"></i> Tambah Supplier
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                Hapus Supplier
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Apakah Anda yakin ingin menghapus supplier ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmDeleteBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                    <button type="button" id="cancelDeleteBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2 w-full max-w-xs pointer-events-none"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showNotification(message, type) {
                const container = document.getElementById('notification-container');
                const notification = document.createElement('div');
                let iconClass = '';
                let bgColorClass = '';
                let textColorClass = 'text-white';
                switch (type) {
                    case 'success':
                        iconClass = 'fas fa-check-circle';
                        bgColorClass = 'bg-green-500';
                        break;
                    case 'error':
                        iconClass = 'fas fa-times-circle';
                        bgColorClass = 'bg-red-500';
                        break;
                    case 'info':
                        iconClass = 'fas fa-info-circle';
                        bgColorClass = 'bg-blue-500';
                        break;
                    default:
                        iconClass = 'fas fa-info-circle';
                        bgColorClass = 'bg-gray-500';
                }
                notification.className = `p-4 rounded-lg shadow-xl flex items-center transition-all duration-500 transform pointer-events-auto ${bgColorClass} ${textColorClass} animate-slide-in-right`;
                notification.innerHTML = `
                    <div class="flex-shrink-0">
                        <i class="${iconClass} text-xl"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-semibold">${message}</p>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 p-1.5 inline-flex h-8 w-8 rounded-lg ${bgColorClass} hover:bg-opacity-80 transition-colors" aria-label="Close notification">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times text-sm"></i>
                    </button>
                `;
                container.prepend(notification);
                notification.querySelector('button').addEventListener('click', () => {
                    notification.classList.remove('animate-slide-in-right');
                    notification.classList.add('animate-slide-out-right');
                    setTimeout(() => notification.remove(), 500);
                });
                setTimeout(() => {
                    notification.classList.remove('animate-slide-in-right');
                    notification.classList.add('animate-slide-out-right');
                    setTimeout(() => notification.remove(), 500);
                }, 5000);
            }
            @if(session('success'))
                showNotification(@json(session('success')), 'success');
            @elseif(session('error'))
                showNotification(@json(session('error')), 'error');
            @endif
            const modal = document.getElementById('deleteModal');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            const cancelBtn = document.getElementById('cancelDeleteBtn');
            let formToSubmit = null;
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    formToSubmit = this.closest('.delete-form');
                    modal.classList.remove('hidden');
                });
            });
            confirmBtn.addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });
            cancelBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>