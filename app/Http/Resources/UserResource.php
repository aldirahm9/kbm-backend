<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->role == 1) $role = 'Mahasiswa';
        else if($this->role == 2) $role = 'Dosen';
        else if($this->role == 3) $role = 'TPjM';
        else if($this->role == 4) $role = 'Admin';

        $user = User::find($this->id);
        return [
            'username' => $this->username,
            'nama' => $this->nama,
            'role' => $role,
            'prodi' => $user->prodi->nama,
        ];
    }
}
