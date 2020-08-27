<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Pendaftaran extends Model
{
    use AutoNumberTrait;

    protected $table = "trans_pendaftaran";
    protected $fillable = [
        'pasien_id', 'id_layanan', 'id_jadwal', 'id_resepsionis', 'id_dokterPoli', 'id_dokterRadiologi', 'nomor_pendaftaran', 'jenis_pemeriksaan', 'keluhan', 'surat_rujukan',
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        ->format('d, F Y H:i');
    }

    public function getAutoNumberOptions()
    {
        return [
            'nomor_pendaftaran' => [
                'format' => function () {
                    return 'PEN/'. date('d-m-Y').'/?';
                },
                'length' => 5
            ]
        ];
    }

    public function resepsionis(){
        return $this->belongsTo("App\User", "id_resepsionis", "id");
    }

    public function dokterPoli(){
        return $this->belongsTo("App\User", "id_dokterPoli", "id");
    }

    public function dokterRadiologi(){
        return $this->belongsTo("App\User", "id_dokterRadiologi", "id");
    }

    public function pasien(){
        return $this->belongsTo("App\Models\Pasien", "pasien_id", "id");
    }

    public function jadwal(){
        return $this->belongsTo("App\Models\Jadwal", "id_jadwal", "id");
    }

    public function layanan(){
        return $this->belongsTo("App\Models\Layanan", "id_layanan", "id");
    }

    public function pemeriksaan(){
        return $this->hasOne("App\Models\Pemeriksaan");
    }

}
