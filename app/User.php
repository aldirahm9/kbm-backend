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
        'username', 'nama', 'role', 'password', 'token_siakad', 'prodi_id'
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
        if($this->isDosen())
        return $this->hasMany('App\KelasDosen');
        else
        return $this->hasMany('App\KelasMahasiswa');
    }

    public function pertemuan()
    {
        return $this->belongsToMany('App\Pertemuan','presensi')
                    ->using('App\Presensi')
                    ->withPivot(['valid','id'])
                    ->withTimestamps();
    }

    public function tugas()
    {
        return $this->belongsToMany('App\Tugas','nilai')
                    ->withPivot('nilai')
                    ->withTimestamps();
    }

    public function prodi()
    {
        return $this->belongsTo('App\ProgramStudi');
    }

    public function isMahasiswa()
    {
        return $this->role == 1;
    }

    public function isDosen()
    {
        return $this->role >= 2;
    }

    public function isTpjm()
    {
        return $this->role == 3;
    }

    public function isAdmin()
    {
        return $this->role == 0;
    }



}
