<?php

namespace App\Observers;

use App\Models\Laporan;

class LaporanObserver
{
    public function updating(Laporan $laporan): void
    {
        if (! $laporan->isDirty('status')) {
            return;
        }

        $laporan->statusHistories()->create([
            'user_id' => auth()->id(),
            'status_lama' => $laporan->getOriginal('status'),
            'status_baru' => $laporan->status,
        ]);
    }
}
