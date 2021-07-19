<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Absen extends Pivot
{
    protected $table = 'absen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertemuan_id', 'user_id', 'valid','created_at','id'
    ];

    public function pertemuan()
    {
        return $this->belongsTo('App\Pertemuan');
    }

}
