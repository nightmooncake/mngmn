<x-app-layout>
        <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    @if (session('status'))
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-md">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Foto Profil</h3>
                <div class="flex items-center space-x-6">
                    <div class="relative w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200 shadow-sm">
                        <img 
                            id="profile-avatar" 
                            src="{{ Auth::user()->avatar 
                                ? asset('storage/' . Auth::user()->avatar) 
                                : asset('default-avatar.png') }}" 
                            alt="Foto Profil"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div class="flex-1">
                        <form id="avatar-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="block">
                                <span class="sr-only">Ganti foto profil</span>
                                <input 
                                    type="file" 
                                    name="avatar" 
                                    accept="image/*" 
                                    onchange="this.form.submit()"
                                    class="block w-full text-sm text-gray-500
                                           file:mr-4 file:py-2 file:px-4
                                           file:rounded-md file:border-0
                                           file:text-sm file:font-semibold
                                           file:bg-blue-50 file:text-blue-700
                                           hover:file:bg-blue-100"
                                />
                            </label>
                        </form>
                        <button 
                            type="button" 
                            onclick="openDeleteAvatarModal()" 
                            class="mt-2 text-sm text-red-600 hover:text-red-800 hover:underline transition-colors"
                        >
                            Hapus Foto Profil
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    
    <div id="deleteAvatarModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
            <h3 class="text-xl font-bold mb-4 text-center">Konfirmasi Hapus</h3>
            <p class="text-gray-700 mb-6 text-center">Apakah Anda yakin ingin menghapus foto profil?</p>
            <div class="flex justify-center space-x-4">
                <button onclick="closeDeleteAvatarModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                <button onclick="executeAvatarDelete()" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Hapus</button>
            </div>
        </div>
    </div>
    
    <div id="messageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
            <h3 id="messageTitle" class="text-xl font-bold mb-4 text-center"></h3>
            <p id="messageText" class="text-gray-700 mb-6 text-center"></p>
            <div class="flex justify-center">
                <button onclick="closeMessageModal()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">OK</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.querySelector('input[name="avatar"]');
            if (input) {
                input.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            document.getElementById('profile-avatar').src = event.target.result;
                        };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }
        });

        function openDeleteAvatarModal() {
            document.getElementById('deleteAvatarModal').classList.remove('hidden');
        }

        function closeDeleteAvatarModal() {
            document.getElementById('deleteAvatarModal').classList.add('hidden');
        }

        function openMessageModal(title, text) {
            document.getElementById('messageTitle').textContent = title;
            document.getElementById('messageText').textContent = text;
            document.getElementById('messageModal').classList.remove('hidden');
        }
        
        function closeMessageModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }

        function executeAvatarDelete() {
            closeDeleteAvatarModal();
            fetch('{{ route('profile.avatar.delete') }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '{{ route('profile.edit') }}';
                } else {
                    openMessageModal('Error', 'Gagal menghapus foto profil.');
                }
            })
            .catch(() => {
                openMessageModal('Error', 'Terjadi kesalahan saat berkomunikasi dengan server.');
            });
        }
    </script>
</x-app-layout>
