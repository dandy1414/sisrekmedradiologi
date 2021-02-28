@extends('layouts.global')

@section('title') List Pemeriksaan @endsection

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Pemeriksaan
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="#"><i class="fa fa-users"></i> Pemeriksaan</a></li>
    </ol>
</section>

<div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-info" id="tombol-satu"><span class="fa fa-stethoscope" style="margin-right: 5px"></span>Belum</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 10px; margin-top: 20px">
            <button class="btn btn-success" id="tombol-dua"><span class="fa fa-check" style="margin-right: 5px"></span>Selesai</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-3 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $total_belum }}</h3>

                    <p>Pasien belum expertise</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>

        <div class="col-xs-3 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $total_selesai }}</h3>

                    <p>Pasien selesai expertise hari ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info" id="tabel-belum-expertise" style="position: relative;" >
                <div class="box-header">
                    <h3 class="box-title">Pasien Belum Dilakukan Expertise</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="30%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="20%">Nama</th>
                                <th width="10%">Jenis Pasien</th>
                                <th width="1%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th width="5%">Waktu Kirim</th>
                                <th width="20%">Dokter Perujuk</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($belum as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $b->nomor_pemeriksaan }}</td>
                                <td>{{ str_pad($b->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $b->pasien->nama }}</td>
                                <td>{{ ($b->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($b->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($b->layanan->nama) }}</td>
                                <td>{{ $b->waktu_kirim }}</td>
                                <td>{{ $b->jadwal->waktu_mulai }} WIB - {{ $b->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ ($b->id_dokterPoli) != null ? $b->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($b->keluhan) != null ? ucfirst($b->keluhan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a id="modal-detail" href="#" data-toggle="modal"
                                                    data-target="#detail-pemeriksaan"
                                                    data-ktp="{{ $b->pasien->nomor_ktp }}"
                                                    data-tanggal="{{ $b->created_at }}"
                                                    data-permintaantambahan="{{ ($b->permintaan_tambahan) != null ? ucfirst($b->permintaan_tambahan) : "Tidak ada" }}"
                                                    data-namaradiografer="{{ $b->radiografer->nama }}">Detail</a>
                                                <li><a href="{{ route('dokterRadiologi.pasien.pendaftaran.surat-rujukan', ['id'=>$b->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                <li><a href="{{ route('dokterRadiologi.pasien.expertise-pasien', ['id'=>$b->id]) }}">Lakukan Expertise</a></li>
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

            <div class="box box-success" id="tabel-selesai-expertise" style="position: relative; display: none">
                <div class="box-header">
                    <h3 class="box-title">Pasien Selesai Dilakukan Expertise</h3>
                </div>
                <div class="box-body">
                    <table id="table2" class="table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="50%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="20%">Nama</th>
                                <th width="10%">Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th width=2%>Jadwal</th>
                                <th width="5%">Selesai Expertise</th>
                                <th width="20%">Dokter Perujuk</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selesai as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nomor_pemeriksaan }}</td>
                                <td>{{ str_pad($s->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $s->pasien->nama }}</td>
                                <td>{{ ($s->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($s->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($s->layanan->nama) }}</td>
                                <td>{{ $s->jadwal->waktu_mulai }} WIB - {{ $s->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $s->waktu_selesai }}</td>
                                <td>{{ ($s->id_dokterPoli) != null ? $s->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($s->keluhan) != null ? ucfirst($s->keluhan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                            data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('dokterRadiologi.pasien.pendaftaran.surat-rujukan', ['id'=>$s->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                <li><a href="{{ route('dokterRadiologi.pasien.detail-pemeriksaan', ['id' => $s->id]) }}">Detail Pemeriksaan</a></li>
                                                <li><a href="{{ route('dokterRadiologi.pasien.pemeriksaan.hasil-expertise', ['id'=>$s->id]) }}" target="_blank">Lihat Hasil Expertise </a></li>
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

<div class="modal fade" id="detail-pemeriksaan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center">Detail Pemeriksaan</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Tanggal Pendaftaran</th>
                                    <td><span id="tanggal"></span></td>
                                </tr>

                                <tr>
                                    <th>Nomor KTP</th>
                                    <td><span id="nomor-ktp"></span></td>
                                </tr>

                                <tr>
                                    <th>Radiografer</th>
                                    <td><span id="nama-radiografer"></span></td>
                                </tr>

                                <tr>
                                    <th>Permintaan Tambahan</th>
                                    <td><span id="permintaan-tambahan"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '#modal-detail', function() {
            var tanggal = $(this).data('tanggal');
            var ktp_pasien = $(this).data('ktp');
            var nama_radiografer = $(this).data('namaradiografer');
            var keluhan_pasien = $(this).data('keluhanpasien');
            var permintaan_tambahan = $(this).data('permintaantambahan');
            $('#tanggal').text(tanggal);
            $('#nomor-ktp').text(ktp_pasien);
            $('#nama-radiografer').text(nama_radiografer);
            $('#keluhan-pasien').text(keluhan_pasien);
            $('#permintaan-tambahan').text(permintaan_tambahan);
        })
    })

$("#tombol-satu").click(function () {
    $("#tabel-belum-expertise").show(1000)
    $("#tabel-selesai-expertise").hide(300)
})
$("#tombol-dua").click(function () {
    $("#tabel-selesai-expertise").show(1000)
    $("#tabel-belum-expertise").hide(300)
})
</script>

@if (Session::has('login_succeed'))
<script>
swal('Login Berhasil', '{!! Session::get('login_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('upload_succeed'))
<script>
swal('Berhasil', '{!! Session::get('upload_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif
@endpush
