<!-- resources/views/stockmovements/show.blade.php -->

<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">Detail Pergerakan Stok</h1>

                    <div class="space-y-4">
                        <p><strong>Nomor SM:</strong> SM-{{ str_pad($stockMovement->id, 5, '0', STR_PAD_LEFT) }}</p>
                        <p><strong>Produk:</strong> {{ $stockMovement->product->name }}</p>
                        <p><strong>Tipe:</strong>
                            @if($stockMovement->type == 'in')
                                <span class="text-green-600 font-medium">Masuk (In)</span>
                            @else
                                <span class="text-red-600 font-medium">Keluar (Out)</span>
                            @endif
                        </p>
                        <p><strong>Kuantitas:</strong> {{ $stockMovement->quantity }}</p>
                        <p><strong>Stok Saat Ini:</strong> {{ $stockMovement->product->stock }}</p>
                        <p><strong>Pengguna:</strong> {{ $stockMovement->user->name }}</p>
                        <p><strong>Tanggal:</strong> {{ $stockMovement->created_at->format('d F Y, H:i') }}</p>
                        <p><strong>Deskripsi:</strong> {{ $stockMovement->description ?? '-' }}</p>
                    </div>

                    <div class="mt-6 flex space-x-2">
                        <a href="{{ route('stockmovements.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
                        <a href="{{ route('stockmovements.edit', $stockMovement->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>