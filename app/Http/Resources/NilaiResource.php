<?php

namespace App\Http\Resources;

use App\Kelas;
use App\Tugas;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class NilaiResource extends JsonResource
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
        $tugas = Tugas::where('kelas_id',$this->kelas)->pluck('id');
        return [
            'mahasiswa_id' => $this->id,
            'nama' => $this->nama,
            'nomor_induk' => $this->nomor_induk,
            'tugas' =>
            $this->tugas()->whereIn('tugas_id',$tugas)->where('tipe',0)->get(['pertemuan_id','nilai','tugas_id'])->makeHidden('pivot'),
            'UTS' => $this->tugas()->whereIn('tugas_id',$tugas)->where('tipe',1)->get(['pertemuan_id','nilai','tugas_id'])->makeHidden('pivot')->first(),
            'UAS' => $this->tugas()->whereIn('tugas_id',$tugas)->where('tipe',2)->get(['pertemuan_id','nilai','tugas_id'])->makeHidden('pivot')->first(),
        ];
    }
}
