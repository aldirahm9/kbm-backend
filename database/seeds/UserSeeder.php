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
        $dosen = App\User::create([
            'nama' => 'eka',
            'email' => 'eka@unj.com',
            'password' => bcrypt('123123'),
            'nomor_induk' => '123',
            'dosen' => 1
        ]);

        $mahasiswa = App\User::create([
            'nama' => 'aldi',
            'email' => 'aldi@unj.com',
            'password' => bcrypt('123123'),
            'nomor_induk' => '1223'
        ]);

        $matakuliah = App\MataKuliah::create([
            'nama' => 'PKB',
            'sks' => 3,
            'kode' => '123456'
        ]);
    }
}
