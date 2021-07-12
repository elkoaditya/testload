@extends('assets.body')
@section('header', 'Delete Absensi')
@section('css')

    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/page-knowledge.css">

@endsection
@section('konten')
    <div class="container">
        <div class="card-panel">
            @php
                use Carbon\Carbon;
            @endphp
            <div class="row">
                <div class="col s12 card-content-link">
                    <div id="view-collaps">
                        <div class="row">
                            @foreach ($siswa as $sw)
                            <div class="col m3 s12">
                                <ul class="collapsible" data-collapsible="accordion">
                                        <li>
                                            <div class="collapsible-header grey" id="mystyle{{$sw->id}}">
                                                <font style="color: white"><i class="material-icons">person_outline</i></font><font style="color: white">{{$sw->nama}} (@php
                                                    $createdAt = Carbon::parse($sw->updated_at);
    
                                                        $createdAt = $createdAt->format('H:i:s');
    
                                                        echo $createdAt;
                                                @endphp)</font>
                                            </div>
                                        </li>
    
                                </ul>
                            </div>
                            
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
        <div class="card-panel">
            <div class="row">
                <div class="col s9 display-flex justify-content-end form-action">
                    <h5>Semua data akan di hapus dan tidak dapat di kembalikan</h5>
                </div>
                <div class="col s3 display-flex justify-content-end form-action">
                    <form action="{{"https://".$_SERVER['HTTP_HOST'].'/'.APP_SUBDOMAIN}}/absen/delete" method="post">
                        @csrf
                        <input type="hidden" value="{{$id}}" name="id">
                    
                        <button class="waves-effect waves-light  btn red">Delete Absensi</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>


@section('js')



@endsection

@endsection