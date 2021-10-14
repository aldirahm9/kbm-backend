<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RPSKelas extends Model
{
    protected $table = "rps_kelas";

    protected $fillable = [
        "kelas_id", 'filename'
    ];
}
