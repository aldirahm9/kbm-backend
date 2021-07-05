<?php

namespace App\Http\Controllers;

use App\Absen;
use App\Http\Resources\AbsenResourceCollection;
use App\Http\Resources\PertemuanResource;
use App\Http\Resources\PertemuanResourceCollection;
use App\Kelas;
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
                'valid_mahasiswa' => 0
            ]);
        }else {
            $pertemuan = Pertemuan::create([
                'pertemuan' => $jumlah + 1,
                'materi' => $request->materi,
                'kelas_id' => $id,
                'valid_mahasiswa' => 1,
                'valid_dosen' => 0
            ]);
        }
        return new PertemuanResource($pertemuan);
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

    public function validPresensi($id) {
        //if dosen || pj
        $absen = Absen::findMany($id);
        foreach($absen as $each) {
            $each->valid = true;
            $each->save();
        }
        return response()->json(['message' => 'Success'],200);
    }

    public function getForm06($id) {
        $list_user = Kelas::where('kelas_id',$id)->pluck('user_id');
        $user = User::find($list_user);
        return (new AbsenResourceCollection($user))->kelas($id);
    }

    public function bukaAbsen($id) {
        $pertemuan = Pertemuan::find($id);
        $pertemuan->open = 1;
        $pertemuan->save();
        return response()->json(['message' => 'Success'],200);
    }
}
