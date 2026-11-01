<?php

namespace Tests\Feature;

use App\Models\Distribusi;
use App\Models\Laporan;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanViewTest extends TestCase
{
    use RefreshDatabase;

    private function makeLaporan(string $role = 'reporter'): array
    {
        $user = User::factory()->create(['role' => $role]);
        $sekolah = Sekolah::create(['nama_sekolah' => 'SMP Tes', 'jenjang' => 'SMP', 'alamat' => 'Jl Tes', 'jumlah_siswa' => 100]);
        $distribusi = $sekolah->distribusis()->create(['tanggal' => now(), 'menu' => 'Nasi Ayam', 'jumlah_porsi' => 100]);
        $laporan = $distribusi->laporans()->create(['user_id' => $user->id, 'deskripsi' => 'tes', 'status' => 'baru']);

        return [$user, $laporan];
    }

    public function test_reporter_can_view_index(): void
    {
        [$user] = $this->makeLaporan();

        $this->actingAs($user)->get(route('laporans.index'))->assertOk();
    }

    public function test_reporter_can_view_own_laporan(): void
    {
        [$user, $laporan] = $this->makeLaporan();

        $this->actingAs($user)->get(route('laporans.show', $laporan))->assertOk();
    }

    public function test_monitor_can_view_index_and_laporan(): void
    {
        [, $laporan] = $this->makeLaporan();
        $monitor = User::factory()->create(['role' => 'monitor']);

        $this->actingAs($monitor)->get(route('laporans.index'))->assertOk();
        $this->actingAs($monitor)->get(route('laporans.show', $laporan))->assertOk();
    }

    public function test_distribusi_lookup_returns_json_for_sekolah(): void
    {
        [$user, $laporan] = $this->makeLaporan();

        $response = $this->actingAs($user)->getJson(route('sekolahs.distribusis', $laporan->distribusi->sekolah));

        $response->assertOk()->assertJsonFragment(['menu' => 'Nasi Ayam']);
    }

    public function test_koordinator_can_view_rekap(): void
    {
        [, $laporan] = $this->makeLaporan();
        $koordinator = User::factory()->create(['role' => 'koordinator']);

        $this->actingAs($koordinator)->get(route('rekap.index'))
            ->assertOk()
            ->assertSee($laporan->distribusi->sekolah->nama_sekolah);
    }

    public function test_reporter_cannot_view_rekap(): void
    {
        [$user] = $this->makeLaporan();

        $this->actingAs($user)->get(route('rekap.index'))->assertForbidden();
    }
}
