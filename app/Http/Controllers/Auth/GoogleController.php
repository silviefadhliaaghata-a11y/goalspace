<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? 'User Google',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(16)),
                'role' => 'user',
            ]);
        } else {
            $user->update([
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
            ]);
        }

        Auth::login($user, true);

        $team = $user->currentTeam ?? $user->personalTeam();

        if (! $team) {
            $team = \App\Models\Team::create([
                'name' => $user->name . "'s Team",
                'slug' => Str::slug($user->name . '-' . Str::random(5)),
                'is_personal' => true,
            ]);

            // Daftarkan user ke tim tersebut sebagai OWNER di tabel pivot
            $user->teams()->attach($team->id, [
                'role' => \App\Enums\TeamRole::Owner->value,
            ]);

            $user->forceFill([
                'current_team_id' => $team->id,
            ])->save();
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
