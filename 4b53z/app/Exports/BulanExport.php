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

class BulanExport implements FromView
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
          $dates[] = $date->format('Y-m-d');
        }




        $id_kelas = session()->get('id_download');

        if(APP_SUBDOMAIN == 'smk_pika'){
            $siswa = DB::table('tb_absen_siswa')
                    ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                    ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                    //->where('tb_absen.id_user', Auth::user()->id)
                    ->where('dprofil_siswa.kelas_id', $id_kelas)
                    ->select('dprofil_siswa.nama as namasiswa', 'dprofil_siswa.gender as kelamin', 'dprofil_siswa.id as id_siswa', 'tb_absen_siswa.status_absen', 'dprofil_siswa.kelas_id', 'tb_absen.id_user', 'dprofil_siswa.nis as nis_siswa')
                    ->orderBy('nis_siswa', 'ASC')
                    ->get();

                    //dd($siswa);
        }else{
            $siswa = DB::table('tb_absen_siswa')
                    ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                    ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                    //->where('tb_absen.id_user', Auth::user()->id)
                    ->where('dprofil_siswa.kelas_id', $id_kelas)
                    ->select('dprofil_siswa.nama as namasiswa', 'dprofil_siswa.gender as kelamin', 'dprofil_siswa.id as id_siswa', 'tb_absen_siswa.status_absen', 'dprofil_siswa.kelas_id', 'tb_absen.id_user')
                    ->get();
        }

        

        if(Auth::user()->role == "admin"){
            $siswa = $siswa;
        }else{
            $siswa = $siswa->where('id_user', Auth::user()->id);
        }
        //dd($siswa);


        $siswa = $siswa->unique('namasiswa');
        $temp = DB::table('tb_absen')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
        ->where('id_user', Auth::user()->id)
        ->where('id_kelas', $id_kelas)
        ->groupBy('date')
        ->get();
        


        $_data = DB::table('tb_absen')
                    //->where('id_user', Auth::user()->id)
                    ->whereDate('tb_absen.created_at', '=', session()->get('id_tanggal'))
                    ->where('id_kelas', $id_kelas)
                    ->get();

        if(Auth::user()->role == "admin"){
            $_data = $_data;
        }else{
            $_data = $_data->where('id_user', Auth::user()->id);
        }

        $jam_ajar = [];      
        foreach($_data as $jm){
            $_jam_ajar = explode(',', $jm->id_jam_ajar);
            foreach($_jam_ajar as $_jm){
                $ajar = DB::table('dakd_jam_ajar')
                    ->where('id', '=', $_jm)
                    ->first();
                array_push($jam_ajar, [
                    "nama" => $ajar->nama,
                    "id" => $_jm,
                    "id_absen" => $jm->id,
                ]);
            }
        }
        
        //dd($jam_ajar);
        //dd($temp);
        //dd($siswa);





        return view('excel.AbsensiV2', [
            'siswa' => $siswa,
            'date' => $dates,
            'bulan' => $bulan,
            'tahun' => $tahun,
            
            'id_kelas' => $id_kelas,
        ]);
    }
    public function download($id, $tahun, $bulan){
        session([
            'id_download' => $id,
            'id_tahun_bulan' => $tahun.'-'.$bulan,
            'id_kelas' => $id
        ]);

        return Excel::download(new BulanExport, 'Siswa Mount Export '.$id.'.xlsx');
    }
    public function convert(Request $request){
        


        return redirect('/export/bulan/'.$request->id_kelas.'/'.$request->tahun.'/'.$request->bulan);
        dd($request);
    }
}
