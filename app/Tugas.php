<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{

    protected $table = 'tugas';

    protected $fillable = [
        'nama', 'tipe', 'bobot'
    ];

    public function mahasiswa()
    {
        return $this->belongsToMany('App\User','nilai')
                    ->withPivot('nilai')
                    ->withTimestamps();
    }

}
