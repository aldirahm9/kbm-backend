<?php

namespace App\Http\Controllers;

use App\Presensi;
use App\ApiUtils\SiakadUtils;
use App\Http\Resources\PresensiResourceCollection;
use App\Http\Resources\PertemuanResourceCollection;
use App\Http\Resources\KelasResource;
use App\Http\Resources\KelasResourceCollection;
use App\Http\Resources\KelasDetailsResource;

use App\Http\Resources\KelasDosenResourceCollection;
use App\Http\Resources\KelasTpjmResourceCollection;
use App\Http\Resources\NilaiResourceCollection;
use App\Http\Resources\PertemuanResource;
use App\Http\Resources\RekapPresensiResourceCollection;
use Illuminate\Http\Request;
use App\KelasMahasiswa;
use App\KelasDosen;
use App\Pertemuan;
use App\ProgramStudi;
use App\RPSKelas;
use App\User;
use Validator;


class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllKelas($semester)
    {
        if(auth()->user()->isDosen()) {
            $resp = SiakadUtils::getKelasDosen(auth()->user()->username,$semester,auth()->user()->token_siakad);

            if($resp->status != true) return response()->json(['message' => 'Data not found!']);
            $data = collect($resp->isi);
            $diff =array_diff($data->pluck('kelas')->toArray(),auth()->user()->kelas->pluck('kelas_id')->toArray());
            if($diff) {
                foreach($diff as $item) {
                    KelasDosen::create([
                        'kelas_id' => $data->where('kelas',$item)->first()->kelas,
                        'user_id' => auth()->user()->id,
                        'semester' => $semester
                    ]);
                }
            }
            // dd($resp->isi);
            return new KelasDosenResourceCollection($resp->isi);
        } else {
            $resp = SiakadUtils::getKelasMahasiswaBySemester(auth()->user()->username,$semester,auth()->user()->token_siakad);
            if($resp->status != true) return response()->json(['message' => 'Data not found!']);
            $data = collect($resp->isi);
            $diff =array_diff($data->pluck('kelas')->toArray(),auth()->user()->kelas->pluck('kelas_id')->toArray());
            if($diff) {
                foreach($diff as $item) {
                    KelasMahasiswa::create([
                        'kelas_id' => $data->where('kelas',$item)->first()->kelas,
                        'user_id' => auth()->user()->id,
                        'semester' => $semester
                    ]);
                }
            }
            return new KelasResourceCollection($resp->isi);
        }

    }

    public function getKelas($semester,$id) {

        //kelas per seksi, cari kode prodi
        $kelas = SiakadUtils::getKelasInfo($id,$semester,auth()->user()->token_siakad);

        if($kelas->status == false) return response()->json(['message' => 'Kelas tidak ditemukan']);
        $kode_prodi = $kelas->identitas->kode_prodi;
        $kelas = collect(SiakadUtils::getKelasInProdi($kode_prodi,auth()->user()->prodi->fakultas->kode,$semester));
        
        return new KelasDetailsResource(collect($kelas['isi'])->where('kelas',$id)->first());
    }

    public function uploadRPS($id, Request $request)
    {
        $validator = Validator::make($request->all(),
        [
        'file' => 'required|mimes:pdf|max:2048',
       ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 415);
        }

        if ($files = $request->file('file')) {

            //store file into document folder
            $originalName = $request->file->getClientOriginalName();
            $file = $request->file->storeAs('public\\rps',$originalName);

            //store your file into database
            $existing = RPSKelas::where('kelas_id',$id)->first();
            if($existing) {
                $existing->filename = $originalName;
                $existing->save();
            } else {
                RPSKelas::create([
                    'filename' => $file,
                    'kelas_id' => $id
                ]);
            }

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file
            ],200);

        }

    }

    public function downloadRPS($id, Request $request)
    {
        $rps = RPSKelas::where('kelas_id',$id)->first();
        if($rps == null) {
            return response()->json([
                'message' => 'File not found'
            ],404);
        }

        $file= public_path(). "\\storage\\rps\\" . $rps->filename;

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file, 'filename.pdf', $headers);
    }



    public function getAllKelasInProdi($semester)
    {
        $prodi = auth()->user()->prodi;
        $fakultas = $prodi->fakultas;
        $resp = SiakadUtils::getKelasInProdi($prodi->kode,$fakultas->kode,$semester);
        if($resp->status != true) return response()->json(['message' => 'Data not found!']);
        $data = collect($resp->isi);

        return new KelasTpjmResourceCollection($data);
    }

    public function assignPJ($semester,$id,Request $request)
    {
        if(!auth()->user()->isDosen() || auth()->user()->kelas->where('kelas_id',$id)->where('semester',$semester)->isEmpty()) return response()->json(['message' => 'Unauthorized!'],401);

        $mhs_id = User::where('username',$request->mahasiswa)->first()->id;
        $pivot = KelasMahasiswa::where('kelas_id', $id)->where('user_id',$mhs_id)->where('semester',$semester)->first();
        $pivot->penanggung_jawab = 1;
        $pivot->save();

        return response()->json(['message' => 'Success!'],200);

    }

    public function getMahasiswaList($semester,$id)
    {
        $mahasiswa_id = KelasMahasiswa::where('kelas_id',$id)->where('semester',$semester)->get()->map->only('user_id','penanggung_jawab');
        $listLengkap = $mahasiswa_id->map(function ($item,$key) {
            $user = User::find($item['user_id']);
            return [
                    'username' => $user->username,
                    'nama'=> $user->nama,
                    'penanggung_jawab'=> $item['penanggung_jawab']];
        });
        return $listLengkap;
    }

    public function rekapPresensi($semester)
    {
        $resp = SiakadUtils::getKelasMahasiswaBySemester(auth()->user()->username,$semester,auth()->user()->token_siakad);
        if($resp->status != true) return response()->json(['message' => 'Data not found!']);
        $data = collect($resp->isi);
        return new RekapPresensiResourceCollection($data);
    }


}
