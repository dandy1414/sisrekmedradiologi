<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Pemeriksaan extends Model
{
    use AutoNumberTrait;

    protected $table = "trans_pemeriksaan";
    protected $primarykey = 'id_pemeriksaan';
    protected $fillable = [
        'id_pemeriksaan', 'id_pasien', 'id_layanan', 'id_jadwal', 'id_resepsionis', 'id_dokterPoli', 'id_dokterRadiologi', 'nomor_pendaftaran', 'jenis_pemeriksaan', 'keluhan', 'surat_rujukan', 'total_tarif',
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        ->format('d, F Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])
        ->format('d, F Y H:i');
    }

    public function getAutoNumberOptions()
    {
        return [
            'nomor_pemeriksaan' => [
                'format' => function () {
                    return 'PEM/'.date('d-m-Y').'/?';
                },
                'length' => 5
            ]
        ];
    }

    public function radiografer(){
        return $this->belongsTo("App\User", "id_radiografer", "id");
    }

    public function dokterPoli(){
        return $this->belongsTo("App\User", "id_dokterPoli", "id");
    }

    public function dokterRadiologi(){
        return $this->belongsTo("App\User", "id_dokterRadiologi", "id");
    }

    public function pendaftaran(){
        return $this->belongsTo("App\Models\Pendaftaran" , "pendaftaran_id", "id");
    }

    public function pasien(){
        return $this->belongsTo("App\Models\Pasien", "pasien_id", "id");
    }

    public function jadwal(){
        return $this->belongsTo("App\Models\Jadwal", "id_jadwal", "id");
    }

    public function tagihan(){
        return $this->hasOne("App\Models\Tagihan");
    }

    public function layanan(){
        return $this->belongsTo("App\Models\Layanan", "id_layanan", "id");
    }

    public function film(){
        return $this->belongsTo("App\Models\Film", "id_film", "id");
    }

    public function ruanganPasien(){
        return $this->hasOneThrough(
            'App\Models\Ruangan'.
            'App\Models\Pasien',
            'id_ruangan',
            'id_pasien',
            'id_ruangan',
            'id_pasien'
        );
    }
}
