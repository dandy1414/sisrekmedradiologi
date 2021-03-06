<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileDokterRadiologiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_dokter_radiologi', function (Blueprint $table) {
            $table->increments('id_dokter');
            $table->integer('id_user')->unsigned()->unique();
            $table->string('avatar');
            $table->string('nama');
            $table->integer('nip')->unique();
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['pria','wanita']);
            $table->integer('nomor_telepon');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_dokter_radiologi');
    }
}
