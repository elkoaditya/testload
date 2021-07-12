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
                <th style="width: 60; text-align: center;border: 1px solid black" rowspan="2">Nama Siswa</th>
                <th style="width: 15; text-align: center;border: 1px solid black" rowspan="2">NISN</th>
                @foreach ($date as $tgl)
                    <th colspan="3" style="border: 1px solid black; text-align: center">{{$tgl->date}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($date as $tgl)
                    <th style="height: 30; text-align: justify; vertical-align: top; border: 1px solid black">Jml Pelajaran</th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: green; border: 1px solid black; width: 5"><b>M</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: skyblue; border: 1px solid black; width: 30"><b>Keterangan</b></th>
                @endforeach
                
            </tr>
        </thead>
        <tbody>
        @php $no = 1 @endphp
        @foreach($siswa as $user)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $user->namasiswa }}</td>
                <td>
                    {{$user->nis}}  
                </td>
                @foreach ($date as $tanggal)
                <td>
                    @php
                     $angka = DB::table('tb_absen_siswa')
                    ->selectRaw('count(*) as total')
                    ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                    ->where('id_user', Auth::user()->id)
                    ->where('id_siswa', $user->id_siswa)
                    ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                    ->first();
                        if($angka->total == 0){
                           echo "Kosong ";
                        }else{
                            echo $angka->total;
                        }
                    @endphp
                </td>
                    @php
                        $angka = null;
                            $angka = DB::table('tb_absen_siswa')
                        ->selectRaw('count(*) as total')
                        ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                        ->where('id_user', Auth::user()->id)
                        ->where('id_siswa', $user->id_siswa)
                        ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                        ->where('status_absen', 1)
                        ->first();
                            $angka1 = DB::table('tb_absen_siswa')
                                ->selectRaw('count(*) as total')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();
                        if($angka1->total == $angka->total){
                            echo '<td style="background-color: green;">M</td>';
                            
                            echo "<td>";
                            $temp = null;
                            $temp = DB::table('tb_absen_siswa')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->select('tb_absen.*', 'tb_absen_siswa.updated_at as updated_at')
                                ->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();
                                    

                                $createdAt = Carbon::parse($temp->updated_at);

                                $createdAt = $createdAt->format('H:i:s');

                                echo $createdAt;

                            echo "</td>";
                        }else{
                            echo "<td></td>";
                            echo "<td>";
                            $temp = null;
                            $temp = DB::table('tb_absen_siswa')
                                ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                ->select('tb_absen.*', 'tb_absen_siswa.updated_at as updated_at')
                                ->where('id_user', Auth::user()->id)
                                ->where('id_siswa', $user->id_siswa)
                                ->whereDate('tb_absen_siswa.created_at', $tanggal->date)
                                ->first();
                                $createdAt = Carbon::parse($temp->updated_at);

                                $createdAt = $createdAt->format('H:i:s');

                                echo $createdAt;
                            echo "</td>";
                        }


                        
                    @endphp
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>