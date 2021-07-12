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

class AbsenController extends Controller
{
    public function index(){
        
        //dd(Str::random(6));
        

        $daftar_ajar = DB::table('dakd_jam_ajar')->get();
        $daftar_kelas = DB::table('dakd_kelas')->get();
        $daftar_pelajaran = DB::table('dakd_pelajaran')->get();
        if(Auth::user()->role == "admin"){
            $daftar_absen = DB::table('tb_absen')
                            ->join('dakd_kelas', 'dakd_kelas.id', '=', 'tb_absen.id_kelas')
                            ->join('dakd_pelajaran', 'dakd_pelajaran.id', '=', 'tb_absen.id_pelajaran')
                            ->join('dakd_kategori_mapel', 'dakd_pelajaran.kategori_id', '=', 'dakd_kategori_mapel.id')
                            ->join('dakd_mapel', 'dakd_pelajaran.mapel_id', '=', 'dakd_mapel.id')
                            ->join('data_user', 'tb_absen.id_user', '=', 'data_user.id')
                            ->whereDate('created_at', Carbon::today())
                            ->select('tb_absen.*', 'dakd_kelas.nama as namakelas', 'dakd_pelajaran.nama as namapelajaran', 'data_user.nama as namauser', 'dakd_kategori_mapel.nama as namakategori', 'dakd_mapel.nama as namamapel')
                            ->get();

            $daftar_absen_all = DB::table('tb_absen')
            ->join('dakd_kelas', 'dakd_kelas.id', '=', 'tb_absen.id_kelas')
            ->join('dakd_pelajaran', 'dakd_pelajaran.id', '=', 'tb_absen.id_pelajaran')
            ->join('dakd_kategori_mapel', 'dakd_pelajaran.kategori_id', '=', 'dakd_kategori_mapel.id')
            ->join('dakd_mapel', 'dakd_pelajaran.mapel_id', '=', 'dakd_mapel.id')
            ->join('data_user', 'tb_absen.id_user', '=', 'data_user.id')
            ->orderBy('created_at', 'desc')
            ->select('tb_absen.*', 'dakd_kelas.nama as namakelas', 'dakd_pelajaran.nama as namapelajaran', 'data_user.nama as namauser', 'dakd_kategori_mapel.nama as namakategori', 'dakd_mapel.nama as namamapel')
                            ->get(); 
            
                            
            $visitorTraffic = DB::table('tb_absen')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
            ->groupBy('date')
            ->get();
        }else if(Auth::user()->role == "sdm"){

                $_max = DB::table('prd_semester')
                            ->max('id');

                $daftar_pelajaran = null;
                $daftar_pelajaran = DB::table('nilai_pelajaran')
                                        ->join('dakd_pelajaran', 'nilai_pelajaran.pelajaran_id', '=', 'dakd_pelajaran.id')
                                        ->select('nilai_pelajaran.guru_id as guruid', 'dakd_pelajaran.*')
                                        ->where('nilai_pelajaran.guru_id', '=', Auth::user()->id)
                                        ->where('nilai_pelajaran.semester_id', '=', $_max)
                                        ->get();


                $daftar_absen = DB::table('tb_absen')
                ->join('dakd_kelas', 'dakd_kelas.id', '=', 'tb_absen.id_kelas')
                ->join('dakd_pelajaran', 'dakd_pelajaran.id', '=', 'tb_absen.id_pelajaran')
                ->join('dakd_kategori_mapel', 'dakd_pelajaran.kategori_id', '=', 'dakd_kategori_mapel.id')
                ->join('dakd_mapel', 'dakd_pelajaran.mapel_id', '=', 'dakd_mapel.id')
                ->join('data_user', 'tb_absen.id_user', '=', 'data_user.id')
                ->whereDate('created_at', Carbon::today())
                ->select('tb_absen.*', 'dakd_kelas.nama as namakelas', 'dakd_pelajaran.nama as namapelajaran', 'data_user.nama as namauser', 'dakd_kategori_mapel.nama as namakategori', 'dakd_mapel.nama as namamapel')
                                ->where('id_user', Auth::user()->id)
                                ->get();
                                
                $daftar_absen_all = DB::table('tb_absen')
                ->join('dakd_kelas', 'dakd_kelas.id', '=', 'tb_absen.id_kelas')
                ->join('dakd_pelajaran', 'dakd_pelajaran.id', '=', 'tb_absen.id_pelajaran')
                ->join('dakd_kategori_mapel', 'dakd_pelajaran.kategori_id', '=', 'dakd_kategori_mapel.id')
                ->join('dakd_mapel', 'dakd_pelajaran.mapel_id', '=', 'dakd_mapel.id')
                ->join('data_user', 'tb_absen.id_user', '=', 'data_user.id')
                ->orderBy('created_at', 'desc')
                ->select('tb_absen.*', 'dakd_kelas.nama as namakelas', 'dakd_pelajaran.nama as namapelajaran', 'data_user.nama as namauser', 'dakd_kategori_mapel.nama as namakategori', 'dakd_mapel.nama as namamapel')
                                ->where('id_user', Auth::user()->id)
                                ->get(); 
                                
                $visitorTraffic = DB::table('tb_absen')
                ->where('id_user', Auth::user()->id)
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
                ->groupBy('date')
                ->get();
            
        }  
        // Ini Laporan
        
                       
        

        $menu = DB::table('main_menus')
                    ->where('userrole_menu', '=', Auth::user()->role)
                    ->get();

        //$_temp = DB::table('dakd_pelajaran')->where('guru_id', Auth::user()->id)->get();
        $_temp0 = DB::table('dakd_pelajaran_kelas')
                    ->join('dakd_pelajaran', 'dakd_pelajaran.id', '=', 'dakd_pelajaran_kelas.pelajaran_id')
                    ->get();


        return view('absensi', compact('menu', 'daftar_ajar', 'daftar_kelas', 'daftar_pelajaran', 'daftar_absen', 'daftar_absen_all', 'visitorTraffic'));
    }
    public function absen_edit($id){
        $daftar_ajar = DB::table('dakd_jam_ajar')->get();
        $daftar_kelas = DB::table('dakd_kelas')->get();
        $daftar_pelajaran = DB::table('dakd_pelajaran')->get();
        
        $absen = DB::table('tb_absen')
                    ->where('id', $id)
                    ->first();

                    //$now = Carbon::now();
                    //dd($now->format('H:i:s'));
        

        $menu = DB::table('main_menus')
                    ->where('userrole_menu', '=', Auth::user()->role)
                    ->get();
        return view('absen_edit', compact('menu', 'daftar_pelajaran', 'daftar_ajar', 'absen', 'id'));
    }
    public function save_update_absensi(Request $request){
        $result = DB::table('tb_absen')
                    ->where('id', $request->id)
                    ->update([
                        'materi' => $request->materi,
                        'jam_awal' => $request->jam_awal,
                        'jam_akhir' => $request->jam_akhir,
                        'id_jam_ajar' => implode(',', $request->id_jam_ajar),
                    ]);

        return redirect('/absen#all-absen');
    }
    public function delete_absensi(Request $request, $id){
        $siswa = DB::table('tb_absen_siswa')
                    ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                    ->select( 'dprofil_siswa.*', 'tb_absen_siswa.*')
                    ->where('id_absen', $request->id)->get();
        $pilihan_absen = DB::table('tb_pilihan_absen')->where('is_aktif', 1)->get();




        $menu = DB::table('main_menus')
                    ->where('userrole_menu', '=', Auth::user()->role)
                    ->get();
        return view('delete_absensi', compact('menu', 'siswa', 'pilihan_absen', 'id'));
    }
    public function delete_absensi_yes(Request $request){

        $result_absen = DB::table('tb_absen')
                        ->where('id', $request->id)
                        ->delete();
        $result_hasil = DB::table('tb_absen_siswa')
                        ->where('id_absen', $request->id)
                        ->delete();

        return redirect('/absen');
    }

