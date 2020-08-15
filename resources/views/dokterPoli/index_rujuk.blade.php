@extends('layouts.global')

@section('title') List Rujuk Pemeriksaan @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Rujuk Pemeriksaan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> List Rujuk Pemeriksaan</a></li>
    </ol>
</section>

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

            @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-dismissable">
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
            <div class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Rujuk</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th>Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Dokter Perujuk</th>
                                <th>Dokter Rujukan</th>
                                <th>Keluhan</th>
                                <th>Surat Rujukan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rujuk as $r)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $r->nomor_pendaftaran }}</td>
                                <td>{{ $r->pasien->nama }}</td>
                                <td>{{ $r->pasien->nomor_rm }}</td>
                                <td>{{ $r->pasien->nomor_ktp }}</td>
                                <td>{{ ucfirst($r->pasien->jenis_pasien) }}</td>
                                <td>{{ ucfirst($r->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($r->layanan->nama) }}</td>
                                <td>{{ $r->jadwal->waktu_mulai }} - {{ $r->jadwal->waktu_selesai }}</td>
                                <td>{{ $r->created_at->toDateString() }}</td>
                                <td>{{ ($r->id_dokterPoli) != null ? $r->dokterPoli->nama : "-" }}</td>
                                <td>{{ ($r->id_dokterRadiologi) != null ? $r->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($r->keluhan) != null ? ucfirst($r->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($r->surat_rujukan) != null ? 'Ada' : 'Tidak ada' }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if ($r->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('dokterPoli.pasien.pendaftaran.surat-rujukan', ['id'=>$r->id]) }}" target="_blank">Lihat Surat Rujukan </a></li>
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
        <!-- /.row -->
    </div>

</section>

@endsection
