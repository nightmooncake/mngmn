<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $product->name }}</h2>
                    @if($product->image)
                        <div class="mb-6">
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-64 object-cover rounded-lg shadow-md">
                        </div>
                    @else
                        <div class="mb-6 bg-gray-100 w-full h-64 flex items-center justify-center rounded-lg">
                            <span class="text-gray-500 text-lg">No Image Available</span>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <p><strong>Category:</strong> <span class="text-gray-700">{{ $product->category->name ?? 'N/A' }}</span></p>
                        <p><strong>Supplier:</strong> <span class="text-gray-700">{{ $product->supplier->name ?? 'N/A' }}</span></p>
                        <p><strong>Price:</strong> <span class="text-gray-700">Rp {{ number_format($product->price ?? 0, 2) }}</span></p>
                        <p><strong>Stock:</strong> <span class="text-gray-700">{{ $product->stock ?? 'N/A' }}</span></p>
                        <p class="md:col-span-2">
                            <strong>Description:</strong>
                            <span class="text-gray-700 block mt-1">{{ $product->description ?? 'No description provided.' }}</span>
                        </p>
                    </div>
                    <div class="mt-8">
                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md transition">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>