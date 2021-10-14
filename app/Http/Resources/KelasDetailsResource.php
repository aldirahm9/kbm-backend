<?php

namespace App\Http\Resources;

use App\KelasMahasiswa;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class KelasDetailsResource extends JsonResource
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

        $arr_dosen = explode('<br/>', $this->dosen);

        $dosen = array_map(function ($val) {
               return explode('-',$val)[1];
        },$arr_dosen);

        if(auth()->user()->isDosen()) {
            return [
                'nama' => $this->namamk,
                'sks' => $this->sksmk,
                'hari' => $hari,
                'jam' => $waktu,
                'dosen' => $dosen,
                // 'penanggung_jawab' => KelasMahasiswa::where('kelas_id',$this->kelas)->where('user_id',auth()->user()->id)->first()->penanggung_jawab == 1? true : false
                'penanggung_jawab_isExists' => KelasMahasiswa::where('kelas_id',$this->kelas)->where('penanggung_jawab',1)->count() > 0 ? true : false
            ];
        } else {
            try {
                return [
                    'nama' => $this->namamk,
                    'sks' => $this->sksmk,
                    'hari' => $hari,
                    'jam' => $waktu,
                    'dosen' => $dosen,
                    'penanggung_jawab' => KelasMahasiswa::where('kelas_id',$this->kelas)->where('user_id',auth()->user()->id)->first()->penanggung_jawab == 1? true : false
                ];
            }   catch (Exception $e) {
                    abort(403, 'access denied');
            }

        }
    }
}
