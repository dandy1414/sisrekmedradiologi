<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = "master_jadwal";

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
