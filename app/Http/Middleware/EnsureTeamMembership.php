<?php

namespace App\Http\Middleware;

use App\Enums\TeamRole;
use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\URL;
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
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
<<<<<<< HEAD
        [$user, $team] = [$request->user(), $this->team($request)];

        abort_if(! $user || ! $team || ! $user->belongsToTeam($team), 403);

        $this->ensureTeamMemberHasRequiredRole($user, $team, $minimumRole);

        if ($request->route('current_team') && ! $user->isCurrentTeam($team)) {
            $user->switchTeam($team);
        }

=======
        $user = $request->user();
        $team = $this->team($request);

        // Jika tidak login, biarkan Laravel yang menangani lewat middleware 'auth'
        if (! $user) {
            return $next($request);
        }

        // Jika tim tidak ditemukan, cari tim yang ada atau tim pribadi
        if (! $team) {
            $team = $user->currentTeam ?? $user->personalTeam() ?? Team::first();
        }

        // Jika masih tidak ada tim sama sekali di database (sangat jarang)
        if (! $team) {
            return $next($request);
        }

        // PAKSA MASUK: Jika belum jadi anggota, masukkan secara otomatis
        if (! $user->belongsToTeam($team)) {
            $user->teams()->syncWithoutDetaching([
                $team->id => ['role' => \App\Enums\TeamRole::Owner->value]
            ]);
        }

        // Pastikan current_team_id sinkron
        if ($user->current_team_id !== $team->id) {
            $user->forceFill(['current_team_id' => $team->id])->save();
        }

        // Set default URL agar tim tetap terbawa di link-link lain
        URL::defaults(['current_team' => $team->slug]);

>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
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
