<?php

namespace App\Http\Controllers;

use App\ApiUtils\SiakadUtils;
use App\Exports\NilaiExport;
use App\Http\Resources\NilaiResourceCollection;
use App\Http\Resources\TugasResource;
use App\Http\Resources\TugasResourceCollection;
use App\Imports\NilaiImport;
use App\KelasDosen;
use App\KelasMahasiswa;
use App\Pertemuan;
use App\Tugas;
use App\User;
use Illuminate\Http\Request;
use Excel;


class TugasController extends Controller
{
    public function getForm06Nilai($semester,$id) {
        $list_user = KelasMahasiswa::where('kelas_id',$id)->where('semester',$semester)->pluck('user_id');
        $user = User::find($list_user);
        return (new NilaiResourceCollection($user))->kelas($id);
    }

    public function getTugas($id) {
        $tugas = Tugas::where('kelas_id',$id)->get();
        return (new TugasResourceCollection($tugas))->kelas($id);
    }

    public function buatTugas($id, Request $request) {
        if(!auth()->user()->isDosen()) return response()->json(['message' => 'Unauthorized'],401);
        if($request->tipe == 2 && Pertemuan::where('kelas_id',$id)->count() < 12) return response()->json(['message' => 'Pertemuan belum cukup untuk melaksanakan UAS'],403);
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

        //TODO: UPDATE NILAI AKHIR
        $this->updateNilaiAkhir($tugas->kelas_id);
        return response()->json(['Message' => 'Success'],200);
    }

    public function editTugasArray(Request $request)
    {
        $kelas_id = '';
        foreach($request->tugas as $tugas) {
            $t = Tugas::find($tugas['id']);
            $kelas_id = $t->kelas_id;
            $t->bobot = $tugas['bobot'];
            $t->save();
        }

        //TODO: UPDATE NILAI AKHIR
        $this->updateNilaiAkhir($kelas_id);
        return response()->json(['message' => 'Success']);
    }

    public function exportExcel($semester,$id)
    {
        $resp = SiakadUtils::getKelasInfo($id,$semester,auth()->user()->token_siakad);
        return Excel::download((new NilaiExport($id)),'Nilai_' . $resp->identitas->nama_mk . '.xlsx');
    }

    public function importExcel($semester,$id,Request $request)
    {
        $import = new NilaiImport($id,$semester);
        Excel::import($import, $request->file);
        $errors = $import->getHasil();
        if(empty($errors)) {
            return response()->json(['status'=> 'Success','message' => 'Import Success']);
        }
        return response()->json(['status'=> 'Error','message' => $errors]);
    }

    public function updateNilaiAkhir($kelas_id) {
        $tugas_ids = Tugas::where('kelas_id',$kelas_id)->pluck('id');
        $list_user = KelasMahasiswa::where('kelas_id',$kelas_id)->pluck('user_id'); //NOTE: NEED SEMESTER?
        $user = User::find($list_user);
        foreach($user as $u) {
            $nilai_akhir = 0;

            foreach($u->tugas->whereIn('id',$tugas_ids) as $nilai_mhs) {
                $nilai_akhir = $nilai_akhir + ($nilai_mhs->pivot->nilai * $nilai_mhs->bobot / 100);
            }
            $kelasUser = $u->kelas->where('kelas_id',$kelas_id)->first();
            $kelasUser->nilai = $nilai_akhir;
            $kelasUser->save();
        }
    }
}

