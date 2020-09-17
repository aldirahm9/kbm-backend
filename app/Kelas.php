<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'kodeSeksi','jadwal'
    ];

    protected $table = 'kelas';

    public function mataKuliah()
    {
        return $this->belongsTo('App\Matakuliah');
    }

    public function dosen()
    {
        return $this->belongsToMany('App\Dosen');
    }

    public function mahasiswa()
    {
        return $this->hasMany('App\Mahasiswa');
    }

    public function pertemuan()
    {
        return $this->hasMany('App\Pertemuan');
    }
}
