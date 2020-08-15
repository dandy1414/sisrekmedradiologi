<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm')->middleware('prevent.login');

Route::group(['prefix' => 'admin', 'middleware' => 'role.admin'], function () {
    Route::get('dashboard', 'DashboardController@dashboard')->name('admin.dashboard');

    Route::get('/user/index', 'UserController@index')->name('user.index');
    Route::get('/user/show', 'UserController@show')->name('user.show');
    Route::get('/user/create', 'UserController@create')->name('user.create');
    Route::post('/user', 'UserController@store')->name('user.store');
    Route::get('/{id}/user/edit', 'UserController@edit')->name('user.edit');
    Route::put('/{id}/user', 'UserController@update')->name('user.update');
    Route::get('/{id}/user/delete', 'UserController@delete')->name('user.delete');
    Route::get('/user/trash', 'UserController@trash')->name('user.trash');
    Route::get('/{id}/user/restore', 'UserController@restore')->name('user.restore');
    Route::get('/{id}/user/destroy', 'UserController@destroy')->name('user.destroy');

    Route::get('/pelayanan/index', 'PelayananController@index')->name('pelayanan.index');

    Route::post('/pelayanan/layanan', 'PelayananController@storeLayanan')->name('layanan.store');
    Route::put('/pelayanan/layanan', 'PelayananController@updateLayanan')->name('layanan.update');
    Route::get('/{id}/pelayanan/layanan/delete', 'PelayananController@deleteLayanan')->name('layanan.delete');

    Route::post('/pelayanan/film', 'PelayananController@storeFilm')->name('film.store');
    Route::put('/pelayanan/film', 'PelayananController@updateFilm')->name('film.update');
    Route::get('/{id}/pelayanan/film/delete', 'PelayananController@deleteFilm')->name('film.delete');
    // Route::get('/trash', 'UserController@trash')->name('user.trash');
    // Route::get('/{id}/restore', 'UserController@restore')->name('user.restore');
    // Route::get('/{id}/destroy', 'UserController@destroy')->name('user.destroy');

    Route::get('/pasien/index/pasien-umum', 'PasienController@indexPasienUmum')->name('pasien.index-pasien-umum');
    Route::get('/pasien/index/pasien-rs', 'PasienController@indexPasienRs')->name('pasien.index-pasien-rs');

    Route::get('{id}/pasien/detail/pasien-umum', 'PasienController@detailPasienUmum')->name('pasien.detail-pasien-umum');
    Route::get('{id}/pasien/detail/pasien-rs', 'PasienController@detailPasienRs')->name('pasien.detail-pasien-rs');

    Route::get('/pasien/create/pasien-umum', 'PasienController@createPasienUmum')->name('pasien.create.pasien-umum');
    Route::get('/pasien/create/pasien-rs', 'PasienController@createPasienRs')->name('pasien.create.pasien-rs');

    Route::post('/pasien/pasien-umum', 'PasienController@storePasienUmum')->name('pasien.store.pasien-umum');
    Route::post('/pasien/pasien-rs', 'PasienController@storePasienRs')->name('pasien.store.pasien-rs');

    Route::get('/{id}/pasien/pasien-umum/edit', 'PasienController@editPasienUmum')->name('pasien.edit-pasien-umum');
    Route::get('/{id}/pasien/pasien-rs/edit', 'PasienController@editPasienRs')->name('pasien.edit-pasien-rs');

    Route::put('/{id}/pasien/pasien-umum', 'PasienController@updatePasienUmum')->name('pasien.update-pasien-umum');
    Route::put('/{id}/pasien/pasien-rs', 'PasienController@updatePasienRs')->name('pasien.update-pasien-rs');

    Route::get('/{id}/pasien/delete', 'PasienController@delete')->name('pasien.delete');
    Route::get('/pasien/trash', 'PasienController@trash')->name('pasien.trash');
    Route::get('/{id}/pasien/restore', 'PasienController@restore')->name('pasien.restore');
    Route::get('/{id}/pasien/destroy', 'PasienController@destroy')->name('pasien.destroy');
});

