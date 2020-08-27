<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Tagihan extends Model
{
    use AutoNumberTrait;

    protected $table = "trans_tagihan";
    protected $fillable = [
        'pasien_id', 'id_kasir', 'id_film', 'id_layanan', 'id_pemeriksaan', 'nomor_tagihan', 'status_pembayaran', 'tarif_dokter', 'tarif_jasa', 'tanggal', 'total_harga'
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        ->format('d, F Y H:i');
    }

    public function getTanggalAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['tanggal'])
        ->format('d, F Y H:i');
    }

    public function getAutoNumberOptions()
    {
        return [
            'nomor_tagihan' => [
                'format' => function () {
                    return 'TAG/'. date('d-m-Y').'/?';
                },
                'length' => 5
            ]
        ];
    }

    public function kasir(){
        return $this->belongsTo("App\User", "id_kasir", "id");
    }

    public function pemeriksaan(){
        return $this->belongsTo("App\Models\Pemeriksaan", "id_pemeriksaan", "id");
    }

    public function pasien(){
        return $this->belongsTo("App\Models\Pasien", "pasien_id", "id");
    }

    public function layanan(){
        return $this->belongsTo("App\Models\Layanan", "id_layanan", "id");
    }

    public function film(){
        return $this->belongsTo("App\Models\Film", "id_film", "id");
    }

    public function jadwal(){
        return $this->belongsTo("App\Models\Jadwal", "id_jadwal", "id");
    }

}
