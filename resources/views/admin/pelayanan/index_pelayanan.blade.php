@extends('layouts.global')

@section('title') Data Pelayanan @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Data Pelayanan
    </h1>
    <ol class="breadcrumb" style="margin-top: 58px">
        <li><a href="{{ route('pelayanan.index') }}"> Data Pelayanan</a></li>
    </ol>
</section>

<div class="row">
    <div class="col-md-8">
        <div class="btn-group" style="float: left; margin-left: 15px; margin-top: 20px">
            <button class="btn btn-success" data-toggle="modal" data-target="#tambah-layanan"><span class="fa fa-plus"
                    style="margin-right: 5px"></span>Tambah Layanan</button>
        </div>
        <div class="btn-group" style="float: left; margin-left: 10px; margin-top: 20px">
            <button class="btn btn-warning" data-toggle="modal" data-target="#tambah-film"><span class="fa fa-plus"
                    style="margin-right: 5px"></span>Tambah Film</button>
        </div>
    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning" id="tabelsemuapasien1" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-header with-border">
                    <h3 class="box-title">Film</h3>
                </div>
                <div class="box-body">
                    <table id="table3" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Film</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($film as $f)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $f->nama }}</td>
                                <td>@currency($f->harga)</td>
                                <td>
                                    <div class="btn-group">
                                        <button id="editFilm" type="button" class="btn btn-success"
                                            data-myNamaFilm="{{ $f->nama }}" data-myHargaFilm="{{ $f->harga }}"
                                            data-myIdFIlm="{{ $f->id }}" data-toggle="modal"
                                            data-target="#edit-film">Edit</button>
                                        <button type="button" class="btn btn-success dropdown-toggle"
                                            data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="delete-film-confirmation" href="{{ route('film.delete', ['id'=>$f->id]) }}">Hapus</a></li>
                                        </ul>
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

        <div class="col-md-6">
            <div class="box box-success" id="tabelsemuapasien2" style="position: relative;">
                <!-- /.box-header -->
                <div class="box-header with-border">
                    <h3 class="box-title">Layanan</h3>
                </div>
                <div class="box-body">
                    <table id="table2" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Layanan</th>
                                <th>Kategori</th>
                                <th>Tarif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($layanan as $l)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $l->nama }}</td>
                                <td>{{ ucfirst($l->kategori->nama) }}
                                </td>
                                <td>@currency($l->tarif)</td>
                                <td>
                                    <div class="btn-group">
                                        <button id="editLayanan" type="button" class="btn btn-success"
                                            data-myNama="{{ $l->nama }}" data-myIdKategori="{{ $l->kategori->id }}" data-myNamaKategori="{{ $l->kategori->nama }}"
                                            data-myTarif="{{ $l->tarif }}" data-toggle="modal"
                                            data-target="#edit-layanan" data-myIdLayanan="{{ $l->id }}">Edit</button>
                                        <button type="button" class="btn btn-success dropdown-toggle"
                                            data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="delete-layanan-confirmation" href="{{ route('layanan.delete', ['id'=>$l->id]) }}">Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- modal-tambah-layanan -->
        <div class="modal fade" id="tambah-layanan">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="POST" action="{{ route('layanan.store') }}" id="layanan-store">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" style="text-align: center">Tambah Layanan Baru</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Nama :</label>
                                        <input type="text" name="nama" id="namaLayanan" class="form-control" placeholder="Nama ..." required>
                                        <br>

                                        <label>Kategori :</label>
                                        <select class="form-control select2" name="kategori" style="width: 100" required>
                                            <option selected disabled>Silahkan pilih salah satu</option>
                                            @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}">{{ ucfirst($k->nama) }}</option>
                                            @endforeach
                                        </select>
                                        <br>

                                        <label>Harga :</label>
                                            <input type="text" name="tarif" class="form-control" placeholder="Tarif ..." required>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Kembali</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </form>
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!-- /modal-tambah-layanan -->

        <!-- modal-tambah-film -->
        <div class="modal fade" id="tambah-film">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="POST" action="{{ route('film.store') }}">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" style="text-align: center">Tambah Film Baru</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <form action="">
                                        <div class="form-group">
                                            <label>Nama :</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Nama ..." required>
                                            <br>

                                            <label>Harga :</label>
                                            <input type="text" name="harga" class="form-control"
                                                placeholder="Harga ..." required>
                                            <br>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Kembali</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </form>
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

        </div>
        <!-- /modal-tambah-layanan -->

        <!-- modal-edit-layanan -->
        <div class="modal fade" id="edit-layanan">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="text-align: center">Edit Layanan</h4>
                    </div>
                    <form action="{{ route('layanan.update') }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama :</label>
                                <input id="nama-layanan" type="text" name="nama" class="form-control" required>
                                <br>

                                <label>Kategori lama :</label>
                                <input id="kategori-layanan" type="text" name="" class="form-control" disabled>
                                <br>

                                <label>Kategori baru :</label>
                                <select class="form-control select2" name="kategori"
                                    style="width: 100%;" required>
                                    @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                                <br>

                                <label>Harga :</label>
                                <input id="tarif" type="text" name="tarif" class="form-control" placeholder="Tarif ..." required>
                                <br>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Kembali</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!-- /modal-edit-layanan -->

        <!-- modal-edit-film -->
        <div class="modal fade" id="edit-film">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="POST" action="{{ route('film.update') }}">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="text-align: center">Edit Film</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <form action="">
                                    <div class="form-group">
                                        <input id="id-film" type="hidden" name="id_film" required>

                                        <label>Nama :</label>
                                        <input id="nama-film" type="text" name="nama" class="form-control"
                                            placeholder="Nama ..." required>
                                        <br>

                                        <label>Harga :</label>
                                        <input id="harga-film" type="text" name="harga" class="form-control"
                                            placeholder="Harga ..." required>
                                        <br>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left"
                                data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                    </form>
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!-- /modal-edit-film -->

    </div>
