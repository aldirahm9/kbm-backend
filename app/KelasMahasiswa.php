<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class KelasMahasiswa extends Model //Merupakan class pivot antara mahasiswa dan kelas(siakad)
{

    protected $table = 'kelas_mahasiswa';

    protected $fillable = [
        'kelas_id', 'user_id', 'nilai', 'penanggung_jawab','semester'
    ];



}
