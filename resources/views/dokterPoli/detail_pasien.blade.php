@extends('layouts.global')

@section('title') Detail Pasien @endsection

@section('content')

<section class="content-header" style="margin-top: 50px;">
    <h1>
        Detail Pasien
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dokterPoli.pasien.index-pasien') }}"><i class="fa fa-users"></i> Pasien</a></li>
        <li class="active">Detail Pasien</li>
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
                            <p class="text-muted">{{ ($pasien->nomor_bpjs) != null ? $pasien->nomor_bpjs : "-" }}</p>

                            <strong><i class="fa fa-pencil margin-r-5"></i> Asal Ruangan :</strong>
                            <p class="text-muted">{{ ($pasien->ruangan->nama_ruangan) }}</p>

                            <strong><i class="fa fa-pencil margin-r-5"></i> Kelas :</strong>
                            <p class="text-muted">{{ ($pasien->ruangan->kelas) }}</p>
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
                    <h3 class="box-title" style="text-align: center">Riwayat Pemeriksaan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table4" class="table table-bordered table-hover">
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
                            @foreach ($pemeriksaan as $pemeriksaan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pemeriksaan->nomor_pemeriksaan }}</td>
                                <td>{{ $pemeriksaan->pasien->nama }}</td>
                                <td>{{ $pemeriksaan->pasien->nomor_rm }}</td>
                                <td>{{ $pemeriksaan->pasien->nomor_ktp }}</td>
                                <td>{{ ucfirst($pemeriksaan->pasien->jenis_pasien) }}</td>
                                <td>{{ ucfirst($pemeriksaan->jenis_pemeriksaan) }}</td>
                                <td>{{ $pemeriksaan->cito }}</td>
                                <td>{{ ucfirst($pemeriksaan->layanan->nama) }}</td>
                                <td>{{ $pemeriksaan->jadwal->waktu_mulai }} - {{ $pemeriksaan->jadwal->waktu_selesai }}</td>
                                <td>{{ $pemeriksaan->created_at }}</td>
                                <td>{{ ($pemeriksaan->id_dokterPoli) != null ? $pemeriksaan->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($pemeriksaan->id_dokterRadiologi) != null ? $pemeriksaan->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($pemeriksaan->keluhan) != null ? ucfirst($pemeriksaan->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($pemeriksaan->permintaan_tambahan) != null ? ucfirst($pemeriksaan->permintaan_tambahan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Lihat rujukan</a></li>
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
