<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 pb-4 border-b border-gray-200 gap-4">
                    <h1 class="text-3xl font-normal text-gray-800">Laporan Pergerakan Stok</h1>
                    <a href="{{ route('stockmovements.create') }}" 
                       class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-all shadow-md  text-center">
                        <i class="fas fa-plus mr-2"></i>Tambah Pergerakan
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table class="min-w-full divide-y divide-gray-200" id="stockMovementsTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NOMOR SM</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="stockMovementsBody">
                            @forelse($stockMovements as $movement)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-normal text-gray-900">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700">
                                        SM-{{ str_pad($loop->iteration, 5, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $movement->product->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-normal">
                                        {{ $movement->quantity }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($movement->type == 'in')
                                            <span class="px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-arrow-up mr-1"></i>Masuk
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-red-100 text-red-800">
                                                <i class="fas fa-arrow-down mr-1"></i>Keluar
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $movement->user->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $movement->created_at->format('d F Y, H:i') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-normal">
                                        <a href="{{ route('stockmovements.show', $movement->id) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                            <i class="fas fa-info-circle mr-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Tidak ada pergerakan stok yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function fetchStockMovements() {
                fetch('{{ route("stockmovements.index") }}')
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById('stockMovementsBody');
                        tbody.innerHTML = '';

                        if (data.length === 0) {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td colspan="8" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    Tidak ada pergerakan stok yang ditemukan.
                                </td>
                            `;
                            tbody.appendChild(row);
                            return;
                        }

                        data.forEach((movement, index) => {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50 transition-colors';
                            row.innerHTML = `
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-normal text-gray-900">${index + 1}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700">SM-${String(index + 1).padStart(5, '0')}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${movement.product?.name || 'N/A'}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-normal">${movement.quantity}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    ${movement.type === 'in'
                                        ? '<span class="px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 text-green-800"><i class="fas fa-arrow-up mr-1"></i>Masuk</span>'
                                        : '<span class="px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-red-100 text-red-800"><i class="fas fa-arrow-down mr-1"></i>Keluar</span>'
                                    }
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${movement.user?.name || 'N/A'}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${new Date(movement.created_at).toLocaleString('id-ID', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-normal">
                                    <a href="/stockmovements/${movement.id}" class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                        <i class="fas fa-info-circle mr-1"></i>Detail
                                    </a>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching stock movements:', error);
                    });
            }

            fetchStockMovements();
            setInterval(fetchStockMovements, 5000);
        });
    </script>
</x-app-layout>