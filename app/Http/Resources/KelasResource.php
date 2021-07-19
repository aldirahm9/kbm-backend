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

        $time1 = substr($this->jam,strpos($this->jam,"(") + 1,5);
        $duration = $this->sksMK * 50;
        $time2 = strtotime($time1 . ' +' . $duration . ' minutes');

        return [
            'id' => $this->idkrs,
            'nama' => $this->namaMK,
            'mata_kuliah_id' => $this->kodemk,
            'sks' => $this->sksMK,
            'hari' => $this->hari,
            'jam' => $time1 . ' - ' . date('H:i',$time2),
            'penanggung_jawab' => Kelas::where('kelas_id',$this->idkrs)->first()->penanggung_jawab == 1? true : false
        ];
    }
}
