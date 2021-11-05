<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelasDosen extends Model
{
    protected $table = 'kelas_dosen';

    protected $fillable = [
        'kelas_id', 'user_id','semester'
    ];

}
