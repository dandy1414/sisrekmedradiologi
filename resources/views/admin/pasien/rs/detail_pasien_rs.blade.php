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
                            @foreach ($pasien->pendaftaran as $pendaftaran)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $pendaftaran->nomor_pendaftaran }}</td>
                                <td>{{ $pendaftaran->jenis_pemeriksaan }}</td>
                                <td>{{ ucfirst($pendaftaran->layanan->nama) }}</td>
                                <td>{{ $pendaftaran->jadwal->waktu_mulai }} - {{ $pendaftaran->jadwal->waktu_selesai }}</td>
                                <td>{{ $pendaftaran->created_at->toDateString() }}</td>
                                <td>{{ ($pendaftaran->id_dokterPoli) != null ? $pendaftaran->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($pendaftaran->id_dokterRadiologi) != null ? $pendaftaran->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($pendaftaran->id_resepsionis) != null ? $pendaftaran->resepsionis->nama : "-" }}</td>
                                <td>{{ ($pendaftaran->keluhan) != null ? ucfirst($pendaftaran->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($pendaftaran->surat_rujukan) != null ? 'Ada' : 'Tidak ada' }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                {{-- <li><a data-toggle="modal" data-target="#lihat-hasil">Lihat
                                                        hasil</a></li>
                                                <li><a data-toggle="modal" data-target="#lihat-expertise">Lihat
                                                        expertise
                                                    </a></li>
                                                <li><a href="#">Lihat rujukan</a></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="lihat-expertise">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style="text-align: center">Lihat Expertise </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <strong><i class="fa fa-book margin-r-5"></i> Nomor Rekam Medis :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Nomor Pendaftaran :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Nama :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Umur :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Alamat :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>
                                    </div>
                                    <div class="col-xs--6">
                                        <strong><i class="fa fa-book margin-r-5"></i> Jenis Kelamin :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Alamat :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Layanan :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Dokter Perujuk :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Dokter Rujukan :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <h4 class="modal-title" style="text-align: center">Hasil Foto </h4>
                                <hr>
                                disini hasil foto
                                <h4 class="modal-title" style="text-align: center">Expertise</h4>
                                <br>
                                disini hasil expertise
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left"
                                        data-dismiss="modal">Kembali</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </div>
                <div class="modal fade" id="lihat-hasil">
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
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
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
                        @foreach ($pasien->pemeriksaans as $pem)
                        <tbody>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pem->nomor_pemeriksaan }}</td>
                                <td>{{ ucfirst($pem->jenis_pemeriksaan) }}</td>
                                <td>{{ $pem->cito }}</td>
                                <td>{{ ucfirst($pem->layanan->nama) }}</td>
                                <td>{{ $pem->jadwal->waktu_mulai }} - {{ $pem->jadwal->waktu_selesai }}</td>
                                <td>{{ $pem->created_at }}</td>
                                <td>{{ ($pem->id_dokterPoli) != null ? $pem->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($pem->id_dokterRadiologi) != null ? $pem->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($pem->keluhan) != null ? ucfirst($pem->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($pem->permintaan_tambahan) != null ? ucfirst($pem->permintaan_tambahan) : "Tidak ada" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="fa fa-gears"></span>
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a data-toggle="modal" data-target="#lihat-hasil">Lihat
                                                        hasil</a></li>
                                                <li><a data-toggle="modal" data-target="#lihat-expertise">Lihat
                                                        expertise
                                                    </a></li>
                                                <li><a href="#">Lihat rujukan</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>


                <div class="modal fade" id="lihat-expertise">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style="text-align: center">Lihat Expertise </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <strong><i class="fa fa-book margin-r-5"></i> Nomor Rekam Medis :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Nomor Pendaftaran :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Nama :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Umur :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Alamat :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>
                                    </div>
                                    <div class="col-xs--6">
                                        <strong><i class="fa fa-book margin-r-5"></i> Jenis Kelamin :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Alamat :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Layanan :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Dokter Perujuk :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>

                                        <strong><i class="fa fa-book margin-r-5"></i> Dokter Rujukan :</strong>

                                        <p class="text-muted">
                                            B.S. in Computer Science from the University of Tennessee at Knoxville
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <h4 class="modal-title" style="text-align: center">Hasil Foto </h4>
                                <hr>
                                disini hasil foto
                                <h4 class="modal-title" style="text-align: center">Expertise</h4>
                                <br>
                                disini hasil expertise
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left"
                                        data-dismiss="modal">Kembali</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </div>
                <div class="modal fade" id="lihat-hasil">
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
                </div>
            </div>
        </div>
    </div> --}}
</section>

@endsection
