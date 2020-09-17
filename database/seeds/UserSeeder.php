<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dosen = App\Dosen::create([
            'nama' => 'eka',
            'email' => 'eka@unj.com',
            'password' => '123123',
            'nidn' => '123'
        ]);

        $mahasiswa = App\Mahasiswa::create([
            'nama' => 'aldi',
            'email' => 'aldi@unj.com',
            'password' => '123123',
            'nrm' => '123'
        ]);

        $matakuliah = App\MataKuliah::create([
            'nama' => 'PKB',
            'sks' => 3,
            'kode' => '123456'
        ]);
    }
}
