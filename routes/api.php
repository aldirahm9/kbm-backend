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
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('kelas', 'HomeController@getAllKelas');
    Route::post('kelas/{id}', 'KelasController@getKelas');
    Route::post('kelas/{id}/form-05', 'KelasController@getForm05');
    Route::post('kelas/{id}/form-05/add', 'KelasController@buatPertemuan');
    Route::post('form-05/{id}/valid', 'KelasController@validPertemuan');
    Route::post('form-05/{id}/buka-absen', 'KelasController@bukaAbsen');
    Route::post('kelas/{id}/form-06', 'KelasController@getForm06');
    Route::post('kelas/{id}/form-06-nilai', 'KelasController@getForm06Nilai');
});

