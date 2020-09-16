@extends('layouts.global')

@section('title') List Pendaftaran @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Pendaftaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"> List Pendaftaran</a></li>
    </ol>
</section>


<section class="content">
    <div class="row">
        <div class="col-xs-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $total_pasien }}</h3>

                    <p>Pendaftaran pasien hari ini</p>
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
                                <th width="18%">Nomor Pendaftaran</th>
                                <th>Nomor RM</th>
                                <th width="30%">Nama</th>
                                <th width="15%">Jenis Pasien</th>
                                <th width="5%">Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th width="5%">Jadwal</th>
                                <th width="40%">Dokter Rujukan</th>
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_pendaftaran }}</td>
                                <td>{{ str_pad($p->pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $p->pasien->nama }}</td>
                                <td>{{ ($p->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($p->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($p->layanan->nama) }}</td>
                                <td>{{ $p->jadwal->waktu_mulai }} WIB - {{ $p->jadwal->waktu_selesai }} WIB</td>
                                <td>{{ ($p->id_dokterRadiologi) != null ? $p->dokterRadiologi->nama : "-" }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a id="modal-detail" href="#" data-toggle="modal"
                                                        data-target="#detail-pendaftaran"
                                                        data-ktp="{{ $p->pasien->nomor_ktp }}"
                                                        data-tanggal="{{ $p->created_at }}"
                                                        data-perujuk="{{ ($p->id_dokterPoli) != null ? $p->dokterPoli->nama : "Tidak ada" }}"
                                                        data-resepsionis="{{ ($p->id_resepsionis) != null ? $p->resepsionis->nama : "Tidak ada" }}"
                                                        data-keluhanpasien="{{ ($p->keluhan) != null ? ucfirst($p->keluhan) : "Tidak ada" }}">Detail</a>
                                                </li>
                                                @if ($p->jenis_pemeriksaan == 'penuh')
                                                <li><a href="{{ route('resepsionis.pasien.pendaftaran.surat-rujukan', ['id'=>$p->id]) }}"
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
        <!-- /.row -->
    </div>

    <div class="modal fade" id="detail-pendaftaran">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center">Detail Pendaftaran</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Tanggal Pendaftaran</th>
                                        <td><span id="tanggal"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Nomor KTP</th>
                                        <td><span id="nomor-ktp"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Dokter Perujuk</th>
                                        <td><span id="dokter-perujuk"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Resepsionis</th>
                                        <td><span id="resepsionis"></span></td>
                                    </tr>

                                    <tr>
                                        <th>Keluhan</th>
                                        <td><span id="keluhan-pasien"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>

</section>

@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '#modal-detail', function() {
            var tanggal = $(this).data('tanggal');
            var ktp_pasien = $(this).data('ktp');
            var dokter_perujuk = $(this).data('perujuk');
            var resepsionis = $(this).data('resepsionis');
            var keluhan_pasien = $(this).data('keluhanpasien');
            $('#tanggal').text(tanggal);
            $('#nomor-ktp').text(ktp_pasien);
            $('#dokter-perujuk').text(dokter_perujuk);
            $('#resepsionis').text(resepsionis);
            $('#keluhan-pasien').text(keluhan_pasien);
        })
    })
</script>
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
