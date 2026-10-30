<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['laporan_id', 'user_id', 'status_lama', 'status_baru'])]
class StatusHistory extends Model
{
    const UPDATED_AT = null;

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
