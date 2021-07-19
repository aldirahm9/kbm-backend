<?php

namespace App\Http\Controllers;

use App\ApiUtils\SiakadUtils;
use App\Exports\NilaiExport;
use App\Http\Resources\NilaiResourceCollection;
use App\Http\Resources\TugasResource;
use App\Http\Resources\TugasResourceCollection;
use App\Imports\NilaiImport;
use App\Kelas;
use App\Tugas;
use App\User;
use Illuminate\Http\Request;
use Excel;

class TugasController extends Controller
{
    public function getForm06Nilai($id) {
        $list_user = Kelas::where('kelas_id',$id)->pluck('user_id');
        $user = User::find($list_user);
        return (new NilaiResourceCollection($user))->kelas($id);
    }

    public function getTugas($id) {
        $tugas = Tugas::where('kelas_id',$id)->get();
        return new TugasResourceCollection($tugas);
    }

    public function buatTugas($id, Request $request) {
        // if(!auth()->user()->isDosen()) return response()->json(['message' => 'Unauthorized'],401);
        $tugas = Tugas::create([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'bobot' => $request->bobot,
            'kelas_id' => $id
        ]);
        return new TugasResource($tugas);
    }

    public function hapusTugas($id)
    {
        $tugas = Tugas::find($id);
        if($tugas==null) return response()->json(['Message' => 'Tugas tidak ditemukan'],404);
        $tugas->delete();
        return response()->json(['Message'=> "Success"],200);
    }

    public function ubahTugas($id, Request $request)
    {
        $tugas = Tugas::find($id);
        // if($tugas==null) return response()->json(['Message' => 'Tugas tidak ditemukan'],404);
        $tugas->nama = $request->nama;
        $tugas->bobot = $request->bobot;
        $tugas->tipe = $request->tipe;
        $tugas->save();
        return response()->json(['Message' => 'Success'],200);
    }

    public function exportExcel($id)
    {
        $resp = SiakadUtils::getKelasMahasiswaBySemester(auth()->user()->username,config('semester.semesterAktif'),auth()->user()->token_siakad);
        $found = collect($resp->isi)->where('idkrs',$id)->first();
        return Excel::download((new NilaiExport($id)),'Nilai_' . $found->namaMK . '.xlsx');
    }

    public function importExcel($id,Request $request)
    {
        Excel::import(new NilaiImport($id), $request->file);
    }
}
