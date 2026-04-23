<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prodi;
use App\Models\Jurusan;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil jurusan
        $ti = Jurusan::where('nama_jurusan', 'Teknologi Informasi')->first();

        Prodi::insert([
            // Teknologi Informasi
            ['jurusan_id' => $ti->id, 'nama_prodi' => 'Teknik Informatika'],
            ['jurusan_id' => $ti->id, 'nama_prodi' => 'Teknik Komputer'],
            ['jurusan_id' => $ti->id, 'nama_prodi' => 'Manajemen Informatika'],
        ]);
    }
}