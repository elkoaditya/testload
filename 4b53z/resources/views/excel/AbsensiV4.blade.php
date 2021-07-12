@php
    $_absen_temp = DB::table('tb_absen_siswa')
                                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                            ->where('id_siswa', 1147)
                                            ->where('status_absen', 1)
                                            ->first();

                                            //dd($_absen_temp);
@endphp





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
            <th colspan="10" style="font-size: 25px;" align="center"><h1>Laporan Absensi Harian ( {{APP_TITLE}} )</h1></th>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="2">
                Hari Tanggal : @php
                $createdAt = Carbon::parse($today);

                $createdAt = $createdAt->isoFormat('dddd, D MMMM Y');

                echo $createdAt;
            @endphp 
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Downloaded by : {{$data->nama}}
            </td>
        </tr>
    </table>
    
    @php
    $oo = 0;
    @endphp
    
    <table style="border: 1px solid black;">
        <thead>
            <tr>
                <th style="width: 10;border: 1px solid black" rowspan="3">No</th>
                <th style="width: 60; text-align: center;border: 1px solid black; vertical-align: center;font-size: 20px;" rowspan="3">Nama Siswa</th>
                <th style="width: 15; text-align: center;border: 1px solid black;text-align: center; vertical-align: center;font-size: 15px;" rowspan="3">NISN</th>
                @foreach ($date as $tgl)
                    <th colspan="{{count($fix_jam_ajar)*3+4}}" style="border: 1px solid black; text-align: center;font-size: 12px;" >{{Carbon::parse($tgl->date)->isoFormat('dddd, D MMMM Y')}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($date as $tgl)
                    @foreach ($fix_jam_ajar as $jam_ajar)
                        <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 15px; vertical-align: center;text-align: center" colspan="3">{{$jam_ajar['nama']}}</th>
                    @endforeach
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: lightskyblue;" rowspan="2">Total Mapel Masuk</th>
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: lightskyblue;" rowspan="1">TOTAL TIDAK MASUK MAPEL</th>
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: lightskyblue;" rowspan="2">ALPHA</th>
                    <th style="height: 60; text-align: justify; vertical-align: top; border: 1px solid black; font-size: 13px; vertical-align: center;text-align: center; width: 16px; word-wrap:break-word; background-color: lightskyblue;" rowspan="2">TERLAMBAT</th>
                @endforeach
                
            </tr>
            <tr>
                @foreach ($date as $tgl)
                    @foreach ($fix_jam_ajar as $jam_ajar)
                        <th style="text-align: center; vertical-align: center; border: 1px solid black; width: 9px;font-size: 12px;">Masuk</th>
                        <th style="text-align: center; vertical-align: center; border: 1px solid black; width: 9px;font-size: 12px;">Alpha</th>
                        <th style="text-align: center; vertical-align: center; border: 1px solid black; width: 9px;font-size: 12px;">Waktu</th>
                    @endforeach
                @endforeach
                
            </tr>
        </thead>
        <tbody style="border: 1px solid black;">
        @php $no = 1 @endphp
        @foreach($siswa as $user)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $user->namasiswa }}</td>
                <td>
                    {{$user->nis}}  
                </td>
                @foreach ($date as $tanggal)
                        @php
                            $angka = DB::table('tb_absen_siswa')
                            ->selectRaw('count(*) as total')
                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                            //->where('id_user', Auth::user()->id)
                            ->where('id_siswa', $user->id_siswa)
                            ->where('status_absen', 1)
                            ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                            ->first();

                            $_absen_temp = DB::table('tb_absen_siswa')
                                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                                ->where('id_siswa', $user->id_siswa)
                                                ->where('status_absen', 1)
                                                ->first();

                            foreach ($fix_jam_ajar as $key) {
                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                //->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '=',1)
                                ->where('tb_absen.id', $key['id_absen'])
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                if($angka->total != 0){
                                    echo "<td style='background-color: green;text-align: center; vertical-align: center;border: 1px solid black;'>".$angka->total."</td>";
                                }else{
                                    echo "<td></td>";
                                }

                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                //->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '!=', 1)
                                ->where('tb_absen.id', $key['id_absen'])
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                if($angka->total != 0){
                                    echo "<td style='background-color: red;text-align: center; vertical-align: center;border: 1px solid black;'>".$angka->total."</td>";
                                }else{
                                    echo "<td></td>";
                                }

                                $angka = DB::table('tb_absen_siswa')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                //->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('tb_absen.id', $key['id_absen'])
                                ->select('tb_absen_siswa.updated_at as dibikin', 'tb_absen_siswa.*')
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();
                                //dd($angka);
                                $createdAt = Carbon::parse($angka->dibikin);

                                $createdAt = $createdAt->format('H:i');
                                if($angka->late == null){
                                    echo "<td style='text-align: center; vertical-align: center;border: 1px solid black;'>".$createdAt."</td>";
                                }else{
                                    echo "<td style='text-align: center; vertical-align: center;border: 1px solid black; background-color: red;'>".$createdAt."</td>";

                                }


                                

                                
                            }
                                
                                                
                        @endphp
                        
                    
                        
                    @endforeach

                    @php
                                if(Auth::user()->role == "admin"){
                                    $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                //->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '=', 1)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";

                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                //->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '!=', 1)
                                //->where('status_absen', '!=', 5)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                if($angka->total == 0){
                                    echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }else{
                                    echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }

                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                //->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '=', 5)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                //dd($angka);

                                if($angka->total == 0){
                                    echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }else{
                                    echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }

                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                //->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('tb_absen_siswa.late', '=', 1)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                

                                if($angka->total == 0){
                                    echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }else{
                                    echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }
                                }else{
                                    $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '=', 1)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";

                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '!=', 1)
                                //->where('status_absen', '!=', 5)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                if($angka->total == 0){
                                    echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }else{
                                    echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }

                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('status_absen', '=', 5)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                //dd($angka);

                                if($angka->total == 0){
                                    echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }else{
                                    echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }

                                $angka = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->where('tb_absen_siswa.late', '=', 1)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();

                                

                                if($angka->total == 0){
                                    echo "<td style='background-color: lightskyblue;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }else{
                                    echo "<td style='background-color: red;border: 1px solid black;text-align: center; vertical-align: center;'>".$angka->total."</td>";
                                }
                                }
                    @endphp

                    
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
