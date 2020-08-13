<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\User;
        $administrator->name = "admin";
        $administrator->email = "administrator@gmail.com";
        $administrator->password = Hash::make("kepegawaian");
        $administrator->role = "admin";
        $administrator->nama = "administrator";
        $administrator->jenis_kelamin = "pria";
        $administrator->alamat = "Jl. Patroman";
        $administrator->nomor_telepon = "081333333333";
        $administrator->save();
        $this->command->info("User Admin berhasil diinsert");
    }
}
