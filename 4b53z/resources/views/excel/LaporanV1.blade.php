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
    $id = Auth::user()->id;
    $data = DB::table("dprofil_sdm")->where('id', $id)->first();

    if($data == null){
        $data = DB::table("dprofil_admin")->where('id', $id)->first();

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
                Walikelas :
            </td>
            <td>
                {{$data->nama}}
            </td>
        </tr>
    </table>
    
    
    <table style="border: 1px solid black">
        <thead>
            <tr>
                <th style="width: 10;border: 1px solid black" rowspan="2">No</th>
                <th style="width: 30; text-align: center;border: 1px solid black" rowspan="2">Tanggal dan Hari</th>
                <th style="width: 15; text-align: center;border: 1px solid black" rowspan="2">Jam ke</th>
                <th style="width: 20; text-align: center;border: 1px solid black" rowspan="2">Pukul Kehadiran</th>
                <th style="width: 25; text-align: center;border: 1px solid black" rowspan="2">Nama Pelajaran</th>
                <th colspan="2" style="border: 1px solid black; text-align: center">Kegiatan Belajar Mengajar</th>
                <th colspan="4" style="border: 1px solid black; text-align: center; width: 23">Absensi Kehadiran</th>
            </tr>
            <tr>
                    <th style="height: 30; text-align: justify; vertical-align: top; border: 1px solid black; width: 38; text-align: center;">Guru Pengajar</th>
                    <th style="height: 30; text-align: center; vertical-align: top; border: 1px solid black; width: 30; text-align: center;"><b>Materi</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color:red; border: 1px solid black; width: 7;    text-align: center;"><b>Absen</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color:green; border: 1px solid black; width: 7; text-align: center;"><b>Masuk</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color:aqua; border: 1px solid black; width: 7; text-align: center;"><b>Semua</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color:wheat; border: 1px solid black; width: 8; text-align: center;"><b>%</b></th>
                
            </tr>
        </thead>
        <td style="text-align: center;" colspan="10"></td>
        <tbody>
        @php $no = 1 @endphp
        @foreach($date as $tanggal)
            @php 
            $_is_same = 0; 
            $_no = 0;
            @endphp

            @php
                        
                if(Auth::user()->role == "admin"){
                    $_absen = DB::table('tb_absen')
                        ->where('id_kelas', $id_kelas)
                        //->where('id_user', Auth::user()->id)
                        ->whereDate('created_at', $tanggal['search_date'])
                        ->get();
                }else{
                    $_absen = DB::table('tb_absen')
                        ->where('id_kelas', $id_kelas)
                        ->where('id_user', Auth::user()->id)
                        ->whereDate('created_at', $tanggal['search_date'])
                        ->get();
                }

                $fix_jam_ajar = [];
                foreach ($_absen as $hav_absen) {
                    
                        if(isset($hav_absen->id_jam_ajar)){
                        $_jam_ajar = explode(',', $hav_absen->id_jam_ajar);
                        foreach($_jam_ajar as $_jm){
                        $_ajar = DB::table('dakd_jam_ajar')
                            ->where('id', '=', $_jm)
                            ->first();
                            //dd($_ajar);
                        array_push($fix_jam_ajar, [
                            "id" => $_ajar->id,
                            "nama" => $_ajar->nama,
                            "awal" => $_ajar->awal,
                            "akhir" => $_ajar->awal,
                        ]);
                    }
                    }else{
                        
                    }
                }
                
                //dd($fix_jam_ajar);


                //dd($_absen);
            @endphp

            @foreach ($fix_jam_ajar as $ajar)
                <tr>
                    @php
                        if($_no == 0){
                                echo '<td style="text-align: center; word-wrap:break-word; vertical-align: center;" rowspan="'.count($fix_jam_ajar).'">'.$no.'</td>';
                                $_no++;
                        }
                    @endphp
                    @php
                        if($_is_same == 0){
                            echo '<td style="text-align: center; word-wrap:break-word; vertical-align: center;" rowspan="'.count($fix_jam_ajar).'">'.$tanggal['dates'].'</td>';
                            $no++;
                            $_is_same = 1;
                        }
                        
                    @endphp
                    <td>{{$ajar['nama']}}</td>
                    <td>{{$ajar['awal']}} - {{$ajar['akhir']}}</td>
                    @php
                        if(Auth::user()->role == "admin"){
                            $_data = DB::table('tb_absen')
                                ->join('dakd_pelajaran', 'tb_absen.id_pelajaran', '=', 'dakd_pelajaran.id')
                                ->join('dprofil_sdm', 'tb_absen.id_user', '=', 'dprofil_sdm.id')
                                ->where('id_kelas', $id_kelas)
                                ->select('tb_absen.*', 'dakd_pelajaran.*', 'dprofil_sdm.nama as namauser', 'tb_absen.id as id_absen_ini')
                                ->whereDate('tb_absen.created_at', $tanggal['search_date'])
                                ->get();

                                
                            // if($_data == null){
                            //     $_data = DB::table('tb_absen')
                            //     ->join('dakd_pelajaran', 'tb_absen.id_pelajaran', '=', 'dakd_pelajaran.id')
                            //     ->join('dprofil_admin', 'tb_absen.id_user', '=', 'dprofil_admin.id')
                            //     ->where('id_kelas', $id_kelas)
                            //     ->select('tb_absen.*', 'dakd_pelajaran.*', 'dprofil_admin.nama as namauser', 'tb_absen.id as id_absen_ini')
                            //     ->whereDate('tb_absen.created_at', $tanggal['search_date'])
                            //     ->first();
                            // }

                                //dd($_data);
                        }else{
                            $_data = DB::table('tb_absen')
                                ->join('dakd_pelajaran', 'tb_absen.id_pelajaran', '=', 'dakd_pelajaran.id')
                                ->join('dprofil_sdm', 'tb_absen.id_user', '=', 'dprofil_sdm.id')
                                ->where('id_kelas', $id_kelas)
                                ->where('tb_absen.id_user', Auth::user()->id)
                                ->select('tb_absen.*', 'dakd_pelajaran.*', 'dprofil_sdm.nama as namauser', 'tb_absen.id as id_absen_ini')
                                ->whereDate('tb_absen.created_at', $tanggal['search_date'])
                                ->get();
                        }
                                
                                foreach ($_data as $hav_data) {
                                        if($_data != null){
                                        //dd($_data);
                                        $temp = explode(',', $hav_data->id_jam_ajar);
                                            foreach ($temp as $asd) {
                                                if($ajar['id'] == $asd){
                                                    $materi = htmlspecialchars($hav_data->materi);

                                                    echo "<td style='text-align: center;'>".$hav_data->kode."</td>";
                                                    echo "<td style='text-align: center;'>".$hav_data->namauser."</td>";
                                                    echo "<td style='text-align: center;'>"."$materi"."</td>";
                                                    $hasil_absen_tidakhadir = DB::table('tb_absen_siswa')
                                                                    ->where('id_absen', $hav_data->id_absen_ini)
                                                                    ->where('status_absen', '!=', 1)
                                                                    ->count();
                                                    $hasil_absen_hadir = DB::table('tb_absen_siswa')
                                                                    ->where('id_absen', $hav_data->id_absen_ini)
                                                                    ->where('status_absen', '=', 1)
                                                                    ->count();
                                                    $hasil_absen_semua = DB::table('tb_absen_siswa')
                                                                    ->where('id_absen', $hav_data->id_absen_ini)
                                                                    ->count();
                                                    //$hasil_persen = ($hasil_absen_hadir / $hasil_absen_semua) * 100;

                                                    if($hasil_absen_hadir == null){
                                                        $hasil_absen_hadir = 0;
                                                    }
                                                    if($hasil_absen_semua == null){
                                                        $hasil_absen_semua = 0;
                                                    }

                                                    $hasil_persen = @($hasil_absen_hadir / $hasil_absen_semua) * 100;
                                                    
                                                    
                                                    echo "<td style='text-align: center;'>".$hasil_absen_tidakhadir.'</td>';
                                                    echo "<td style='text-align: center;'>".$hasil_absen_hadir.'</td>';
                                                    echo "<td style='text-align: center;'>".$hasil_absen_semua.'</td>';
                                                    if ($hasil_persen < 70) {
                                                        echo "<td style='text-align: center; background-color: red'>".round($hasil_persen,2).' %'.'</td>';
                                                    }else{
                                                        echo "<td style='text-align: center; background-color: green'>".round($hasil_persen,2).' %'.'</td>';
                                                    }
                                                }else{
                                                    
                                                }
                                            }
                                        //echo "<td>".$_data->nama."</td>";
                                    }else {
                                        echo "<td></td>";
                                    }
                                }
                    @endphp
                
                </tr>
            @endforeach
            @php $_is_same = null; @endphp
            
        @endforeach
        </tbody>
    </table>
</body>
</html>