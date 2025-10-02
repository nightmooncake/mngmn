<x-app-layout>
    <div class="min-h-screen">
        <div class="p-6 text-gray-900 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-lg font-semibold mb-4">Edit User</h2>

                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="name" value="{{ $user->name }}" required class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" required class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:ring-blue-300 focus:border-blue-400">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User </option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password Baru <span class="text-xs text-gray-400">(Opsional)</span></label>
                            <input type="password" name="password" class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:ring-blue-300 focus:border-blue-400" placeholder="Biarkan kosong jika tidak ingin mengubah">
                        </div>
                    </div>

                    <button type="submit" class="mt-6 px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>