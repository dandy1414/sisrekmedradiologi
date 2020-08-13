<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileRadiograferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_radiografer', function (Blueprint $table) {
            $table->increments('id_radiografer');
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
        Schema::dropIfExists('profile_radiografer');
    }
}
