<?php

namespace App\Http\Resources;

use App\KelasMahasiswa;
use App\Tugas;
use App\User;
use App\Utils\NilaiUtils;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class NilaiResource extends JsonResource
{
    protected $kelas;
    // function __construct(User $model)
    // {
    //     parent::__construct($model);
    // }

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
        $user = User::find($this->id);
        $nilai_akhir = $user->kelas->where('kelas_id',$this->kelas)->first()->nilai;
        $nilai_huruf = NilaiUtils::nilaiAngkaToHuruf($nilai_akhir);
        return [
            'mahasiswa_id' => $this->id,
            'nama' => $this->nama,
            'nomor_induk' => $this->username,
            'tugas' =>
            $this->tugas()->whereIn('tugas_id',$tugas)->where('tipe',0)->get(['nilai','tugas_id'])->makeHidden('pivot'),
            'UTS' => $this->tugas()->whereIn('tugas_id',$tugas)->where('tipe',1)->get(['nilai','tugas_id'])->makeHidden('pivot')->first(),
            'UAS' => $this->tugas()->whereIn('tugas_id',$tugas)->where('tipe',2)->get(['nilai','tugas_id'])->makeHidden('pivot')->first(),
            'nilai_akhir' => $nilai_akhir,
            'nilai_huruf' => $nilai_huruf
        ];
    }
}
