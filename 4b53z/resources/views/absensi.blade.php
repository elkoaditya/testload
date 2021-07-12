@extends('assets.body')
@section('header', 'Absensi')
@section('css')
        
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/app-assets/vendors/select2/select2.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/app-assets/vendors/select2/select2-materialize.css') }}" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/pages/page-account-settings.css') }}">

    
    

        <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/pages/data-tables.css') }}">
        
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/data-tables/css/select.dataTables.min.css/css/app.css') }}">
    
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/form-select2.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <link rel="stylesheet" href="dist/wickedpicker.min.css">

    
<link rel="stylesheet" href="{{ asset('/app-assets/js/time.css') }}">

@endsection
@section('konten')

<section class="tabs-vertical mt-1 section">
    <div class="row">
    <div class="col l3 s12">
        <!-- tabs  -->
        <div class="card-panel">
            <ul class="tabs">
                <li class="tab">
                    <a href="#general">
                        <i class="material-icons">library_books</i>
                        <span>Absensi Hari Ini</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#change-password">
                        <i class="material-icons">border_color</i>
                        <span>Buat Absensi</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#all-absen">
                        <i class="material-icons">storage</i>
                        <span>Semua Absensi</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#all-laporan">
                        <i class="material-icons">assignment_turned_in</i>
                        <span>Laporan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col l9 s12">
        <div id="general">
            <div class="card">
                <div class="card-content">
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <h4 class="card-title">Absensi ( {{Carbon::now()->isoFormat('dddd, D MMMM Y')}} )</h4>
                    <div class="row">
                        <div class="col s12">
                            <table id="page-length-option" class="display">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Pelajaran</th>
                                        <th>Jam Ajar</th>
                                        <th>Create by</th>
                                        <th>Token</th>
                                        <th>create at</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daftar_absen as $absen)
                                    <tr>
                                        <td>{{$absen->namakelas}}</td>
                                    <td><a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/satu/{{$absen->id}}"><?php 

                                    $absen->namakategori = str_replace("Kelompok A ","",$absen->namakategori);
                                    $absen->namakategori = str_replace("Kelompok B ","",$absen->namakategori);
                                    $absen->namakategori = str_replace("Kelompok C ","",$absen->namakategori);
                                    echo $absen->namakategori;

                                    
                                    ?> {{$absen->namamapel}}</a></td>
                                                <td>
                                                    <ul>
                                                    @php
                                                    $temp = null;
                                                        

                                                        if($absen->id_jam_ajar != null){
                                                            $temp = explode(',', $absen->id_jam_ajar);

                                                        foreach($temp as $t){
                                                            $all[] = DB::table('dakd_jam_ajar')->where('id', '=', $t)->select('dakd_jam_ajar.nama')->first();
                                                        }
                                                        foreach ($all as $a) {
                                                            echo "<small><li>".$a->nama."</li></small>";
                                                        }
                                                        }
                                                        
                                                        
                                                        $all = null;
                                                    @endphp 
                                                    
                                                        
                                                    </ul>
                                                </td>
                                            <td>{{$absen->namauser}}</td>
                                        <td>
                                            <font style="color: red">{{$absen->token}}</font>
                                        </td>
                                        <td>
                                            @php
                                                $createdAt = Carbon::parse($absen->created_at);

                                                $createdAt = $createdAt->isoFormat('dddd, D MMMM Y');

                                                echo $createdAt;
                                            @endphp    
                                        </td>
                                        <td>
                                            <a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/edit/{{$absen->id}}"><i class="material-icons">edit</i></a>
                                        </td>
                                        <td><span><a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/delete/{{$absen->id}}"><i class="material-icons delete">delete_outline</i></a></span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col l8 s12">
            <div id="change-password">
                <div class="card-panel">
                    <form class="paaswordvalidate" method="POST" action="{{"https://".$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/create">
                        @csrf
                        <div class="row">
                            <div class="col s12">
                                <h6 class="card-title">Tanggal Absensi</h6>
                                <div class="input-field">
                                    <input type="text" class="datepicker" id="birthdate" name="tanggal_absensi">
                                </div>
                            </div>
                            <div class="col s12">
                                <h6 class="card-title">Pilih Daftar Mapel</h6>
                                <div class="input-field">
                                    <select class="select2 browser-default" name="mapel" id="mapel">
                                        <optgroup label="Mapel">
                                            <option value="0">-- Select Mapel --</option>
                                            @foreach ($daftar_pelajaran as $mapel)
                                                <option value="{{$mapel->id}}">{{$mapel->nama}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col s12">
                                <h6>Pilih Kelas</h6>
                                <div class="input-field">
                                    <select data-placeholder="Pilih kelas" class="select2-icons browser-default" id="kelas" multiple="multiple" name="kelas[]">
                                        <option value="0" data-icon='school' >-- Select Kelas --</option>
                                    </select>
                                </div>
                            </div>
                            @if (Auth::user()->role == "admin")
                            <div class="col s12">
                                <h6 class="card-title">Pilih Guru Mapel</h6>
                                <div class="input-field">
                                    <select class="select2 browser-default" name="guru" id="mapel0">
                                        <optgroup label="Mapel">
                                            <option value="0">-- Pilih Pengajar --</option>
                                            @foreach ($list_user as $guru)
                                                <option value="{{$guru->id}}">{{$guru->nama}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col s12">
                                <h6 class="card-title">Metode</h6>
                                <div class="input-field">
                                    <select class="select2 browser-default" name="metode">
                                        <option value="1">Guru yang mengapsenkan</option>
                                        <option value="2">Siswa Absen Menggunakan Token</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col s12">
                                <h6 class="card-title">Materi</h6>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="last_name" type="text" name="materi">
                                        <label for="last_name">Hal yang di ajarkan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12">
                                <h6>Pilih Jam Ajar</h6>
                                <div class="input-field">
                                    <select data-placeholder="Pilih jam kelas" class="select2-icons browser-default" id="multiple-select2-icons" multiple="multiple" name="jam_ajar[]">
                                        @foreach ($daftar_ajar as $ajar)
                                            <option value="{{$ajar->id}}" data-icon="access_alarm">{{$ajar->nama}} <!--({{$ajar->awal}}) - ({{$ajar->akhir}}) --></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col s12">
                                <h6 class="card-title">Jam Mengajar</h6>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="time" id="appt" name="jam_awal" required>
                                        <label for="last_name">Jam awal</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="time" id="appt" name="jam_akhir" required>
                                        <label for="last_name">Jam Akhir</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12">
                                <label for="appt">Select a time:</label>
                                <input type="text" id="timepicker-12-hr" name="jam_terlambat" class="timepicker-12-hr">
                            </div>
                            
                            <div class="col s12 display-flex justify-content-end form-action">
                                    <button class="waves-effect waves-light  btn">Simpan Absensi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="all-absen">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12">
                            <table id="page-length-option" class="display">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Pelajaran</th>
                                        <th>Jam Ajar</th>
                                        <th>Create by</th>
                                        <th>Token</th>
                                        <th>create at</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daftar_absen_all as $absen)
                                    <tr>
                                        <td>{{$absen->namakelas}}</td>
                                    <td><a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/satu/{{$absen->id}}"><?php 

                                    $absen->namakategori = str_replace("Kelompok A ","",$absen->namakategori);
                                    $absen->namakategori = str_replace("Kelompok B ","",$absen->namakategori);
                                    $absen->namakategori = str_replace("Kelompok C ","",$absen->namakategori);
                                    echo $absen->namakategori;

                                    
                                    ?> {{$absen->namamapel}}</a></td>
                                                <td>
                                                    <ul>
                                                    @php
                                                    $temp = null;
                                                        

                                                        if($absen->id_jam_ajar != null){
                                                            $temp = explode(',', $absen->id_jam_ajar);

                                                        foreach($temp as $t){
                                                            $all[] = DB::table('dakd_jam_ajar')->where('id', '=', $t)->select('dakd_jam_ajar.nama')->first();
                                                        }
                                                        foreach ($all as $a) {
                                                            echo "<small><li>".$a->nama."</li></small>";
                                                        }
                                                        }
                                                        
                                                        
                                                        $all = null;
                                                    @endphp 
                                                    
                                                        
                                                    </ul>
                                                </td>
                                            <td>{{$absen->namauser}}</td>
                                        <td>
                                            <font style="color: red">{{$absen->token}}</font>
                                        </td>
                                        <td>
                                            @php
                                                $createdAt = Carbon::parse($absen->created_at);

                                                $createdAt = $createdAt->isoFormat('dddd, D MMMM Y');

                                                echo $createdAt;
                                            @endphp    
                                        </td>
                                        <td>
                                            <a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/edit/{{$absen->id}}"><i class="material-icons">edit</i></a>
                                        </td>
                                        <td><span><a href="https://{{$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/delete/{{$absen->id}}"><i class="material-icons delete">delete_outline</i></a></span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="all-laporan">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 l12 m12">
                            <table id="" class="display">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Total memiliki Absensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitorTraffic as $item)
                                        <tr>
                                            <td>@php
                                                $createdAt = Carbon::parse($item->date);
    
                                                $createdAt = $createdAt->isoFormat('dddd, D MMMM Y');
    
                                                echo  '<a href="https://'.$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN.'/agenda/single/'.$item->date.'"';
                                                echo '">'.$createdAt.'</a>';
                                            @endphp</td>
                                           
                                            <td>{{$item->views}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</section>

@section('js')

    
<script src="{{ asset('/app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/app-assets/js/scripts/page-account-settings.js') }}"></script>
    
    <script src="{{ asset('/app-assets/js/scripts/data-tables.js') }}"></script>

    
    <script src="{{ asset('/app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>

    
    <script src="{{ asset('/app-assets/js/scripts/form-select2.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/select2/select2.full.min.js') }}"></script>
    
    <script>
        $(function () {
            $("select").formSelect();

            $(".timepicker").timepicker({
                default: "now", // Set default time
                fromnow: 0, // set default time to * milliseconds from now (using with default = 'now')
                twelvehour: false, // Use AM/PM or 24-hour format
                donetext: "OK", // text for done-button
                cleartext: "Clear", // text for clear-button
                canceltext: "Batal", // Text for cancel-button
                autoclose: false, // automatic close timepicker
                ampmclickable: false, // make AM PM clickable
                aftershow: function () { } //Function for after opening timepicker
            });

            $("input#input_text, textarea#textarea1").characterCounter();
            });
    </script>
    
    <script type='text/javascript'>

        $(document).ready(function(){
    
          // Department Change
          $('#mapel').change(function(){
    
             // Department id
             var id = $(this).val();
             
    
             // Empty the dropdown
             $('#kelas').find('option').not(':first').remove();
    
             // AJAX request 
             $.ajax({
               url: '{{"https://".$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/getkelas/'+id,
               type: 'get',
               dataType: 'json',
               success: function(response){
    
                 var len = 0;
                 if(response['data'] != null){
                   len = response['data'].length;
                 }
                 if(len > 0){
                   // Read data and create <option >
                    var option = null;
                   for(var i=0; i<len; i++){
    
                     var id = response['data'][i].id;
                     var name = response['data'][i].nama;
    
                     option = "<option value='"+id+"' data-icon='school' >"+name+"</option>"; 
    
                     $("#kelas").append(option);
                     
                   }
                 }
    
               }
            });
          });
    
        });
    
        </script>
        
        <script type="text/javascript" src="{{ asset('/app-assets/js/time.js') }}"></script>

        <script>
            $('.timepicker-12-hr').wickedpicker({
            now: "00:00", //hh:mm 24 hour format only, defaults to current time
            twentyFour: true,  //Display 24 hour format, defaults to false
            upArrow: 'wickedpicker__controls__control-up',  //The up arrow class selector to use, for custom CSS
            downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
            close: 'wickedpicker__close', //The close class selector to use, for custom CSS
            hoverState: 'hover-state', //The hover state class to use, for custom CSS
            title: 'Timepicker', //The Wickedpicker's title,
            showSeconds: false, //Whether or not to show seconds,
            timeSeparator: ':', // The string to put in between hours and minutes (and seconds)
            secondsInterval: 1, //Change interval for seconds, defaults to 1,
            minutesInterval: 1, //Change interval for minutes, defaults to 1
            beforeShow: null, //A function to be called before the Wickedpicker is shown
            afterShow: null, //A function to be called after the Wickedpicker is closed/hidden
            show: null, //A function to be called when the Wickedpicker is shown
            clearable: false, //Make the picker's input clearable (has clickable "x")
            });
        </script>

@endsection

@endsection
