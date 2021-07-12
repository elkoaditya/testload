<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenModel extends Model
{
    use HasFactory;
    protected $table = "tb_absen";
    protected $fillable = [
        'nama_absen',
        'id_kelas',
        'id_user',
        'id_pelajaran',
        'id_jam_ajar',
        'materi',
        'jam_awal',
        'jam_akhir',
        'token',
        'is_aktif',
    ];
}
