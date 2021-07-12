@php
    use Carbon\Carbon;
@endphp
@extends('assets.body')
@section('header', 'View Agenda')
@section('css')


<link rel="stylesheet" type="text/css" href="/app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/data-tables/css/select.dataTables.min.css">


@endsection
@section('konten')
<div class="row">
    <div class="col s12 m12 l12">
        <div id="button-trigger" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">{{Carbon::now()->isoFormat('dddd, D MMMM Y')}}</h4>
                <div class="row">
                    <div class="col s12">
                        <p class="mb-2">Menampilkan Laporan jurnal pada {{Carbon::now()->isoFormat('dddd, D MMMM Y')}}</p>
                    </div>
                    <div class="col s12">
                        <table id="data-table-simple" class="display">
                            <thead>
                                <tr>
                                    <th data-field="id">No.</th>
                                    <th data-field="id">kelas</th>
                                    <th data-field="name">Jam Mengajar</th>
                                    <th data-field="price">Pukul</th>
                                    <th data-field="price">Mapel</th>
                                    <th data-field="total">Guru yang mengajar</th>
                                    <th data-field="status">Materi</th>
                                    <th data-field="status">Siswa tidak masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($fix_jam as $jam)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$jam['nama']}}</td>
                                        <td>{{$jam['nama']}}</td>
                                        <td>{{$jam['awal']}} - {{$jam['akhir']}}</td>
                                        @php
                                            $_absens = DB::table('tb_absen')
                                                    ->join('dprofil_sdm', 'tb_absen.id_user', '=', 'dprofil_sdm.id')
                                                    ->join('dakd_pelajaran', 'tb_absen.id_pelajaran', '=', 'dakd_pelajaran.id')
                                                    ->where('tb_absen.id_user', Auth::user()->id)
                                                    ->where('tb_absen.id', $jam['id_absen'])
                                                    ->select('dprofil_sdm.nama as namauser', 'tb_absen.materi', 'dakd_pelajaran.nama', 'tb_absen.id')
                                                    ->first();


                                                    
                                            if($_absens != null){
                                                    
                                                echo '<td>'.$_absens->nama.'</td>';
                                                echo '<td>'.$_absens->namauser.'</td>';
                                                echo '<td>'.$_absens->materi.'</td>';

                                                $tidak_masuk = DB::table('tb_absen_siswa')
                                                                ->join('dprofil_siswa', 'tb_absen_siswa.id_siswa', '=', 'dprofil_siswa.id')
                                                                ->where('id_absen', $_absens->id)
                                                                ->where('status_absen', '!=', 1)
                                                                ->get();
                                                echo '<td>';
                                                echo '<ol>';

                                                    foreach ($tidak_masuk as $tdk) {
                                                        echo '<li>'.$tdk->nama.'</li>'; 
                                                    }
                                                echo '</ol>';
                                                echo '</td>';
                                            }

                                        @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th data-field="id">No.</th>
                                    <th data-field="name">Jam Mengajar</th>
                                    <th data-field="price">Pukul</th>
                                    <th data-field="price">Mapel</th>
                                    <th data-field="total">Guru yang mengajar</th>
                                    <th data-field="status">Materi</th>
                                    <th data-field="status">Siswa tidak masuk</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')

<script src="/app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
<script src="/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
<script src="/app-assets/vendors/data-tables/js/dataTables.select.min.js"></script>


<script src="/app-assets/js/scripts/data-tables.js"></script>
 


@endsection

@endsection