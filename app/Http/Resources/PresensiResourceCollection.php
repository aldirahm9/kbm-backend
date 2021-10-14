<?php

namespace App\Http\Resources;

use App\KelasMahasiswa;
use App\Pertemuan;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PresensiResourceCollection extends ResourceCollection
{
    protected $kelas;

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
        $this->collection->each->kelas($this->kelas);
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'meta' => [
                'jumlah_pertemuan' => Pertemuan::where('kelas_id',$this->kelas)->count(),
                'pertemuan_terakhir' => Pertemuan::where('kelas_id',$this->kelas)->get()->last()->created_at->format('d/m/Y H:i')
            ]
        ];
    }
}
