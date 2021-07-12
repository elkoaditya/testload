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
<body>
    <table>
        <tr>
            <td>
                Bulan : 
            </td>
            <td>
                January
            </td>
        </tr>
        <tr>
            <td>
                Kelas : 
            </td>
            <td>
                XII B
            </td>
        </tr>
        <tr>
            <td>
                Walikelas :
            </td>
            <td>
                Pak Budi
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
                @foreach ($date as $tgl)
                    <th colspan="5" style="border: 1px solid black; text-align: center">{{$tgl['dates']}}</th>
                @endforeach
            </tr>
            <tr>
                    <th style="height: 30; text-align: justify; vertical-align: top; border: 1px solid black">Jml Pelajaran</th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: green; border: 1px solid black; width: 5"><b>M</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: skyblue; border: 1px solid black; width: 5"><b>I</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color:yellow; border: 1px solid black; width: 5"><b>S</b></th>
                    <th style="height: 30; text-align: center; vertical-align: top; background-color: red; border: 1px solid black; width: 5"><b>A</b></th>    
                
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
                            <td>
                                @php



                                    $_data = DB::table('tb_absen')
                                                ->join('dakd_pelajaran', 'tb_absen.id_pelajaran', '=', 'dakd_pelajaran.id')
                                                ->whereDate('tb_absen.created_at', $tanggal['search_date'])
                                                ->first();

                                    

                                    if($_data != null){
                                        if($_data->id_jam_ajar != null){
                                                $temp = explode(',', $_data->id_jam_ajar);
                                                foreach ($temp as $asd) {
                                                    if($jam->id == $asd){
                                                        echo $_data->nama;
                                                    }
                                                    
                                                }
                                        }
                                        
                                    }
                                    $temp = null;
                                    $_data = null;
                                    
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                </table>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>