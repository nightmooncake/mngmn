<x-app-layout>
    @section('title', 'Log Aktivitas')

    <div class="py-12 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white flex items-center gap-3">
                    <i class="fas fa-history text-indigo-500"></i>
                    Log Aktivitas Sistem
                </h2>
                <a href="{{ route('activities.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full shadow transition duration-200 flex items-center gap-2">
                    <i class="fas fa-file-export"></i> Export CSV
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-4 md:p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="relative w-full md:w-1/2">
                        <input id="searchInput" type="text" placeholder="Cari log..."
                               class="pl-12 pr-4 py-3 w-full rounded-full border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               autocomplete="off">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-300"></i>
                    </div>

                    <div class="w-full md:w-1/4">
                        <select id="actionFilter" class="py-3 px-4 w-full rounded-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="">Semua Aksi</option>
                            <option value="created">Created</option>
                            <option value="updated">Updated</option>
                            <option value="deleted">Deleted</option>
                            <option value="logged in">Login</option>
                            <option value="logged out">Logout</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider rounded-tl-xl">
                                    User
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Detail
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider rounded-tr-xl">
                                    Waktu
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="activityTableBody">
                            @forelse ($activities as $activity)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($activity->causer)
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $activity->causer->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $activity->causer->role ?? 'User' }}
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Sistem</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                            @if(str_contains($activity->description, 'created') || $activity->description == 'created') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif(str_contains($activity->description, 'updated') || $activity->description == 'updated') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @elseif(str_contains($activity->description, 'deleted') || $activity->description == 'deleted') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @elseif(str_contains($activity->description, 'logged in')) bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200
                                            @elseif(str_contains($activity->description, 'logged out')) bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @endif">
                                            @if(str_contains($activity->description, 'created') || $activity->description == 'created')
                                                <i class="fas fa-plus-circle mr-1"></i> Created
                                            @elseif(str_contains($activity->description, 'updated') || $activity->description == 'updated')
                                                <i class="fas fa-pencil-alt mr-1"></i> Updated
                                            @elseif(str_contains($activity->description, 'deleted') || $activity->description == 'deleted')
                                                <i class="fas fa-trash-alt mr-1"></i> Deleted
                                            @elseif(str_contains($activity->description, 'logged in'))
                                                <i class="fas fa-sign-in-alt mr-1"></i> Login
                                            @elseif(str_contains($activity->description, 'logged out'))
                                                <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                            @else
                                                <i class="fas fa-info-circle mr-1"></i> {{ ucfirst($activity->description) }}
                                            @endif
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        @if($activity->subject_type)
                                            <div class="font-medium text-gray-800 dark:text-gray-200">
                                                {{ class_basename($activity->subject_type) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                ID #{{ $activity->subject_id }}
                                            </div>
                                        @endif

                                        @php
                                            $subjectName = null;
                                            if ($activity->subject_type === \App\Models\PurchaseOrder::class) {
                                                if ($activity->subject && $activity->subject->supplier) {
                                                    $subjectName = $activity->subject->supplier->name;
                                                } else {
                                                    $subjectName = data_get($activity->properties, 'supplier_name') ??
                                                                   data_get($activity->properties, 'attributes.supplier_name') ??
                                                                   data_get($activity->properties, 'old.supplier_name') ??
                                                                   'Supplier tidak diketahui';
                                                }
                                            } elseif ($activity->subject_type === \App\Models\StockMovement::class) {
                                                if ($activity->subject && $activity->subject->product) {
                                                    $subjectName = $activity->subject->product->name;
                                                } else {
                                                    $subjectName = data_get($activity->properties, 'product_name') ??
                                                                   data_get($activity->properties, 'attributes.product_name') ??
                                                                   data_get($activity->properties, 'old.product_name') ??
                                                                   'Produk tidak diketahui';
                                                }
                                            } elseif ($activity->subject_type === \App\Models\User::class) {
                                                $subjectName = data_get($activity->properties, 'name') ??
                                                               data_get($activity->properties, 'attributes.name') ??
                                                               data_get($activity->properties, 'old.name') ??
                                                               'User tidak diketahui';
                                            } else {
                                                if ($activity->subject) {
                                                    $subjectName = $activity->subject->name ??
                                                                   $activity->subject->customer_name ??
                                                                   $activity->subject->email ??
                                                                   null;
                                                } else {
                                                    $subjectName = data_get($activity->properties, 'name') ??
                                                                   data_get($activity->properties, 'attributes.name') ??
                                                                   data_get($activity->properties, 'old.name') ??
                                                                   data_get($activity->changes, 'attributes.name');
                                                }
                                                $subjectName = $subjectName ?: 'Entitas tidak diketahui';
                                            }
                                        @endphp

                                        @if($subjectName)
                                            <div class="text-sm text-gray-600 dark:text-gray-300 truncate max-w-sm mt-1" title="{{ $subjectName }}">
                                                <span class="font-normal text-xs text-gray-400 dark:text-gray-500 mr-1">Nama:</span>{{ $subjectName }}
                                            </div>
                                        @endif

                                        @if($activity->description === 'updated' && $activity->properties->has('attributes') && $activity->properties->has('old'))
                                            <div class="mt-3 pt-2 border-t border-gray-200 dark:border-gray-700">
                                                <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 mb-1">Perubahan:</p>
                                                @php
                                                    $old = $activity->properties['old'] ?? [];
                                                    $attributes = $activity->properties['attributes'] ?? [];
                                                    $changes = [];
                                                    foreach ($attributes as $key => $value) {
                                                        $oldValue = $old[$key] ?? '—';
                                                        if ((string) $oldValue !== (string) $value) {
                                                            $changes[$key] = [
                                                                'old' => $oldValue,
                                                                'new' => $value
                                                            ];
                                                        }
                                                    }
                                                @endphp

                                                @forelse($changes as $attribute => $change)
                                                    <div class="text-xs text-gray-700 dark:text-gray-300 mb-1">
                                                        <span class="font-medium capitalize">{{ str_replace('_', ' ', $attribute) }}:</span>
                                                        <span class="line-through text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-900/30 px-1 rounded">{{ $change['old'] }}</span>
                                                        <i class="fas fa-arrow-right text-xs mx-1 text-gray-400"></i>
                                                        <span class="text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-1 rounded font-medium">{{ $change['new'] }}</span>
                                                    </div>
                                                @empty
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 italic">Tidak ada perubahan terdeteksi.</div>
                                                @endforelse
                                            </div>
                                        @endif

                                        @if(in_array($activity->description, ['logged in', 'logged out']))
                                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-user-circle mr-1"></i> {{ $activity->description === 'logged in' ? 'Berhasil masuk ke sistem' : 'Keluar dari sistem' }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <div class="text-sm">{{ $activity->created_at->translatedFormat('d F Y') }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $activity->created_at->translatedFormat('H:i:s') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-box-open text-4xl mb-3 opacity-50"></i>
                                        <p class="text-lg font-medium">Tidak ada aktivitas tercatat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                {{ $activities->links() }}
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const actionFilter = document.getElementById('actionFilter');
            const tableBody = document.getElementById('activityTableBody');
            const rows = tableBody ? Array.from(tableBody.querySelectorAll('tr')) : [];
            const emptyMessage = tableBody ? tableBody.querySelector('tr[colspan="4"]') : null;

            function filterTable() {
                const searchText = searchInput.value.toLowerCase().trim();
                const actionValue = actionFilter.value.toLowerCase();
                let hasVisibleRows = false;

                rows.forEach(row => {
                    if (row.hasAttribute('colspan')) return;

                    const cells = row.querySelectorAll('td');
                    if (cells.length < 4) return;

                    const userText = cells[0]?.innerText.toLowerCase() || '';
                    const actionText = cells[1]?.innerText.toLowerCase() || '';
                    const targetText = cells[2]?.innerText.toLowerCase() || '';

                    const matchesSearch = !searchText ||
                        userText.includes(searchText) ||
                        actionText.includes(searchText) ||
                        targetText.includes(searchText);

                    const matchesAction = !actionValue || 
                        (actionValue === 'logged in' && actionText.includes('login')) ||
                        (actionValue === 'logged out' && actionText.includes('logout')) ||
                        actionText.includes(actionValue);

                    const isVisible = matchesSearch && matchesAction;
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) {
                        hasVisibleRows = true;
                    }
                });

                if (emptyMessage) {
                    emptyMessage.style.display = hasVisibleRows ? 'none' : 'table-row';
                }
            }

            searchInput?.addEventListener('input', filterTable);
            actionFilter?.addEventListener('change', filterTable);
        });
    </script>
</x-app-layout>
