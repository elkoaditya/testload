@extends('assets.body')
@section('header', 'Laporan')
@section('css')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/horizontal-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/horizontal-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/layouts/style-horizontal.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/page-users.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/custom/custom.css">

    <link rel="stylesheet" href="/app-assets/vendors/select2/select2.min.css" type="text/css">
    <link rel="stylesheet" href="/app-assets/vendors/select2/select2-materialize.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/form-select2.css">


    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
@endsection
@section('konten')
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
                                <th>verified</th>
                                <th>role</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftar_kelas as $kelas)
                                <tr>
                                    <td></td>
                                    <td>{{ $kelas->id_kelas }}</td>
                                    <td><a href="page-users-view.html">{{ $kelas->nama_kelas }}</a>
                                    </td>
                                    <td>{{ $kelas->nama }}</td>
                                    <td>
                                        {{ $kelas->kode }}
                                    </td>
                                    <td>
                                        <small><a class="wwaves-effect waves-light btn modal-trigger mb-2 mr-1n"
                                                href="#modal2" data-id_kelas1="{{ $kelas->id_kelas }}" id="data_kelas1"><i
                                                    class="material-icons left">file_download</i> By Day</a></small>
                                    </td>
                                    <td>
                                        <small><a class="wwaves-effect waves-light btn modal-trigger mb-2 mr-1n"
                                                href="#modal1" data-id_kelas="{{ $kelas->id_kelas }}" id="data_kelas"><i
                                                    class="material-icons left">file_download</i> By Mount</a></small>
                                    </td>
                                    <td>
                                        <small><a class="waves-effect waves-light  btn"><i
                                                    class="material-icons left">file_download</i> By Semester</a></small>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div id="modal1" class="modal modal-fixed-footer">
                    <form action="{{ 'https://' . $_SERVER['HTTP_HOST'] . '/' . APP_SUBDOMAIN }}/export/bulan" method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="row">
                                <input type="text" id="id_kelasku" name="id_kelas">
                                <div class="input-field col l6 m6 s12">
                                    <select name="tahun">
                                        <option value="" disabled selected>-- Pilih Tahun --</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                    <label>Pilih Tahun</label>
                                </div>
                                <div class="input-field col l6 m6 s12">
                                    <select name="bulan">
                                        <option value="" disabled selected>-- Pilih Bulan --</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Feburuary</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <label>Pilih Bulan</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Batal</a>
                            <input class="waves-effect waves-green btn-flat " type="submit" value="Download">
                        </div>
                    </form>
                </div>
                <div id="modal2" class="modal modal-fixed-footer">
                    <form action="{{ 'https://' . $_SERVER['HTTP_HOST'] . '/' . APP_SUBDOMAIN }}/export/tanggal" method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="row">
                                <div class="col s12">
                                    <div id="date-picker" class="card card-tabs">
                                        <div class="card-content">
                                            <div class="card-title">
                                                <div class="row">
                                                    <div class="col s12 m6 l6">
                                                        <h4 class="card-title">Inputkan Tanggal</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" id="id_kelas1" name="id_kelas">
                                            <div id="view-date-picker">
                                                <p>Pilih tanggal yang ingin di download <br>( Apabila di tanggal yang di
                                                    download tidak ada record absen maka data yang di download tidak dapat
                                                    di tampilkan )</p>
                                                <label for="birthdate">Tanggal Absen</label>
                                                <input type="text" class="datepicker" id="birthdate" name="tanggal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Disagree</a>
                            <input class="waves-effect waves-green btn-flat " type="submit" value="Download">
                        </div>
                    </form>
                </div>
                <!-- datatable ends -->
            </div>
        </div>
    </div>

@section('js')
    <script src="/app-assets/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="/app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script src="/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="/app-assets/js/plugins.js"></script>
    <script src="/app-assets/js/search.js"></script>
    <script src="/app-assets/js/custom/custom-script.js"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="/app-assets/js/scripts/page-users.js"></script>

    <script src="/app-assets/vendors/select2/select2.full.min.js"></script>

    <script src="/app-assets/js/scripts/advance-ui-modals.js"></script>

    <script src="/app-assets/js/scripts/form-select2.js"></script>
    <script>
        $(document).on("click", "#data_kelas", function() {
            let id_barang = $(this).data('id_kelas');

            $("#id_kelasku").val(id_barang);

        });

    </script>
    <script>
        $(document).on("click", "#data_kelas1", function() {
            let id_barang = $(this).data('id_kelas1');
            $("#id_kelas1").val(id_barang);

        });

    </script>

@endsection

@endsection
