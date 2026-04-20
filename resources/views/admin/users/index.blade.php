@extends('layouts.admin')

@section('title', 'Data User')
@section('page_heading', 'Data User')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data User</h1>
        <p class="text-sm text-gray-500">Daftar semua user yang terdaftar</p>
    </div>
</div>
<div class="flex justify-end mb-5">
    <form method="GET" class="flex gap-2 w-full md:w-auto">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama atau email user..."
               class="border px-3 py-2 rounded-lg w-full md:w-80"
               oninput="debounceUserSearch(this)">

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Cari
        </button>
    </form>
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
            </tr>
        </thead>

        <tbody>
            @forelse($users as $index => $user)
                <tr class="border-t">
                    <td class="p-3">
                        {{ $users->firstItem() + $index }}
                    </td>

                    <td class="p-3 font-medium text-gray-800">
                        {{ $user->name }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $user->email }}
                    </td>

                    <td class="p-3">

@if($user->id == auth()->id())
    <span class="text-xs text-gray-400">You</span>
@else

<form action="{{ route('users.updateRole', [$current_team, $user->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <select name="role"
            onchange="this.form.submit()"
            class="px-2 py-1 text-xs rounded border">

        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
            User
        </option>

        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
            Admin
        </option>

    </select>
</form>

@endif

</td>

                    <td class="p-3 text-gray-500">
                        {{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-5 text-gray-400">
                        Tidak ada data user
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>

@endsection

@push('scripts')
<script>
let userSearchTimeout = null;

function debounceUserSearch(input) {
    clearTimeout(userSearchTimeout);

    userSearchTimeout = setTimeout(() => {
        input.form.submit();
    }, 800);
}
</script>
@endpush