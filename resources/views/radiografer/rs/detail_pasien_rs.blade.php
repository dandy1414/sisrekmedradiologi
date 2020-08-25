@extends('layouts.global')

@section('title') Detail Pasien Rumah Sakit @endsection

@section('content')

<section class="content-header" style="margin-top: 50px;">
    <h1>
        Detail Pasien Rumah Sakit
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('radiografer.pasien.index-pasien-rs') }}"><i class="fa fa-users"></i> Pasien RS</a></li>
        <li class="active">Detail Pasien RS</li>
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
                            <strong><i class="fa fa-calendar"></i> Tanggal Pendaftaran :</strong>

                            <p class="text-muted">{{ $pasien->created_at->toDateString() }}</p>

                            <strong><i class="fa fa-medkit"></i> Nomor Rekam Medis :</strong>

                            <p class="text-muted">{{ $pasien->nomor_rm }}</p>

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

                            <strong><i class="fa fa-hospital-o"></i> Asal Ruangan / Kelas :</strong>

                            <p class="text-muted">{{ $pasien->ruangan->nama_ruangan }} / {{ $pasien->ruangan->kelas }}</p>

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
                            @foreach ($pemeriksaan as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_pemeriksaan }}</td>
                                <td>{{ $p->pasien->nama }}</td>
                                <td>{{ $p->pasien->nomor_rm }}</td>
                                <td>{{ $p->pasien->nomor_ktp }}</td>
                                <td>{{ ucfirst($p->pasien->jenis_pasien) }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ $p->cito }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} - {{ $p->jadwal->waktu_selesai }}</td>
                                <td>{{ $p->created_at }}</td>
                                <td>{{ ($p->id_dokterPoli) != null ? $p->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($p->keluhan) != null ? ucfirst($p->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($p->permintaan_tambahan) != null ? ucfirst($p->permintaan_tambahan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if ($p->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('radiografer.pasien.pendaftaran.surat-rujukan', ['id'=>$p->pendaftaran_id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
                                                <li><a href="{{ route('radiografer.pasien.pemeriksaan.hasil-expertise', ['id'=>$p->id]) }}" target="_blank">Lihat Hasil Expertise </a></li>
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
