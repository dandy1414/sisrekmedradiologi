@extends('layouts.global')

@section('title') List Pemeriksaan @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Pemeriksaan
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="#"><i class="fa fa-users"></i> Pemeriksaan</a></li>
    </ol>
</section>

{{--  <div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-default" style="background-color: #3c8dbc; color: white" id="button-one"><i class="fa fa-user" style="margin-right: 5px"></i>Belum</button>
            <button class="btn btn-default" id="button-two">Pending</button>
            <button class="btn btn-default" id="button-three">Selesai</button>
        </div>
    </div>
</div>  --}}

<div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-info" id="button-one"><span class="fa fa-stethoscope" style="margin-right: 5px"></span>Belum</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 5px; margin-top: 20px">
            <button class="btn btn-warning" id="button-two"><span class="fa fa-clock-o" style="margin-right: 5px"></span>Pending</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 5px; margin-top: 20px">
            <button class="btn btn-success" id="button-three"><span class="fa fa-check" style="margin-right: 5px"></span>Selesai</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-check"></i>
                    Berhasil
                </h4>
                    {{ $message }}
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info" id="tabelbelum" style="position: relative;" >
                <div class="box-header">
                    <h3 class="box-title">Pasien Belum Diperiksa</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Pemeriksaan</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th>Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>CITO</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Dokter Perujuk</th>
                                <th>Dokter Rujukan</th>
                                <th>Keluhan</th>
                                <th>Permintaan Tambahan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($belum as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $b->nomor_pemeriksaan }}</td>
                                <td>{{ $b->pasien->nama }}</td>
                                <td>{{ $b->pasien->nomor_rm }}</td>
                                <td>{{ $b->pasien->nomor_ktp }}</td>
                                <td>{{ ($b->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($b->jenis_pemeriksaan) }}</td>
                                <td>{{ $b->cito }}</td>
                                <td>{{ ucfirst($b->layanan->nama) }}</td>
                                <td>{{ $b->jadwal->waktu_mulai }} - {{ $b->jadwal->waktu_selesai }}</td>
                                <td>{{ $b->created_at->toDateString() }}</td>
                                <td>{{ ($b->id_dokterPoli) != null ? $b->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($b->id_dokterRadiologi) != null ? $b->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($b->keluhan) != null ? ucfirst($b->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($b->permintaan_tambahan) != null ? ucfirst($b->permintaan_tambahan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('radiografer.pasien.pemeriksaan-pasien', ['id'=>$b->id]) }}">Unggah Hasil</a></li>
                                                @if ($b->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('radiografer.pasien.pendaftaran.surat-rujukan', ['id'=>$b->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box box-warning" id="tabelpending" style="position: relative; display: none">
                <div class="box-header">
                    <h3 class="box-title">Pemeriksaan Pasien Pending </h3>
                </div>
                <div class="box-body">
                    <table id="table2" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Pemeriksaan</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th>Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>CITO</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Waktu Kirim</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Dokter Perujuk</th>
                                <th>Dokter Rujukan</th>
                                <th>Radiografer</th>
                                <th>Keluhan</th>
                                <th>Permintaan Tambahan</th>
                                <th>Tipe Film</th>
                                <th>Arus Listrik</th>
                                <th>FFD</th>
                                <th>BSF</th>
                                <th>Jumlah Penyinaran</th>
                                <th>Dosis Penyinaran</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_pemeriksaan }}</td>
                                <td>{{ $p->pasien->nama }}</td>
                                <td>{{ $p->pasien->nomor_rm }}</td>
                                <td>{{ $p->pasien->nomor_ktp }}</td>
                                <td>{{ ($p->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ $p->cito }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} - {{ $p->jadwal->waktu_selesai }}</td>
                                <td>{{ $p->waktu_kirim }}</td>
                                <td>{{ $p->created_at->toDateString() }}</td>
                                <td>{{ ($p->id_dokterPoli) != null ? $p->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ $p->radiografer->nama }}</td>
                                <td>{{ ($p->keluhan) != null ? ucfirst($p->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($p->permintaan_tambahan) != null ? ucfirst($p->permintaan_tambahan) : "Tidak ada" }}</td>
                                <td>{{ ucfirst($p->film->nama) }}</td>
                                <td>{{ ($p->arus_listrik) != null ? $p->arus_listrik : "-" }}</td>
                                <td>{{ ($p->ffd) != null ? $p->ffd : "-" }}</td>
                                <td>{{ ($p->bsf) != null ? $p->bsf : "-" }}</td>
                                <td>{{ ($p->jumlah_penyinaran) != null ? $p->jumlah_penyinaran : "-" }}</td>
                                <td>{{ ($p->dosis_penyinaran) != null ? $p->dosis_penyinaran : "-" }}</td>
                                <td>{{ ($p->catatan) != null ? $p->catatan : "-" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Detail Pemeriksaan</a></li>
                                                <li><a href="#">Lihat Hasil Foto</a></li>
                                                @if ($p->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('radiografer.pasien.pendaftaran.surat-rujukan', ['id'=>$p->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box box-success" id="tabelselesai" style="position: relative; display: none">
                <div class="box-header">
                    <h3 class="box-title">Pasien Selesai Diperiksa</h3>
                </div>
                <div class="box-body">
                    <table id="table5" class="table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Pemeriksaan</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th>Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>CITO</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Waktu Kirim</th>
                                <th>Waktu Selesai</th>
                                <th>Durasi</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Dokter Perujuk</th>
                                <th>Dokter Rujukan</th>
                                <th>Radiografer</th>
                                <th>Keluhan</th>
                                <th>Permintaan Tambahan</th>
                                <th>Tipe Film</th>
                                <th>Arus Listrik</th>
                                <th>FFD</th>
                                <th>BSF</th>
                                <th>Jumlah Penyinaran</th>
                                <th>Dosis Penyinaran</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selesai as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nomor_pemeriksaan }}</td>
                                <td>{{ $s->pasien->nama }}</td>
                                <td>{{ $s->pasien->nomor_rm }}</td>
                                <td>{{ $s->pasien->nomor_ktp }}</td>
                                <td>{{ ($s->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($s->jenis_pemeriksaan) }}</td>
                                <td>{{ $s->cito }}</td>
                                <td>{{ ucfirst($s->layanan->nama) }}</td>
                                <td>{{ $s->jadwal->waktu_mulai }} - {{ $s->jadwal->waktu_selesai }}</td>
                                <td>{{ $s->waktu_kirim }}</td>
                                <td>{{ $s->waktu_selesai }}</td>
                                <td>{{ $s->durasi }}</td>
                                <td>{{ $s->created_at->toDateString() }}</td>
                                <td>{{ ($s->id_dokterPoli) != null ? $s->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($s->id_dokterRadiologi) != null ? $s->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ $s->radiografer->nama }}</td>
                                <td>{{ ($s->keluhan) != null ? ucfirst($s->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($s->permintaan_tambahan) != null ? ucfirst($s->permintaan_tambahan) : "Tidak ada" }}</td>
                                <td>{{ ucfirst($s->film->nama) }}</td>
                                <td>{{ ($s->arus_listrik) != null ? $s->arus_listrik : "-" }}</td>
                                <td>{{ ($s->ffd) != null ? $s->ffd : "-" }}</td>
                                <td>{{ ($s->bsf) != null ? $s->bsf : "-" }}</td>
                                <td>{{ ($s->jumlah_penyinaran) != null ? $s->jumlah_penyinaran : "-" }}</td>
                                <td>{{ ($s->dosis_penyinaran) != null ? $s->dosis_penyinaran : "-" }}</td>
                                <td>{{ ($s->catatan) != null ? $s->catatan : "-" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="fa fa-gears"></span>
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Detail Pemeriksaan</a></li>
                                                @if ($s->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('radiografer.pasien.pendaftaran.surat-rujukan', ['id'=>$s->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                <li><a href="{{ route('radiografer.pasien.pemeriksaan.hasil-expertise', ['id'=>$s->id]) }}" target="_blank">Lihat Hasil Expertise </a></li>
                                                @endif
                                                <li><a href="#">Cetak Expertise</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>

</section>

@endsection
@push('scripts')
<script>
$("#button-one").click(function () {
    // $(this).css("background", "#3c8dbc");
    // $(this).css("color", "white");
    // $("#button-two").css("background", "#ecf0f5")
    // $("#button-two").css("color", "black")
    // $("#button-three").css("background", "#ecf0f5")
    // $("#button-three").css("color", "black")
    $("#tabelbelum").show(1000)
    $("#tabelpending").hide(300)
    $("#tabelselesai").hide(300)
})
$("#button-two").click(function () {
    // $(this).css("background", "#3c8dbc");
    // $(this).css("color", "white");
    // $("#button-one").css("background", "#ecf0f5")
    // $("#button-one").css("color", "black")
    // $("#button-three").css("background", "#ecf0f5")
    // $("#button-three").css("color", "black")
    $("#tabelpending").show(1000)
    $("#tabelbelum").hide(300)
    $("#tabelselesai").hide(300)
})
$("#button-three").click(function () {
    // $(this).css("background", "#3c8dbc");
    // $(this).css("color", "white");
    // $("#button-one").css("background", "#ecf0f5")
    // $("#button-one").css("color", "black")
    // $("#button-two").css("background", "#ecf0f5")
    // $("#button-two").css("color", "black")
    $("#tabelselesai").show(1000)
    $("#tabelbelum").hide(300)
    $("#tabelpending").hide(300)
})
</script>
@endpush