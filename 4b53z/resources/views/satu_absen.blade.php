@extends('assets.body')
@section('header', 'Isi Absen')
@section('css')

    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/page-knowledge.css">

@endsection
@section('konten')

<div class="row">
    <div class="col s12">
        <div class="container">
            <!-- knowledge -->
            <div class="section" id="knowledge">
                <!--
                <div class="row knowledge-content">
                    <div class="col s12 m4">
                        <div class="card card-hover z-depth-0 card-border-gray">
                            <a href="page-knowledge-licensing.html">
                                <div class="card-content center-align">
                                    <h5><b>Absen With Barcode</b></h5>
                                    <i class="material-icons md-48 red-text">center_focus_weak</i>
                                    <p class="mb-2 black-text">Synonyms for support with free <br> online thesaurus, antonyms.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="card card-hover z-depth-0 card-border-gray">
                            <a href="page-knowledge-licensing.html">
                                <div class="card-content center-align">
                                    <h5><b>Absen With Token</b></h5>
                                    <i class="material-icons md-48 amber-text">fingerprint</i>
                                    <p class="mb-2 black-text">A Licensing agreement is an <br> arrangement whereby a licensor.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="card card-hover z-depth-0 card-border-gray">
                            <a href="page-knowledge-licensing.html">
                                <div class="card-content center-align">
                                    <h5><b>Absen Manual</b></h5>
                                    <i class="material-icons md-48 blue-text">group_add</i>
                                    <p class="mb-2 black-text">Your Google Account gives you <br> quick access to settings and tools</p>
                                </div>
                            </a>
                        </div>
                    </div>
                -->
                    <!-- Getting started -->
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <div class="row">
                        <div class="col s12 m9 l9 card-content-link">
                            <div id="view-collaps">
                                <div class="row">
                                    @foreach ($siswa as $sw)
                                    <div class="col m4 s12">
                                        <ul class="collapsible" data-collapsible="accordion">
                                                <li>
                                                    <div class="collapsible-header <?php if($sw->status_absen == 1){
                                                        echo "green";
                                                    }else if($sw->status_absen == 5){
                                                        echo "red";
                                                    }else if($sw->status_absen == 4){
                                                        echo "orange";
                                                    }else if($sw->status_absen == 3){
                                                        echo "blue";
                                                    } 
                                                    ?>" id="mystyle{{$sw->id}}">
                                                        <font style="color: white"></font><font style="color: white">
                                                            @if ($sw->late == null)
                                                            {{$sw->nama}}
                                                                
                                                            @else
                                                            
                                                            <font style="background-color: red;">{{$sw->nama}}</font>

                                                            @endif
                                                        (<small>@php
                                                            $createdAt = Carbon::parse($sw->updated_at);

                                                            $createdAt = $createdAt->format('H:i:s');

                                                            echo $createdAt;
                                                    @endphp</small>)</font>
                                                    </div>
                                                    <form action="#" class="mt-1">
                                                        @if ($sw->metode_absen == 1 || Auth::user()->role == "siswa")
                                                            @foreach ($pilihan_absen as $pil)
                                                            <p class="mb-1">
                                                                <label>
                                                                    <input name="group1" type="radio" onclick="createPost('{{$sw->id}}', '{{$pil->id}}', '{{$pil->color}}')" <?php 
                                                                            if($sw->status_absen == $pil->id){
                                                                                echo "checked";
                                                                            }
                                                                        ?>/>
                                                                <span style="color: {{$pil->color}}"><b>{{$pil->nama}}</b>@php
                                                                    if($sw->late == null){

                                                                    }else{
                                                                        if($sw->status_absen == $pil->id){
                                                                                echo '<small style="color: grey;">Terlambat</small>';
                                                                            }
                                                                    }
                                                                @endphp</span>
                                                                </label>
                                                            </p>
                                                            @endforeach
                                                        @else
                                                            <div class="container">
                                                                <a class="waves-effect waves-light  btn" onclick="sendNotif('{{$sw->id_siswa}}', '{{$sw->id_absen}}')"><i class="material-icons left">settings_backup_restore</i>Send Notif</a>
                                                            </div>
                                                        @endif
                                                        
                                                        
                                                    </form>
                                                    <div class="collapsible-body">
                                                        <div class="row">
                                                            <!-- Phone -->
                                                            <div class="col s12 phone mt-1 p-0">
                                                                <div class="col s2 m2 l2"><i class="material-icons"> today </i></div>
                                                                <div class="col s10 m10 l10">
                                                                    <p class="m-1">{{$sw->lahir_tgl}}</p>
                                                                </div>
                                                            </div>
                                                            <!-- Mail -->
                                                            <div class="col s12 mail mt-1 p-0">
                                                                <div class="col s2 m2 l2"><i class="material-icons"> mail_outline </i></div>
                                                                <div class="col s10 m10 l10">
                                                                    <p class="m-0">
                                                                        @php
                                                                            if($sw->gender == "p"){
                                                                                echo "Laki - laki";
                                                                            }else if($sw->gender == "l"){
                                                                                echo "Perempuan";
                                                                            }
                                                                        @endphp
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
    
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->role == "sdm" || Auth::user()->role == "admin")
                            @php
                            $hasil_masuk = DB::table('tb_absen_siswa')
                                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                            ->where('tb_absen_siswa.status_absen', 1)
                                            ->where('tb_absen.id', $id)
                                            ->count();
                            $hasil_tidak_masuk = DB::table('tb_absen_siswa')
                                            ->join('tb_absen', 'tb_absen_siswa.id_absen', '=', 'tb_absen.id')
                                            ->where('tb_absen_siswa.status_absen', '!=', 1)
                                            ->where('tb_absen.id', $id)
                                            ->count();

                        @endphp
                        <div class="col s12 m3 l3">
                            <div class="card mt-2">
                                <div class="card-content">
                                    <span class="card-title">Keterangan</span>
                                    <div class="category-list">
                                        <p class="mt-4"><i class="material-icons vertical-text-sub green-text"> panorama_fish_eye </i> Siswa Masuk : {{$hasil_masuk}}
                                        </p>
                                        <p class="mt-4"><i class="material-icons vertical-text-sub red-text"> panorama_fish_eye </i> Tidak Hadir : {{$hasil_tidak_masuk}}
                                        </p>
                                    </div>
                                    <span class="card-title mt-10">Info</span>
                                    <div class="display-flex">
                                        <div class="mr-4">
                                            <i class="material-icons vertical-text-sub blue-text"> av_timer </i>
                                        </div>
                                        <div class="pl-0">
                                            <p class="text-sm">{{$absen->jam_awal}} - {{$absen->jam_akhir}}</p>
                                        </div>
                                    </div>
                                    <div class="display-flex">
                                        <div class="mr-4">
                                            <i class="material-icons vertical-text-sub blue-text"> library_books </i>
                                        </div>
                                        <div class="pl-0">
                                            <p class="text-sm">{{$absen->materi}}</p>
                                        </div>
                                    </div>
                                    <div class="display-flex">
                                        <div class="mr-4">
                                            <i class="material-icons vertical-text-sub blue-text"> lock_open </i>
                                        </div>
                                        <div class="pl-0">
                                            <p class="text-sm">{{$absen->token}}</p>
                                        </div>
                                    </div>
                                    <span class="card-title mt-10">About Absensi</span>
                                    <div class="display-flex">
                                        <div class="mr-4">
                                            <i class="material-icons vertical-text-sub blue-text"> perm_contact_calendar </i>
                                        </div>
                                        <div class="pl-0">
                                            <p class="text-sm">{{$absen->profile_user}}</p>
                                        </div>
                                    </div>
                                    <div class="display-flex">
                                        <div class="mr-4">
                                            <i class="material-icons vertical-text-sub blue-text"> assignment </i>
                                        </div>
                                        <div class="pl-0">
                                            <p class="text-sm">{{$absen->nama}}</p>
                                        </div>
                                    </div>
                                    <div class="display-flex">
                                        <div class="mr-4">
                                            <i class="material-icons vertical-text-sub blue-text"> book </i>
                                        </div>
                                        <div class="pl-0">
                                            <p class="text-sm">{{$absen->kelas_siswa}}</p>
                                        </div>
                                    </div>
                                    <div class="display-flex">
                                        <div class="mr-4">
                                            <i class="material-icons vertical-text-sub blue-text"> date_range </i>
                                        </div>
                                        <div class="pl-0">
                                            <p class="text-sm">
                                                @php
                                                $createdAt = Carbon::parse($absen->created_at);

                                                $createdAt = $createdAt->isoFormat('dddd, D MMMM Y');

                                                echo $createdAt;
                                            @endphp
                                            </p>
                                        </div>
                                    </div>
                                    <div class="display-flex">
                                        <div class="pl-0">
                                            <div class="row">
                                                <div class="col s6 m6 l6">
                                                    <a class="waves-effect waves-light  btn" href="{{"https://".$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/edit/{{$id}}">Edit</a>
                                                </div>
                                                <div class="col s6 m6 l6">
                                                    <a class="waves-effect waves-light  btn red" href="{{"https://".$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/delete/{{$id}}">Delete</a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- Item Support -->
                    
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>

