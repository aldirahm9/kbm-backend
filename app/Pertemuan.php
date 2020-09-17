<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{

    protected $table = 'pertemuan';

    protected $fillable = [
        'pertemuan', 'materi', 'validDosen', 'validMahasiswa'
    ];

    public function kelas()
    {
        return $this->belongsTo('App\Kelas');
    }

    public function tugas()
    {
        return $this->hasMany('App\Tugas');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany('App\Mahasiswa')
                    ->as('absen')
                    ->withPivot(['valid'])
                    ->withTimestamps();
    }
}
