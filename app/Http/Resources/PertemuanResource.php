<?php

namespace App\Http\Resources;

use App\KelasMahasiswa;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PertemuanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($pj = KelasMahasiswa::where('kelas_id',$this->kelas_id)->where('penanggung_jawab',1)->first()) $user_pj = User::find($pj->user_id)->username;
        else $user_pj = '';
        $hadir = auth()->user()->pertemuan->where('id',$this->id)->count() >= 1 ? true : false;
        return [
            'id' => $this->id,
            'pertemuan' => $this->pertemuan,
            'materi' => $this->materi,
            'valid_dosen' => $this->valid_dosen == 1? true : false,
            'valid_mahasiswa' => $this->valid_mahasiswa == 1 ? true: false,
            'jumlah_mahasiswa' => $this->jumlah_mahasiswa == null ? 0 : $this->jumlah_mahasiswa,
            'penanggung_jawab' => $this->penanggung_jawab_sementara != null ? $this->penanggung_jawab_sementara : $user_pj,
            'hadir' => $hadir,
            'hadir_valid' => $hadir ? (auth()->user()->pertemuan->where('id',$this->id)->first()->pivot->valid == 1 ? true : false) : false,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('l, d/m/Y H:m:s'),
        ];
    }

    public function with($request) {
        return [
            'kelas_id' =>$this->kelas_id
        ];
    }
}
