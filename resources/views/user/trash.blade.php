@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">User Dihapus (Trash)</h2>
        <a href="{{ route('users.index') }}" class="btn btn-primary">Kembali</a>
    </div>
    @if($trashedUsers->isEmpty())
        <div class="alert alert-info">Tidak ada user yang dihapus.</div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($trashedUsers as $user)
                <div class="bg-white rounded shadow p-4 flex flex-col gap-2">
                    <div>
                        <strong>{{ $user->name }}</strong><br>
                        <span class="text-sm text-gray-500">{{ $user->email }}</span>
                    </div>
                    <div class="flex gap-2 mt-2">
                        <form action="{{ route('users.restore', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Restore</button>
                        </form>
                        <form action="{{ route('users.force-delete', $user->id) }}" method="POST" onsubmit="return confirm('Hapus permanen user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
