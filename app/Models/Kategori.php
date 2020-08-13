<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "master_kategori";

    protected $fillable = [

    ];

    public function layanan(){
        return $this->hasMany("App\Models\Layanan");
    }
}
