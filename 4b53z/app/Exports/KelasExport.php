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
use Auth;
use Illuminate\Http\Request;

class KelasExport implements FromView
{
    public $Pub_id;

    public function  view(): View
    {
        $id_kelas = session()->get('id_download');
        //$id_kelas = session()->get('id_kelas');
        $today = session()->get('id_tanggal');
        $siswa = DB::table('tb_absen_siswa')
                    ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                    ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                    
                    //->where('tb_absen.id_user', Auth::user()->id)
                    
                    ->where('dprofil_siswa.kelas_id', $id_kelas)
                    
                    ->select('dprofil_siswa.nama as namasiswa', 'dprofil_siswa.gender as kelamin', 'dprofil_siswa.id as id_siswa', 'tb_absen_siswa.status_absen', 'dprofil_siswa.kelas_id', 'dprofil_siswa.nis', 'tb_absen.id_user')
                    ->get();

        if(Auth::user()->role == "admin"){
            $siswa = $siswa;
        }else{
            $siswa = $siswa->where('id_user', Auth::user()->id);
        }

        $siswa = $siswa->unique('namasiswa');
        
        
        if(Auth::user()->role == "admin"){
            $temp = DB::table('tb_absen')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
                //->where('id_user', Auth::user()->id)
                ->whereDate('tb_absen.created_at', '=', session()->get('id_tanggal'))
                ->where('id_kelas', $id_kelas)
                ->groupBy('date')
                ->get();
        }else{
            $temp = DB::table('tb_absen')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
                ->where('id_user', Auth::user()->id)
                ->whereDate('tb_absen.created_at', '=', session()->get('id_tanggal'))
                ->where('id_kelas', $id_kelas)
                ->groupBy('date')
                ->get();
        }

        if($temp->isEmpty()){

            echo "Data Kosong";die;
        }

        //dd($id_kelas);

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



        return view('excel.AbsensiV4', [
            'siswa' => $siswa,
            'date' => $temp,
            'id_kelas' => $id_kelas,
            'today' => $today,
            'fix_jam_ajar' => $jam_ajar,
        ]);
    }
    public function download($id){
        session([
            'id_download' => $id,
        ]);

        return Excel::download(new KelasExport, 'Siswa Kelas Export '.$id.'.xlsx');
    }
    public function convert(Request $request){
        $dateString = $request->tanggal;
        $dateObject = Carbon::createFromFormat('d/m/Y', $dateString);
        $dateObject = $dateObject->toDateString();

        session([
            'id_tanggal' => $dateObject,
        ]);
        return redirect('/export/'.$request->id_kelas);
        
    }
}
