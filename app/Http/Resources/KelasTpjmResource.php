<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class KelasTpjmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $hari = '';
        $waktu = '';
        if($this->waktu) {
            $string = $this->waktu;
            $arr = explode('<br/>',$string);
            $duration = $this->sksmk * 50;
            $hari = explode(' ',$arr[0])[0];
            $time1 = explode(' ',$arr[0])[2];
            $time2 = strtotime($time1 . ' +' . $duration . ' minutes');
            $waktu = substr($time1,0,5) . ' - ' . date('H:i',$time2);
        }

        $dosen_arr = explode('-',$this->dosen);
        $dosen = [];
        foreach($dosen_arr as $key=>$item) {
            if($key == 0 ) {
                continue;
            } elseif($key != sizeOf($dosen_arr)-1) {
                $dosen[] = explode('<',$item)[0];
            }else {
                $dosen[] = $item;
            }
        }
        return [
            'id' => $this->kelas,
            'nama' => $this->namamk,
            'dosen' => $dosen,
            'hari' => $hari,
            'jam' => $waktu,
        ];
    }
}
