<?php

namespace App\Http\Resources;

use App\Utils\NilaiUtils;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TugasResourceCollection extends ResourceCollection
{

    public function kelas($value){
        $this->kelas = $value;
        return $this;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        $nilai_akhir = auth()->user()->kelas->where('kelas_id',$this->kelas)->first()->nilai;
        if(!auth()->user()->isDosen()) {
            return [
                "meta" => [
                    "nilai_akhir" => $nilai_akhir,

                ]
            ];
        }
    }
}
