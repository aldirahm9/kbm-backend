<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TugasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(auth()->user()->dosen == 1) {
            return [
                'id' => $this->id,
                'nama' => $this->nama,
                'tipe' => $this->tipe,
                'bobot' => $this->bobot,
                'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('l, d/m/Y'),
            ];
        } else {
            return [
                'id' => $this->id,
                'nama' => $this->nama,
                'tipe' => $this->tipe,
                'bobot' => $this->bobot,
                'nilai' => $this->mahasiswa->where('user_id',auth()->user()->id)->first(),
                'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('l, d/m/Y'),
            ];
        }
    }
}
