@extends('layouts.global')

@section('title') Detail Pasien Rumah Sakit @endsection

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

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
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Waktu Selesai</th>
                                <th width="15%">Dokter Perujuk</th>
                                <th width="15%">Dokter Rujukan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemeriksaan as $p)
                            <tr>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_pemeriksaan }}</td>
                                <td>{{ $p->pasien->nomor_rm }}</td>
                                <td>{{ $p->pasien->nama }}</td>
                                <td>{{ ($p->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} WIB - {{ $p->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $p->waktu_selesai }}</td>
                                <td>{{ ($p->id_dokterPoli) != null ? $p->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('radiografer.pasien.detail-pemeriksaan', ['id' => $p->id]) }}">Detail Pemeriksaan</a></li>
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
