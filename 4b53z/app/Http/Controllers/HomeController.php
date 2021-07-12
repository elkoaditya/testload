<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use App\Models\AbsenModel;
use App\Models\AbsenSiswa;
use App\Models\Token;
use App\Models\Siswa;
use App\Models\Akun;
use Carbon\Carbon;
use DB;
use Auth;
use Str;

class HomeController extends Controller
{
    // Fungsi contruk unutk Mengecek sudah login atau belum
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Fungsi Default untuk index
    public function index()
    {
        $menu = DB::table('main_menus')
                    ->where('userrole_menu', '=', Auth::user()->role)
                    ->get();
        $total_admin = Akun::where('role', 'admin')->count();
        $total_guru = Akun::where('role', 'sdm')->count();
        $total_siswa = Akun::where('role', 'siswa')->count();
        $total_user = Akun::count();

        $daftar_absen = DB::table('tb_absen')
                ->join('dakd_kelas', 'dakd_kelas.id', '=', 'tb_absen.id_kelas')
                ->join('dakd_pelajaran', 'dakd_pelajaran.id', '=', 'tb_absen.id_pelajaran')
                ->join('dakd_kategori_mapel', 'dakd_pelajaran.kategori_id', '=', 'dakd_kategori_mapel.id')
                ->join('dakd_mapel', 'dakd_pelajaran.mapel_id', '=', 'dakd_mapel.id')
                ->join('data_user', 'tb_absen.id_user', '=', 'data_user.id')
                ->join('tb_absen_siswa', 'tb_absen.id', '=', 'tb_absen_siswa.id_absen')
                ->whereDate('tb_absen.created_at', Carbon::today())
                ->select('tb_absen.*', 'dakd_kelas.nama as namakelas', 'dakd_pelajaran.nama as namapelajaran', 'data_user.nama as namauser', 'dakd_kategori_mapel.nama as namakategori', 'dakd_mapel.nama as namamapel', 'tb_absen_siswa.id_siswa')
                                ->where('id_siswa', Auth::user()->id)
                                ->get();

        //dd($daftar_absen);

        return view('dasboard', compact('menu', 'total_admin', 'total_guru', 'total_siswa', 'total_user', 'daftar_absen'));
    }
}
