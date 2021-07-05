<?php

namespace App\Http\Controllers;

use App\Http\Resources\NilaiResourceCollection;
use App\Http\Resources\TugasResourceCollection;
use App\Kelas;
use App\Tugas;
use App\User;
use Illuminate\Http\Request;

class NilaiController extends Controller
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
}
