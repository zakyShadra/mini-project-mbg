<?php

namespace App\Services;

use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LaporanService
{
    private const STATUS_ORDER = ['baru', 'ditinjau', 'diteruskan', 'selesai'];

    public function review(Laporan $laporan, array $data): Laporan
    {
        if ($laporan->status === 'selesai') {
            throw ValidationException::withMessages([
                'status' => 'Laporan yang sudah selesai tidak dapat diubah lagi.',
            ]);
        }

        if (isset($data['status']) && $data['status'] !== $laporan->status) {
            $this->ensureStatusNotRegressing($laporan->status, $data['status']);
        }

        if (! empty($data['forwarded_to'])) {
            $data['forwarded_at'] = now();
        }

        DB::transaction(function () use ($laporan, $data): void {
            $laporan->fill($data);
            $laporan->save();
        });

        return $laporan;
    }

    private function ensureStatusNotRegressing(string $current, string $next): void
    {
        $currentIndex = array_search($current, self::STATUS_ORDER, true);
        $nextIndex = array_search($next, self::STATUS_ORDER, true);

        if ($nextIndex < $currentIndex) {
            throw ValidationException::withMessages([
                'status' => "Status tidak dapat kembali dari \"{$current}\" ke \"{$next}\".",
            ]);
        }
    }
}
