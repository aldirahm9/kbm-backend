<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Absen extends Pivot
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertemuan_id', 'uesr_id', 'valid'
    ];

}
