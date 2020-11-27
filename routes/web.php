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
    Route::post('dashboard/kunjungan-tahunan', 'DashboardController@getKunjunganPasienPerTahun');
    Route::post('dashboard/kunjungan-bulanan', 'DashboardController@getKunjunganPasienPerBulan');
    Route::post('dashboard/layanan-tahunan', 'DashboardController@getLayananPerTahun');
    Route::post('dashboard/layanan-bulanan', 'DashboardController@getLayananPerBulan');
    Route::post('dashboard/pendapatan-tahunan', 'DashboardController@getPendapatanPerTahun');
    Route::post('dashboard/pendapatan-bulanan', 'DashboardController@getPendapatanPerBulan');
    Route::post('dashboard/asuransi-tahunan', 'DashboardController@getJenisAsuransiPerTahun');
    Route::post('dashboard/asuransi-bulanan', 'DashboardController@getJenisAsuransiPerBulan');
    Route::post('dashboard/durasi-tahunan', 'DashboardController@getDurasiPerTahun');
    Route::post('dashboard/durasi-bulanan', 'DashboardController@getDurasiPerBulan');

    Route::post('pelaporan/laporan-bulanan', 'ReportingController@laporanBulanan');
    Route::post('pelaporan/laporan-tahunan', 'ReportingController@laporanTahunan');

    Route::get('dashboard/bulan', 'DashboardController@getDurasiPerTahun');

    Route::get('/user/index/dokter', 'UserController@indexDokter')->name('dokter.index');
    Route::get('/user/index/pegawai', 'UserController@indexPegawai')->name('pegawai.index');

    Route::get('{id}/user/detail', 'UserController@detailUser')->name('user.detail');

    Route::get('{id}/detail/profil', 'UserController@profil')->name('profil.show');
    Route::put('/{id}/update/profil', 'UserController@updateProfilPegawai')->name('profil.update.pegawai');

    Route::get('/user/create/dokter', 'UserController@createDokter')->name('dokter.create');
    Route::get('/user/create/pegawai', 'UserController@createPegawai')->name('pegawai.create');

    Route::post('/user/dokter', 'UserController@storeDokter')->name('dokter.store');
    Route::post('/user/pegawai', 'UserController@storePegawai')->name('pegawai.store');

    Route::get('/{id}/user/edit/dokter', 'UserController@editDokter')->name('dokter.edit');
    Route::get('/{id}/user/edit/pegawai', 'UserController@editPegawai')->name('pegawai.edit');

    Route::put('/{id}/user/update/dokter', 'UserController@updateDokter')->name('dokter.update');
    Route::put('/{id}/user/update/pegawai', 'UserController@updatePegawai')->name('pegawai.update');

    Route::get('/{id}/user/delete', 'UserController@delete')->name('user.delete');
    Route::get('/user/trash', 'UserController@trash')->name('user.trash');
    Route::get('/{id}/user/restore', 'UserController@restore')->name('user.restore');
    Route::get('/{id}/user/destroy', 'UserController@destroy')->name('user.destroy');

    Route::get('/pelayanan/index', 'PelayananController@index')->name('pelayanan.index');

    Route::post('/pelayanan/layanan', 'PelayananController@storeLayanan')->name('layanan.store');
    Route::put('/pelayanan/layanan/update', 'PelayananController@updateLayanan')->name('layanan.update');
    Route::get('/{id}/pelayanan/layanan/delete', 'PelayananController@deleteLayanan')->name('layanan.delete');

    Route::post('/pelayanan/film', 'PelayananController@storeFilm')->name('film.store');
    Route::put('/pelayanan/film/update', 'PelayananController@updateFilm')->name('film.update');
    Route::get('/{id}/pelayanan/film/delete', 'PelayananController@deleteFilm')->name('film.delete');

    Route::get('/pasien/index/pasien-umum', 'PasienController@indexPasienUmum')->name('pasien.index-pasien-umum');
    Route::get('/pasien/index/pasien-rs', 'PasienController@indexPasienRs')->name('pasien.index-pasien-rs');

    Route::get('{id}/pasien/detail/pasien-umum', 'PasienController@detailPasienUmum')->name('pasien.detail-pasien-umum');
    Route::get('{id}/pasien/detail/pasien-rs', 'PasienController@detailPasienRs')->name('pasien.detail-pasien-rs');

    Route::get('/pasien/create/pasien-umum', 'PasienController@createPasienUmum')->name('pasien.create.pasien-umum');
    Route::get('/pasien/create/pasien-rs', 'PasienController@createPasienRs')->name('pasien.create.pasien-rs');

    Route::post('/pasien/pasien-umum', 'PasienController@storePasienUmum')->name('pasien.store.pasien-umum');
    Route::post('/pasien/pasien-rs', 'PasienController@storePasienRs')->name('pasien.store.pasien-rs');

    Route::get('/{id}/detail/pemeriksaan', 'PasienController@detailPemeriksaan')->name('pasien.detail-pemeriksaan');

    Route::get('/{id}/pasien/edit/pasien-umum', 'PasienController@editPasienUmum')->name('pasien.edit-pasien-umum');
    Route::get('/{id}/pasien/edit/pasien-rs', 'PasienController@editPasienRs')->name('pasien.edit-pasien-rs');

    Route::put('/{id}/pasien/pasien-umum', 'PasienController@updatePasienUmum')->name('pasien.update-pasien-umum');
    Route::put('/{id}/pasien/pasien-rs', 'PasienController@updatePasienRs')->name('pasien.update-pasien-rs');

    Route::get('/{id}/pasien/delete', 'PasienController@delete')->name('pasien.delete');
    Route::get('/pasien/trash', 'PasienController@trash')->name('pasien.trash');
    Route::get('/{id}/pasien/restore', 'PasienController@restore')->name('pasien.restore');
    Route::get('/{id}/pasien/destroy', 'PasienController@destroy')->name('pasien.destroy');

    Route::get('{id}/pasien/detail/surat-rujukan', 'PasienController@detailSuratRujukan')->name('pasien.pendaftaran.surat-rujukan');
    Route::get('{id}/rujuk/unduh/surat-rujukan', 'PendaftaranController@downloadSuratRujukan')->name('pasien.download.surat-rujukan');

    Route::get('{id}/pasien/hasil-expertise', 'PasienController@detailHasilExpertise')->name('pasien.pemeriksaan.hasil-expertise');
    Route::get('{id}/pemeriksaan/unduh/hasil-expertise', 'ExpertiseController@downloadHasilExpertise')->name('pasien.download.hasil-expertise');

    Route::get('/{id}/pasien/detail/tagihan', 'PasienController@detailTagihan')->name('pasien.detail-tagihan');
});

