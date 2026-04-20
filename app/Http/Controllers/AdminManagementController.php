<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index($current_team)
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Akses ditolak!');
        }

        $admins = User::where('role', 'admin')
            ->latest()
            ->paginate(10);

        return view('admin.admins.index', compact('admins', 'current_team'));
    }

    public function create($current_team)
    {
        return view('admin.admins.create', compact('current_team'));
    }

    public function store(Request $request, $current_team)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = 'admin';
    $user->current_team_id = auth()->user()->current_team_id;
    $user->email_verified_at = now();
    $user->save();

    return redirect()->route('admins.index', $current_team)
        ->with('success', 'Admin berhasil ditambahkan!');
}

}