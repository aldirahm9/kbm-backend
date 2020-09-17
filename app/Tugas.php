<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{

    protected $table = 'tugas';

    protected $fillable = [
        'nama', 'tipe'
    ];

    public function mahasiswa()
    {
        return $this->belongsToMany('App\Mahasiswa')
                    ->as('nilai')
                    ->withPivot('nilai')
                    ->withTimestamps();
    }

    public function pertemuan()
    {
        return $this->belongsTo('App\Pertemuan');
    }
}
