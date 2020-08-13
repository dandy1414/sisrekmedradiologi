<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_pasien', function (Blueprint $table) {
            $table->increments('id_pasien');
            $table->integer('nomor_rm')->unique();
            $table->integer('id_ruangan')->unsigned();
            $table->integer('nomor_ktp')->unique();
            $table->enum('jenis_pasien', ['umum', 'rs']);
            $table->string('nama_pasien');
            $table->date('tanggal_lahir');
            $table->char('jenis_kelamin');
            $table->text('alamat');
            $table->integer('nomor_telepon')->nullable();
            $table->enum('jenis_asuransi', ['bjs', 'umum', 'lainnya']);
            $table->integer('nomor_bpjs')->nullable()->unique();
            $table->enum('status_periksa', ['sudah','pending','belum']);
            $table->enum('status_pasien', ['rs','umum']);
            $table->timestamps();

        });

        Schema::table('trans_pasien', function (Blueprint $table){
            $table->foreign('id_ruangan')->references('id_ruangan')->on('master_ruangan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_pasien');
    }
}
