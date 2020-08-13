<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPemeriksaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_pemeriksaan', function (Blueprint $table) {
            $table->increments('id_pemeriksaan');
            $table->integer('id_pasien')->unsigned();
            $table->integer('id_layanan')->unsigned();
            $table->integer('id_film')->unsigned();
            $table->integer('id_jadwal')->unsigned()->unique();
            $table->integer('id_dokter_poli')->unsigned()->nullable();
            $table->integer('id_dokter_radiologi')->unsigned()->nullable();
            $table->integer('id_radiografer')->unsigned();
            $table->enum('jenis_pemeriksaan', ['biasa', 'penuh']);
            $table->string('hasil_foto');
            $table->string('surat_rujukan')->nullable();
            $table->text('anamnesa')->nullable();
            $table->string('keluhan')->nullable();
            $table->text('permintaan_tambahan')->nullable();
            $table->dateTimeTz('waktu_kirim')->nullable();
            $table->dateTimeTz('waktu_selesai')->nullable();
            $table->dateTime('durasi')->nullable();
            $table->enum('cito', ['ya', 'tidak'])->nullable();
            $table->integer('arus_listrik')->nullable();
            $table->integer('ffd')->nullable();
            $table->integer('bsf')->nullable();
            $table->integer('jumlah_penyinaran')->nullable();
            $table->integer('dosis_penyinaran')->nullable();
            $table->text('catatan')->nullable();
            $table->integer('total_tarif');
            $table->timestamps();
        });

        Schema::table('trans_pemeriksaan', function (Blueprint $table){
            $table->foreign('id_pasien')->references('id_pasien')->on('trans_pasien')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_layanan')->references('id_layanan')->on('master_layanan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_jadwal')->references('id_jadwal')->on('master_jadwal')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign("id_dokter_poli")->references("id_dokter")->on("profile_dokter_poli")->onDelete('cascade')->onDelete('cascade');
            $table->foreign("id_dokter_radiologi")->references("id_dokter")->on("profile_dokter_radiologi")->onDelete('cascade')->onDelete('cascade');
            $table->foreign('id_radiografer')->references('id_radiografer')->on('profile_radiografer')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_film')->references('id_film')->on('master_film')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_pemeriksaan');
    }
}
