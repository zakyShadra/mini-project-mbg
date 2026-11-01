<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekapController extends Controller
{
    public function index(Request $request): View
    {
        $query = Laporan::query()
            ->when($request->filled('sekolah_id'), fn ($q) => $q->whereHas(
                'distribusi',
                fn ($q) => $q->where('sekolah_id', $request->integer('sekolah_id'))
            ));

        $totalLaporan = (clone $query)->count();
        $laporanDiproses = (clone $query)->where('status', '!=', 'selesai')->count();
        $laporanSelesai = (clone $query)->where('status', 'selesai')->count();

        $rekapPerSekolah = Sekolah::query()
            ->select('sekolahs.*')
            ->selectRaw('(select count(*) from laporans inner join distribusis on distribusis.id = laporans.distribusi_id where distribusis.sekolah_id = sekolahs.id) as total_laporan')
            ->orderByDesc('total_laporan')
            ->get();

        return view('rekap.index', [
            'totalLaporan' => $totalLaporan,
            'laporanDiproses' => $laporanDiproses,
            'laporanSelesai' => $laporanSelesai,
            'rekapPerSekolah' => $rekapPerSekolah,
            'sekolahs' => Sekolah::orderBy('nama_sekolah')->get(),
        ]);
    }
}
