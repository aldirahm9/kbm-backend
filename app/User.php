<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'nama', 'dosen', 'password', 'token_siakad'
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function kelas()
    {
        return $this->hasMany('App\Kelas');
    }

    public function pertemuan()
    {
        return $this->belongsToMany('App\Pertemuan','absen')
                    ->using('App\Absen')
                    ->withPivot(['valid','id'])
                    ->withTimestamps();
    }

    public function tugas()
    {
        return $this->belongsToMany('App\Tugas','nilai')
                    ->withPivot('nilai')
                    ->withTimestamps();
    }

    public function isDosen()
    {
        return $this->dosen == 1;
    }
}
