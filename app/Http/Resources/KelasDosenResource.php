<?php

namespace App\Http\Resources;

use App\KelasMahasiswa;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasDosenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $time1 = substr($this->awal,0,5);
        $duration = $this->sksmk * 50;
        $time2 = strtotime($time1 . ' +' . $duration . ' minutes');

        if($this->hari == 1) $hari = 'Senin';
        elseif($this->hari == 2) $hari = "Selasa";
        elseif($this->hari == 3) $hari = "Rabu";
        elseif($this->hari == 4) $hari = "Kamis";
        elseif($this->hari == 5) $hari = "Jumat";
        elseif($this->hari == 6) $hari = "Sabtu";
        elseif($this->hari == 0) $hari = "";

        return [
            'id' => $this->kelas,
            'nama' => $this->namamk,
            'mata_kuliah_id' => $this->kodemk,
            'sks' => $this->sksmk,
            'hari' => $hari,
            'jam' => $time1 . ' - ' . date('H:i',$time2),
            // 'penanggung_jawab' => KelasMahasiswa::where('kelas_id',$this->kelas)->where('user_id',auth()->user()->id)->first()->penanggung_jawab == 1? true : false
            'penanggung_jawab_isExists' => KelasMahasiswa::where('kelas_id',$this->kelas)->where('penanggung_jawab',1)->count() > 0 ? true : false
        ];
    }
}
