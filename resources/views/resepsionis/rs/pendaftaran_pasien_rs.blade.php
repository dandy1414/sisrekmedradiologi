@extends('layouts.global')

@section('title')Pendaftaran Pemeriksaan Pasien RS @endsection

@section('content')
<section class="content-header" style="margin-top: 50px;">
    <h1>
        Pendaftaran Pemeriksaan Pasien Rumah Sakit
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('resepsionis.pasien.index-pasien-rs') }}"><i class="fa fa-users"></i> Pasien RS</a>
        <li><a href="#"> Pendaftaran Pemeriksaan Pasien Umum</a>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h4>
                    <i class="icon fa fa-info"></i>
                    Petunjuk Khusus Jenis Pemeriksaan Penuh
                </h4>
                - Setelah mendaftarkan pasien, akan tampil hasil surat rujukan <br>
                - Pada tampilan surat rujukan tersebut terdapat tombol "Export PDF", klik untuk mengunduh surat rujukan
                <br>
                - Setelah surat rujukan terunduh, berikan tanda tangan dokter yang merujuk pada surat tersebut
                menggunakan tanda tangan digital <br>
                - Setelah diberi tanda tangan, unggah surat rujukan tersebut pada sistem <br>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-info" style="position: relative;">
                <div class="box-header">
                    <h3 class="box-title">Detail Pasien</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-medkit"></i> Nomor Rekam Medis :</strong>

                    <p class="text-muted">{{ str_pad($pasien->nomor_rm, 6, '0', STR_PAD_LEFT) }}</p>

                    <strong><i class="fa fa-credit-card"></i> Nomor KTP :</strong>

                    <p class="text-muted">{{ $pasien->nomor_ktp }}</p>

                    <strong><i class="fa fa-user"></i> Nama :</strong>

                    <p class="text-muted">{{ $pasien->nama }}</p>

                    <strong><i class="fa fa-user"></i> Jenis Kelamin :</strong>

                    <p class="text-muted">{{ ucfirst($pasien->jenis_kelamin) }}</p>

                    <strong><i class="fa fa-user"></i> Umur :</strong>

                    <p class="text-muted">{{ $pasien->umur }} tahun</p>

                    <strong><i class="fa fa-home"></i> Alamat :</strong>

                    <p class="text-muted">{{ ucfirst($pasien->alamat) }}</p>

                    <strong><i class="fa fa-phone"></i> Nomor telepon :</strong>

                    <p class="text-muted">{{ $pasien->nomor_telepon }}</p>

                    <strong><i class="fa fa-hospital-o"></i> Asal Ruangan / Kelas :</strong>

                    <p class="text-muted">{{ $pasien->ruangan->nama_ruangan }} / {{ $pasien->ruangan->kelas }}</p>

                    <strong><i class="fa fa-institution"></i> Jenis Asuransi :</strong>

                    <p class="text-muted">{{ ucfirst($pasien->jenis_asuransi) }}</p>

                    <strong><i class="fa fa-bars"></i> Nomor BPJS :</strong>

                    <p class="text-muted">
                        {{ ($pasien->nomor_bpjs) != null ? $pasien->nomor_bpjs : "-" }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <form method="POST"
                action="{{ route('resepsionis.pasien.store.pendaftaran.pasien-rs', ['id' => $pasien->id]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="box box-success" style="position: relative;">
                    <div class="box-header">
                        <h3 class="box-title">Form Pendaftaran Pemeriksaan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->first('jenisPemeriksaan') ? "has-error" : "" }}">
                            <label><span style="color: red">*</span> Jenis Pemeriksaan :</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="jenisPemeriksaan" id="biasa" value="biasa"
                                        {{ old('jenisPemeriksaan') == 'biasa' ? "checked" : "" }}
                                        onchange="disableSelect()">
                                    Biasa
                                </label>
                                <label>
                                    <input type="radio" name="jenisPemeriksaan" id="penuh" value="penuh"
                                        {{ old('jenisPemeriksaan') == 'penuh' ? "checked" : "" }}
                                        onchange="disableSelect()">
                                    Penuh
                                </label>
                                <span class="help-block">{{ $errors->first('jenisPemeriksaan') }}</span>
                            </div>
                        </div>

                        {{-- <div class="form-group {{ $errors->first('cito') ? "has-error" : "" }}">
                            <label>CITO :</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="cito" id="ya" value="iya"
                                        {{ old('cito') == 'iya' ? "checked" : "" }}>
                                    Ya
                                </label>
                                <label>
                                    <input type="radio" name="cito" id="tidak" value="tidak"
                                        {{ old('cito') == 'tidak' ? "checked" : "" }}>
                                    Tidak
                                </label>
                                <span class="help-block">{{ $errors->first('cito') }}</span>
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <label><span style="color: red">*</span> Kategori Layanan :</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="kategori" id="rontgen" value="rontgen"
                                        onchange="selectNone()">
                                    Rontgen
                                </label>
                                <label>
                                    <input type="radio" name="kategori" id="usg" value="usg" onchange="selectNone()">
                                    USG
                                </label>
                            </div>
                        </div>

                        <div id="select-rontgen" class="form-group {{ $errors->first('layanan') ? "has-error": "" }}"
                            style="display: none">
                            <label><span style="color: red">*</span> Layanan Kategori Rontgen :</label>
                            <select class="form-control select2" name="layanan" style="width: 100%;">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($layanan_rontgen as $lr)
                                <option value="{{ $lr->id }}" {{ old('layanan') == $lr->id ? "selected" : "" }}>
                                    {{ $lr->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('layanan') }}</span>
                        </div>
                        <div id="select-usg" class="form-group {{ $errors->first('layanan') ? "has-error": "" }}"
                            style="display: none">
                            <label><span style="color: red">*</span> Layanan Kategori USG :</label>
                            <select class="form-control select2" name="layanan" style="width: 100%;">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($layanan_usg as $lu)
                                <option value="{{ $lu->id }}" {{ old('layanan') == $lu->id ? "selected" : "" }}>
                                    {{ $lu->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('layanan') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('jadwal') ? "has-error" : "" }}">
                            <label><span style="color: red">*</span> Jadwal :</label>
                            <select class="form-control select2" name="jadwal" style="width: 100%;">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($jadwal as $j)
                                <option value="{{ $j->id }}" {{ old('jadwal') == $j->id ? "selected" : "" }}>
                                    {{ $j->waktu_mulai }} WIB - {{ $j->waktu_selesai }} WIB</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('jadwal') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('dokterPerujuk') ? "has-error" : "" }}">
                            <label><span style="color: red">*</span> Dokter Perujuk :</label>
                            <select class="form-control select2" name="dokterPerujuk" style="width: 100%;"
                                onchange="disableSelect()" id="dokter-perujuk">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($dokter_poli as $dp)
                                <option value="{{ $dp->id }}" {{ old('dokterPerujuk') == $dp->id ? "selected" : "" }}>
                                    {{ $dp->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('dokterPerujuk') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('dokterRujukan') ? "has-error": "" }}">
                            <label><span style="color: red">*</span> Dokter Rujukan :</label>
                            <select class="form-control select2" name="dokterRujukan" style="width: 100%;"
                                onchange="disableSelect()" id="dokter-rujukan">
                                <option selected disabled>Silahkan pilih salah satu</option>
                                @foreach ($dokter_radiologi as $dr)
                                <option value="{{ $dr->id }}" {{ old('dokterRujukan') == $dr->id ? "selected" : "" }}>
                                    {{ $dr->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('dokterRujukan') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('keluhan') ? "has-error": "" }}">
                            <label>Keluhan :</label>
                            <input value="{{ old('nama') }}" type="text" name="keluhan" class="form-control"
                                placeholder="Keluhan ...">
                            <span class="help-block">{{ $errors->first('keluhan') }}</span>
                        </div>

                        <div class="form-group {{ $errors->first('permintaan') ? "has-error": "" }}">
                            <label>Informasi Tambahan/Permintaan Tambahan :</label>
                            <input value="{{ old('permintaan') }}" type="text" name="permintaan" class="form-control"
                                placeholder="Informasi tambahan  ...">
                            <span class="help-block">{{ $errors->first('permintaan') }}</span>
                        </div>

                        <hr>
                        <label class="text-muted"><span style="color: red">*</span> Wajib diisi</label>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script type="text/javascript">
    function disableSelect() {
        if (document.getElementById('biasa').checked) {
            document.getElementById('dokter-perujuk').disabled = true;
            document.getElementById('dokter-rujukan').disabled = true;
        } else if (document.getElementById('penuh').checked) {
            document.getElementById('dokter-perujuk').disabled = false;
            document.getElementById('dokter-rujukan').disabled = false;
        }
    }

    $('#rontgen').click(function () {
        $('#select-rontgen').show(500);
        $('#select-usg').hide(200);
    })

    $('#usg').click(function () {
        $('#select-usg').show(500);
        $('#select-rontgen').hide(200);
    })

</script>

@if (Session::has('store_failed'))
<script>
    swal('Gagal', '{!! Session::get('
        store_failed ') !!}', 'error', {
            button: 'OK',
        });

</script>
@endif
@endpush
