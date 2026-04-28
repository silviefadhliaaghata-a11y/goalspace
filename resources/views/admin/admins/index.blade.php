@extends('layouts.admin')

@section('title', 'Data Admin')
@section('page_heading', 'Data Admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Admin</h1>
        <p class="text-sm text-gray-500">Daftar semua admin sistem 1</p>
    </div>

    <a href="{{ route('admins.create', $current_team) }}"
       class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
        + Tambah Admin
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">No</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Email</th>
                <th class="p-3">Role</th>
                <th class="p-3">Tanggal Daftar</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($admins as $index => $admin)
                <tr class="border-t">
                    <td class="p-3">
                        {{ $admins->firstItem() + $index }}
                    </td>

                    <td class="p-3 font-medium text-gray-800">
                        {{ $admin->name }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $admin->email }}
                    </td>

                    <td class="p-3">
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                            Admin
                        </span>
                    </td>

                    <td class="p-3 text-gray-500">
                        {{ $admin->created_at?->format('d-m-Y H:i') }}
                    </td>

                    <td class="p-3">
                        @if($admin->id == auth()->id())
                            <span class="text-xs text-gray-400">You</span>
                        @else
                            <form action="{{ route('users.updateRole', [$current_team, $admin->id]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="role" value="user">

                                <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">
                                    Turunkan ke User
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-5 text-gray-400">
                        Tidak ada admin
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $admins->links() }}
</div>

@endsection