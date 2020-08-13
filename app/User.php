<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'email', 'password','role', 'nama', 'sip', 'nip', 'jenis_kelamin', 'alamat', 'nomor_telepon', 'avatar', 'jadwal_praktek'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pemeriksaan(){
        return $this->hasMany("App\Models\Pemeriksaan");
    }

    public function pendaftaran(){
        return $this->hasMany("App\Models\Pendaftaran");
    }

    public function tagihan(){
        return $this->hasMany("App\Models\Tagihan");
    }

}
