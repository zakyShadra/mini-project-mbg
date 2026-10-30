<?php

namespace App\Policies;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LaporanPolicy
{
    public function view(User $user, Laporan $laporan): bool
    {
        return $user->id === $laporan->user_id
            || $user->isPemantau()
            || $user->isKoordinator();
    }

    public function create(User $user): bool
    {
        return $user->isPelapor();
    }

    public function update(User $user, Laporan $laporan): bool
    {
        if ($user->id === $laporan->user_id) {
            return $laporan->status === 'baru';
        }

        return $user->isPemantau() || $user->isKoordinator();
    }
}