Route::group(['prefix' => 'resepsionis/', 'middleware' => 'role.resepsionis'], function () {
    Route::get('{id}/detail/profil', 'UserController@profil')->name('profil.show.resepsionis');
    Route::put('/{id}/update/profil', 'UserController@updateProfilPegawai')->name('profil.update.resepsionis');

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
    Route::post('{id}/rujuk/unggah/surat-rujukan', 'PendaftaranController@uploadSuratRujukan')->name('resepsionis.pasien.upload.surat-rujukan');
    Route::get('{id}/rujuk/unduh/surat-rujukan', 'PendaftaranController@downloadSuratRujukan')->name('resepsionis.pasien.download.surat-rujukan');
});

Route::group(['prefix' => 'dokter-poli/', 'middleware' => 'role.dokterpoli'], function () {
    Route::get('{id}/detail/profil', 'UserController@profil')->name('profil.show.dokterPoli');
    Route::put('/{id}/update/profil', 'UserController@updateProfilDokter')->name('profil.update.dokterPoli');

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

    Route::get('/{id}/detail/pemeriksaan', 'RujukanController@detailPemeriksaan')->name('dokterPoli.pasien.detail-pemeriksaan');

    Route::get('{id}/rujuk/detail/surat-rujukan', 'RujukanController@detailSuratRujukan')->name('dokterPoli.pasien.pendaftaran.surat-rujukan');
    Route::get('{id}/rujuk/export-pdf/surat-rujukan', 'PendaftaranController@suratRujukan')->name('dokterPoli.pasien.pendaftaran.print.surat-rujukan');
    Route::post('{id}/rujuk/unggah/surat-rujukan', 'RujukanController@uploadSuratRujukan')->name('dokterPoli.pasien.upload.surat-rujukan');
    Route::get('{id}/rujuk/unduh/surat-rujukan', 'PendaftaranController@downloadSuratRujukan')->name('dokterPoli.pasien.download.surat-rujukan');

    Route::get('{id}/pemeriksaan/hasil-expertise', 'ExpertiseController@detailHasilExpertise')->name('dokterPoli.pasien.pemeriksaan.hasil-expertise');
    Route::get('{id}/pemeriksaan/unduh/hasil-expertise', 'ExpertiseController@downloadHasilExpertise')->name('dokterPoli.pasien.download.hasil-expertise');
});

