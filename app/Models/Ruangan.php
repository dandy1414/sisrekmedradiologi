<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = "master_ruangan";

    public function pasien(){
        return $this->hasMany("App\Models\Pasien");
    }
}
