@extends('layouts.global')

@section('title') List User @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List User
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> Data User</a></li>
        <li class="active">Tempat Sampah</li>
    </ol>
</section>

<div class="row">
    <div class="col-xs-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-success" onclick="window.location='{{ route('user.index') }}'"><span class="fa fa-users" style="margin-right: 5px"></span>List User</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-check"></i>
                    Success
                </h4>
                    {{ $message }}
            </div>
            @endif

            @if ($message = Session::get('warning'))
            <div class="alert alert-warning">
                {{ $message }}
            </div>
            @endif
        </div>
    </div>
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
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="fa fa-gears"></span>
                                                <span class="fa fa-caret-down"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('user.restore',
                                                    ['id'=>$user->id]) }}">Kembalikan User</a></li>
                                                <li><a href="{{ route('user.destroy',
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
