<?php

namespace Database\Seeders;

use App\Models\Distribusi;
use App\Models\Laporan;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $zaky = User::factory()->create([
            'name' => 'Zaky',
            'username' => 'zaky',
            'email' => 'zaky@mbg.test',
            'password' => Hash::make('zaky123'),
            'role' => 'reporter',
        ]);

        User::factory()->create([
            'name' => 'Shadra',
            'username' => 'shadra',
            'email' => 'shadra@mbg.test',
            'password' => Hash::make('shadra123'),
            'role' => 'monitor',
        ]);

        User::factory()->create([
            'name' => 'Ice',
            'username' => 'ice',
            'email' => 'ice@mbg.test',
            'password' => Hash::make('ice123'),
            'role' => 'koordinator',
        ]);

        $smpHarapan = Sekolah::create([
            'nama_sekolah' => 'SMP Harapan',
            'jenjang' => 'SMP',
            'alamat' => 'Jl. Harapan No. 1, Bandung',
            'jumlah_siswa' => 320,
            'kontak_pic' => '0812-1111-0001',
        ]);

        $sdnMelati = Sekolah::create([
            'nama_sekolah' => 'SDN Melati 02',
            'jenjang' => 'SD',
            'alamat' => 'Jl. Melati No. 2, Bandung',
            'jumlah_siswa' => 210,
            'kontak_pic' => '0812-1111-0002',
        ]);

        $distribusi1 = Distribusi::create([
            'sekolah_id' => $smpHarapan->id,
            'tanggal' => now()->subDays(3),
            'menu' => 'Nasi, ayam goreng, sayur bayam, buah pisang',
            'jumlah_porsi' => 300,
        ]);

        $distribusi2 = Distribusi::create([
            'sekolah_id' => $smpHarapan->id,
            'tanggal' => now()->subDay(),
            'menu' => 'Nasi, telur dadar, tumis kangkung, buah jeruk',
            'jumlah_porsi' => 310,
        ]);

        $distribusi3 = Distribusi::create([
            'sekolah_id' => $sdnMelati->id,
            'tanggal' => now()->subDays(2),
            'menu' => 'Nasi, ikan goreng, sayur sop, buah semangka',
            'jumlah_porsi' => 200,
        ]);

        Laporan::create([
            'distribusi_id' => $distribusi1->id,
            'user_id' => $zaky->id,
            'deskripsi' => 'Beberapa siswa mengeluh mual dan sakit perut beberapa jam setelah makan siang.',
            'status' => 'baru',
        ]);

        Laporan::create([
            'distribusi_id' => $distribusi2->id,
            'user_id' => $zaky->id,
            'deskripsi' => 'Anak saya mengalami gatal-gatal setelah makan, diduga alergi telur.',
            'status' => 'ditinjau',
            'catatan' => 'Sudah diperiksa, keluhan hanya dari satu siswa.',
        ]);

        Laporan::create([
            'distribusi_id' => $distribusi3->id,
            'user_id' => $zaky->id,
            'deskripsi' => 'Beberapa siswa muntah setelah makan siang, diduga makanan kurang matang.',
            'status' => 'diteruskan',
            'catatan' => 'Keluhan dari beberapa siswa pada distribusi yang sama, perlu ditindaklanjuti.',
            'ditandai' => true,
            'forwarded_to' => 'Puskesmas Kecamatan',
            'forwarded_at' => now()->subHours(6),
        ]);

        Laporan::create([
            'distribusi_id' => $distribusi1->id,
            'user_id' => $zaky->id,
            'deskripsi' => 'Satu siswa pusing ringan setelah makan, sudah membaik setelah istirahat.',
            'status' => 'selesai',
            'catatan' => 'Sudah ditindaklanjuti oleh pihak sekolah, kondisi siswa membaik.',
        ]);
    }
}
