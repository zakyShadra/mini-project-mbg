<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $laporans = $request->user()->isReporter()
            ? Laporan::where('user_id', $request->user()->id)->latest()->get()
            : Laporan::latest()->get();

        return view('laporans.index', ['laporans' => $laporans]);
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
}
