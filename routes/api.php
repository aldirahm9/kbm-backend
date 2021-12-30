<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KelasController;
use App\Http\Resources\PresensiResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test', function () {
    return response()->json(['message' => 'Test']);
});


Route::group(['middleware' => 'api','prefix'=> 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('semester-aktif','HomeController@getSemesterAktif');

    Route::get('kelas/{id}/form-05', 'PertemuanController@getForm05');
    Route::post('kelas/{id}/form-05', 'PertemuanController@buatPertemuan');

    Route::post('kelas/{id}/rps', 'KelasController@uploadRPS');
    Route::get('kelas/{id}/rps', 'KelasController@downloadRPS');

    Route::get('kelas/{id}/tugas', 'TugasController@getTugas');
    Route::post('kelas/{id}/tugas', 'TugasController@buatTugas');

    Route::get('kelas/{semester}', 'KelasController@getAllKelas');
    Route::get('kelas/{semester}/{id}', 'KelasController@getKelas');
    Route::post('kelas/{semester}/{id}/penanggung-jawab/', 'KelasController@assignPJ');
    Route::get('kelas/{semester}/{id}/mahasiswa/', 'KelasController@getMahasiswaList');

    Route::get('kelas/{semester}/{id}/form-06', 'PertemuanController@getForm06');
    Route::get('kelas/{semester}/{id}/nilai', 'TugasController@getForm06Nilai');

    Route::get('kelas/{semester}/{id}/nilai/excel', 'TugasController@exportExcel');
    Route::post('kelas/{semester}/{id}/nilai/excel', 'TugasController@importExcel');



    Route::post('form-05/{id}/valid', 'pertemuanController@validPertemuan');
    Route::post('form-05/{id}/hadir', 'pertemuanController@hadirPertemuan');
    Route::post('form-05/{id}/tutup-presensi', 'PertemuanController@tutupPresensi');
    Route::put('form-05/{id}', 'PertemuanController@ubahPertemuan');
    Route::delete('form-05/{id}', 'PertemuanController@hapusPertemuan');
    Route::get('form-05/{id}/unvalid', 'PertemuanController@getUnvalidatedPresensi');
    Route::post('form-05/{id}/penanggung-jawab-sementara/', 'PertemuanController@assignPenanggungJawabSementara');

    Route::post('presensi/valid', 'PertemuanController@validPresensi');


    Route::get('dosen', 'AdminController@getDosen');
    Route::post('dosen/{username}/switch-role', 'AdminController@switchRole');


    Route::delete('tugas/{id}', 'TugasController@hapusTugas');
    Route::put('tugas/{id}', 'TugasController@ubahTugas');
    Route::put('tugas', 'TugasController@editTugasArray');



    Route::get('monitoring/kelas/{semester}', 'KelasController@getAllKelasInProdi');

    Route::get('rekap-presensi/{semester}', 'KelasController@rekapPresensi');



});



