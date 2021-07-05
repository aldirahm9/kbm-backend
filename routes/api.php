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
    Route::get('kelas/{id}/form-05', 'PertemuanController@getForm05');
    Route::post('kelas/{id}/form-05/add', 'PertemuanController@buatPertemuan');
    Route::post('form-05/{id}/valid', 'pertemuanController@validPertemuan');
    Route::post('form-05/{id}/hadir', 'pertemuanController@hadirPertemuan');
    Route::post('form-05/{id}/buka-absen', 'PertemuanController@bukaAbsen');

    Route::post('absen/{id}/valid', 'PertemuanController@validPresensi');

    Route::get('kelas/{id}/form-06', 'PertemuanController@getForm06');
    Route::post('kelas/{id}/form-06-nilai', 'NilaiController@getForm06Nilai');

    Route::get('kelas/{id}/tugas', 'NilaiController@getTugas');

});


