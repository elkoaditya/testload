<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenSiswa extends Model
{
    use HasFactory;
    protected $table = "tb_absen_siswa";
    protected $fillable = [
        'id_siswa',
        'id_absen',
        'status_absen',
        'keterangan_absen',
        'metode_absen',
        'created_at',
        'updated_at',
    ];
}
