@extends('layouts.global')

@section('title') List Pasien Rumah Sakit @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Pasien Rumah Sakit
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="{{ route('pasien.index-pasien-rs') }}"><i class="fa fa-users"></i> List Pasien Rumah Sakit</a></li>
    </ol>
</section>

<div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-success" onclick="window.location='{{ route('pasien.create.pasien-rs') }}'"><span class="fa fa-user-plus" style="margin-right: 5px"></span>Tambah Pasien</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 10px; margin-top: 20px">
            <button class="btn btn-warning" onclick="window.location='{{ route('pasien.trash') }}'"><span class="fa fa-trash" style="margin-right: 5px"></span>Tempat Sampah</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table6" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
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
                                <td>{{ str_pad($p->nomor_rm, 6, '0', STR_PAD_LEFT)  }}</td>
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
                                                <li><a href="{{ route('pasien.detail-pasien-rs',
                                                    ['id'=>$p->id]) }}">Detail Pasien</a></li>
                                                <li><a href="{{ route('pasien.edit-pasien-rs',
                                                    ['id'=>$p->id]) }}">Edit Pasien</a></li>
                                                <li><a class="delete-confirmation" href="{{ route('pasien.delete',
                                                    ['id'=>$p->id]) }}">Hapus Pasien</a></li>
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
    text: "Setelah terhapus, data pasien akan tersimpan di tempat sampah sistem",
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

@if (Session::has('delete_succeed'))
<script>
swal('Berhasil', '{!! Session::get('delete_succeed') !!}', 'warning',{
    button:'OK',
});
</script>
@endif

@endpush

