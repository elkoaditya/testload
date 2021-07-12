<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['addSubdomain']], function () {

});
Route::get('/', function () {
    return view('login.login');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/getkelas/{id}',  [App\Http\Controllers\AbsenController::class, 'getkelas']);

Auth::routes();

Route::group(['middleware' => ['is_admin:admin']], function () {
    Route::get('/users/all', [App\Http\Controllers\UsersController::class, 'index']);
});
    
Route::group(['middleware' => ['is_admin:sdm,admin']], function () {
    Route::get('/absen', [App\Http\Controllers\AbsenController::class, 'index']);
    Route::get('/absen/edit/{id}', [App\Http\Controllers\AbsenController::class, 'absen_edit']);
    Route::post('/absen/edit/save', [App\Http\Controllers\AbsenController::class, 'save_update_absensi']);
    Route::get('/absen/delete/{id}', [App\Http\Controllers\AbsenController::class, 'delete_absensi']);
    Route::post('/absen/delete', [App\Http\Controllers\AbsenController::class, 'delete_absensi_yes']);
    Route::get('/absen/satu/{id}',  [App\Http\Controllers\AbsenController::class, 'satu_show']);
    Route::get('/absen/siswa_absen/{id}',  [App\Http\Controllers\AbsenController::class, 'siswa_absen_sendiri']);
    Route::post('/absen/create', ['uses' => 'App\Http\Controllers\AbsenController@save']);
    Route::get('/export', ['uses' => 'App\Http\Controllers\AbsenController@show_kelas']);

    Route::get('/export/{id}', ['uses' => 'App\Exports\KelasExport@download']);
    Route::get('/export/bulan/{id}/{tahun}/{bulan}', ['uses' => 'App\Exports\BulanExport@download']);
    Route::post('/export/bulan/', ['uses' => 'App\Exports\BulanExport@convert']);
    Route::post('/export/tanggal/', ['uses' => 'App\Exports\KelasExport@convert']);
    
    Route::post('/notif/siswa', ['uses' => 'App\Http\Controllers\AbsenController@siswa_notif']);

    Route::get('/agenda/export/{tahun}/{bulan}/{id_kelas}', ['uses' => 'App\Exports\Agenda@download']);
    
});
Route::group(['middleware' => ['is_admin:siswa']], function () {
    
    Route::post('/absen/save', ['uses' => 'App\Http\Controllers\AbsenController@post']);
    Route::get('/absen/siswa_absen/{id}',  [App\Http\Controllers\AbsenController::class, 'siswa_absen_sendiri']);
    
});
    Route::post('/agenda/bulan', ['uses' => 'App\Exports\Agenda@convert']);
    Route::get('/agenda/single/{id}', ['uses' => 'App\Http\Controllers\AbsenController@list_agenda']);
    Route::get('/agenda', ['uses' => 'App\Http\Controllers\AbsenController@show_agenda']);

    Route::get('/siswa/absen/{metode}/{id_siswa}/{id_absen}', ['uses' => 'App\Http\Controllers\AbsenController@absen_link']);

    Route::get('/cek_login/{username}/{password}/{token}', ['uses' => 'App\Http\Controllers\AbsenController@mod_login']);
    Route::get('/mod_login/{username}/{pass}', ['uses' => 'App\Http\Controllers\AbsenController@login_mod']);
    
    
    Route::post('/absen/save', ['uses' => 'App\Http\Controllers\AbsenController@post']);

   