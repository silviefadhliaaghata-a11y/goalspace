<?php

namespace App\Http\Middleware;

use App\Enums\TeamRole;
use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeamMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $minimumRole = null): Response
    {
        $user = $request->user();
        $team = $this->team($request);

        // Jika tim tidak ditemukan di database, coba cari tim pribadi user sebagai cadangan
        if (! $team && $user) {
            $team = $user->currentTeam ?? $user->personalTeam();
        }

        // Jika masih tidak ada tim atau user tidak login
        if (! $user || ! $team) {
            return $next($request);
        }

        // Jika user adalah admin, izinkan akses ke tim mana pun
        if ($user->role === 'admin') {
            if (! $user->isCurrentTeam($team)) {
                $user->switchTeam($team);
            }
            return $next($request);
        }

        // Cek keanggotaan tim untuk user biasa
        if (! $user->belongsToTeam($team)) {
            // AUTO-REPAIR: Jika ID tim cocok dengan current_team_id user, anggap dia pemilik dan daftarkan ke pivot
            if ($user->current_team_id === $team->id) {
                $user->teams()->attach($team->id, [
                    'role' => \App\Enums\TeamRole::Owner->value,
                ]);
            } else {
                abort(403, 'Anda bukan anggota tim ini.');
            }
        }

        $this->ensureTeamMemberHasRequiredRole($user, $team, $minimumRole);

        if ($request->route('current_team') && ! $user->isCurrentTeam($team)) {
            $user->switchTeam($team);
        }

        return $next($request);
    }

    /**
     * Ensure the given user has at least the given role, if applicable.
     */
    protected function ensureTeamMemberHasRequiredRole(User $user, Team $team, ?string $minimumRole): void
    {
        if ($minimumRole === null) {
            return;
        }

        $role = $user->teamRole($team);

        $requiredRole = TeamRole::tryFrom($minimumRole);

        abort_if(
            $requiredRole === null ||
            $role === null ||
            ! $role->isAtLeast($requiredRole),
            403,
        );
    }

    /**
     * Get the team associated with the request.
     */
    protected function team(Request $request): ?Team
    {
        $team = $request->route('current_team') ?? $request->route('team');

        if (is_string($team)) {
            $team = Team::where('slug', $team)->first();
        }

        return $team;
    }
}
