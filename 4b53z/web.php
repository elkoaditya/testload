<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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
Route::domain('{sekolah}.lk0.xyz')->group(function () {
    // Ini Route admin
    Route::group(['middleware' => ['cek_sekolah','is_login','CekRole:admin', 'save_history']], function(){
        Route::get('/cek', function ($sekolah) {
            echo $sekolah;
        });
        Route::get('/admin/home', ['uses' => 'App\Http\Controllers\AdminSekolah@home']);
        // Untuk Add sdm
        Route::get('/admin/add-sdm', ['uses' => 'App\Http\Controllers\AdminSekolah@add']);
        Route::post('/admin/add-sdm/create', ['uses' => 'App\Http\Controllers\AdminSekolah@create_sdm']);
        // Untuk add kelas
        Route::get('/admin/add-kelas', ['uses' => 'App\Http\Controllers\AdminSekolah@add_kelas']);
        Route::post('/admin/add-kelas/create', ['uses' => 'App\Http\Controllers\AdminSekolah@create_kelas']);
        // Untuk add Pelajaran
        Route::get('/admin/add-mapel', ['uses' => 'App\Http\Controllers\AdminSekolah@add_mapel']);
        Route::post('/admin/add-mapel/create', ['uses' => 'App\Http\Controllers\AdminSekolah@create_mapel']);
        
        Route::get('/admin/add-pelajaran', ['uses' => 'App\Http\Controllers\AdminSekolah@add_pelajaran']);
        Route::post('/admin/add-pelajaran/create', ['uses' => 'App\Http\Controllers\AdminSekolah@create_pelajaran']);
        
        Route::get('/admin/add-siswa', ['uses' => 'App\Http\Controllers\AdminSekolah@add_usersiswa']);
        Route::post('/admin/add-siswa/create', ['uses' => 'App\Http\Controllers\AdminSekolah@create_siswa']);
        
    });
    
});

Route::group(['middleware' => ['is_login','CekRole:superadmin', 'save_history']], function(){
    // Home
    Route::get('/superadmin/home', ['uses' => 'App\Http\Controllers\SuperAdminController@home']);
    // Add sekolah
    Route::get('/superadmin/addsekolah', ['uses' => 'App\Http\Controllers\SuperAdminController@addsekolah']);
    Route::post('/superadmin/addsekolah/create', ['uses' => 'App\Http\Controllers\SuperAdminController@create_sekolah']);
    Route::get('/superadmin/addsekolah/{sekolah}', ['uses' => 'App\Http\Controllers\SekolahSuperadminController@single_sekolah']);

    // Menu / Sidebar
    Route::get('/superadmin/addmenu', ['uses' => 'App\Http\Controllers\SuperAdminController@addmenu']);
    Route::post('/superadmin/addmenu/create', ['uses' => 'App\Http\Controllers\SuperAdminController@create_menu']);
    Route::post('/superadmin/addmenu/create_sekolah', ['uses' => 'App\Http\Controllers\SekolahSuperadminController@create_menu_sekolah']);

    // Add user admin
    Route::post('/superadmin/adduser_admin', ['uses' => 'App\Http\Controllers\SekolahSuperadminController@adduser_admin']);
    


    Route::get('/superadmin/sekolah', ['uses' => 'App\Http\Controllers\SekolahController@index']);
    Route::get('/superadmin/add-sdm', ['uses' => 'App\Http\Controllers\SiswaController@add']);
    Route::get('/superadmin/add-kelas', ['uses' => 'App\Http\Controllers\SiswaController@kelas']);
    Route::get('/superadmin/add-mapel', ['uses' => 'App\Http\Controllers\SiswaController@mapel']);
    Route::get('/superadmin/add-pelajaran', ['uses' => 'App\Http\Controllers\SiswaController@pelajaran']);
    Route::get('/superadmin/siswa', ['uses' => 'App\Http\Controllers\SiswaController@index']);
    Route::get('/guru', ['uses' => 'App\Http\Controllers\GuruController@index']);

});


Route::get('/', function () {
    return view('auth.login');
});
Route::get('/test', function () {
    $data = Http::get('http://backend.lk0.xyz/api/coba');
    $data = $data->json('data');
    $temp = null;

    foreach($data as $s){
        $temp = $temp.$s['name'];
    }

    return $temp;
});
Route::post('/userlogin', ['uses' => 'App\Http\Controllers\ApiLoginUserController@cek_login']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
