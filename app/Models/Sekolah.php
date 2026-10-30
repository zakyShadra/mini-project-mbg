<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_sekolah', 'jenjang', 'alamat', 'jumlah_siswa', 'kontak_pic'])]
class Sekolah extends Model
{
    public function distribusis(): HasMany
    {
        return $this->hasMany(Distribusi::class);
    }
}
