<?php

use App\KelasMahasiswa;
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
        $d = App\User::create([
            'username' => '0015067705',
            'nama' => 'Med Irzal',
            'role' => 3,
            'password' => bcrypt('dosen'),
            'token_siakad' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6IjMxNDUxNjEzMjQiLCJwYXNzd29yZCI6Ijk2YWxkaTk5In0.OMOH-dUhJLFma6XpQzPSgRnU_KAOGmV2hQL-ljl5LDY',
            'prodi_id' => 1
        ]);

       $p = App\User::create([
           'username' => '3145160515',
           'nama' => 'Puti Andini',
           'role' => 1,
           'prodi_id' => 1,
           'password' => bcrypt('123'),
       ]);
       KelasMahasiswa::create([
        'kelas_id' => '3903',
        'user_id' => $p->id,
        'semester' => '110'
        ]);

        $p = App\User::create([
            'username' => '3145161574',
            'nama' => 'Dwi Solihatun',
            'role' => 1,
            'prodi_id' => 1,
            'password' => bcrypt('123'),
        ]);
        KelasMahasiswa::create([
         'kelas_id' => '3903',
         'user_id' => $p->id,
         'semester' => '110'
         ]);

         $p = App\User::create([
            'username' => '3145160864',
            'nama' => 'Ardie Perdana',
            'role' => 1,
            'prodi_id' => 1,
            'password' => bcrypt('123'),
        ]);
        KelasMahasiswa::create([
         'kelas_id' => '3903',
         'user_id' => $p->id,
         'semester' => '110'
         ]);

         $p = App\User::create([
            'username' => '3145161387',
            'nama' => 'Zulfa Aginka',
            'role' => 1,
            'prodi_id' => 1,
            'password' => bcrypt('123'),
        ]);
        KelasMahasiswa::create([
         'kelas_id' => '3903',
         'user_id' => $p->id,
         'semester' => '110'
         ]);

         App\User::create([
             'username' => "123",
             'nama' => 'Admin',
             'role' => 4,
             'password' => bcrypt('123')
         ]);
    }
}
