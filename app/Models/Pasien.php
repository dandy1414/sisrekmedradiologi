<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pasien extends Model
{
    use SoftDeletes;

    protected $table = "trans_pasien";
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama', 'id_ruangan', 'nomor_rm', 'nomor_ktp', 'jenis_pasien',
        'umur', 'jenis_kelamin', 'alamat', 'nomor_telepon', 'jenis_asuransi', 'nomor_bpjs',
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        ->format('d, F Y H:i');
    }

    public function ruangan(){
        return $this->belongsTo("App\Models\Ruangan", "id_ruangan", "id");
    }

    public function pendaftaran(){
        return $this->hasMany("App\Models\Pendaftaran");
    }

    public function pemeriksaan(){
        return $this->hasMany("App\Models\Pemeriksaan");
    }

    public function tagihan(){
        return $this->hasMany("App\Models\Tagihan");
    }

}
