<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResourceCollection;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function getDosen() {
        $prodi = auth()->user()->prodi;
        $dosen = User::whereIn('role',[2,3])->where('prodi_id',$prodi->id)->get();

        return new UserResourceCollection($dosen);
    }

    public function switchRole($username) {
        $dosen = User::where('username',$username)->first();

        if($dosen->role == 2)
            $dosen->role = 3;
        else if($dosen->role == 3)
            $dosen->role = 2;
        $dosen->save();
        return response()->json(['message' => 'Success']);
    }
}
