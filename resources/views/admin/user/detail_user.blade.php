@extends('layouts.global')

@section('title')Detail User @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Detail User
    </h1>
    <ol class="breadcrumb">
        @if ($user->role == 'dokterPoli' || $user->role == 'dokterRadiologi')
        <li><a href="{{ route('dokter.index') }}"><i class="fa fa-user-md"></i> Dokter</a>
            @else
        <li><a href="{{ route('pegawai.index') }}"><i class="fa fa-users"></i> Pegawai</a>
            @endif
        <li class="active">Detail User</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if ($user->avatar == null)
                    <img class="profile-user-img img-responsive img-circle"
                        src="{{ asset('adminlte/dist/img/avatar1.png') }}" alt="User profile picture">
                    @else
                    <img class="profile-user-img img-responsive img-circle"
                        src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="User profile picture">
                    @endif
                    <h3 class="profile-username text-center">{{ $user->nama }}</h3>

                    @switch($user->role)
                    @case('resepsionis')
                    <p class="text-muted text-center">
                        Resepsionis
                    </p>
                    @break
                    @case('dokterPoli')
                    <p class="text-muted text-center">
                        Dokter Poli
                    </p>
                    @break
                    @case('dokterRadiologi')
                    <p class="text-muted text-center">
                        Dokter Radiologi
                    </p>
                    @break
                    @case('radiografer')
                    <p class="text-muted text-center">
                        Radiografer
                    </p>
                    @break
                    @case('kasir')
                    <p class="text-muted text-center">
                        Kasir
                    </p>
                    @break
                    @default
                    @endswitch
                    <hr>

                    <strong><i class="fa fa-book margin-r-5"></i> NIP</strong>

                    <p class="text-muted">
                        @if ($user->role == 'dokterPoli' || $user->role == 'dokterRadiologi')
                        {{ $user->sip }}
                        @else
                        {{ $user->nip }}
                        @endif
                    </p>

                    <hr>

                    @if ($user->role == 'dokterPoli' || $user->role == 'dokterRadiologi')
                    <strong><i class="fa fa-book margin-r-5"></i> Spesialis</strong>

                    <p class="text-muted">
                        {{ Str::replaceArray('_', [' '], ucfirst($user->spesialis)) }}
                    </p>

                    <hr>
                    @else
                    <strong><i class="fa fa-book margin-r-5"></i> Jabatan</strong>

                    <p class="text-muted">
                        @if ($user->jabatan == 'pendaftaran_ri')
                        Resepsionis Pendaftaran Rawat Inap
                        @endif
                        @if ($user->jabatan == 'pendaftaran_rj')
                        Resepsionis Pendaftaran Rawat Jalan
                        @endif
                        @if ($user->jabatan == 'radiografer')
                        Radiografer
                        @endif
                        @if ($user->jabatan == 'kasir')
                        Kasir
                        @endif
                    </p>

                    <hr>
                    @endif

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Nomor Telepon</strong>

                    <p class="text-muted">{{ $user->nomor_telepon }}</p>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Email</strong>

                    <p class="text-muted">{{ $user->email }}</p>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>

                    <p class="text-muted">{{ $user->alamat }}</p>

                    <hr>

                    <strong><i class="fa fa-user margin-r-5"></i> Jenis Kelamin</strong>

                    <p class="text-muted">{{ ucfirst($user->jenis_kelamin) }}</p>

                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-8">
            @switch($user->role)
            @case('dokterPoli')
            @if ($rujukan != null)
            <div id="box-riwayat" class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-header">
                    <h3 class="box-title">Riwayat Rujukan</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="18%">Nomor Rujukan</th>
                                <th>Tanggal Rujukan</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th width="30%">Nama</th>
                                <th width="5%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th width="5%">Jadwal</th>
                                <th width="40%">Dokter Rujukan</th>
                                <th>Keluhan</th>
                                <th>Permintaan Tambahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rujukan as $r)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $r->nomor_pendaftaran }}</td>
                                <td>{{ $r->created_at }}</td>
                                <td>{{ $r->pasien->nomor_rm }}</td>
                                <td>{{ $r->pasien->nomor_ktp }}</td>
                                <td>{{ $r->pasien->nama }}</td>
                                <td>{{ ucfirst($r->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($r->layanan->nama) }}</td>
                                <td>{{ $r->jadwal->waktu_mulai }} WIB - {{ $r->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ ($r->id_dokterRadiologi) != null ? $r->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($r->keluhan) != null ? ucfirst($r->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($r->permintaan_tambahan) != null ? ucfirst($r->permintaan_tambahan) : "Tidak ada" }}
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
            @endif
            @break
            @case('dokterRadiologi')
            @if ($pemeriksaan_dokter != null)
            <div id="box-riwayat" class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-header">
                    <h3 class="box-title">Riwayat Pemeriksaan</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemeriksaan_dokter as $pd)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pd->nomor_pemeriksaan }}</td>
                                <td>{{ $pd->pasien->nomor_rm }}</td>
                                <td>{{ $pd->pasien->nama }}</td>
                                <td>{{ ($pd->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($pd->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($pd->layanan->nama) }}</td>
                                <td>{{ $pd->jadwal->waktu_mulai }} WIB - {{ $pd->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $pd->waktu_selesai }}</td>
                                <td>{{ ($pd->id_dokterPoli) != null ? $pd->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($pd->keluhan) != null ? ucfirst($pd->keluhan) : "Tidak ada" }}</td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
            @endif
            @break
            @case('radiografer')
            @if ($pemeriksaan_radiografer != null)
            <div id="box-riwayat" class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-header">
                    <h3 class="box-title">Riwayat Pemeriksaan</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="40%">Nomor Pemeriksaan</th>
                                <th>Nomor RM</th>
                                <th width="30%">Nama</th>
                                <th width="15%">Jenis Pasien</th>
                                <th width="2%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Waktu Selesai</th>
                                <th width="15%">Dokter Perujuk</th>
                                <th width="15%">Dokter Rujukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemeriksaan_radiografer as $pr)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pr->nomor_pemeriksaan }}</td>
                                <td>{{ $pr->pasien->nomor_rm }}</td>
                                <td>{{ $pr->pasien->nama }}</td>
                                <td>{{ ($pr->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($pr->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($pr->layanan->nama) }}</td>
                                <td>{{ $pr->jadwal->waktu_mulai }} WIB - {{ $pr->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ $pr->waktu_selesai }}</td>
                                <td>{{ ($pr->id_dokterPoli) != null ? $pr->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($pr->id_dokterRadiologi) != null ? $pr->dokterRadiologi->nama : "-" }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @break
            @case('kasir')
            @if ($tagihan != null)
            <div id="box-riwayat" class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-header">
                    <h3 class="box-title">Riwayat Pembayaran</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
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
                                <th>Kasir</th>
                                <th>Total Tarif</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->tanggal }}</td>
                                <td>{{ $t->nomor_tagihan }}</td>
                                <td>{{ $t->pasien->nama }}</td>
                                <td>{{ $t->pasien->nomor_rm }}</td>
                                <td>{{ $t->pasien->nomor_ktp }}</td>
                                <td>{{ ($t->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($t->pemeriksaan->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($t->layanan->nama) }}</td>
                                <td>{{ $t->jadwal->waktu_mulai }} - {{ $t->jadwal->waktu_selesai }}</td>
                                <td>@currency($t->tarif_dokter)</td>
                                <td>@currency($t->tarif_jasa)</td>
                                <td>{{ ucfirst($t->kasir->nama) }}</td>
                                <td>@currency($t->total_harga)</td>
                                <td><span class="badge bg-green">LUNAS</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @break
            @case('resepsionis')
            @if ($pendaftaran != null)
            <div id="box-riwayat" class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-header">
                    <h3 class="box-title">Riwayat Pendaftaran</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="18%">Nomor Pendaftaran</th>
                                <th>Nomor RM</th>
                                <th width="30%">Nama</th>
                                <th width="15%">Jenis Pasien</th>
                                <th width="5%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th width="5%">Jadwal</th>
                                <th width="40%">Dokter Rujukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_pendaftaran }}</td>
                                <td>{{ $p->pasien->nomor_rm }}</td>
                                <td>{{ $p->pasien->nama }}</td>
                                <td>{{ ($p->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} WIB - {{ $p->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @break
            @default
            @endswitch
        </div>
    </div>
</section>
@endsection
@push('scripts')
@endpush
