<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'pertemuan' => $this->pertemuan,
            'materi' => $this->materi,
            'valid_dosen' => $this->valid_dosen == 1? true : false,
            'valid_mahasiswa' => $this->valid_mahasiswa == 1 ? true: false,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('l, d/m/Y H:m:s'),
            'jumlah_mahasiswa' => $this->jumlah_mahasiswa == null ? 0 : $this->jumlah_mahasiswa,
            'hadir' => auth()->user()->pertemuan->where('id',$this->id)->count() >= 1 ? true : false
        ];
    }

    public function with($request) {
        return [
            'kelas_id' =>$this->kelas_id
        ];
    }
}
