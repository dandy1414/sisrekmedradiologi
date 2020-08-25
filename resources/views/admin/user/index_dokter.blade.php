@extends('layouts.global')

@section('title') List Dokter @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        List Dokter
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="#"><i class="fa fa-user-md"></i> Dokter</a></li>
    </ol>
</section>

<div class="row">
    <div class="col-xs-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-success" onclick="window.location='{{ route('dokter.create') }}'"><span class="fa fa-user-plus" style="margin-right: 5px"></span>Tambah Dokter</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 10px; margin-top: 20px">
            <button class="btn btn-warning" onclick="window.location='{{ route('user.trash') }}'"><span class="fa fa-trash" style="margin-right: 5px"></span>Tempat Sampah</button>
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
                                <th>Username</th>
                                <th>SIP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Spesialis</th>
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
                                <td>{{ $user->sip }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role == 'dokterPoli')
                                    Dokter Poli
                                    @else
                                    Dokter Radiologi
                                    @endif
                                </td>
                                <td>
                                    @if ($user->spesialis == 'umum')
                                    Dokter Umum
                                    @endif
                                    @if ($user->spesialis == 'obgyn')
                                    Spesialis Obgyn
                                    @endif
                                    @if ($user->spesialis == 'syaraf')
                                    Spesialis Syaraf
                                    @endif
                                    @if ($user->spesialis == 'jiwa')
                                    Spesialis Jiwa
                                    @endif
                                    @if ($user->spesialis == 'gigi')
                                    Dokter Gigi
                                    @endif
                                    @if ($user->spesialis == 'penyakit_dalam')
                                    Spesialis Penyakit Dalam
                                    @endif
                                    @if ($user->spesialis == 'penyakit_mulut')
                                    Spesialis Penyakit Mulut
                                    @endif
                                    @if ($user->spesialis == 'anak')
                                    Spesialis Anak
                                    @endif
                                    @if ($user->spesialis == 'mata')
                                    Spesialis Mata
                                    @endif
                                    @if ($user->spesialis == 'anasthesi')
                                    Spesialis Anasthesi
                                    @endif
                                    @if ($user->spesialis == 'radiologi')
                                    Dokter Radiologi
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
                                                <li><a href="#">Detail Dokter</a></li>
                                                <li><a href="{{ route('dokter.edit',
                                                    ['id'=>$user->id]) }}">Edit Dokter</a></li>
                                                <li><a href="{{ route('user.delete',
                                                    ['id'=>$user->id]) }}">Hapus Dokter</a></li>
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
