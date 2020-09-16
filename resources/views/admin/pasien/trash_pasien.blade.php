@extends('layouts.global')

@section('title') List Semua pasien @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Semua Pasien
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="{{ route('pasien.index-pasien-umum') }}"><i class="fa fa-users"></i> Pasien Umum</a> |
            <a href="{{ route('pasien.index-pasien-rs') }}"><i class="fa fa-users"></i> Pasien RS</a></li>
        <li class="active">Tempat Sampah</li>
    </ol>
</section>

<div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-info" onclick="window.location='{{ route('pasien.index-pasien-umum') }}'"><span class="fa fa-users" style="margin-right: 5px"></span>Pasien Umum</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 10px; margin-top: 20px">
            <button class="btn btn-success" onclick="window.location='{{ route('pasien.index-pasien-rs') }}'"><span class="fa fa-users" style="margin-right: 5px"></span>Pasien Rumah Sakit</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Pasien</th>
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
                                <td>{{ ucfirst($p->jenis_pasien) }}</td>
                                <td>{{ str_pad($p->nomor_rm, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->nomor_ktp }}</td>
                                <td>{{ $p->id_ruangan == null ? '-' : $p->ruangan->nama_ruangan }}</td>
                                <td>{{ $p->id_ruangan == null ? '-' : $p->ruangan->kelas }}</td>
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
                                                <li><a href="{{ route('pasien.restore',
                                                    ['id'=>$p->id]) }}">Kembalikan Pasien</a></li>
                                                <li><a class="delete-confirmation" href="{{ route('pasien.destroy',
                                                    ['id'=>$p->id]) }}">Hapus Permanen</a></li>
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</section>

@endsection
@push('scripts')
<script>
    $(".delete-confirmation").on('click', function (event) {
        event.preventDefault();
        const url=$(this).attr('href');
        swal({
        title: "Apa anda yakin?",
        text: "Data pasien akan terhapus permanen",
        icon: "warning",
        buttons: ["Tidak", "Ya"],
        })
        .then(function(value) {
            if (value) {
                window.location.href = url;
            }
        });
    });
</script>
@if (Session::has('restore_succeed'))
<script>
swal('Berhasil', '{!! Session::get('restore_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('destroy_succeed'))
<script>
swal('Berhasil', '{!! Session::get('destroy_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif
@endpush
