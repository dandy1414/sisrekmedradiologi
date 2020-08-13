<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPendaftaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_pendaftaran', function (Blueprint $table) {
            $table->increments('id_pendaftaran');
            $table->integer('id_pasien')->unsigned()->unique();
            $table->integer('id_resepsionis')->unsigned()->nullable();
            $table->integer('id_layanan')->unsigned()->nullable();
            $table->integer('id_jadwal')->unsigned();
            $table->integer('id_dokter_poli')->unsigned()->nullable();
            $table->integer('id_dokter_radiologi')->unsigned()->nullable();
            $table->integer('nomor_pendaftaran')->unique();
            $table->enum('jenis_pemeriksaan', ['biasa', 'penuh']);
            $table->string('surat_rujukan')->nullable();
            $table->dateTimeTz('tanggal');
            $table->timestamps();
        });

        Schema::table('trans_pendaftaran', function (Blueprint $table){
            $table->foreign("id_pasien")->references("id_pasien")->on("trans_pasien")->onDelete('cascade')->onDelete('cascade');
            $table->foreign("id_resepsionis")->references("id_resepsionis")->on("profile_resepsionis")->onDelete('cascade')->onDelete('cascade');
            $table->foreign("id_dokter_poli")->references("id_dokter")->on("profile_dokter_poli")->onDelete('cascade')->onDelete('cascade');
            $table->foreign("id_dokter_radiologi")->references("id_dokter")->on("profile_dokter_radiologi")->onDelete('cascade')->onDelete('cascade');
            $table->foreign("id_jadwal")->references("id_jadwal")->on("master_jadwal")->onDelete('cascade')->onDelete('cascade');
            $table->foreign("id_layanan")->references("id_layanan")->on("master_layanan")->onDelete('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_pendaftaran');
    }
}
