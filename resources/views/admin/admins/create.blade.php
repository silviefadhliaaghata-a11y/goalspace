@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Admin</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admins.store', $current_team) }}" method="POST" class="space-y-4">
        @csrf

        <input type="text" name="name" placeholder="Nama"
            class="w-full border rounded px-3 py-2">

        <input type="email" name="email" placeholder="Email"
            class="w-full border rounded px-3 py-2">

        <input type="password" name="password" placeholder="Password"
            class="w-full border rounded px-3 py-2">

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
            class="w-full border rounded px-3 py-2">

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>
@endsection