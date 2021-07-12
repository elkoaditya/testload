@extends('assets.body')
@section('header', 'Dashboard')
@section('css')
    
<link rel="stylesheet" type="text/css" href="/app-assets/css/pages/page-knowledge.css">

<link rel="stylesheet" type="text/css" href="/app-assets/css/custom/custom.css">
@endsection
@section('konten')

@php
    use Carbon\Carbon;
@endphp


    @php
        //dd($_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN);
    @endphp

    <div class="row">
        <div class="row">
            @if (Auth::user()->role == "sdm" || Auth::user()->role == "admin")
            <div class="col s12 m12 l12">
                <div class="section" id="knowledge">
                    <div class="row knowledge-content">
                        <div class="col s12 m3">
                            <div class="card card-hover z-depth-0 card-border-gray">
                                <a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen#change-password">
                                    <div class="card-content center-align">
                                        <h5><b>Buat Absensi</b></h5>
                                        <i class="material-icons md-48 red-text">create</i>
                                        <p class="mb-2 black-text">Buat absensi terbaru</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col s12 m3">
                            <div class="card card-hover z-depth-0 card-border-gray">
                                <a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen#general">
                                    <div class="card-content center-align">
                                        <h5><b>Tampil Absensi</b></h5>
                                        <i class="material-icons md-48 amber-text">storage</i>
                                        <p class="mb-2 black-text">Menampilkan data absensi terkini</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col s12 m3">
                            <div class="card card-hover z-depth-0 card-border-gray">
                                <a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/export">
                                    <div class="card-content center-align">
                                        <h5><b>Laporan Absensi</b></h5>
                                        <i class="material-icons md-48 blue-text">file_download</i>
                                        <p class="mb-2 black-text">Mendownload laporan absensi</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col s12 m3">
                            <div class="card card-hover z-depth-0 card-border-gray">
                                <a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/agenda">
                                    <div class="card-content center-align">
                                        <h5><b>Laporan Jurnal</b></h5>
                                        <i class="material-icons md-48 blue-text">event_available</i>
                                        <p class="mb-2 black-text">Melihat Jurbnal dan Mendownload Journal</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l12">
                <div class="row">
                    <div class="col s12 m12 l4">
                        <div id="profile-card" class="card animate fadeRight">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img class="activator" src="{{ asset('/app-assets/images/gallery/3.png') }}" alt="user bg" />
                            </div>
                            <div class="card-content">
                            <h5 class="card-title activator grey-text text-darken-4">{{Auth::user()->alias}}</h5>
                                <p><i class="material-icons profile-card-i">perm_identity</i>{{Auth::user()->nama}}</p>
                                <p><i class="material-icons profile-card-i">cached</i>{{Auth::user()->login_last}}</p>
                                <p><i class="material-icons profile-card-i">email</i>{{Auth::user()->email}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col s12 m6 l6">
                <div class="card recent-buyers-card animate fadeUp">
                    <div class="card-content">
                        <h4 class="card-title mb-0"><i class="material-icons float-right">more_vert</i></h4>
                        <p class="medium-small pt-2">Today</p>
                        <ul class="collection mb-0">
                            
                            @foreach ($daftar_absen as $siswa)
                                @php
                                    $now = Carbon::now()->format('H:i:s');
                                    $createdAt = Carbon::parse($siswa->jam_awal);
                                    $createdAt = $createdAt->format('H:i:s');
                                    
                                    $Akhir = Carbon::parse($siswa->jam_akhir);
                                    $Akhir = $Akhir->format('H:i:s');

                                    //dd($Akhir);
                                @endphp
                                @if ($now >= $createdAt  && $now <= $Akhir)
                                    <a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/siswa_absen/{{$siswa->id}}">
                                        <li class="collection-item avatar">
                                            <p class="font-weight-600">{{$siswa->namapelajaran}} ( {{$siswa->materi}} )</p>
                                            <p class="medium-small">{{$siswa->created_at}}</p>
                                            <a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}#!" class="secondary-content"><i class="material-icons">star_border</i></a>
                                        </li>
                                    </a>
                                @endif
                                
                            @endforeach
                        </ul>
                    </div>
                </div>
                
            </div>
            <div class="col s12 m6 l6">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div id="profile-card" class="card animate fadeRight">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img class="activator" src="{{ asset('/app-assets/images/gallery/3.png') }}" alt="user bg" />
                            </div>
                            <div class="card-content">
                            <h5 class="card-title activator grey-text text-darken-4">{{Auth::user()->alias}}</h5>
                                <p><i class="material-icons profile-card-i">perm_identity</i>{{Auth::user()->nama}}</p>
                                <p><i class="material-icons profile-card-i">cached</i>{{Auth::user()->login_last}}</p>
                                <p><i class="material-icons profile-card-i">email</i>{{Auth::user()->email}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
        </div>
        
    </div>

    @section('js')
    @php
    // Untuk Itu
        $pil = DB::table('tb_pilihan_absen')
                ->where('is_aktif', 1)
                ->get();
    @endphp 
    
    <script src="/app-assets/vendors/chartjs/chart.min.js"></script>
    
    <script>
        $(window).on("load", function() {
            var ctx = $("#polar-chart");
        
            var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            responsiveAnimationDuration: 500,
            legend: {
                position: "left"
            },
            title: {
                display: true,
                text: "Chart.js Polar Area Chart"
            },
            scale: {
                ticks: {
                    beginAtZero: true
                },
                reverse: true
            },
            animation: {
                animateRotate: true
            }
            };
            var chartData = {
            labels: ["January", "February", "March", "April", "May"],
            datasets: [
                {
                    data: [65, 59, 80, 81, 56],
                    backgroundColor: ["#03a9f4", "#00bcd4", "#ffc107", "#e91e63", "#4caf50"],
                    label: "My dataset" // for legend
                }
            ]
            };
            var config = {
            type: "polarArea",
            options: chartOptions,
            data: chartData
            };
            var polarChart = new Chart(ctx, config);
        });
 

    </script>
    

    
    
    @endsection

@endsection