<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-md rounded-lg border border-gray-200">
                @php
                    $isEdit = isset($supplier);
                    $title = $isEdit ? 'Edit Supplier' : 'Tambah Supplier Baru';
                    $action = $isEdit ? route('suppliers.update', $supplier) : route('suppliers.store');
                    $method = $isEdit ? 'PUT' : 'POST';
                @endphp
                <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $title }}</h1>

                <form action="{{ $action }}" method="POST">
                    @csrf
                    @method($method)

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $isEdit ? $supplier->name : '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md
                                       focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                               required>
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contact_person" class="block text-sm font-semibold text-gray-700 mb-2">Kontak Person</label>
                        <input type="text"
                               name="contact_person"
                               id="contact_person"
                               value="{{ old('contact_person', $isEdit ? $supplier->contact_person : '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md
                                       focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        @error('contact_person')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $isEdit ? $supplier->email : '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md
                                       focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Telepon</label>
                        <input type="text"
                               name="phone"
                               id="phone"
                               value="{{ old('phone', $isEdit ? $supplier->phone : '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md
                                       focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        @error('phone')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                        <textarea name="address"
                                  id="address"
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md
                                         focus:ring-indigo-500 focus:border-indigo-500 outline-none">{{ old('address', $isEdit ? $supplier->address : '') }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('suppliers.index') }}"
                           class="px-5 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md font-semibold transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md font-semibold transition-colors duration-200">
                            {{ $isEdit ? 'Update Supplier' : 'Simpan Supplier' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
