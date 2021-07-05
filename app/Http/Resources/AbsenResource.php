<?php

namespace App\Http\Resources;

use App\Kelas;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
{

    protected $kelas;
    function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function kelas($value){
        $this->kelas = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'mahasiswa_id' => $this->id,
            'nama' => $this->nama,
            'nomor_induk' => $this->username,
            'pertemuan' =>
                $this->pertemuan()->where('kelas_id',$this->kelas)->get(['pertemuan','pertemuan_id','valid'])->sortBy('pertemuan')->makeHidden('pivot'),
        ];
    }

}
