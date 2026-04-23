<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Prodi;

class Jurusan extends Model
{
    protected $fillable = [
        'nama_jurusan',
    ];

    /**
     * Relasi ke Prodi (1 jurusan punya banyak prodi)
     */
    public function prodis()
    {
        return $this->hasMany(Prodi::class);
    }
}