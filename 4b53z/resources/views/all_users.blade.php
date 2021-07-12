@extends('assets.body')
@section('header', 'Dashboard')
@section('css')
    
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/pages/page-users.css') }}">
@endsection
@section('konten')

<section class="users-list-wrapper section">
    <div class="users-list-table">
        <div class="card">
            <div class="card-content">
                <!-- datatable start -->
                <div class="responsive-table">
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>username</th>
                                <th>name</th>
                                <th>last activity</th>
                                <th>Gender</th>
                                <th>role</th>
                                <th>status</th>
                                <th>edit</th>
                                <th>view</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_users as $usr)
                                <tr>
                                    <td></td>
                                    <td>{{$usr->id}}</td>
                                    <td>{{$usr->username}}</td>
                                    <td>{{$usr->nama}}</td>
                                    <td>{{$usr->login_last}}</td>
                                    <td>
                                        @if ($usr->gender == "l")
                                            Laki Laki
                                        @else
                                            Wanita
                                        @endif
                                    </td>
                                    <td>{{$usr->role}}</td>
                                    <td><span class="chip green lighten-5">
                                            <span class="green-text">Active</span>
                                        </span>
                                    </td>
                                    <td><a href="page-users-edit.html"><i class="material-icons">edit</i></a></td>
                                    <td><a href="page-users-view.html"><i class="material-icons">remove_red_eye</i></a></td>
                                </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- datatable ends -->
            </div>
        </div>
    </div>
</section>

@section('js')
    <script src="{{ asset('/app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/app-assets/js/scripts/page-users.js') }}"></script>
@endsection

@endsection