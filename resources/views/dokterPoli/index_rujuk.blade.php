@extends('layouts.global')

@section('title') List Rujuk Pemeriksaan @endsection

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Rujuk Pemeriksaan
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="#"> List Rujuk Pemeriksaan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $total_pasien }}</h3>

                    <p>Rujukan pasien hari ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
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
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rujuk as $r)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $r->nomor_pendaftaran }}</td>
                                <td>{{ $r->created_at }}</td>
                                <td>{{ str_pad($r->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $r->pasien->nomor_ktp }}</td>
                                <td>{{ $r->pasien->nama }}</td>
                                <td>{{ ucfirst($r->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($r->layanan->nama) }}</td>
                                <td>{{ $r->jadwal->waktu_mulai }} WIB - {{ $r->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ ($r->id_dokterRadiologi) != null ? $r->dokterRadiologi->nama : "-" }}</td>
                                <td>{{ ($r->keluhan) != null ? ucfirst($r->keluhan) : "Tidak ada" }}</td>
                                <td>{{ ($r->permintaan_tambahan) != null ? ucfirst($r->permintaan_tambahan) : "Tidak ada" }}</td>
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
@push('scripts')
@if (Session::has('store_succeed'))
<script>
swal('Berhasil', '{!! Session::get('store_succeed') !!}', 'success',{
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
