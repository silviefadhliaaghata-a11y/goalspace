<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        if (! $googleUser->getEmail()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Email Google tidak ditemukan.',
            ]);
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (! $user) {
            $teamId = DB::table('teams')->value('id');

            if (! $teamId) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Team default tidak ditemukan. Buat team dulu sebelum login Google.',
                ]);
            }

            $user = new User();
            $user->name = $googleUser->getName() ?: 'User Google';
            $user->email = $googleUser->getEmail();
            $user->password = bcrypt(Str::random(16));
            $user->role = 'user';
            $user->current_team_id = $teamId;
            $user->email_verified_at = now();
        }

        $user->google_id = $googleUser->getId();
        $user->google_avatar = $googleUser->getAvatar();
        $user->email_verified_at = $user->email_verified_at ?: now();
        $user->save();

        Auth::login($user, true);

        $team = $user->currentTeam ?? $user->personalTeam();

        if (! $team) {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun berhasil login, tapi belum memiliki team aktif.',
            ]);
        }

        URL::defaults([
            'current_team' => $team->slug,
        ]);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard', [
                'current_team' => $team->slug,
            ]);
        }

        return redirect()->route('dashboard', [
            'current_team' => $team->slug,
        ]);
    }
}