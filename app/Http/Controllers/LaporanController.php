<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewLaporanRequest;
use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
use App\Models\Distribusi;
use App\Models\Laporan;
use App\Models\Sekolah;
use App\Services\LaporanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function __construct(private LaporanService $laporanService) {}

    public function index(Request $request): View
    {
        $query = $request->user()->isReporter()
            ? Laporan::where('user_id', $request->user()->id)
            : Laporan::query();

        $query->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('distribusi_id'), fn ($q) => $q->where('distribusi_id', $request->integer('distribusi_id')))
            ->when($request->filled('q'), fn ($q) => $q->where('deskripsi', 'like', '%'.$request->string('q').'%'));

        $laporans = $query->latest()->paginate(10)->withQueryString();

        return view('laporans.index', [
            'laporans' => $laporans,
            'sekolahs' => $request->user()->isReporter() ? Sekolah::orderBy('nama_sekolah')->get() : collect(),
            'distribusis' => $request->user()->isReporter() ? Distribusi::with('sekolah')->latest('tanggal')->get() : collect(),
        ]);
    }

    public function store(StoreLaporanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti-laporan', 'public');
        }

        $data['user_id'] = $request->user()->id;

        $laporan = Laporan::create($data);

        return Redirect::route('laporans.show', $laporan)->with('status', 'laporan-created');
    }

    public function show(Laporan $laporan): View
    {
        Gate::authorize('view', $laporan);

        return view('laporans.show', ['laporan' => $laporan]);
    }

    public function update(UpdateLaporanRequest $request, Laporan $laporan): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('bukti')) {
            if ($laporan->bukti) {
                Storage::disk('public')->delete($laporan->bukti);
            }

            $data['bukti'] = $request->file('bukti')->store('bukti-laporan', 'public');
        }

        $laporan->update($data);

        return Redirect::route('laporans.show', $laporan)->with('status', 'laporan-updated');
    }

    public function review(ReviewLaporanRequest $request, Laporan $laporan): RedirectResponse
    {
        $this->laporanService->review($laporan, $request->validated());

        return Redirect::route('laporans.show', $laporan)->with('status', 'laporan-reviewed');
    }
}
