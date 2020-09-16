@extends('layouts.global')

@section('title') List User @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List User
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="{{ route('dokter.index') }}"><i class="fa fa-user-md"></i> List Dokter</a> | <a href="{{ route('pegawai.index') }}"><i class="fa fa-users"></i> List Pegawai</a></li>
        <li class="active">Tempat Sampah</li>
    </ol>
</section>

<div class="row">
    <div class="col-xs-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-info" onclick="window.location='{{ route('dokter.index') }}'"><span class="fa fa-users" style="margin-right: 5px"></span>List Dokter</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-success" onclick="window.location='{{ route('pegawai.index') }}'"><span class="fa fa-users" style="margin-right: 5px"></span>List Pegawai</button>
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
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>SIP</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->sip == null ? '-' : $user->sip }}</td>
                                <td>{{ $user->nip == null ? '-' : $user->nip }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->jenis_kelamin }}</td>
                                <td>{{ $user->alamat }}</td>
                                <td>{{ $user->nomor_telepon }}</td>
                                <td>
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success dropdown-toggle"
                                                data-toggle="dropdown">Aksi
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('user.restore',
                                                    ['id'=>$user->id]) }}">Kembalikan User</a></li>
                                                <li><a class="delete-confirmation" href="{{ route('user.destroy',
                                                    ['id'=>$user->id]) }}">Hapus Permanen</a></li>
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
        text: "Data user akan terhapus permanen",
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

