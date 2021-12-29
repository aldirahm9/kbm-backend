<?php

namespace App\Http\Controllers;

use App\Presensi;
use App\Http\Resources\PresensiResourceCollection;
use App\Http\Resources\PertemuanResource;
use App\Http\Resources\PertemuanResourceCollection;
use App\Http\Resources\ValidasiPresensiResourceCollection;
use App\KelasMahasiswa;
use App\Pertemuan;
use App\User;
use Illuminate\Http\Request;

class PertemuanController extends Controller
{

    public function getForm05($id) {
        $pertemuan = Pertemuan::where('kelas_id',$id)->get();
        if($pertemuan == null) return response()->json(['message' => 'Not Found'],404);
        return new PertemuanResourceCollection($pertemuan);
    }

    public function buatPertemuan($id,Request $request)
    {
        $pertemuan = null;
        $jumlah = Pertemuan::where('kelas_id',$id)->count();
        if(auth()->user()->isDosen()) {
            $pertemuan = Pertemuan::create([
                'pertemuan' => $jumlah + 1,
                'materi' => $request->materi,
                'kelas_id' => $id,
                'valid_dosen' => 1,
                'valid_mahasiswa' => 0,
                'open' => 1
            ]);
        }else {
            $pertemuan = Pertemuan::create([
                'pertemuan' => $jumlah + 1,
                'materi' => $request->materi,
                'kelas_id' => $id,
                'valid_mahasiswa' => 1,
                'valid_dosen' => 0,
                'open' => 1
            ]);
        }
        return new PertemuanResource($pertemuan);
    }

    public function ubahPertemuan($id,Request $request)
    {
        $pertemuan = Pertemuan::find($id);
        if(!auth()->user()->isDosen()) return response()->json(['message'=>'Unauthorized'],401);
        if($pertemuan == null) return response()->json(['message' => 'Pertemuan Not Found'],404);

        $pertemuan->materi = $request->materi;
        $pertemuan->save();

        return response()->json(['message' => 'Success'],200);
    }

    public function hapusPertemuan($id) {
        $pertemuan = Pertemuan::find($id);
        $pertemuan->delete();
        return response()->json(['message' => 'Succes'],200);
    }

    public function validPertemuan($id) {
        $pertemuan = Pertemuan::find($id);
        if(auth()->user()->isDosen()) {
            $pertemuan->valid_dosen();
            $pertemuan->save();
        }
        else {
            $pertemuan->valid_mahasiswa();
            $pertemuan->save();
        }
        return response()->json(['message' => 'Success'],200);
    }

    public function hadirPertemuan($id) {
        auth()->user()->pertemuan()->attach($id);

        return response()->json(['message' => 'Success'],200);
    }

    public function getUnvalidatedPresensi($id) {
        $pertemuan = Pertemuan::find($id);
        $user = $pertemuan->mahasiswa->where('pivot.valid',0);
        return new ValidasiPresensiResourceCollection($user);
    }

    public function validPresensi(Request $request) {
        //if dosen || pj
        $presensi = Presensi::findMany($request);
        foreach($presensi as $each) {
            $each->valid = true;
            $each->save();
        }
        $pertemuan = Pertemuan::find($presensi->first()->pertemuan->id);
        $pertemuan->jumlah_mahasiswa = $pertemuan->mahasiswa->where('pivot.valid',1)->count();
        $pertemuan->save();
        return response()->json(['message' => 'Success'],200);
    }

    public function getForm06($semester,$id) {
        $list_user = KelasMahasiswa::where('kelas_id',$id)->where('semester',$semester)->pluck('user_id');
        $user = User::find($list_user);
        return (new PresensiResourceCollection($user))->kelas($id);
    }

    public function tutupPresensi($id) {
        $pertemuan = Pertemuan::find($id);
        $pertemuan->open = 0;
        $pertemuan->save();
        return response()->json(['message' => 'Success'],200);
    }

    public function assignPenanggungJawabSementara($pertemuan,Request $request) {

        $pertemuan = Pertemuan::find($pertemuan);
        $pertemuan->penanggung_jawab_sementara = $request->mahasiswa;
        $pertemuan->save();
        return response()->json(['message' => 'Success'],200);
    }
}