</section>
@endsection
@push('scripts')
<script>
    $(".delete-layanan-confirmation").on('click', function (event) {
        event.preventDefault();
        const url=$(this).attr('href');
        swal({
        title: "Apa anda yakin?",
        text: "Setelah terhapus, data layanan akan terhapus permanen",
        icon: "warning",
        buttons: ["Tidak", "Ya"],
        })
        .then(function(value) {
            if (value) {
                window.location.href = url;
            }
        });
    });

    $(".delete-film-confirmation").on('click', function (event) {
        event.preventDefault();
        const url=$(this).attr('href');
        swal({
        title: "Apa anda yakin?",
        text: "Setelah terhapus, data film akan terhapus permanen",
        icon: "warning",
        buttons: ["Tidak", "Ya"],
        })
        .then(function(value) {
            if (value) {
                window.location.href = url;
            }
        });
    });

    $('#edit-layanan').on('show.bs.modal', function (event) {
        var id_layanan = $('#editLayanan').attr('data-MyIdLayanan')
        var nama = $("#editLayanan").attr("data-MyNama")
        var id_kategori = $('#editLayanan').attr("data-MyIdKategori")
        var nama_kategori = $('#editLayanan').attr("data-MyNamaKategori")
        var tarif = $('#editLayanan').attr('data-myTarif')

        var modal = $(this)
        modal.find('.modal-body #id-layanan').val(id_layanan);
        modal.find('.modal-body #nama-layanan').val(nama);
        modal.find('.modal-body #kategori-layanan').val(nama_kategori);
        modal.find('.modal-body #tarif').val(tarif);
    })

    $('#edit-film').on('show.bs.modal', function (event) {
        var id_film = $('#editFilm').attr('data-MyIdFIlm')
        var nama = $("#editFilm").attr("data-MyNamaFilm")
        var harga = $('#editFilm').attr('data-myHargaFilm')

        var modal = $(this)
        modal.find('.modal-body #id-film').val(id_film);
        modal.find('.modal-body #nama-film').val(nama);
        modal.find('.modal-body #harga-film').val(harga);
    })
</script>

@if (Session::has('store_layanan_succeed'))
<script>
swal('Berhasil', '{!! Session::get('store_layanan_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('store_layanan_failed'))
<script>
swal('Berhasil', '{!! Session::get('delete_succeed') !!}', 'error',{
    button:'OK',
});
</script>
@endif

@if (Session::has('store_film_succeed'))
<script>
swal('Berhasil', '{!! Session::get('store_layanan_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('store_film_failed'))
<script>
swal('Berhasil', '{!! Session::get('delete_succeed') !!}', 'error',{
    button:'OK',
});
</script>
@endif

@if (Session::has('update_layanan_succeed'))
<script>
swal('Berhasil', '{!! Session::get('update_layanan_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('update_layanan_failed'))
<script>
swal('Berhasil', '{!! Session::get('update_layanan_succeed') !!}', 'error',{
    button:'OK',
});
</script>
@endif

@if (Session::has('update_film_succeed'))
<script>
swal('Berhasil', '{!! Session::get('update_film_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('update_film_failed'))
<script>
swal('Berhasil', '{!! Session::get('update_film_failed') !!}', 'error',{
    button:'OK',
});
</script>
@endif

@if (Session::has('delete_layanan_succeed'))
<script>
swal('Berhasil', '{!! Session::get('delete_layanan_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif

@if (Session::has('delete_film_succeed'))
<script>
swal('Berhasil', '{!! Session::get('delete_film_succeed') !!}', 'success',{
    button:'OK',
});
</script>
@endif
@endpush
