<?php

namespace App\Http\Controllers\API;

use App\Models\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function getAllPasien(Request $request)
    {
        $pasiens = Pasien::all();

        if($pasiens){
            return ResponseFormatter::success($pasiens, 'Data pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien tidak ditemukan', 404);
        }
    }

    public function getAllPasienUmum(Request $request)
    {
        $pasiens = Pasien::where('jenis_pasien', 'umum')->get();

        if($pasiens){
            return ResponseFormatter::success($pasiens, 'Data pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien tidak ditemukan', 404);
        }
    }

    public function getAllPasienRs(Request $request)
    {
        $pasiens = Pasien::where('jenis_pasien', 'rs')->get();

        if($pasiens){
            return ResponseFormatter::success($pasiens, 'Data pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien tidak ditemukan', 404);
        }
    }

    public function getPasienUmumDetailsById(Request $request, $id)
    {
        $pasien = Pasien::select()
            ->where('id', $id)
            ->where('jenis_pasien', 'umum')
            ->first();

        if($pasien){
            return ResponseFormatter::success($pasien, 'Data detail pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data detail pasien tidak ditemukan', 404);
        }
    }

    public function getPasienRsDetailsById(Request $request, $id)
    {
        $pasien = Pasien::select()
            ->where('id', $id)
            ->where('jenis_pasien', 'rs')
            ->first();

        if($pasien){
            return ResponseFormatter::success($pasien, 'Data detail pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data detail pasien tidak ditemukan', 404);
        }
    }

    public function getAllPasienUmumWithPemeriksaan(Request $request)
    {
        $pemeriksaan = Pasien::with('pemeriksaan')->where('jenis_pasien', 'umum')->get();

        if($pemeriksaan){
            return ResponseFormatter::success($pemeriksaan, 'Data pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien tidak ditemukan', 404);
        }
    }

    public function getAllPasienRsWithPemeriksaan(Request $request)
    {
        $pemeriksaan = Pasien::with('pemeriksaan')->where('jenis_pasien', 'rs')->get();

        if($pemeriksaan){
            return ResponseFormatter::success($pemeriksaan, 'Data pasien beserta data pemeriksaan berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien beserta data pemeriksaan tidak ditemukan', 404);
        }
    }

    public function getAllPasienUmumWithPendaftaran(Request $request)
    {
        $pendaftaran = Pasien::with('pendaftaran')->where('jenis_pasien', 'umum')->get();

        if($pendaftaran){
            return ResponseFormatter::success($pendaftaran, 'Data pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien tidak ditemukan', 404);
        }
    }

    public function getAllPasienRsWithPendaftaran(Request $request)
    {
        $pendaftaran = Pasien::with('pendaftaran')->where('jenis_pasien', 'umum')->get();

        if($pendaftaran){
            return ResponseFormatter::success($pendaftaran, 'Data pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien tidak ditemukan', 404);
        }
    }

    public function getAllPasienUmumWithTagihan(Request $request)
    {
        $tagihan = Pasien::with('tagihan')->where('jenis_pasien', 'umum')->get();

        if($tagihan){
            return ResponseFormatter::success($tagihan, 'Data pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien tidak ditemukan', 404);
        }
    }

    public function getAllPasienRsWithTagihan(Request $request)
    {
        $tagihan = Pasien::with('tagihan')->where('jenis_pasien', 'umum')->get();

        if($tagihan){
            return ResponseFormatter::success($tagihan, 'Data pasien berhasil diambil');
        } else {
            return ResponseFormatter::error(null, 'Data pasien tidak ditemukan', 404);
        }
    }
}
