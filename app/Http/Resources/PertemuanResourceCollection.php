<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PertemuanResourceCollection extends ResourceCollection
{
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
        return [
            // 'kelas_id' => $this->first()->kelas->id,
            // 'nama' => $this->first()->kelas->mata_kuliah->nama,
            // // 'jadwal' => $this->first()->kelas->jadwal
        ];
    }


}
