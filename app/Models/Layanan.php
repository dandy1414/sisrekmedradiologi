<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'master_layanan';
    protected $primarykey = 'id_layanan';

    protected $fillable = [
        'nama', 'id_kategori', 'harga'
    ];

    public function kategori(){
        return $this->belongsTo("App\Models\Kategori", "id_kategori", "id");
    }

    public function pemeriksaan(){
        return $this->hasMany("App\Models\Pemeriksaan");
    }

    public function pendaftaran(){
        return $this->hasMany("App\Models\Pendaftaran");
    }
}