@section('js')
<!-- JavaScript Unutk Input Absensi -->
<script>
    function createPost(id, isi, warna) {
      let _url     = `{{"https://".$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/save`;
      let _token   = $('meta[name="csrf-token"]').attr('content');
  
        $.ajax({
          url: _url,
          type: "POST",
          data: {
            id: id,
            isi: isi,
            _token: _token
          },
          success: function(response) {
            console.log(response);
            $('#mystyle'+id).removeClass('green'); 
            $('#mystyle'+id).removeClass('red'); 
            $('#mystyle'+id).removeClass('blue'); 
            $('#mystyle'+id).removeClass('orange'); 
            $('#mystyle'+id).addClass(warna);  
          },
          error: function(response) {
            console.log(response);
            alert(response+id+isi);
          }
        });
    }
  </script>    
  <script>
    function sendNotif(id_siswa, id_absen) {
        alert(id_siswa+'/'+id_absen);
      let _url     = `/notif/siswa`;
      let _token   = $('meta[name="csrf-token"]').attr('content');
      alert(_url);
  
        $.ajax({
          url: _url,
          type: "POST",
          data: {
            id_siswa: id_siswa,
            id_absen: id_absen,
            _token: _token
          },
          success: function(response) {
              alert("Berhasil Mengirim Notif");
          },
          error: function(response) {
            alert(response.Message);
          }
        });
    }
  </script>    


@endsection

@endsection