Route::group(['prefix' => 'resepsionis/'], function () {
    Route::get('/pasien/index/pasien-umum', 'PendaftaranController@indexPasienUmum')->name('resepsionis.pasien.index-pasien-umum');
    Route::get('/pasien/index/pasien-rs', 'PendaftaranController@indexPasienRs')->name('resepsionis.pasien.index-pasien-rs');

    Route::get('/{id}/pasien/detail/pasien-umum', 'PendaftaranController@detailPasienUmum')->name('resepsionis.pasien.detail-pasien-umum');
    Route::get('/{id}/pasien/detail/pasien-rs', 'PendaftaranController@detailPasienRs')->name('resepsionis.pasien.detail-pasien-rs');

    Route::get('/pasien/create/pasien-umum', 'PendaftaranController@createPasienUmum')->name('resepsionis.pasien.create.pasien-umum');
    Route::get('/pasien/create/pasien-rs', 'PendaftaranController@createPasienRs')->name('resepsionis.pasien.create.pasien-rs');

    Route::post('/pasien/pasien-umum', 'PendaftaranController@storePasienUmum')->name('resepsionis.pasien.store.pasien-umum');
    Route::post('/pasien/pasien-rs', 'PendaftaranController@storePasienRs')->name('resepsionis.pasien.store.pasien-rs');

    Route::get('/{id}/pasien/pasien-umum/edit', 'PendaftaranController@editPasienUmum')->name('resepsionis.pasien.edit-pasien-umum');
    Route::get('/{id}/pasien/pasien-rs/edit', 'PendaftaranController@editPasienRs')->name('resepsionis.pasien.edit-pasien-rs');

    Route::put('/{id}/pasien/pasien-umum', 'PendaftaranController@updatePasienUmum')->name('resepsionis.pasien.update-pasien-umum');
    Route::put('/{id}/pasien/pasien-rs', 'PendaftaranController@updatePasienRs')->name('resepsionis.pasien.update-pasien-rs');

    Route::get('{id}/pendaftaran/pasien-umum', 'PendaftaranController@pendaftaranPasienUmum')->name('resepsionis.pasien.pendaftaran.pasien-umum');
    Route::get('{id}/pendaftaran/pasien-rs', 'PendaftaranController@pendaftaranPasienRs')->name('resepsionis.pasien.pendaftaran.pasien-rs');

    Route::post('{id}/pendaftaran/pasien-umum', 'PendaftaranController@storePendaftaranPasienUmum')->name('resepsionis.pasien.store.pendaftaran.pasien-umum');
    Route::post('{id}/pendaftaran/pasien-rs', 'PendaftaranController@storePendaftaranPasienRs')->name('resepsionis.pasien.store.pendaftaran.pasien-rs');

    Route::get('/pendaftaran/index/', 'PendaftaranController@indexPendaftaran')->name('resepsionis.pasien.index.pendaftaran');

    Route::get('{id}/pendaftaran/detail/surat-rujukan', 'PendaftaranController@detailSuratRujukan')->name('resepsionis.pasien.pendaftaran.surat-rujukan');
    Route::get('{id}/pendaftaran/export-pdf/surat-rujukan', 'PendaftaranController@SuratRujukan')->name('resepsionis.pasien.pendaftaran.print.surat-rujukan');
});

Route::group(['prefix' => 'dokter-poli/'], function () {
    Route::get('pasien/index', 'RujukanController@indexPasienRs')->name('dokterPoli.pasien.index-pasien');
    Route::get('/{id}/detail/pasien', 'RujukanController@detailPasien')->name('dokterPoli.pasien.detail-pasien');
    Route::get('/pasien/create', 'RujukanController@createPasien')->name('dokterPoli.pasien.create-pasien');
    Route::post('/pasien', 'RujukanController@storePasien')->name('dokterPoli.pasien.store-pasien');
    Route::get('/{id}/pasien/edit', 'RujukanController@editPasien')->name('dokterPoli.pasien.edit-pasien');
    Route::put('/{id}/pasien', 'RujukanController@updatePasien')->name('dokterPoli.pasien.update-pasien');

    Route::get('{id}/pasien/rujuk-pasien', 'RujukanController@rujukPasien')->name('dokterPoli.pasien.rujuk-pasien');
    Route::post('{id}/rujuk-pasien', 'RujukanController@storeRujukPasien')->name('dokterPoli.pasien.store.rujuk-pasien');

    Route::get('/index/rujuk-pemeriksaan', 'RujukanController@indexRujuk')->name('dokterPoli.pasien.index-rujuk');
    Route::get('/index/pemeriksaan', 'RujukanController@indexPemeriksaan')->name('dokterPoli.pasien.index-pemeriksaan');

    Route::get('{id}/rujuk/detail/surat-rujukan', 'RujukanController@detailSuratRujukan')->name('dokterPoli.pasien.pendaftaran.surat-rujukan');
    Route::get('{id}/rujuk/export-pdf/surat-rujukan', 'PendaftaranController@SuratRujukan')->name('dokterPoli.pasien.pendaftaran.print.surat-rujukan');
});

