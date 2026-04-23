<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jurusan;
use App\Models\User;

class Prodi extends Model
{
    protected $fillable = [
        'jurusan_id',
        'nama_prodi',
    ];

    /**
     * Relasi ke Jurusan (Prodi milik 1 jurusan)
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Relasi ke User (1 prodi punya banyak user)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}