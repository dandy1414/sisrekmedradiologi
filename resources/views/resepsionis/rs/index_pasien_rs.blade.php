@extends('layouts.global')

@section('title') List Pasien RS @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Pasien Rumah Sakit
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="#"><i class="fa fa-users"></i> Pasien RS</a></li>
    </ol>
</section>

<div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-success" onclick="window.location='{{ route('resepsionis.pasien.create.pasien-rs') }}'"><span class="fa fa-user-plus" style="margin-right: 5px"></span>Tambah Pasien</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Nomor RM</th>
                                <th>Nama</th>
                                <th>Nomor KTP</th>
                                <th>Asal Ruangan</th>
                                <th>Kelas</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Jenis Asuransi</th>
                                <th>Nomor BPJS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pasien as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->created_at }}</td>
                                <td>{{ str_pad($p->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->nomor_ktp }}</td>
                                <td>{{ $p->ruangan->nama_ruangan }}</td>
                                <td>{{ $p->ruangan->kelas }}</td>
                                <td>{{ $p->umur }} tahun</td>
                                <td>{{ $p->jenis_kelamin }}</td>
                                <td>{{ ucfirst($p->alamat) }}</td>
                                <td>{{ $p->nomor_telepon }}</td>
                                <td>{{ ucfirst($p->jenis_asuransi) }}</td>
                                <td>{{ $p->nomor_bpjs == null ? '-' : $p->nomor_bpjs}}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('resepsionis.pasien.detail-pasien-rs', ['id'=>$p->id]) }}">Detail Pasien</a></li>
                                                <li><a href="{{ route('resepsionis.pasien.pendaftaran.pasien-rs',
                                                    ['id'=>$p->id]) }}">Daftar Pemeriksaan</a></li>
                                                <li><a href="{{ route('resepsionis.pasien.edit-pasien-rs',
                                                    ['id'=>$p->id]) }}">Edit Pasien</a></li>
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

@if (Session::has('update_succeed'))
<script>
swal('Berhasil', '{!! Session::get('update_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@endpush
