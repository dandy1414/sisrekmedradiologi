<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(){
        //Tahun untuk kunjungan pasien
        $pendaftaran = DB::table('trans_pendaftaran')->get();
        foreach($pendaftaran as $p){
            $year_kunjungan = explode('-', $p->created_at);
            $year_used_kunjungan[] = $year_kunjungan[0];
        }
        $year_used_kunjungan = array_unique($year_used_kunjungan);

        //Tahun untuk layanan terbanyak
        $pemeriksaan = DB::table('trans_pemeriksaan')->get();
        foreach($pemeriksaan as $p){
            $year_layanan = explode('-', $p->created_at);
            $year_used_layanan[] = $year_layanan[0];
        }
        $year_used_layanan = array_unique($year_used_layanan);

        //Tahun untuk pendapatan terbanyak
        $tagihan = DB::table('trans_tagihan')->get();
        foreach($tagihan as $t){
            $year_tagihan = explode('-', $t->created_at);
            $year_used_tagihan[] = $year_tagihan[0];
        }
        $year_used_tagihan = array_unique($year_used_tagihan);

        //Tahun untuk asuransi terbanyak
        $pasien = DB::table('trans_pasien')->get();
        foreach($pasien as $p){
            $year_pasien = explode('-', $p->created_at);
            $year_used_pasien[] = $year_pasien[0];
        }
        $year_used_pasien = array_unique($year_used_pasien);

        //Tahun untuk durasi
        foreach($pemeriksaan as $p){
            $year_durasi = explode('-', $p->created_at);
            $year_used_durasi[] = $year_durasi[0];
        }
        $year_used_durasi = array_unique($year_used_durasi);

        $bulan = [
            (object)["value"=>'01',"name"=>"Januari"],
            (object)["value"=>'02',"name"=>"Februari"],
            (object)["value"=>'03',"name"=>"Maret"],
            (object)["value"=>'04',"name"=>"April"],
            (object)["value"=>'05',"name"=>"Mei"],
            (object)["value"=>'06',"name"=>"Juni"],
            (object)["value"=>'07',"name"=>"Juli"],
            (object)["value"=>'08',"name"=>"Agustus"],
            (object)["value"=>'09',"name"=>"September"],
            (object)["value"=>'10',"name"=>"Oktober"],
            (object)["value"=>'11',"name"=>"November"],
            (object)["value"=>'12',"name"=>"Desember"],
        ];

        $tgl = date('Y-m-d').'%';
        $total_today = DB::table('trans_pendaftaran')->where('created_at', 'like', $tgl)->count();

        $bln = date('Y-m').'%';
        $total_this_month = DB::table('trans_pendaftaran')->where('created_at', 'like', $bln)->count();

        $yr = date('Y').'%';
        $total_this_year = DB::table('trans_pendaftaran')->where('created_at', 'like', $yr)->count();

        return view('admin.dashboard.dashboard', ['year_used_kunjungan' => $year_used_kunjungan, 'year_used_layanan' => $year_used_layanan, 'year_used_tagihan' => $year_used_tagihan, 'year_used_pasien' => $year_used_pasien, 'year_used_durasi' => $year_used_durasi, 'bulan'=> $bulan, 'total_today' => $total_today, 'total_this_month' => $total_this_month, 'total_this_year' => $total_this_year]);
    }

    public function getKunjunganPasienPerTahun(Request $request){
        $tahun = $request->thn_kunjungan;
        $result = DB::table('trans_pendaftaran')->where('created_at', 'like', $tahun.'%')
        ->orderBy('created_at')
        ->get();

        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];

        $total_pasien = [];
        for($i = 1; $i <= 12; $i++){
            $total_pasien[$i-1] = 0;
        }

        if(isset($result)){
            foreach($result as $data){
                $bulan = explode('-', $data->created_at)[1];
                $total_pasien[$bulan-1]++;
            }
        }

        return response()->json([
            'labels' => $labels,
            'total' => $total_pasien
        ]);
    }

    public function getKunjunganPasienPerBulan(Request $request){
        // $tahun = $request->thn_kunjungan;
        // $bulan = $request->bln_kunjungan;
        $tahun = 2020;
        $bulan = '02';

        $result = DB::table('trans_pendaftaran')->where([
            ['created_at', 'like', $tahun.'-'.$bulan.'%']
        ])->first([
            DB::raw('max(created_at) as max')
        ]);

        if($result->max != null){
            $tgl_max = explode('-', $result->max)[2];

            $tgl_where = $tahun.'-'.$bulan.'%';

            $pasien = DB::table('trans_pendaftaran')->where([
            ['created_at', 'like', $tgl_where]])
            ->get('created_at');

            $total_pasien = [];
            $label = [];

            for($i = 1; $i <= $tgl_max; $i++){
                $total_pasien[] = 0;
                $label[] = $i;
            }
        }else{
            $total_pasien = [];
            $label = [];

            $tgl_max = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

            for($i = 1; $i <= $tgl_max; $i++){
                $total_pasien[] = 0;
                $label[] = $i;
            }
        }

        if(isset($result->max)){
            foreach($pasien as $data){
                $tgl = explode('-', $data->created_at)[2];
                $tgl = explode(' ', $tgl)[0];
                $total_pasien[$tgl-1]++;
            }
        }

        return response()->json([
            'labels' => $label,
            'total' => $total_pasien
        ]);
    }

    public function getPendapatanPerTahun(Request $request){
        $tahun = $request->thn_pendapatan;

        $result = DB::table('trans_tagihan')->where([
            ['tanggal', 'like', $tahun.'%']
        ])->get(['tanggal', 'total_harga']);

        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];

        $total_pendapatan = [];
        for($i = 1; $i <= 12; $i++){
            $total_pendapatan[$i-1] = 0;
        }

        if(isset($result)){
            foreach($result as $data){
                $bulan = explode('-', $data->tanggal)[1];
                $total_pendapatan[$bulan-1]+=$data->total_harga;
            }
        }

        return response()->json([
            'labels' => $labels,
            'total' => $total_pendapatan
        ]);
    }

    public function getPendapatanPerBulan(Request $request){
        $tahun = $request->thn_pendapatan;
        $bulan = $request->bln_pendapatan;
        // $tahun = 2020;
        // $bulan = '02';


        $result = DB::table('trans_tagihan')->where([
            ['tanggal', 'like', $tahun.'-'.$bulan.'%']
        ])->first([
            DB::raw('max(tanggal) as max')
        ]);

        if($result->max != null){
            $tgl_max = explode('-', $result->max)[2];

            $tgl_where = $tahun.'-'.$bulan.'%';

            $tagihan = DB::table('trans_tagihan')->where([
                ['tanggal', 'like', $tgl_where]
            ])->get(['tanggal', 'total_harga']);

            $label = [];
            $total_pendapatan = [];
            for($i = 1; $i <= $tgl_max; $i++){
                $label[] = $i;
                $total_pendapatan[] = 0;
            }
        }else{
            $tgl_max = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

            $label = [];
            $total_pendapatan = [];
            for($i = 1; $i <= $tgl_max; $i++){
                $label[] = $i;
                $total_pendapatan[] = 0;
            }
        }

        if(isset($result->max)){
            foreach($tagihan as $data){
                $tgl = explode('-', $data->tanggal)[2];
                $tgl = explode(' ', $tgl)[0];
                $total_pendapatan[$tgl-1]+=$data->total_harga;
            }
        }

        return response()->json([
            'labels' => $label,
            'total' => $total_pendapatan
        ]);
    }

    public function getJenisAsuransiPerBulan(Request $request){
        // $bulan = $request->bln_asuransi;
        // $tahun = $request->thn_asuransi;
        $bulan = '01';
        $tahun = 2020;

        $tgl_max = DB::table('trans_pasien')->where('created_at', 'like', $tahun.'-'.$bulan.'%')
        ->groupBy('jenis_asuransi')
        ->max('created_at');

        if($tgl_max != null){
            $tgl = explode('-', $tgl_max)[2];
            $tgl = explode(' ', $tgl)[0];

            $temp = [];
            for($i = 1; $i <= $tgl; $i++){
                $temp[] = ['bpjs' => 0, 'umum' => 0, 'tidak ada' => 0, 'lainnya' => 0];
            }

            $trans_pasiens = DB::table('trans_pasien')->where('created_at', 'like', $tahun.'-'.$bulan.'%')
            ->orderBy('created_at')
            ->get(['jenis_asuransi', 'created_at']);
        }else{
            $tgl = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

            $labels = [];
            $total_asuransi = [];
            for($i = 1; $i <= $tgl; $i++){
                $labels[] = 'N/A';
                $total_asuransi[] = 0;
            }
        }

        if(isset($tgl_max)){
            foreach($trans_pasiens as $data){
                $tgl = explode('-', $data->created_at)[2];
                $tgl = explode(' ', $tgl)[0];
                $temp[$tgl-1][$data->jenis_asuransi]++;
            }

            $labels = [];
            $total_asuransi = [];
            foreach($temp as $key => $data){
                $max = 0;
                $labels[$key] = "N/A";
                if($data['bpjs'] > $max) {
                    $labels[$key] = 'BPJS';
                    $max = $data['bpjs'];
                }
                if($data['umum'] > $max) {
                    $labels[$key] = 'Umum';
                    $max = $data['umum'];
                }
                if($data['tidak ada'] > $max) {
                    $labels[$key] = 'Tidak Ada';
                    $max = $data['tidak ada'];
                }
                if($data['lainnya'] > $max) {
                    $labels[$key] = 'Lainnya';
                    $max = $data['lainnya'];
                }
                $total_asuransi[$key] = $max;
            }
        }

        return response()->json([
            'labels' => $labels,
            'total' => $total_asuransi
        ], 200);
    }

    public function getJenisAsuransiPerTahun(Request $request ){
        $tahun = $request->thn_asuransi;

        $result = DB::table('trans_pasien')->where('created_at', 'like', $tahun.'%')
        ->groupBy(['created_at', 'jenis_asuransi'])
        ->get(['created_at', 'jenis_asuransi']);

        if(isset($result)){
            $temp = [];
            for($i = 1; $i <= 12; $i++){
                $temp[] = ['bpjs' => 0, 'umum' => 0, 'tidak ada' => 0, 'lainnya' => 0];
            }

            foreach($result as $data){
                $bulan = explode('-', $data->created_at)[1];
                $temp[$bulan-1][$data->jenis_asuransi]++;
            }

            $labels = [];
            $total_asuransi = [];
            foreach($temp as $key => $data){
                $max = 0;
                $labels[$key] = "N/A";
                if($data['bpjs'] > $max) {
                    $labels[$key] = 'BPJS';
                    $max = $data['bpjs'];
                }
                if($data['umum'] > $max) {
                    $labels[$key] = 'Umum';
                    $max = $data['umum'];
                }
                if($data['tidak ada'] > $max) {
                    $labels[$key] = 'Tidak Ada';
                    $max = $data['tidak ada'];
                }
                if($data['lainnya'] > $max) {
                    $labels[$key] = 'Lainnya';
                    $max = $data['lainnya'];
                }
                $total_asuransi[$key] = $max;
            }
        }else{
            $labels = [];
            $total_asuransi = [];
            for($i = 1; $i <= 12; $i++){
                $labels[] = 'N/A';
                $total_asuransi[] = 0;
            }
        }
        return response()->json([
            'labels' => $labels,
            'total' => $total_asuransi
        ]);
    }

    public function getLayananPerTahun(Request $request){
        $tahun = $request->thn_layanan;

        $tgl_max = DB::table('trans_pemeriksaan')
        ->where('created_at', 'like', $tahun.'%')
        ->max('created_at');

        $nama_layanan = DB::table('master_layanan')->pluck('nama');

        if(isset($tgl_max)){
            $result = DB::table('trans_pemeriksaan as a')
            ->join('master_layanan as b', 'a.id_layanan', 'b.id')
            ->where('a.created_at', 'like', $tahun.'%')
            ->groupBy(['a.created_at', 'a.id_layanan'])
            ->get(['a.created_at', 'a.id_layanan', 'b.nama']);

            $init = [];
            foreach($nama_layanan as $data){
                $init[$data] = 0;
            }

            $temp = [];
            for($i = 1; $i <= 12; $i++){
                $temp[$i-1] = $init;
            }

            foreach($result as $data){
                $bulan = explode('-', $data->created_at)[1];
                $temp[$bulan-1][$data->nama]++;
            }

            $labels = [];
            $total_layanan = [];
            foreach($temp as $key => $data){
                $max = 0;
                $labels[$key] = "N/A";
                foreach($result as $r){
                    if($data[$r->nama] > $max) {
                        $labels[$key] = $r->nama;
                        $max = $data[$r->nama];
                    }
                    $total_layanan[$key] = $max;
                }
            }
        }else{
            $labels = [];
            $total_layanan = [];
            for($i = 1; $i <= 12; $i++){
                $labels[] = 'N/A';
                $total_layanan[] = 0;
            }
        }

        return response()->json([
            'labels' => $labels,
            'total' => $total_layanan
        ]);
    }

    public function getLayananPerBulan(Request $request){
        $tahun = $request->thn_layanan;
        $bulan = $request->bln_layanan;

        $tgl_where = $tahun.'-'.$bulan.'%';

        $tgl_max = DB::table('trans_pemeriksaan')
        ->where('created_at', 'like', $tgl_where)
        ->max('created_at');

        $nama_layanan = DB::table('master_layanan')->pluck('nama');

        if($tgl_max != null){
            $tgl = explode('-', $tgl_max)[2];
            $tgl = explode(' ', $tgl)[0];

            $result = DB::table('trans_pemeriksaan as a')
            ->join('master_layanan as b', 'a.id_layanan', 'b.id')
            ->where('a.created_at', 'like', $tgl_where)
            ->groupBy(['a.created_at', 'a.id_layanan'])
            ->get([
                'a.created_at',
                'a.id_layanan',
                'b.nama'
            ]);

            $init = [];
            foreach($nama_layanan as $data){
                $init[$data] = 0;
            }
            $temp = [];
            for($i = 1; $i <= $tgl; $i++){
                $temp[$i-1] = $init;
            }
        }else{
            $tgl_max = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

            $labels = [];
            $total_layanan = [];
            for($i = 1; $i <= $tgl_max; $i++){
                $labels[] = 'N/A';
                $total_layanan[] = 0;
            }
        }

        if(isset($result)){
            foreach($result as $data){
                $tgl = explode('-', $data->created_at)[2];
                $tgl = explode(' ', $tgl)[0];
                $temp[$tgl-1][$data->nama]++;
            }

            $labels = [];
            $total_layanan = [];
            foreach($temp as $key => $data){
                $max = 0;
                $labels[$key] = "N/A";
                foreach($result as $r){
                    if($data[$r->nama] > $max) {
                        $labels[$key] = $r->nama;
                        $max = $data[$r->nama];
                    }
                    $total_layanan[$key] = $max;
                }
            }
        }

        return response()->json([
            'labels' => $labels,
            'total' => $total_layanan
        ]);
    }

    public function getDurasiPerBulan(Request $request){
        $bulan = $request->bln_durasi;
        $tahun = $request->thn_durasi;

        $tgl_where = $tahun.'-'.$bulan.'%';

        $tgl_max = DB::table('trans_pemeriksaan')
        ->where('waktu_selesai', 'like', $tgl_where)
        ->max('waktu_selesai');

        if($tgl_max != null){
            $tgl = explode('-', $tgl_max)[2];
            $tgl = explode(' ', $tgl)[0];

            $result = DB::table('trans_pemeriksaan')
            ->where('waktu_selesai', 'like', $tgl_where)
            ->groupBy(DB::raw('day(waktu_selesai)'))
            ->get([DB::raw('day(waktu_selesai) as day'), DB::raw('min(durasi) as min_durasi')]);

            $labels = [];
            $durasi = [];
            for($i = 1; $i <= $tgl; $i++){
                $labels[$i-1] = $i;
                $durasi[$i-1] = 0;
            }
        }else{
            $tgl = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);

            $labels = [];
            $durasi = [];
            for($i = 1; $i <= $tgl; $i++){
                $labels[$i-1] = $i;
                $durasi[$i-1] = 0;
            }
        }

        if(isset($tgl_max)){

            foreach($result as $data){
                $durasi[$data->day-1] = $data->min_durasi;
            }
        }
        return response()->json([
            'labels' => $labels,
            'total' => $durasi
            ]);
    }

    public function getDurasiPerTahun(Request $request){
        $tahun = $request->thn_durasi;

        $result = DB::table('trans_pemeriksaan')
        ->where('waktu_selesai', 'like', $tahun.'-'.'%')
        ->groupBy(DB::raw('month(waktu_selesai)'))
        ->get([DB::raw('month(waktu_selesai) as month'), DB::raw('min(durasi) as min_durasi')]);

        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];

        $durasi = [];
        for($i = 1; $i <= 12; $i++){
            $labels[$i-1] = $i;
            $durasi[$i-1] = 0;
        }

        if(isset($result)){
            foreach($result as $data){
                $durasi[$data->month-1] = $data->min_durasi;
            }
        }

        return response()->json([
            'labels' => $labels,
            'total' => $durasi
         ]);
    }

}
