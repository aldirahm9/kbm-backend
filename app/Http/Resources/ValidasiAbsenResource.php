<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ValidasiAbsenResource extends JsonResource
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
            'id' => $this->pivot->id,
            'mahasiswa_id' => $this->id,
            'nama' => $this->nama,
            'nomor_induk' => $this->username,
            'waktu' => \Carbon\Carbon::parse($this->pivot->created_at)->translatedFormat('H:m:s'),
        ];
    }
}
