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
</head>@php
    $id = Auth::user()->id;
    $data = DB::table("dprofil_sdm")->where('id', $id)->first();
    
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
                <th style="width: 18; text-align: center;border: 1px solid black" rowspan="2">Total Kehadiran</th>
                <th colspan="5" style="border: 1px solid black; text-align: center">Agenda</th>
            </tr>
            <tr>
                    <th style="height: 30; text-align: justify; vertical-align: top; border: 1px solid black; width: 38">Jml Pelajaran</th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: green; border: 1px solid black; width: 30"><b>Nama Guru</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: skyblue; border: 1px solid black; width: 30"><b>Materi</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color:red; border: 1px solid black; width: 21"><b>Total Tidak kehadiran</b></th>
                
            </tr>
        </thead>
        <tbody>
        @php $no = 1 @endphp
        @foreach($date as $tanggal)
            <tr>
                <td>{{ $no++ }}</td>
                <td style="text-align: center;">{{ $tanggal['dates'] }}</td>
                <table>
                    <tr></tr>
                    @foreach ($jam_ajar as $jam)
                        <tr>
                            <td>{{$jam->nama}}</td>
                            <td>{{$jam->awal}} - {{$jam->akhir}}</td>
                                @php
                                    $c = 0;
                                    $_data = DB::table('tb_absen')
                                                ->join('dakd_pelajaran', 'tb_absen.id_pelajaran', '=', 'dakd_pelajaran.id')
                                                ->join('dprofil_sdm', 'tb_absen.id_user', '=', 'dprofil_sdm.id')
                                                ->where('tb_absen.id_user', Auth::user()->id)
                                                ->select('tb_absen.*', 'dakd_pelajaran.*', 'dprofil_sdm.nama as namauser', 'tb_absen.id as id_absen_ini')
                                                ->whereDate('tb_absen.created_at', $tanggal['search_date'])
                                                ->get();
                                    // Untuk Jam mengajar
                                  
                                    foreach ($_data as $dt) {
                                        if($dt != null){
                                            if($dt->id_jam_ajar != null){
                                                    $temp = explode(',', $dt->id_jam_ajar);
                                                    $x = count($temp);
                                                    
                                                    foreach ($temp as $asd) {
                                                        if($jam->id == $asd){
                                                            echo '<td>'.$dt->nama.'</td>';
                                                            echo '<td>'.$dt->namauser.'</td>';
                                                            echo '<td>'.$dt->materi.'</td>';
                                                            
                                                            $hasil_absen = DB::table('tb_absen_siswa')
                                                                            ->where('id_absen', $dt->id_absen_ini)
                                                                            ->where('status_absen', '!=', 1)
                                                                            ->count();
                                                            echo '<td>'.$hasil_absen.'</td>';


                                                        }
                                                    }
                                                   
                                            }
                                        }
                                        $total_tidak_hadir = null;
                                    }
                                 
                                    $temp = null;
                                    $_data = null;
                                    // Untuk Nama Mapel
                                @endphp
                            
                        </tr>
                        <td></td>
                    @endforeach
                </table>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>