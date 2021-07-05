<?php

namespace App\Http\Resources;

use App\Kelas;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasResource extends JsonResource
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
            'id' => $this->idkrs,
            'nama' => $this->namaMK,
            'mata_kuliah_id' => $this->kodemk,
            'sks' => $this->sksMK,
            'penanggung_jawab' => Kelas::where('kelas_id',$this->idkrs)->first()->penanggung_jawab == 1? true : false
        ];
    }
}
