@extends('assets.body')
@section('header', 'Edit Absensi')
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

@endsection
@section('konten')

<div class="container">
    <div id="change-password">
        <div class="card-panel">
            <form class="paaswordvalidate" method="POST" action="{{"https://".$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/edit/save">
                @csrf
                <input type="hidden" name="id" value="{{$id}}">
                <div class="row">
                    <div class="col s12">
                        <h6 class="card-title">Materi</h6>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="last_name" type="text" name="materi" value="{{$absen->materi}}">
                                <label for="last_name">Hal yang di ajarkan</label>
                            </div>
                        </div>
                    </div>
                    <div class="col s12">
                        <h6>Pilih Jam Ajar</h6>
                    </div>
                    <div class="col s12">
                        <div class="row">
                            @foreach ($daftar_ajar as $ajar)
                            <div class="col s12">
                                <label>
                                    <input type="checkbox" value="{{$ajar->id}}" name="id_jam_ajar[]" @php
                                        if($absen->id_jam_ajar != null){
                                            $temp = explode(',', $absen->id_jam_ajar);
                                            foreach ($temp as $jam) {
                                                if($ajar->id == $jam){
                                                    echo "checked";
                                                }
                                            }
                                        }
                                        

                                    @endphp/>
                                    <span>{{$ajar->nama}} ({{$ajar->awal}}) - ({{$ajar->akhir}} )</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col s12">
                        <h6 class="card-title">Jam Mengajar</h6>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" class="timepicker" id="lunch-time" name="jam_awal" value="{{$absen->jam_awal}}">
                                <label for="last_name">Jam awal</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" class="timepicker" id="lunch-time" name="jam_akhir" value="{{$absen->jam_akhir}}">
                                <label for="last_name">Jam Akhir</label>
                            </div>
                        </div>
                    </div>

                    <div class="col s12">
                        <label for="appt">Select a time:</label>
                        <input type="time" id="appt" name="jam_terlambat" min="00:00" max="05:00" value="{{$absen->jam_terlambat}}">
                    </div>
                    
                    <div class="col s12 display-flex justify-content-end form-action">
                            <button class="waves-effect waves-light  btn">Simpan Absensi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



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
    
    <script src="{{ asset('/app-assets/js/scripts/form-elements.js') }}"></script>
    
    

@endsection

@endsection