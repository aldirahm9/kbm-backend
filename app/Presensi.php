<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Presensi extends Pivot
{
    protected $table = 'presensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertemuan_id', 'user_id', 'valid','created_at','id'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function pertemuan()
    {
        return $this->belongsTo('App\Pertemuan');
    }

}
