<?php

namespace App\Imports;

use App\Tugas;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NilaiImport implements ToCollection
{
    public function __construct($id)
    {
        $this->kelas_id = $id;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
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
                $nilai[$uas_id] = ['nilai' => $row[count($row)-3]];
            }

            $user->tugas()->syncWithoutDetaching($nilai);
        }
    }




}
