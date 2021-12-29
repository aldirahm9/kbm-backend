<?php

use App\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Semester::create([
            'semester' => '110'
        ]);
        Semester::create([
            'semester' => '109'
        ]);
        Semester::create([
            'semester' => '108'
        ]);

    }
}
