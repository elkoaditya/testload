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
                <th style="width: 15; text-align: center;border: 1px solid black" rowspan="2">Jenis Kelamin</th>
                @foreach ($date as $tgl)
                    <th colspan="5" style="border: 1px solid black; text-align: center">
                        @php
                        $createdAt = Carbon::parse($tgl->date);

                        $createdAt = $createdAt->isoFormat('dddd, D MMMM Y');

                        echo $createdAt;
                    @endphp    
                    </th>
                @endforeach
            </tr>
            <tr>
                @foreach ($date as $tgl)
                    <th style="height: 30; text-align: justify; vertical-align: top; border: 1px solid black">Jml Pelajaran</th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: green; border: 1px solid black; width: 5"><b>M</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: skyblue; border: 1px solid black; width: 5"><b>I</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color:yellow; border: 1px solid black; width: 5"><b>S</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: red; border: 1px solid black; width: 5"><b>A</b></th>    
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
                    
                    @if ($user->kelamin == "p")
                        Laki - laki
                    @else
                     Perempuan   
                    @endif    
                </td>
                @foreach ($date as $tanggal)
                <td>
                    @php
                     $angka = DB::table('tb_absen_siswa')
                    ->selectRaw('count(*) as total')
                    ->where('id_siswa', $user->id_siswa)
                    ->whereDate('created_at', $tanggal->date)
                    ->first();
                        if($angka->total == 0){
                           echo "Kosong ";
                        }else{
                            echo $angka->total;
                        }
                    @endphp
                </td>
                <td>
                    @php
                    $angka = null;
                        $angka = DB::table('tb_absen_siswa')
                    ->selectRaw('count(*) as total')
                    ->where('id_siswa', $user->id_siswa)
                    ->whereDate('created_at', $tanggal->date)
                    ->where('status_absen', 1)
                    ->first();
                    echo $angka->total;
                    @endphp
                </td>
                <td>
                    @php
                    $angka = null;
                        $angka = DB::table('tb_absen_siswa')
                    ->selectRaw('count(*) as total')
                    ->where('id_siswa', $user->id_siswa)
                    ->whereDate('created_at', $tanggal->date)
                    ->where('status_absen', 3)
                    ->first();
                    echo $angka->total;
                    @endphp
                </td>
                <td>
                    @php
                    $angka = null;
                        $angka = DB::table('tb_absen_siswa')
                    ->selectRaw('count(*) as total')
                    ->where('id_siswa', $user->id_siswa)
                    ->whereDate('created_at', $tanggal->date)
                    ->where('status_absen', 4)
                    ->first();
                    echo $angka->total;
                    @endphp
                </td>
                <td>
                    @php
                    $angka = null;
                        $angka = DB::table('tb_absen_siswa')
                    ->selectRaw('count(*) as total')
                    ->where('id_siswa', $user->id_siswa)
                    ->whereDate('created_at', $tanggal->date)
                    ->where('status_absen', 5)
                    ->first();
                    echo $angka->total;
                    @endphp
                </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>