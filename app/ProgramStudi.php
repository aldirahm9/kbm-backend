<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';

    protected $fillable = [
        'nama', 'kode', 'fakultas_id'
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function fakultas()
    {
        return $this->belongsTo('App\Fakultas');
    }
}
