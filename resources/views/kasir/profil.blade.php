@extends('layouts.global')

@section('title')Profil Saya @endsection

@section('csrf')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Profil Saya
    </h1>
    <ol class="breadcrumb">
        <li class="active">Profil Saya</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if ($user->avatar == null)
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset('adminlte/dist/img/avatar1.png') }}" alt="User profile picture">
                    @else
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="User profile picture">
                    @endif

                    <h3 class="profile-username text-center">{{ $user->nama }}</h3>

                    <p class="text-muted text-center">
                        Kasir
                    </p>

                    <hr>

                    <strong><i class="fa fa-book margin-r-5"></i> NIP</strong>

                    <p class="text-muted">
                        {{ $user->nip }}
                    </p>

                    <hr>

                    <strong><i class="fa fa-phone margin-r-5"></i> Nomor Telepon</strong>

                    <p class="text-muted">{{ $user->nomor_telepon }}</p>

                    <hr>

                    <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>

                    <p class="text-muted">{{ $user->email }}</p>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>

                    <p class="text-muted">{{ $user->alamat }}</p>

                    <button class="btn btn-success pull-left" id="edit-profil">Edit Profil</button>
                    <button class="btn btn-info pull-right" id="riwayat-pendaftaran">Riwayat</button>

                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-8">
            <div id="box-riwayat" class="box box-info" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-header">
                    <h3 class="box-title">Riwayat Pembayaran</h3>
                </div>
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nomor Tagihan</th>
                                <th>Nama</th>
                                <th>Nomor RM</th>
                                <th>Nomor KTP</th>
                                <th>Jenis Pasien</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Layanan</th>
                                <th>Jadwal</th>
                                <th>Tarif Dokter</th>
                                <th>Tarif Jasa</th>
                                <th>Kasir</th>
                                <th>Total Tarif</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->tanggal }}</td>
                                <td>{{ $t->nomor_tagihan }}</td>
                                <td>{{ $t->pasien->nama }}</td>
                                <td>{{ $t->pasien->nomor_rm }}</td>
                                <td>{{ $t->pasien->nomor_ktp }}</td>
                                <td>{{ ($t->pasien->jenis_pasien) == 'umum' ? "Umum" : "Rumah Sakit" }}</td>
                                <td>{{ ucfirst($t->pemeriksaan->jenis_pemeriksaan) }}</td>
                                <td>{{ ucfirst($t->layanan->nama) }}</td>
                                <td>{{ $t->jadwal->waktu_mulai }} - {{ $t->jadwal->waktu_selesai }}</td>
                                <td>@currency($t->tarif_dokter)</td>
                                <td>@currency($t->tarif_jasa)</td>
                                <td>{{ ucfirst($t->kasir->nama) }}</td>
                                <td>@currency($t->total_harga)</td>
                                <td><span class="badge bg-green">LUNAS</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="box-edit" class="box box-success" style="position: relative; display:none">
                <form method="POST" action="{{ route('profil.update.kasir', ['id' => $user->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="box-header">
                        <h3 class="box-title">Edit Profil</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('name') ? "has-error": "" }}">
                                    <label>Username :</label>
                                    <input value="{{ $user->name }}" type="text" name="name" class="form-control"
                                        placeholder="Username ...">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('email') ? "has-error": "" }}">
                                    <label>Email :</label>
                                    <input value="{{ $user->email }}" type="email" name="email" class="form-control"
                                        placeholder="Email ...">
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nip') ? "has-error": "" }}">
                                    <label>NIP :</label>
                                    <input value="{{ $user->nip }}" type="text" name="nip"
                                        class="form-control {{$errors->first('nip') ? "is-invalid" : ""}}"
                                        placeholder="NIP ...">
                                    <span class="help-block">{{ $errors->first('nip') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('password') ? "has-error": "" }}">
                                    <label>Password Baru :</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Password ...">
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nama') ? "has-error": "" }}">
                                    <label>Nama :</label>
                                    <input value="{{ $user->nama }}" type="text" name="nama"
                                        class="form-control {{$errors->first('nama') ? "is-invalid" : ""}}"
                                        placeholder="Nama ...">
                                    <span class="help-block">{{ $errors->first('nama') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('jenisKelamin') ? "has-error": "" }}">
                                    <label>Jenis Kelamin :</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jenisKelamin" id="pria" value="pria"
                                                {{ $user->jenis_kelamin == 'pria' ? "checked" : "" }} disabled>
                                            Pria
                                        </label>
                                        <label>
                                            <input type="radio" name="jenisKelamin" id="wanita" value="wanita"
                                                {{ $user->jenis_kelamin == 'wanita' ? "checked" : "" }} disabled>
                                            Wanita
                                        </label>
                                        <span class="help-block">{{ $errors->first('jenisKelamin') }}</span>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->first('alamat') ? "has-error": "" }}">
                                    <label>Alamat :</label>
                                    <textarea name="alamat" id="alamat"
                                        class="form-control {{$errors->first('alamat') ? "is-invalid" : ""}}">{{ $user->alamat }}</textarea>
                                    <span class="help-block">{{ $errors->first('alamat') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('nomorTelepon') ? "has-error": "" }}">
                                    <label>No. Telepon :</label>
                                    <input value="{{$user->nomor_telepon}}" type="text" name="nomorTelepon"
                                        class="form-control {{$errors->first('nomorTelepon') ? "is-invalid" : ""}}"
                                        placeholder="Nomor telepon ...">
                                    <span class="help-block">{{ $errors->first('nomorTelepon') }}</span>
                                </div>

                                <div class="form-group {{ $errors->first('avatar') ? "has-error": "" }}">
                                    <label for="foto">Avatar</label>
                                    <input id="avatar"
                                        class="form-control {{$errors->first('avatar') ? "is-invalid" : ""}}"
                                        name="avatar" type="file" id="foto">
                                    <span class="help-block">{{ $errors->first('avatar') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>

$(document).ready(function () {
        $(document).on('click', '#modal-detail', function() {
            var tanggal = $(this).data('tanggal');
            var ktp_pasien = $(this).data('ktp');
            var keluhan_pasien = $(this).data('keluhanpasien');
            var permintaan_tambahan = $(this).data('permintaantambahan');
            $('#tanggal').text(tanggal);
            $('#nomor-ktp').text(ktp_pasien);
            $('#keluhan-pasien').text(keluhan_pasien);
            $('#permintaan-tambahan').text(permintaan_tambahan);
        })
    })

$("#edit-profil").click(function () {
    $("#box-edit").show(1000)
    $("#box-riwayat").hide(300)
})
$("#riwayat-pendaftaran").click(function () {
    $("#box-riwayat").show(1000)
    $("#box-edit").hide(300)
})
</script>

@if (Session::has('store_succeed'))
<script>
swal('Berhasil', '{!! Session::get('store_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('store_failed'))
<script>
swal('Gagal', '{!! Session::get('store_failed') !!}', 'error',{
    button:'OK',
});
</script>
@endif
@endpush

