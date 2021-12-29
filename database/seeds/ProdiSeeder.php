<?php

use App\Fakultas;
use App\ProgramStudi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Fakultas::find(1) == null) {
            $fmipa = Fakultas::create([
                'nama' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam',
                'kode' => 13
            ]);

            ProgramStudi::create([
                'nama' => 'Ilmu Komputer',
                'kode' => 13136,
                'fakultas_id' => $fmipa->id
            ]);

            ProgramStudi::create([
                'nama' => 'Pendidikan Matematika',
                'kode' => 13016,
                'fakultas_id' => $fmipa->id
            ]);

            ProgramStudi::create([
                'nama' => 'Matematika',
                'kode' => 13056,
                'fakultas_id' => $fmipa->id
            ]);

            ProgramStudi::create([
                'nama' => 'Statistika',
                'kode' => 13146,
                'fakultas_id' => $fmipa->id
            ]);

            ProgramStudi::create([
                'nama' => 'S2 Pendidikan Matematika',
                'kode' => 13098,
                'fakultas_id' => $fmipa->id
            ]);
        }


    }
}
