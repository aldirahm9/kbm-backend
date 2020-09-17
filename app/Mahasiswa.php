<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    use Notifiable;

    protected $table = 'mahasiswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'nrm'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function kelas()
    {
        return $this->hasMany('App\Kelas');
    }

    public function pertemuan()
    {
        return $this->belongsToMany('App\Pertemuan')
                    ->as('absen')
                    ->withPivot('valid')
                    ->withTimestamps();
    }

    public function tugas()
    {
        return $this->belongsToMany('App\Tugas')
                    ->as('nilai')
                    ->withPivot('nilai')
                    ->withTimestamps();
    }
}
