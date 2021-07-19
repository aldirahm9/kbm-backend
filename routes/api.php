<?php

use App\Http\Resources\AbsenResource;
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



Route::group(['middleware' => 'api','prefix'=> 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('kelas', 'KelasController@getAllKelas');
    Route::get('kelas/{id}', 'KelasController@getKelas');
    Route::post('kelas/{id}/rps', 'KelasController@uploadRPS');
    Route::get('kelas/{id}/rps', 'KelasController@downloadRPS');
    Route::get('kelas/{id}/form-05', 'PertemuanController@getForm05');
    Route::post('kelas/{id}/form-05', 'PertemuanController@buatPertemuan');

    Route::post('form-05/{id}/valid', 'pertemuanController@validPertemuan');
    Route::post('form-05/{id}/hadir', 'pertemuanController@hadirPertemuan');
    Route::post('form-05/{id}/tutup-absen', 'PertemuanController@tutupAbsen');
    Route::put('form-05/{id}', 'PertemuanController@ubahPertemuan');
    Route::delete('form-05/{id}', 'PertemuanController@hapusPertemuan');
    Route::get('form-05/{id}/unvalid', 'PertemuanController@getUnvalidatedPresensi');

    Route::post('absen/valid', 'PertemuanController@validPresensi');


    Route::get('kelas/{id}/form-06', 'PertemuanController@getForm06');
    Route::get('kelas/{id}/nilai', 'TugasController@getForm06Nilai');

    Route::get('kelas/{id}/tugas', 'TugasController@getTugas');
    Route::post('kelas/{id}/tugas', 'TugasController@buatTugas');
    Route::delete('tugas/{id}', 'TugasController@hapusTugas');
    Route::put('tugas/{id}', 'TugasController@ubahTugas');


    Route::get('kelas/{id}/nilai/excel', 'TugasController@exportExcel');
    Route::post('kelas/{id}/nilai/excel', 'TugasController@importExcel');

});


