<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{

    protected $table = 'mata_kuliah';

    protected $fillable = [
        'kode','nama', 'sks'
    ];

}
