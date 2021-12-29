<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;

class NilaiUtils{


    static public function nilaiAngkaToHuruf($nilai)
    {
        if($nilai >= 86)
        return 'A';
        else if($nilai >= 81)
        return 'A-';
        else if($nilai >= 76)
        return 'B+';
        else if($nilai >= 71)
        return 'B';
        else if($nilai >= 66)
        return 'B-';
        else if($nilai >= 61)
        return 'C+';
        else if($nilai >= 56)
        return 'C';
        else if($nilai >= 51)
        return 'C-';
        else if($nilai >= 46)
        return 'D';
        else
        return 'E';
    }
}