Route::group(['prefix' => 'radiografer/'], function () {
    Route::get('/pasien/index/pasien-umum', 'PemeriksaanController@indexPasienUmum')->name('radiografer.pasien.index-pasien-umum');
    Route::get('/pasien/index/pasien-rs', 'PemeriksaanController@indexPasienRs')->name('radiografer.pasien.index-pasien-rs');

    Route::get('/{id}/pasien/detail/pasien-umum', 'PemeriksaanController@detailPasienUmum')->name('radiografer.pasien.detail-pasien-umum');
    Route::get('/{id}/pasien/detail/pasien-rs', 'PemeriksaanController@detailPasienRs')->name('radiografer.pasien.detail-pasien-rs');

    Route::get('/index/pemeriksaan', 'PemeriksaanController@indexPemeriksaan')->name('radiografer.pasien.index-pemeriksaan');
    Route::get('{id}/create/pemeriksaan-pasien', 'PemeriksaanController@pemeriksaanPasien')->name('radiografer.pasien.pemeriksaan-pasien');
    Route::put('{id}/pemeriksaan-pasien', 'PemeriksaanController@storePemeriksaanPasien')->name('radiografer.pasien.store.pemeriksaan-pasien');

    Route::get('{id}/pemeriksaan/detail/surat-rujukan', 'PemeriksaanController@detailSuratRujukan')->name('radiografer.pasien.pendaftaran.surat-rujukan');
    Route::get('{id}/pemeriksaan/export-pdf/surat-rujukan', 'PendaftaranController@SuratRujukan')->name('radiografer.pasien.pendaftaran.print.surat-rujukan');
});

Route::group(['prefix' => 'dokter-radiologi/'], function () {
    Route::get('/pasien/index/pasien-umum', 'ExpertiseController@indexPasienUmum')->name('dokterRadiologi.pasien.index-pasien-umum');
    Route::get('/pasien/index/pasien-rs', 'ExpertiseController@indexPasienRs')->name('dokterRadiologi.pasien.index-pasien-rs');

    Route::get('/{id}/pasien/detail/pasien-umum', 'ExpertiseController@detailPasienUmum')->name('dokterRadiologi.pasien.detail-pasien-umum');
    Route::get('/{id}/pasien/detail/pasien-rs', 'ExpertiseController@detailPasienRs')->name('dokterRadiologi.pasien.detail-pasien-rs');

    Route::get('/index/pemeriksaan', 'ExpertiseController@indexPemeriksaan')->name('dokterRadiologi.pasien.index-pemeriksaan');
    Route::get('{id}/create/expertise-pasien', 'ExpertiseController@expertisePasien')->name('dokterRadiologi.pasien.expertise-pasien');
    Route::put('{id}/expertise-pasien', 'ExpertiseController@storeExpertisePasien')->name('dokterRadiologi.pasien.store.expertise-pasien');

    Route::get('{id}/pemeriksaan/detail/surat-rujukan', 'ExpertiseController@detailSuratRujukan')->name('dokterRadiologi.pasien.pendaftaran.surat-rujukan');
    Route::get('{id}/pemeriksaan/export-pdf/surat-rujukan', 'PendaftaranController@SuratRujukan')->name('dokterRadiologi.pasien.pendaftaran.print.surat-rujukan');
});

Route::group(['prefix' => 'kasir/'], function () {
    Route::get('/pasien/index/pasien-umum', 'TagihanController@indexPasienUmum')->name('kasir.pasien.index-pasien-umum');
    Route::get('/pasien/index/pasien-rs', 'TagihanController@indexPasienRs')->name('kasir.pasien.index-pasien-rs');

    Route::get('/{id}/pasien/detail/pasien-umum', 'TagihanController@detailPasienUmum')->name('kasir.pasien.detail-pasien-umum');
    Route::get('/{id}/pasien/detail/pasien-rs', 'TagihanController@detailPasienRs')->name('kasir.pasien.detail-pasien-rs');

    Route::get('/index/tagihan', 'TagihanController@indexTagihan')->name('kasir.index-tagihan');
    Route::get('{id}/create/pembayaran-pasien', 'TagihanController@pembayaranPasien')->name('kasir.pasien.pembayaran-pasien');
    Route::put('{id}/pembayaran-pasien', 'TagihanController@storePembayaranPasien')->name('kasir.pasien.store.pembayaran-pasien');
    Route::get('/{id}/pasien/detail/tagihan', 'TagihanController@detailTagihan')->name('kasir.pasien.detail-tagihan');
    Route::get('{id}/pasien/export-pdf/detail-pembayaran', 'TagihanController@strukPembayaran')->name('kasir.pasien.print.tagihan');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
