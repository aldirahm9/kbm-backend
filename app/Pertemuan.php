<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{

    protected $table = 'pertemuan';

    protected $fillable = [
        'id','pertemuan', 'materi', 'valid_dosen', 'valid_mahasiswa','kelas_id','open'
    ];

    public function valid_dosen()
    {
        $this->valid_dosen = 1;
    }

    public function valid_mahasiswa()
    {
        $this->valid_mahasiswa = 1;
    }

    public function tugas()
    {
        return $this->hasMany('App\Tugas');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany('App\User','absen')
                    ->using('App\Absen')
                    ->withPivot(['valid','id'])
                    ->withTimestamps();
    }

}
