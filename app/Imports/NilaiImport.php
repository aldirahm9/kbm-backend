<?php

namespace App\Imports;

use App\ApiUtils\SiakadUtils;
use App\KelasMahasiswa;
use App\Tugas;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NilaiImport implements ToCollection
{

    private $errors;

    public function __construct($id,$semester)
    {
        $this->kelas_id = $id;
        $this->semester = $semester;
    }

    public function getHasil() {
        return $this->errors;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $kelas_info = SiakadUtils::getKelasInfo($this->kelas_id,$this->semester,auth()->user()->token_siakad);
        $sks = $kelas_info->identitas->sks;
        $this->errors = [];
        foreach ($rows as $key=>$row)
        {
            if($key < 2) continue;

           $user = User::where('username',$row[0])->first();
           $tugas = array_slice($row->toArray(),2,-4);

           $tugas_ids = Tugas::where('kelas_id',$this->kelas_id)->where('tipe',0)->pluck('id');
           $nilai = [];
           $index = 0;
           foreach($tugas as $each) {
               if($tugas[$index] !== null)
               $nilai[$tugas_ids[$index]] = ['nilai'=> $tugas[$index]];
               $index++;

            }

            $uts_id = Tugas::where('kelas_id',$this->kelas_id)->where('tipe',1)->pluck('id')->first();
            if($uts_id && $row[count($row)-4] !== null) {
                $nilai[$uts_id] = ['nilai' => $row[count($row)-4]];
            }

            $uas_id = Tugas::where('kelas_id',$this->kelas_id)->where('tipe',2)->pluck('id')->first();
            if($uas_id && $row[count($row)-3] !== null) {
                //cek dulu presensi mhsnya cukup atau engga
                $jumlah_hadir = $user->pertemuan->where('kelas_id',$this->kelas_id)->where('valid',1)->count();
                if($sks == 3 && $jumlah_hadir >= 13) {
                    $nilai[$uas_id] = ['nilai' => $row[count($row)-3]];
                }
                else {
                    //gaboleh ikut uas
                    array_push($this->errors,'Jumlah hadir mahasiswa ' . $user->username . ' tidak mencukupi untuk mengikuti UAS');
                }
            }

            $user->tugas()->syncWithoutDetaching($nilai);
            $nilai_akhir = 0;

            foreach($user->tugas->whereIn('id',$tugas_ids) as $nilai_mhs) {
                $nilai_akhir = $nilai_akhir + ($nilai_mhs->pivot->nilai * $nilai_mhs->bobot / 100);
            }
            $kelas = KelasMahasiswa::where('kelas_id',$this->kelas_id)->where('user_id',$user->id)->first();
            $kelas->nilai = $nilai_akhir;
            $kelas->save();
        }
    }




}
