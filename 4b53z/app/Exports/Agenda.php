<?php

namespace App\Exports;

use App\kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\AbsenSiswa;
use App\Models\AbsenModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Auth;
use Illuminate\Http\Request;

class Agenda implements FromView
{
    public $Pub_id;
    public $have;

    public function  view(): View
    {
        $month = session()->get('id_tahun_bulan');
        $id_kelas = session()->get('id_kelas');
        

        $dateString = session()->get('id_tahun_bulan');
        $dateObject = Carbon::parse($dateString);
        $bulan = $dateObject->format('m');
        $tahun = $dateObject->format('Y');

        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        
        $period = CarbonPeriod::create($start, $end);
        foreach($period as $date)
        {
          //$dates[] = $date->isoFormat('dddd, D MMMM Y');
          //$search_date[] = $date->format('Y-m-d');

          $new_date[] = [
            'dates' => $date->isoFormat('dddd, D MMMM Y'),
            'search_date' => $date->format('Y-m-d')
          ];
        }



        //$id_kelas = session()->get('id_download');

        $siswa = DB::table('tb_absen_siswa')
                    ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                    ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                    ->where('tb_absen.id_user', Auth::user()->id)
                    ->where('dprofil_siswa.kelas_id', $id_kelas)
                    ->select('dprofil_siswa.nama as namasiswa', 'dprofil_siswa.gender as kelamin', 'dprofil_siswa.id as id_siswa', 'tb_absen_siswa.status_absen', 'dprofil_siswa.kelas_id')
                    ->get();
        $siswa = $siswa->unique('namasiswa');
        $temp = DB::table('tb_absen')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
        ->where('id_user', Auth::user()->id)
        ->where('id_kelas', $id_kelas)
        ->groupBy('date')
        ->get();

        $jam_ajar = DB::table('dakd_jam_ajar')->get();
        

        

        $absen = DB::table('tb_absen')
                    ->join('dakd_pelajaran', 'tb_absen.id_pelajaran', '=', 'dakd_pelajaran.id')
                    ->get();


        return view('excel.LaporanV1', [
            'siswa' => $siswa,
            'date' => $new_date,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jam_ajar' => $jam_ajar,
            'id_kelas' => $id_kelas,
        ]);
    }
    public function download($tahun, $bulan, $id_kelas){
        session([
            'id_tahun_bulan' => $tahun.'-'.$bulan,
            'id_kelas' => $id_kelas,
        ]);

        return Excel::download(new Agenda, 'LaporanExcel.xlsx');
    }
    public function convert(Request $request){
        
        


        return redirect('/agenda/export/'.$request->tahun.'/'.$request->bulan.'/'.$request->id_kelas);
    }
}
