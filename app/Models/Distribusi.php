<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['sekolah_id', 'tanggal', 'menu', 'jumlah_porsi'])]
class Distribusi extends Model
{
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }
}
