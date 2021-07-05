<?php

namespace App\Http\Controllers;

use App\Absen;
use App\ApiUtils\SiakadUtils;
use App\Http\Resources\AbsenResourceCollection;
use App\Http\Resources\PertemuanResourceCollection;
use App\Http\Resources\KelasResource;
use App\Http\Resources\KelasResourceCollection;
use App\Http\Resources\NilaiResourceCollection;
use App\Http\Resources\PertemuanResource;
use Illuminate\Http\Request;
use App\Kelas;
use App\Pertemuan;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Log;
use Config;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllKelas()
    {
        $resp = SiakadUtils::getKelasMahasiswaBySemester(auth()->user()->username,config('semester.semesterAktif'),auth()->user()->token_siakad);
        $data = collect($resp->isi);
        $diff =array_diff($data->pluck('idkrs')->toArray(),auth()->user()->kelas->pluck('kelas_id')->toArray());
        if($diff) {
            foreach($diff as $item) {
                Kelas::create([
                    'kelas_id' => $data->where('idkrs',$item)->first()->idkrs,
                    'user_id' => auth()->user()->id,
                ]);
            }
        }
        return new KelasResourceCollection($resp->isi);

    }

    public function getKelas($id) {
        $resp = SiakadUtils::getKelasMahasiswaBySemester(auth()->user()->username,config('semester.semesterAktif'),auth()->user()->token_siakad);
        $found = collect($resp->isi)->where('idkrs',$id)->first();
        return new KelasResource($found);
    }





}
