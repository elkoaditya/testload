<?php

namespace App\Exports;

use App\Models\AbsenSiswa;
use App\Models\AbsenModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Auth;

use Maatwebsite\Excel\Concerns\Exportable;


class SiswaExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $siswa = DB::table('tb_absen_siswa')
                    ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                    ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                    ->where('tb_absen.id_user', Auth::user()->id)
                    ->select('dprofil_siswa.nama as namasiswa', 'dprofil_siswa.gender as kelamin', 'dprofil_siswa.id as id_siswa', 'tb_absen_siswa.status_absen')
                    ->get();
        $siswa = $siswa->unique('namasiswa');
        $temp = DB::table('tb_absen')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
        ->where('id_user', Auth::user()->id)
        ->groupBy('date')
        ->get();





        return view('excel.AbsensiV1', [
            'siswa' => $siswa,
            'date' => $temp,
        ]);
    }
    public function download(){
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }
}
