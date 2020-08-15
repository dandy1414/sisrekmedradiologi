@extends('layouts.global')

@section('title') Detail Pasien Umum @endsection

@section('content')

<section class="content-header" style="margin-top: 50px;">
    <h1>
        Detail Pasien Umum
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('resepsionis.pasien.index-pasien-umum') }}"><i class="fa fa-users"></i> Pasien Umum</a></li>
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
                                <th>Surat Rujukan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $p)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $p->nomor_pendaftaran }}</td>
                                <td>{{ $p->jenis_pemeriksaan }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} - {{ $p->jadwal->waktu_selesai }}</td>
                                <td>{{ $p->created_at->toDateString() }}</td>
                                <td>{{ ($p->id_dokterPoli) != null ? $p->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($p->id_resepsionis) != null ? $p->resepsionis->nama : "-" }}</td>
                                <td>{{ ($p->keluhan) != null ? ucfirst($p->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($p->surat_rujukan) != null ? 'Ada' : 'Tidak ada' }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if ($p->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('resepsionis.pasien.pendaftaran.surat-rujukan', ['id'=>$p->id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
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
</section>

@endsection
