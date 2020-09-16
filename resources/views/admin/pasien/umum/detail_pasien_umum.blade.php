@extends('layouts.global')

@section('title') Detail Pasien Umum @endsection

@section('content')

<section class="content-header" style="margin-top: 50px;">
    <h1>
        Detail Pasien Umum
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('pasien.index-pasien-umum') }}"><i class="fa fa-users"></i> Pasien Umum</a></li>
        <li class="active">Detail Pasien Umum</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title" style="text-align: center">Detail Pasien</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-7">
                            <strong><i class="fa fa-calendar"></i> Tanggal Pendaftaran :</strong>

                            <p class="text-muted">{{ $pasien->created_at }}</p>

                            <strong><i class="fa fa-medkit"></i> Nomor Rekam Medis :</strong>

                            <p class="text-muted">{{ str_pad($pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</p>

                            <strong><i class="fa fa-credit-card"></i> Nomor KTP :</strong>

                            <p class="text-muted">{{ $pasien->nomor_ktp }}</p>

                            <strong><i class="fa fa-user"></i> Nama :</strong>

                            <p class="text-muted">{{ $pasien->nama }}</p>

                            <strong><i class="fa fa-user"></i> Jenis Kelamin :</strong>

                            <p class="text-muted">{{ ucfirst($pasien->jenis_kelamin) }}</p>

                            <strong><i class="fa fa-user"></i> Umur :</strong>

                            <p class="text-muted">{{ $pasien->umur }} tahun</p>
                        </div>

                        <div class="col-md-5">
                            <strong><i class="fa fa-home"></i> Alamat :</strong>

                            <p class="text-muted">{{ ucfirst($pasien->alamat) }}</p>

                            <strong><i class="fa fa-phone"></i> Nomor telepon :</strong>

                            <p class="text-muted">{{ $pasien->nomor_telepon }}</p>

                            <strong><i class="fa fa-institution"></i> Jenis Asuransi :</strong>

                            <p class="text-muted">{{ ucfirst($pasien->jenis_asuransi) }}</p>

                            <strong><i class="fa fa-bars"></i> Nomor BPJS :</strong>

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
                    <h3 class="box-title" style="text-align: center">Riwayat Pendaftaran</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table4" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Pendaftaran</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Dokter Perujuk</th>
                                <th>Dokter Rujukan</th>
                                <th>Resepsionis</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $pen)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $pen->nomor_pendaftaran }}</td>
                                <td>{{ ucfirst($pen->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($pen->layanan->nama) }}</td>
                                <td>{{ $pen->jadwal->waktu_mulai }} WIB - {{ $pen->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $pen->created_at }}</td>
                                <td>{{ ($pen->id_dokterPoli) != null ? $pen->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($pen->id_dokterRadiologi) != null ? $pen->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($pen->id_resepsionis) != null ? $pen->resepsionis->nama : "-" }}</td>
                                <td>{{ ($pen->keluhan) != null ? ucfirst($pen->keluhan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if ($pen->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('pasien.pendaftaran.surat-rujukan', ['id'=>$pen->id]) }}"
                                                        target="_blank">Lihat Surat Rujukan </a></li>
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
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title" style="text-align: center">Riwayat Pemeriksaan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Pemeriksaan</th>
                                <th>Jenis Pemeriksaan</th>
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
                        @foreach ($pemeriksaan as $pem)
                        <tbody>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pem->nomor_pemeriksaan }}</td>
                                <td>{{ ucfirst($pem->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($pem->layanan->nama) }}</td>
                                <td>{{ $pem->jadwal->waktu_mulai }} WIB - {{ $pem->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $pem->created_at }}</td>
                                <td>{{ ($pem->id_dokterPoli) != null ? $pem->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($pem->id_dokterRadiologi) != null ? $pem->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($pem->keluhan) != null ? ucfirst($pem->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($pem->permintaan_tambahan) != null ? ucfirst($pem->permintaan_tambahan) : "Tidak ada" }}
                                </td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('pasien.detail-pemeriksaan', ['id' => $pem->id]) }}">Detail Pemeriksaan</a></li>
                                                @if ($pem->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('pasien.pendaftaran.surat-rujukan', ['id'=>$pem->pendaftaran_id]) }}"
                                                        target="_blank">Lihat Surat Rujukan </a></li>
                                                <li><a href="{{ route('pasien.pemeriksaan.hasil-expertise', ['id'=>$pem->pendaftaran_id]) }}"
                                                        target="_blank">Lihat Hasil Expertise </a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                {{--  <div class="modal fade" id="lihat-hasil">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content" style="overflow: auto;">
                            <div class="modal-body" style="height: 500px">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/2/22/Turkish_Van_Cat.jpg"
                                    id="imagepreview" style="width: 100%;height: 100%;position: absolute;">
                            </div>
                        </div>
                        <div style="display: flex;">
                            <button class="btn btn-primary" style="width: 50%;" onclick="zoomin()">Zoom In</button>
                            <button class="btn btn-danger" style="width: 50%;" onclick="zoomout()">Zoom Out</button>
                        </div>
                    </div>
                </div>  --}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success" style="position: relative;">
                <div class="box-header">
                    <h3 class="box-title">Riwayat Pembayaran</h3>
                </div>
                <div class="box-body">
                    <table id="table5" class="table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nomor Tagihan</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Tarif Dokter</th>
                                <th>Tarif Jasa</th>
                                <th>Kasir</th>
                                <th>Total Tarif</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->tanggal }}</td>
                                <td>{{ $t->nomor_tagihan }}</td>
                                <td>{{ ucfirst($t->pemeriksaan->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($t->layanan->nama) }}</td>
                                <td>{{ $t->jadwal->waktu_mulai }} WIB - {{ $t->jadwal->waktu_selesai }} WIB</td>
                                <td>@currency($t->tarif_dokter)</td>
                                <td>@currency($t->tarif_jasa)</td>
                                <td>{{ ucfirst($t->kasir->nama) }}</td>
                                <td>@currency($t->total_harga)</td>
                                <td><span class="badge bg-green">LUNAS</span></td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('pasien.detail-tagihan', ['id'=>$t->id]) }}">Detail
                                                    Pembayaran</a></li>
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
    </div>
</section>

@endsection