    public function satu_show(Request $request){
        $siswa = DB::table('tb_absen_siswa')
                    ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                    ->select( 'dprofil_siswa.*', 'tb_absen_siswa.*')
                    ->where('id_absen', $request->id)->get();
        $pilihan_absen = DB::table('tb_pilihan_absen')->where('is_aktif', 1)->get();


        $menu = DB::table('main_menus')
                    ->where('userrole_menu', '=', Auth::user()->role)
                    ->get();


        

        
        return view('satu_absen', compact('menu', 'siswa', 'pilihan_absen'));
    }


    public function save(Request $request){
        //$createdAt = Carbon::parse($request->tanggal_absensi);
        if($request->tanggal_absensi != null){
            $createdAt = Carbon::createFromFormat('d/m/Y', $request->tanggal_absensi)->format('d-m-Y');
            $date = Carbon::parse($createdAt);
            $date = $date->toDateTimeString();
            
            if($request->jam_ajar == null){
                $data = new AbsenModel();
                $data->id_kelas = $request->kelas;
                $data->timestamps = false;
                $data->id_user = Auth::user()->id;
                $data->id_pelajaran = $request->mapel;
                $data->token = Str::random(6);
                $data->materi = $request->materi;
                $data->jam_awal = $request->jam_awal;
                $data->jam_akhir = $request->jam_akhir;
                $data->is_aktif = 1;
                $data->created_at = $date;
                $data->save();
            }else{
                $data = new AbsenModel();
                $data->id_kelas = $request->kelas;
                $data->timestamps = false;
                $data->id_user = Auth::user()->id;
                $data->id_pelajaran = $request->mapel;
                $data->token = Str::random(6);
                $data->id_jam_ajar = implode(',', $request->jam_ajar);
                $data->materi = $request->materi;
                $data->jam_awal = $request->jam_awal;
                $data->jam_akhir = $request->jam_akhir;
                $data->is_aktif = 1;
                $data->created_at = $date;
                $data->save();
            }
            

        }else{
            if($request->jam_ajar == null){
                $data = AbsenModel::create([
                    'id_kelas' => $request->kelas,
                    'id_user' => Auth::user()->id,
                    'id_pelajaran' => $request->mapel,
                    'token' => Str::random(6),
                    'materi' => $request->materi,
                    'jam_awal' => $request->jam_awal,
                    'jam_akhir' => $request->jam_akhir,
                    'is_aktif' => 1               
                ]);
            }else{
    
                            
                           
    
                $data = AbsenModel::create([
                'id_kelas' => $request->kelas,
                'id_user' => Auth::user()->id,
                'id_pelajaran' => $request->mapel,
                'id_jam_ajar' => implode(',', $request->jam_ajar),
                'materi' => $request->materi,
                'jam_awal' => $request->jam_awal,
                'jam_akhir' => $request->jam_akhir,
                'token' => Str::random(6),
                'is_aktif' => 1,
            ]);
            }
        }


            



        
        if($request->metode == 1){
            $temp_kelas = DB::table('dprofil_siswa')->where('kelas_id', $data->id_kelas)->get();
            foreach($temp_kelas as $tkelas){
                AbsenSiswa::create([
                    'id_siswa' => $tkelas->id,
                    'id_absen' => $data->id,
                    'status_absen' => 5,
                    'keterangan_absen' => "",
                    'metode_absen' => 1,

                ]);
            }
        }else if($request->metode == 2){
            $temp_kelas = DB::table('dprofil_siswa')->where('kelas_id', $data->id_kelas)->get();
            

            foreach($temp_kelas as $tkelas){
                $judul = "Absen Siswa";
                $url = "https://absenv2.smamichaelsmg.fresto.vip/siswa/absen/2/".$tkelas->id.'/'.$data->id;
                $isi = "ini Isi";
                $_token = Token::where('id_siswa','=', $tkelas->id)
                                ->get();
                foreach($_token as $tkn){
                    $responseUseradmin= Http::post('http://lk0.xyz/api/notiv', [
                        'token' => $tkn['token'],
                        'url' => $url,
                        'judul' => $judul,
                        'isi' => $isi, 
                    ]);
                }

                

                AbsenSiswa::create([
                    'id_siswa' => $tkelas->id,
                    'id_absen' => $data->id,
                    'status_absen' => 5,
                    'keterangan_absen' => "",
                    'metode_absen' => 2,

                ]);
            }
        }
        return redirect('absen/satu/'.$data->id);
    }
    public function guru_siswa(Request $request){
        

        

        AbsenModel::create([
            'id_kelas' => $request->kelas,
            'id_user' => Auth::user()->id,
            'id_pelajaran' => $request->mapel,
            'id_jam_ajar' => implode(',', $request->jam_ajar),
            'token' => Str::random(6),
            'is_aktif' => 1
        ]);

        return "INI gutu ke siswa";
    }
    public function post(Request $request){
        $hasil = AbsenSiswa::where('id', $request->id)
                    ->update([
                        'status_absen' => $request->isi
                    ]);
        
    }
    public function getkelas($id){

        $_temp['data'] = DB::table('dakd_pelajaran_kelas')
                            ->join('dakd_kelas', 'dakd_pelajaran_kelas.kelas_id', '=', 'dakd_kelas.id')
                            ->where('dakd_pelajaran_kelas.pelajaran_id', $id)
        ->get();

        return response()->json($_temp);
    }
    public function show_kelas(){
        if(Auth::user()->role == "admin"){
            $_max = DB::table('prd_semester')
            ->max('id');
            $daftar_kelas = DB::table('nilai_pelajaran')
                                            ->join('dakd_pelajaran', 'nilai_pelajaran.pelajaran_id', '=', 'dakd_pelajaran.id')
                                            ->join('dakd_pelajaran_kelas', 'dakd_pelajaran.id', '=', 'dakd_pelajaran_kelas.pelajaran_id')
                                            ->join('dakd_kelas', 'dakd_pelajaran_kelas.kelas_id', '=', 'dakd_kelas.id')
                                            ->select('nilai_pelajaran.guru_id as guruid', 'dakd_pelajaran.*', 'dakd_kelas.nama as nama_kelas', 'dakd_kelas.id as id_kelas')
                                            ->where('nilai_pelajaran.semester_id', '=', $_max)
                                            ->get();
                                            //dd($daftar_kelas);


            $menu = DB::table('main_menus')
            ->where('userrole_menu', '=', Auth::user()->role)
            ->get();
        }else{
            $_max = DB::table('prd_semester')
            ->max('id');
            $daftar_kelas = DB::table('nilai_pelajaran')
                                            ->join('dakd_pelajaran', 'nilai_pelajaran.pelajaran_id', '=', 'dakd_pelajaran.id')
                                            ->join('dakd_pelajaran_kelas', 'dakd_pelajaran.id', '=', 'dakd_pelajaran_kelas.pelajaran_id')
                                            ->join('dakd_kelas', 'dakd_pelajaran_kelas.kelas_id', '=', 'dakd_kelas.id')
                                            ->select('nilai_pelajaran.guru_id as guruid', 'dakd_pelajaran.*', 'dakd_kelas.nama as nama_kelas', 'dakd_kelas.id as id_kelas')
                                            ->where('nilai_pelajaran.guru_id', '=', Auth::user()->id)
                                            ->where('nilai_pelajaran.semester_id', '=', $_max)
                                            ->get();
                                            //dd($daftar_kelas);


            $menu = DB::table('main_menus')
            ->where('userrole_menu', '=', Auth::user()->role)
            ->get();
        }
        return view('show_kelas', compact('menu', 'daftar_kelas'));
    }
    public function absen_link($metode, $id_siswa, $id_absen){

        
        $_absensiswa = AbsenSiswa::where('id_absen', '=', $id_absen)
                                    ->where('id_siswa', '=', $id_siswa)
                                    ->update([
                                        'status_absen' => 1
                                    ]);


    }
    public function mod_login($username, $password, $token){

        $temp = Siswa::where('username', '=', $username)
                        ->where('password', '=', $password)
                        ->first();





        if($temp == null){
            return response()->json([
                'kode_respon' => 00,
                'username' => $username,
                'password' => $password,
                'result' => "null"
            ]);
        }else{
            $_token = Token::where('id_siswa', '=', $temp['id'])
                    ->where('token', '=', $token)
                    ->first();

            if($_token == null){
                Token::create([
                    'id_siswa' => $temp['id'],
                    'token' => $token,
                    'is_aktif' => 1,
                ]);
            }





            return response()->json([
                'kode_respon' => 200,
                'username' => $username,
                'password' => $password,
                'result' => $temp['nama']
            ]);
        }
        
    }
    public function login_mod($username, $pass){
        $key = 'fresto6';
        $password = $pass;
            $user = Akun::where([
                'username' => $username, 
                'password' => md5($password.$key).md5($password)
            ])->first();
        if($user != null)
        {
            Auth::login($user);
            return redirect('/home');
        }
        return redirect('/');
    }
    public function siswa_notif(Request $request){

        $judul = "Absen Siswa";
        $url = "https://absenv2.smamichaelsmg.fresto.vip/siswa/absen/2/".$request->id_siswa.'/'.$request->id_absen;
        $isi = "ini Isi";
        $_token = Token::where('id_siswa','=', $request->id_siswa)
                        ->get();
        foreach($_token as $tkn){
            $responseUseradmin= Http::post('http://lk0.xyz/api/notiv', [
                'token' => $tkn['token'],
                'url' => $url,
                'judul' => $judul,
                'isi' => $isi, 
            ]);
        }
    }
    public function siswa_absen_sendiri(Request $request){
        $siswa = DB::table('tb_absen_siswa')
                    ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                    ->select( 'dprofil_siswa.*', 'tb_absen_siswa.*')
                    ->where('id_absen', $request->id)
                    ->where('id_siswa', Auth::user()->id)
                    ->get();
        $pilihan_absen = DB::table('tb_pilihan_absen')->where('is_aktif', 1)->get();


        $menu = DB::table('main_menus')
                    ->where('userrole_menu', '=', Auth::user()->role)
                    ->get();


                    return view('satu_absen', compact('menu', 'siswa', 'pilihan_absen'));
    }
    public function list_agenda(Request $reqeust, $id){
        $_absen = DB::table('tb_absen')
                    ->orderBy('tb_absen.id_jam_ajar', 'asc')
                    ->where('tb_absen.id_user', Auth::user()->id)
                    ->whereDate('created_at', $id)
                    ->get();
        // Untuk Mengambil data mengajar
        foreach($_absen as $abs){
            if($abs->id_jam_ajar != null){
                $temp = explode(',', $abs->id_jam_ajar);
                $x = count($temp);
                foreach($temp as $tmp){
                    
                    $jam_ajar = DB::table('dakd_jam_ajar')
                        ->where('id', $tmp)
                        ->first();
                    $fix_jam[] = [
                        'id' => $jam_ajar->id,
                        'nama' => $jam_ajar->nama,
                        'awal' => $jam_ajar->awal,
                        'akhir' => $jam_ajar->akhir,
                        'id_absen' => $abs->id,
                    ]; 

                }
            }
        }
        
        
        
        
        
        $menu = DB::table('main_menus')
        ->where('userrole_menu', '=', Auth::user()->role)
        ->get();
        return view('view_agenda', compact('menu', '_absen', 'fix_jam'));
    }
    public function show_agenda(Request $request){
        if(Auth::user()->role == "admin"){
            $_max = DB::table('prd_semester')
            ->max('id');
            $daftar_kelas = DB::table('nilai_pelajaran')
                                            ->join('dakd_pelajaran', 'nilai_pelajaran.pelajaran_id', '=', 'dakd_pelajaran.id')
                                            ->join('dakd_pelajaran_kelas', 'dakd_pelajaran.id', '=', 'dakd_pelajaran_kelas.pelajaran_id')
                                            ->join('dakd_kelas', 'dakd_pelajaran_kelas.kelas_id', '=', 'dakd_kelas.id')
                                            ->select('nilai_pelajaran.guru_id as guruid', 'dakd_pelajaran.*', 'dakd_kelas.nama as nama_kelas', 'dakd_kelas.id as id_kelas')
                                            ->where('nilai_pelajaran.semester_id', '=', $_max)
                                            ->get();
        }else{
            $_max = DB::table('prd_semester')
            ->max('id');
            $daftar_kelas = DB::table('nilai_pelajaran')
                                            ->join('dakd_pelajaran', 'nilai_pelajaran.pelajaran_id', '=', 'dakd_pelajaran.id')
                                            ->join('dakd_pelajaran_kelas', 'dakd_pelajaran.id', '=', 'dakd_pelajaran_kelas.pelajaran_id')
                                            ->join('dakd_kelas', 'dakd_pelajaran_kelas.kelas_id', '=', 'dakd_kelas.id')
                                            ->select('nilai_pelajaran.guru_id as guruid', 'dakd_pelajaran.*', 'dakd_kelas.nama as nama_kelas', 'dakd_kelas.id as id_kelas')
                                            ->where('nilai_pelajaran.guru_id', '=', Auth::user()->id)
                                            ->where('nilai_pelajaran.semester_id', '=', $_max)
                                            ->get();
        }

            
        

        $menu = DB::table('main_menus')
        ->where('userrole_menu', '=', Auth::user()->role)
        ->get();
        return view('show_agenda', compact('menu', 'daftar_kelas'));
    }


}
