@extends('layouts.global')

@section('title') List Pegawai @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Pegawai
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="#"><i class="fa fa-users"></i> Pegawai</a></li>
    </ol>
</section>

<div class="row">
    <div class="col-xs-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-success" onclick="window.location='{{ route('pegawai.create') }}'"><span class="fa fa-user-plus" style="margin-right: 5px"></span>Tambah Pegawai</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 10px; margin-top: 20px">
            <button class="btn btn-warning" onclick="window.location='{{ route('user.trash') }}'"><span class="fa fa-trash" style="margin-right: 5px"></span>Tempat Sampah</button>
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
                                <th>Username</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Jabatan</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nip }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role == 'resepsionis')
                                    Resepsionis
                                    @endif
                                    @if ($user->role == 'radiografer')
                                    Radiografer
                                    @endif
                                    @if ($user->role == 'admin')
                                    Admin
                                    @endif
                                    @if ($user->role == 'kasir')
                                    Kasir
                                    @endif
                                </td>
                                <td>
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
                                </td>
                                <td>{{ ucfirst($user->jenis_kelamin) }}</td>
                                <td>{{ ucfirst($user->alamat) }}</td>
                                <td>{{ $user->nomor_telepon }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('user.detail', ['id' => $user->id]) }}">Detail Pegawai</a></li>
                                                <li><a href="{{ route('pegawai.edit',
                                                    ['id'=>$user->id]) }}">Edit Pegawai</a></li>
                                                <li><a class="delete-confirmation" href="{{ route('user.delete',
                                                    ['id'=>$user->id]) }}">Hapus Pegawai</a></li>
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
        text: "Setelah terhapus, data pegawai akan tersimpan di tempat sampah sistem",
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
