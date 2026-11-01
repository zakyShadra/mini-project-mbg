<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\JsonResponse;

class DistribusiController extends Controller
{
    public function bySekolah(Sekolah $sekolah): JsonResponse
    {
        return response()->json(
            $sekolah->distribusis()->latest('tanggal')->get(['id', 'tanggal', 'menu'])
        );
    }
}
