@extends('layouts.global')

@section('title') Detail Pasien Umum @endsection

@section('content')

<section class="content-header" style="margin-top: 50px;">
    <h1>
        Detail Pasien Umum
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('kasir.pasien.index-pasien-umum') }}"><i class="fa fa-users"></i> Pasien Umum</a></li>
        <li class="active">Detail Pasien Umum</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title" style="text-align: center">Data Pasien</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-7">
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Tanggal Pendaftaran :</strong>
                            <p class="text-muted">{{ $pasien->created_at->toDateString() }}</p>

                            <strong><i class="fa fa-book margin-r-5"></i> Nomor Rekam Medis :</strong>
                            <p class="text-muted">{{ $pasien->nomor_rm }}</p>

                            <strong><i class="fa fa-book margin-r-5"></i> Nomor KTP :</strong>
                            <p class="text-muted">{{ $pasien->nomor_ktp }}</p>

                            <strong><i class="fa fa-pencil margin-r-5"></i> Nama :</strong>
                            <p class="text-muted">{{ $pasien->nama }}</p>

                            <strong><i class="fa fa-pencil margin-r-5"></i> Jenis Kelamin :</strong>
                            <p class="text-muted">{{ ucfirst($pasien->jenis_kelamin) }}</p>

                            <strong><i class="fa fa-pencil margin-r-5"></i> Umur :</strong>
                            <p class="text-muted">{{ $pasien->jenis_kelamin }} tahun</p>
                        </div>

                        <div class="col-md-5">
                            <strong><i class="fa fa-pencil margin-r-5"></i> Alamat :</strong>
                            <p class="text-muted">{{ ucfirst($pasien->alamat) }}</p>

                            <strong><i class="fa fa-pencil margin-r-5"></i> Nomor telepon :</strong>
                            <p class="text-muted">{{ $pasien->nomor_telepon }}</p>

                            <strong><i class="fa fa-pencil margin-r-5"></i> Jenis Asuransi :</strong>
                            <p class="text-muted">{{ ucfirst($pasien->jenis_asuransi) }}</p>

                            <strong><i class="fa fa-pencil margin-r-5"></i> Nomor BPJS :</strong>
                            <p class="text-muted">
                                {{ ($pasien->nomor_bpjs) != null ? $pasien->nomor_bpjs : "-" }}</p>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title" style="text-align: center">Riwayat Tagihan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table4" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nomor Tagihan</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th>Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Tarif Dokter</th>
                                <th>Tarif Jasa</th>
                                <th>Total Tarif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->tanggal }}</td>
                                <td>{{ $s->nomor_tagihan }}</td>
                                <td>{{ $s->pasien->nama }}</td>
                                <td>{{ $s->pasien->nomor_rm }}</td>
                                <td>{{ $s->pasien->nomor_ktp }}</td>
                                <td>{{ ($s->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($s->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($s->layanan->nama) }}</td>
                                <td>{{ $s->jadwal->waktu_mulai }} - {{ $s->jadwal->waktu_selesai }}</td>
                                <td>@currency($s->tarif_dokter)</td>
                                <td>@currency($s->tarif_jasa)</td>
                                <td>@currency($s->total_harga)</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="fa fa-gears"></span>
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Detail Pembayaran</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
