<?php

namespace App\ApiUtils;

use Illuminate\Support\Facades\Http;

class SiakadUtils{

    public static function getCaptcha() {
        $resp = json_decode(Http::get('http://103.8.12.212:36880/siakad_api/api/as400/captcha'));

        return $resp->data;
    }

    public static function login($username,$password) {
        $resp = Http::asForm()->post('http://103.8.12.212:36880/siakad_api/api/as400/login',[
                                    'username'=>$username,
                                    'password'=>$password,
                                    'securid'=>2,
                                    'captcha_id'=>2]);

        return $resp;
    }

    public static function getKelasMahasiswaBySemester($nrm,$semester,$token) {
        $resp = json_decode(Http::get('http://103.8.12.212:36880/siakad_api/api/as400/krsMahasiswaPerSemester/' .
                                        $nrm . '/' .
                                        $semester . '/' .
                                        $token));
        return $resp;
    }

    public static function getKelasInfo($kode,$semester,$token) {
        $resp = json_decode(Http::get('http://103.8.12.212:36880/siakad_api/api/as400/KelasPerSeksi/' .
                                        $semester . '/' .
                                        $kode . '/' .
                                        $token));
        return $resp;
    }

    public static function getKelasInProdi($prodi,$fakultas,$semester) {
        $resp = json_decode(Http::get('http://103.8.12.212:36880/siakad_api/api/as400/penjadwalan/'.
                                        $semester . '/' .
                                        $fakultas . '/' .
                                        $prodi));
        return $resp;
    }

    public static function getKelasDosen($nidn,$semester,$token) {
        $resp = json_decode(Http::get('http://103.8.12.212:36880/siakad_api/api/as400/penjadwalanDosen/'.
                                        $nidn . '/' .
                                        $semester . '/' .
                                        $token));
        return $resp;
    }

    public static function getInfoDosen($nidn,$token) {
        $resp = json_decode(Http::get('http://103.8.12.212:36880/siakad_api/api/as400/dataDosen/'.
                                        $nidn . '/' .
                                        $token));
        return $resp;
    }
}
