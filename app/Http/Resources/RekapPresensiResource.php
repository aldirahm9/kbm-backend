<?php

namespace App\Http\Resources;

use App\Pertemuan;
use App\Presensi;
use Illuminate\Http\Resources\Json\JsonResource;

class RekapPresensiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pertemuan = Pertemuan::where('kelas_id',$this->kelas)->get();
        $presensi = Presensi::where('user_id',auth()->user()->id)->whereIn('pertemuan_id',$pertemuan->pluck('id'))->get();
        $arr = [];
        foreach($pertemuan as $key=>$item) {
            if($presensi->contains('pertemuan_id',$item->id) && $presensi->where('pertemuan_id',$item->id)->first()->valid == 1)
            $arr[$key] = 1;
            else
            $arr[$key] = 0;
        }

        return [
            'nama_kelas' => $this->namaMK,
            'pertemuan' => $arr

        ];
    }
}
