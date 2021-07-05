<?php

namespace App\Http\Resources;

use App\Kelas;
use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NilaiResourceCollection extends ResourceCollection
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
                'tugas_id' => Kelas::find($this->kelas)->tugas->where('tipe',0)->pluck('id')
            ]
        ];
    }
}