Route::group(['prefix' => 'radiografer/', 'middleware' => 'role.radiografer'], function () {
    Route::get('{id}/detail/profil', 'UserController@profil')->name('profil.show.radiografer');
    Route::put('/{id}/update/profil', 'UserController@updateProfilPegawai')->name('profil.update.radiografer');

    Route::get('/pasien/index/pasien-umum', 'PemeriksaanController@indexPasienUmum')->name('radiografer.pasien.index-pasien-umum');
    Route::get('/pasien/index/pasien-rs', 'PemeriksaanController@indexPasienRs')->name('radiografer.pasien.index-pasien-rs');

    Route::get('/{id}/pasien/detail/pasien-umum', 'PemeriksaanController@detailPasienUmum')->name('radiografer.pasien.detail-pasien-umum');
    Route::get('/{id}/pasien/detail/pasien-rs', 'PemeriksaanController@detailPasienRs')->name('radiografer.pasien.detail-pasien-rs');

    Route::get('/index/pemeriksaan', 'PemeriksaanController@indexPemeriksaan')->name('radiografer.pasien.index-pemeriksaan');
    Route::get('{id}/create/pemeriksaan-pasien', 'PemeriksaanController@pemeriksaanPasien')->name('radiografer.pasien.pemeriksaan-pasien');
    Route::put('{id}/pemeriksaan-pasien', 'PemeriksaanController@storePemeriksaanPasien')->name('radiografer.pasien.store.pemeriksaan-pasien');

    Route::get('/{id}/detail/pemeriksaan', 'PemeriksaanController@detailPemeriksaan')->name('radiografer.pasien.detail-pemeriksaan');

    Route::get('{id}/pemeriksaan/detail/surat-rujukan', 'PemeriksaanController@detailSuratRujukan')->name('radiografer.pasien.pendaftaran.surat-rujukan');
    Route::get('{id}/rujuk/unduh/surat-rujukan', 'PendaftaranController@downloadSuratRujukan')->name('radiografer.pasien.download.surat-rujukan');

    Route::get('{id}/pemeriksaan/hasil-expertise', 'ExpertiseController@detailHasilExpertise')->name('radiografer.pasien.pemeriksaan.hasil-expertise');
    Route::get('{id}/pemeriksaan/unduh/hasil-expertise', 'ExpertiseController@downloadHasilExpertise')->name('radiografer.pasien.download.hasil-expertise');
    Route::post('{id}/pemeriksaan/unggah/hasil-expertise', 'PemeriksaanController@uploadHasilExpertise')->name('radiografer.pasien.upload.hasil-expertise');
});

Route::group(['prefix' => 'dokter-radiologi/', 'middleware' => 'role.dokterradiologi'], function () {
    Route::get('{id}/detail/profil', 'UserController@profil')->name('profil.show.dokterRadiologi');
    Route::put('/{id}/update/profil', 'UserController@updateProfilDokter')->name('profil.update.dokterRadiologi');

    Route::get('/pasien/index/pasien-umum', 'ExpertiseController@indexPasienUmum')->name('dokterRadiologi.pasien.index-pasien-umum');
    Route::get('/pasien/index/pasien-rs', 'ExpertiseController@indexPasienRs')->name('dokterRadiologi.pasien.index-pasien-rs');

    Route::get('/{id}/pasien/detail/pasien-umum', 'ExpertiseController@detailPasienUmum')->name('dokterRadiologi.pasien.detail-pasien-umum');
    Route::get('/{id}/pasien/detail/pasien-rs', 'ExpertiseController@detailPasienRs')->name('dokterRadiologi.pasien.detail-pasien-rs');

    Route::get('/{id}/pasien/detail/pemeriksaan', 'ExpertiseController@detailPemeriksaan')->name('dokterRadiologi.pasien.detail-pemeriksaan');

    Route::get('/index/pemeriksaan', 'ExpertiseController@indexPemeriksaan')->name('dokterRadiologi.pasien.index-pemeriksaan');
    Route::get('{id}/create/expertise-pasien', 'ExpertiseController@expertisePasien')->name('dokterRadiologi.pasien.expertise-pasien');
    Route::put('{id}/expertise-pasien', 'ExpertiseController@storeExpertisePasien')->name('dokterRadiologi.pasien.store.expertise-pasien');

    Route::get('{id}/pemeriksaan/hasil-expertise', 'ExpertiseController@detailHasilExpertise')->name('dokterRadiologi.pasien.pemeriksaan.hasil-expertise');
    Route::get('{id}/pemeriksaan/export-pdf/hasil-expertise', 'ExpertiseController@hasilExpertise')->name('dokterRadiologi.pasien.pemeriksaan.print.hasil-expertise');
    Route::post('{id}/pemeriksaan/unggah/hasil-expertise', 'ExpertiseController@uploadHasilExpertise')->name('dokterRadiologi.pasien.upload.hasil-expertise');
    Route::get('{id}/pemeriksaan/unduh/hasil-expertise', 'ExpertiseController@downloadHasilExpertise')->name('dokterRadiologi.pasien.download.hasil-expertise');

    Route::get('{id}/pemeriksaan/detail/surat-rujukan', 'ExpertiseController@detailSuratRujukan')->name('dokterRadiologi.pasien.pendaftaran.surat-rujukan');
    Route::get('{id}/rujuk/unduh/surat-rujukan', 'PendaftaranController@downloadSuratRujukan')->name('dokterRadiologi.pasien.download.surat-rujukan');
});

Route::group(['prefix' => 'kasir/', 'middleware' => 'role.kasir'], function () {
    Route::get('{id}/detail/profil', 'UserController@profil')->name('profil.show.kasir');
    Route::put('/{id}/update/profil', 'UserController@updateProfilPegawai')->name('profil.update.kasir');

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

Route::post('/markAsRead', 'UserController@markAsReadNotification')->name('markAsRead.notification')->middleware('terontetikasi');
Route::get('/total-notifications', 'UserController@totalNotifications')->name('total.notifications')->middleware('terontetikasi');

Auth::routes();

