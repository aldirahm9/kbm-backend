<?php

use App\Kelas;
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
            'nama' => 'dosen',
            'email' => 'dosen@unj.com',
            'password' => bcrypt('123123'),
            'nomor_induk' => '123',
            'dosen' => 1
        ]);

        $mahasiswa = App\User::create([
            'nama' => 'aldi',
            'email' => 'aldi@unj.com',
            'password' => bcrypt('123123'),
            'nomor_induk' => '3145161324'
        ]);

        App\User::create([
            'nama' => 'mahasiswa',
            'email' => 'mahasiswa@unj.com',
            'password' => bcrypt('123123'),
            'nomor_induk' => '125223'
        ]);

        $mata_kuliah = App\MataKuliah::create([
            'nama' => 'Pengantar Kecerdasan Buatan',
            'sks' => 3,
            'kode' => '123456'
        ]);

        App\MataKuliah::create([
            'nama' => 'OSK',
            'sks' => 3,
            'kode' => '1234562'
        ]);

        $kelas = Kelas::create([
            'mata_kuliah_id' => $mata_kuliah->id
        ]);

        $mahasiswa->kelas()->attach($kelas->id);
        $dosen->kelas()->attach($kelas->id);

    }
}
