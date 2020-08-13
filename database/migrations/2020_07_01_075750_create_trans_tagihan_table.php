<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransTagihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_tagihan', function (Blueprint $table) {
            $table->increments('id_tagihan');
            $table->integer('id_pemeriksaan')->unsigned()->unique();
            $table->integer('id_kasir')->unsigned();
            $table->integer('nomor_tagihan')->unique();
            $table->dateTimeTz('tanggal');
            $table->integer('tarif');
            $table->timestamps();
        });

        Schema::table('trans_tagihan', function (Blueprint $table){
            $table->foreign('id_pemeriksaan')->references('id_pemeriksaan')->on('trans_pemeriksaan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_kasir')->references('id_kasir')->on('profile_kasir')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_tagihan');
    }
}
