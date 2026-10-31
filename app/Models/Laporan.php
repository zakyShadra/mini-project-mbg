<?php

namespace App\Models;

use App\Observers\LaporanObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['distribusi_id', 'user_id', 'deskripsi', 'bukti', 'status', 'catatan', 'ditandai', 'forwarded_to', 'forwarded_at'])]
#[ObservedBy(LaporanObserver::class)]
class Laporan extends Model
{
    public function distribusi(): BelongsTo
    {
        return $this->belongsTo(Distribusi::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(StatusHistory::class);
    }
}
