<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = "master_film";

    protected $fillable = [
        'nama', 'harga'
    ];

    public function catatan(){
        return $this->hasMany("App\Models\Pemeriksaan");
    }
}
