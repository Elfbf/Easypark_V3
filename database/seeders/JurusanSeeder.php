<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        Jurusan::insert([
            ['nama_jurusan' => 'Teknologi Informasi'],
        ]);
    }
}