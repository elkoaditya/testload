<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <style>
        .garsi, th{
            border: 1px solid black;
        }
    </style>
</head>
@php
     use Carbon\Carbon;
@endphp
@php
    $id = Auth::user()->id;
    if(Auth::user()->role == "admin"){
        $data = DB::table("dprofil_admin")->where('id', $id)->first();
    }else{
        $data = DB::table("dprofil_sdm")->where('id', $id)->first();
    }
    
    $nama_kelas = DB::table("dakd_kelas")->where('id', $id_kelas)->first();
@endphp
<body>
    <table>
        <tr>
            <td>
                Kelas : 
            </td>
            <td>
                {{$nama_kelas->nama}}
            </td>
        </tr>
        <tr>
            <td>
                Downloaded :
            </td>
            <td>
                {{$data->nama}}
            </td>
        </tr>
    </table>
    
    
    <table style="border: 1px solid black">
        <thead>
            <tr>
                <th style="width: 10;border: 1px solid black; text-align: center; width: 16px; word-wrap:break-word; vertical-align: center; text-align: center; word-wrap:break-word; font-size: 25px;" rowspan="3">No</th>
                <th style="width: 60; text-align: center;border: 1px solid black; text-align: center; word-wrap:break-word; vertical-align: center;" rowspan="3">Nama Siswa</th>
                <th style="width: 10; text-align: center;border: 1px solid black; text-align: center; word-wrap:break-word; vertical-align: center;" rowspan="3">NIS</th>
                <th style="width: 15; text-align: center;border: 1px solid black; text-align: center; word-wrap:break-word; vertical-align: center;" rowspan="3">Jenis Kelamin</th>
                <th style="width: 10; text-align: center;border: 1px solid black; text-align: center; word-wrap:break-word; vertical-align: center;" rowspan="3">Total Kehadiran</th>
                @foreach ($date as $tgl)

                @php
                $_data = DB::table('tb_absen')
                //->where('id_user', Auth::user()->id)
                ->whereDate('tb_absen.created_at', '=', $tgl)
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
                        if($ajar != null){
                            array_push($jam_ajar, [
                            "nama" => $ajar->nama,
                            "id" => $_jm,
                            "id_absen" => $jm->id,
                        ]);
                        }
                    }
                }

                //dd($jam_ajar);
                @endphp
                    <th colspan="{{count($jam_ajar)*3+3+1}}" style="border: 1px solid black; text-align: center;font-size: 12px;">{{$tgl}}</th>
                @endforeach
                <th style="text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: palegreen;" rowspan="3">Total Mapel Masuk Sebulan</th>
                <th style="text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: palegreen;" rowspan="3">TOTAL TIDAK MASUK MAPEL Sebulan</th>
                <th style="text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: palegreen;" rowspan="3">Total ALPHA Sebulan</th>
                <th style="text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: palegreen;" rowspan="3">Total TERLAMBAT Sebulan</th>
            </tr>
            <tr>
                @foreach ($date as $tgl)

                @php
                $_data = DB::table('tb_absen')
                //->where('id_user', Auth::user()->id)
                ->whereDate('tb_absen.created_at', '=', $tgl)
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
                        if($ajar != null){
                            array_push($jam_ajar, [
                            "nama" => $ajar->nama,
                            "id" => $_jm,
                            "id_absen" => $jm->id,
                        ]);
                        }
                    }
                }

                //dd($jam_ajar);
                @endphp



                @foreach ($jam_ajar as $ajr)
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 15px; vertical-align: center;text-align: center" colspan="3">{{$ajr['nama']}}</th>
                @endforeach
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: lightskyblue;" rowspan="2">Total Mapel Masuk</th>
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: lightskyblue;" rowspan="2">TOTAL TIDAK MASUK MAPEL</th>
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: lightskyblue;" rowspan="2">ALPHA</th>
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: lightskyblue;" rowspan="2">TERLAMBAT</th>
                @endforeach
                
            </tr>

            <tr>
                @foreach ($date as $tgl)
                @php
                $_data = DB::table('tb_absen')
                //->where('id_user', Auth::user()->id)
                ->whereDate('tb_absen.created_at', '=', $tgl)
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
                        if($ajar != null){
                            array_push($jam_ajar, [
                            "nama" => $ajar->nama,
                            "id" => $_jm,
                            "id_absen" => $jm->id,
                        ]);
                        }
                    }
                }

                //dd($jam_ajar);
                @endphp

                    @foreach ($jam_ajar as $jam_ajar)
                    <th style="text-align: center; vertical-align: center; border: 1px solid black; width: 9px;font-size: 12px;">Masuk</th>
                    <th style="text-align: center; vertical-align: center; border: 1px solid black; width: 9px;font-size: 12px;">Alpha</th>
                    <th style="text-align: center; vertical-align: center; border: 1px solid black; width: 9px;font-size: 12px;">Waktu</th>
                    @endforeach

            @endforeach
            
            </tr>
         
                

        </thead>
        <tbody>
        @php $no = 1 @endphp
        @foreach($siswa as $user)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $user->namasiswa }}</td>
                <td>{{ $user->nis_siswa }}</td>
                <td>
                    
                    @if ($user->kelamin == "l")
                        Laki - laki
                    @else
                     Perempuan   
                    @endif    
                </td>
                <td>
                    @php
                         $angka = DB::table('tb_absen_siswa')
                        ->selectRaw('count(*) as total')
                        ->where('id_siswa', $user->id_siswa)
                        ->whereMonth('created_at', '=', $bulan)
                        ->whereYear('created_at', $tahun)
                        ->first();
                        //dd($angka);

                        $_all = 0;
                        $_angka = null;
                        $_angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->where('id_siswa', $user->id_siswa)
                                ->whereMonth('created_at', $bulan)
                                ->whereYear('created_at', $tahun)
                                ->where('status_absen', 3)
                                ->first();
                                $_all = $_all + $_angka->total;
                        $_angka = null;
                        $_angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->where('id_siswa', $user->id_siswa)
                                ->whereMonth('created_at', $bulan)
                                ->whereYear('created_at', $tahun)
                                ->where('status_absen', 4)
                                ->first();
                                $_all = $_all + $_angka->total;
                        $_angka = null;
                        $_angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->where('id_siswa', $user->id_siswa)
                                ->whereMonth('created_at', $bulan)
                                ->whereYear('created_at', $tahun)
                                ->where('status_absen', 5)
                                ->first();
                                $_all = $_all + $_angka->total;
                                
                    //$angka->total = 100;
                    if($angka->total == 0){
                        $_temp = "Kosong";
                    }else{
                        
                    $_temp = $_all / $angka->total * 100;
                            $_temp = 100 - $_temp;
                    }
                    $_temp = (float)$_temp;
                    echo number_format($_temp,2).'%';
                    $public_masuk = null;
                    $public_tidakmasuk = null;
                    $public_alpha = null;
                    $public_terlambat = null;
                    @endphp
                </td>
                @foreach ($date as $tanggal)

                    @if (Auth::user()->role == "admin")
                        
                            @php
                                $_data = DB::table('tb_absen')
                                //->where('id_user', Auth::user()->id)
                                ->whereDate('tb_absen.created_at', '=', $tanggal)
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
                                        if($ajar != null){
                                            array_push($jam_ajar, [
                                            "nama" => $ajar->nama,
                                            "id" => $_jm,
                                            "id_absen" => $jm->id,
                                        ]);
                                        }
                                    }
                                }

                                //daaaaaaaaaaaaaaaaaaaaaa
                                
                            @endphp

                            @foreach ($jam_ajar as $item)
                                @php
                                    $angka = DB::table('tb_absen_siswa')
                                    ->selectRaw('count(*) as total')
                                    ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                    ->where('id_siswa', $user->id_siswa)
                                    ->where('status_absen', '=', 1)
                                    ->where('tb_absen.id', $item['id_absen'])
                                    ->whereDate('tb_absen_siswa.created_at', $tanggal)
                                    ->first();

                                    if($angka->total != 0){
                                        echo "<td style='background-color: green;text-align: center; vertical-align: center;border: 1px solid black;'>".$angka->total."</td>";
                                    }else{
                                        echo "<td></td>";
                                    }
                                    $public_masuk = $public_masuk + $angka->total;
                                    
                                @endphp
                            
                        
                            @php
                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '!=', 1)
                                ->where('tb_absen.id', $item['id_absen'])
                                ->whereDate('tb_absen_siswa.created_at', $tanggal)
                                ->first();

                                $public_tidakmasuk = $public_tidakmasuk + $angka->total;
                                if($angka->total != 0){
                                    echo "<td style='background-color: red;text-align: center; vertical-align: center;border: 1px solid black;'>".$angka->total."</td>";
                                }else{
                                    echo "<td></td>";
                                }
                                $angka = DB::table('tb_absen_siswa')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_siswa', $user->id_siswa)
                                ->where('tb_absen.id', $item['id_absen'])
                                ->whereDate('tb_absen_siswa.created_at', $tanggal)
                                ->select('tb_absen_siswa.updated_at as dibikin', 'tb_absen_siswa.late')
                                ->first();


                                if(isset($angka->dibikin)){
                                    $createdAt = Carbon::parse($angka->dibikin);
                                    $createdAt = $createdAt->format('H:i');
                                    if($angka->late == null){
                                        echo "<td style='text-align: center; vertical-align: center;border: 1px solid black;'>".$createdAt."</td>";
                                    }else{
                                        echo "<td style='text-align: center; vertical-align: center;border: 1px solid black; background-color: red'>".$createdAt."</td>";
                                    }
                                }else{
                                    echo "<td></td>";
                                }
                                
                            @endphp
                            
                                
                            @endforeach  

                            @php
                                $angka = DB::table('tb_absen_siswa')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->selectRaw('count(*) as total')
                                ->where('id_siswa', $user->id_siswa)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal)
                                ->first();


                                echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";


                            @endphp 
                            @php
                                $angka = DB::table('tb_absen_siswa')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->selectRaw('count(*) as total')
                                ->where('status_absen', '!=', 1)
                                ->where('id_siswa', $user->id_siswa)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal)
                                ->first();


                                if($angka->total == 0){
                                    echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }else{
                                    echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }


                            @endphp
                            @php
                                $angka = DB::table('tb_absen_siswa')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->selectRaw('count(*) as total')
                                ->where('status_absen', '=', 5)
                                ->where('id_siswa', $user->id_siswa)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal)
                                ->first();
                                $public_alpha = $public_alpha + $angka->total;

                                if($angka->total == 0){
                                    echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }else{
                                    echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }


                            @endphp
                            @php
                            $angka = DB::table('tb_absen_siswa')
                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                            ->selectRaw('count(*) as total')
                            ->where('tb_absen_siswa.late', '=', 1)
                            ->where('id_siswa', $user->id_siswa)
                            ->whereDate('tb_absen_siswa.created_at', $tanggal)
                            ->first();
                            $public_terlambat = $public_terlambat + $angka->total;

                            if($angka->total == 0){
                                echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                            }else{
                                echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                            }


                            @endphp

                    @else
                        
                            @php
                            $_data = DB::table('tb_absen')
                            //->where('id_user', Auth::user()->id)
                            ->whereDate('tb_absen.created_at', '=', $tanggal)
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

                            //daaaaaaaaaaaaaaaaaaaaaa
                            
                        @endphp

                        @foreach ($jam_ajar as $item)
                            @php
                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '=', 1)
                                ->where('tb_absen.id', $item['id_absen'])
                                ->whereDate('tb_absen_siswa.created_at', $tanggal)
                                ->first();

                                if($angka->total != 0){
                                    echo "<td style='background-color: green;text-align: center; vertical-align: center;border: 1px solid black;'>".$angka->total."</td>";
                                }else{
                                    echo "<td></td>";
                                }
                                $public_masuk = $public_masuk + $angka->total;
                                
                            @endphp
                        
                    
                        @php
                            $angka = DB::table('tb_absen_siswa')
                            ->selectRaw('count(*) as total')
                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                            ->where('id_user', Auth::user()->id)
                            ->where('id_siswa', $user->id_siswa)
                            ->where('status_absen', '!=', 1)
                            ->where('tb_absen.id', $item['id_absen'])
                            ->whereDate('tb_absen_siswa.created_at', $tanggal)
                            ->first();

                            $public_tidakmasuk = $public_tidakmasuk + $angka->total;
                            if($angka->total != 0){
                                echo "<td style='background-color: red;text-align: center; vertical-align: center;border: 1px solid black;'>".$angka->total."</td>";
                            }else{
                                echo "<td></td>";
                            }
                            $angka = DB::table('tb_absen_siswa')
                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_user', Auth::user()->id)
                            ->where('id_siswa', $user->id_siswa)
                            ->where('tb_absen.id', $item['id_absen'])
                            ->whereDate('tb_absen_siswa.created_at', $tanggal)
                            ->select('tb_absen_siswa.updated_at as dibikin', 'tb_absen_siswa.late')
                            ->first();


                            if(isset($angka->dibikin)){
                                $createdAt = Carbon::parse($angka->dibikin);
                                $createdAt = $createdAt->format('H:i');
                                if($angka->late == null){
                                    echo "<td style='text-align: center; vertical-align: center;border: 1px solid black;'>".$createdAt."</td>";
                                }else{
                                    echo "<td style='text-align: center; vertical-align: center;border: 1px solid black; background-color: red'>".$createdAt."</td>";
                                }
                            }else{
                                echo "<td></td>";
                            }
                            
                        @endphp
                        
                            
                        @endforeach  

                        @php
                            $angka = DB::table('tb_absen_siswa')
                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_user', Auth::user()->id)
                            ->selectRaw('count(*) as total')
                            ->where('id_siswa', $user->id_siswa)
                            ->whereDate('tb_absen_siswa.created_at', $tanggal)
                            ->first();


                            echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";


                        @endphp 
                        @php
                            $angka = DB::table('tb_absen_siswa')
                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                            ->selectRaw('count(*) as total')
                                ->where('id_user', Auth::user()->id)
                            ->where('status_absen', '!=', 1)
                            ->where('id_siswa', $user->id_siswa)
                            ->whereDate('tb_absen_siswa.created_at', $tanggal)
                            ->first();


                            if($angka->total == 0){
                                echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                            }else{
                                echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                            }


                        @endphp
                        @php
                            $angka = DB::table('tb_absen_siswa')
                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                            ->selectRaw('count(*) as total')
                            ->where('status_absen', '=', 5)
                                ->where('id_user', Auth::user()->id)
                            ->where('id_siswa', $user->id_siswa)
                            ->whereDate('tb_absen_siswa.created_at', $tanggal)
                            ->first();
                            $public_alpha = $public_alpha + $angka->total;

                            if($angka->total == 0){
                                echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                            }else{
                                echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                            }


                        @endphp
                        @php
                        $angka = DB::table('tb_absen_siswa')
                        ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                        ->selectRaw('count(*) as total')
                                ->where('id_user', Auth::user()->id)
                        ->where('tb_absen_siswa.late', '=', 1)
                        ->where('id_siswa', $user->id_siswa)
                        ->whereDate('tb_absen_siswa.created_at', $tanggal)
                        ->first();
                        $public_terlambat = $public_terlambat + $angka->total;

                        if($angka->total == 0){
                            echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                        }else{
                            echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                        }


                        @endphp

                    @endif


                @endforeach
                <td style="text-align: justify; vertical-align: top; vertical-align: center;text-align: center; word-wrap:break-word; background-color: palegreen;">{{$public_masuk}}</td>
                <td style="text-align: justify; vertical-align: top; vertical-align: center;text-align: center; word-wrap:break-word; background-color: palegreen;">{{$public_tidakmasuk}}</td>
                <td style="text-align: justify; vertical-align: top; vertical-align: center;text-align: center; word-wrap:break-word; background-color: palegreen;">{{$public_alpha}}</td>
                <td style="text-align: justify; vertical-align: top; vertical-align: center;text-align: center; word-wrap:break-word; background-color: palegreen;">{{$public_terlambat}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>