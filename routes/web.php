<?php

use Illuminate\Support\Facades\{Route, Auth};
use App\Http\Controllers\Admin;
use App\Http\Controllers\Adminauth;
use App\Http\Controllers\IkuController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PerdtahunController;
use App\Http\Controllers\TupoksiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Skp;
use App\Http\Controllers\TargetSemesterController;
use App\Http\Controllers\Penilaianstaf;
use App\Http\Controllers\ManajemenPController;
use App\Http\Controllers\TPeriodeController;
use App\Http\Controllers\TJabatanController;
use App\Http\Controllers\TTupoksiController;
use App\Http\Controllers\RSKPController;
use App\Http\Controllers\TLogController;
use App\Http\Controllers\PengajuanR;
use App\Http\Controllers\PenilaianA;
use App\Http\Controllers\TAdendumController;
use App\Http\Controllers\TPerilakuController;
use App\Http\Controllers\Pencetakan;
use App\Http\Controllers\Monitoring;
use App\Http\Controllers\KinerjaUtamaController;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['statuspeg:pegawai'])->group(function () {
        route::prefix('skp')->group(function () {
            Route::prefix('/cetak')->group(function () {
                Route::get('/rencana-skp', [Pencetakan::class, 'rencanaskp'])->name('cetak.rskp');
                Route::get('/rencana-skp-lengkap', [Pencetakan::class, 'rskpl'])->name('cetak.rskpl');
                Route::get('/realisasi-skp', [Pencetakan::class, 'relskp'])->name('cetak.relskp');
                Route::get('/realisasi-skp-lengkap', [Pencetakan::class, 'relskpl'])->name('cetak.relskpl');
                Route::get('/log-harian', [Pencetakan::class, 'log'])->name('cetak.log');
                Route::get('/log-harian-bulan/{a}', [Pencetakan::class, 'logb'])->name('cetak.logb');
            });
            Route::post('setperiode', [Skp::class, 'set'])->name('user.set');
            Route::get('setperiode/{tahun}', [Skp::class, 'sett'])->name('user.tahun');

            Route::get('/', [Skp::class, 'index'])->name('user.skp');
            Route::get('/informasi', [Skp::class, 'informasi'])->name('user.info');
            Route::get('/integrasi', [Skp::class, 'integrasi'])->name('user.integrasi');

            Route::prefix('/penilaianstaf')->group(function () {
                Route::get('/persetujuan', [Penilaianstaf::class, 'persetujuan'])->name('setuju.staf');
                Route::get('/p_setuju', [Penilaianstaf::class, 'setuju'])->name('p_setuju.staf');
                Route::get('/p_tolak', [Penilaianstaf::class, 'tolak'])->name('p_tolak.staf');
                Route::get('/p_lihat', [Penilaianstaf::class, 'lihat1'])->name('p_lihat.staf');
                Route::get('/p_lihat2', [Penilaianstaf::class, 'lihat2'])->name('p_lihat2.staf');
                Route::get('/data', [Penilaianstaf::class, 'data'])->name('p_lihat.akun');
                Route::get('/datapegawai', [Penilaianstaf::class, 'datapegawai'])->name('p_lihat.pegawai');

                Route::get('/p_tupoksi/{id}', [Penilaianstaf::class, 'tupoksi'])->name('p_tupoksi.staf');
            });
            Route::prefix('/rancangan')->group(function () {
                Route::resource('/skp', RSKPController::class);
                Route::resource('/kinerja-utama', KinerjaUtamaController::class);

                Route::get('/itemskp', [RSKPController::class, 'item'])->name('skp.item');

                Route::get('/itemskpu', [RSKPController::class, 'itemu'])->name('skp.itemu');

                Route::get('/periode', [Skp::class, 'r_tahun'])->name('user.r_perd');
                Route::resource('/tahunperiode', PerdtahunController::class);
                Route::get('/tahunan/{id}/{sem}', [Skp::class, 'r_semester'])->name('user.r_semester');
                Route::get('/item', [Skp::class, 'item'])->name('user.item');
                Route::post('/item', [Skp::class, 'insert'])->name('user.inserttupok');
                Route::resource('/skpmanajemen', TargetSemesterController::class)->only(['destroy']);
            });
            Route::resource('/logharian', TLogController::class);
            Route::post('/edit', [TLogController::class, 'store2'])->name('logharian.store2');
            Route::get('/logharianget', [TLogController::class, 'get'])->name('logharian.getitem');
            Route::get('/logharianitem', [TLogController::class, 'item'])->name('logharian.item');
            Route::get('/loghariantarget', [TLogController::class, 'itemtarget'])->name('logharian.target');
            Route::get('/loghariantargets', [TLogController::class, 'itemtargets'])->name('logharian.targets');
            Route::get('/hapuslogbulan/{a}', [TLogController::class, 'destroyAll'])->name('logharian.hapusbulan');

            Route::resource('/pengajuan-realisasi', PengajuanR::class);
            Route::post('/pengajuan-realisasi/nilai-tambah', [PengajuanR::class, 'nilaitambah'])->name('pengajuan-realisasi.nilaitambah');
            Route::prefix('/persetujuan')->group(function () {

                Route::get('/tugas-tambahan', [PengajuanR::class, 'lihatnilai'])->name('pengajuan-realisasi.setujutt');
                Route::get('/lihat-tugas', [PengajuanR::class, 'lihatdata'])->name('pengajuan-realisasi.lihatdata');
                Route::post('/simpan-tugas', [PengajuanR::class, 'simpannilai'])->name('pengajuan-realisasi.simpannilai');
            });


            Route::get('/pengajuan-remunerasi', [PengajuanR::class, 'remunindex'])->name('pengajuan-realisasi.remun');
            Route::get('/pengukuran-realisasi', [PengajuanR::class, 'pengukuran'])->name('pengajuan-realisasi.pengukuran');

            Route::post('/pengukuran-realisasi', [PengajuanR::class, 'storeukuran'])->name('pengajuan-realisasi.storeukuran');

            Route::post('/pengajuan-remunerasi', [PengajuanR::class, 'ajuremun'])->name('pengajuan-realisasi.ajuremun');


            Route::resource('/penilaian-realisasi', PenilaianA::class);
            Route::post('/penilaian-realisasi/bulan/', [PenilaianA::class, 'bulan'])->name('penilaian-realisasi.bulan');
            Route::post('/penilaian-realisasi/isi/', [PenilaianA::class, 'isi'])->name('penilaian-realisasi.isi');
            Route::post('/penilaian-realisasi/reset/', [PenilaianA::class, 'reset'])->name('penilaian-realisasi.reset');

            Route::resource('/adendum', TAdendumController::class)->only([
                'index', 'update', 'store', 'destroy'
            ]);
            Route::prefix('/adendum')->group(function () {
                Route::get('/persetujuan', [TAdendumController::class, 'persetujuan'])->name('adendum.persetujuan');
                Route::get('/lihat', [TAdendumController::class, 'lihat'])->name('adendum.lihat');
                Route::get('/data', [TAdendumController::class, 'data'])->name('adendum.akun');
                Route::get('/setuju', [TAdendumController::class, 'setuju'])->name('adendum.setuju');
                Route::get('/tolak', [TAdendumController::class, 'tolak'])->name('adendum.tolak');
            });

            Route::resource('/perilaku-kerja', TPerilakuController::class)->only([
                'index', 'update', 'store', 'destroy'
            ]);
            Route::prefix('/perilaku-kerja')->group(function () {
                Route::post('/sms1', [TPerilakuController::class, 'sms1'])->name('perilaku.sms1');
                Route::post('/check', [TPerilakuController::class, 'check'])->name('perilaku.check');
                Route::post('/reset', [TPerilakuController::class, 'reset'])->name('perilaku.reset');
                Route::get('/integrasi', [TPerilakuController::class, 'integrasi'])->name('perilaku.integrasi');
                Route::post('/nilai', [TPerilakuController::class, 'integrasinilai'])->name('perilaku.integrasinilai');
            });
        });
    });

    Route::middleware(['statuspeg:dosen'])->group(function () {
        Route::get('iku', [Skp::class, 'index'])->name('user.skpp');
    });
});

Route::prefix('admin')->group(function () {
    route::get('/login', [Adminauth::class, 'index'])->name('admin.auth');
    route::post('/login', [Adminauth::class, 'login'])->name('admin.proses');
    route::post('/logout', [Adminauth::class, 'logout'])->name('admin.logout');

    route::group(['middleware' => ['cek_admin:1']], function () {
        Route::get('/', [Admin::class, 'index'])->name('admin.ds');
        Route::get('/user', [Adminauth::class, 'admin'])->name('admin.user');
        Route::post('/user', [Adminauth::class, 'simpan'])->name('admin.simpan');
        Route::put('/user', [Adminauth::class, 'edit'])->name('admin.edit');
        Route::get('/profil', [Admin::class, 'profil'])->name('admin.profile');
        Route::post('/edit', [Admin::class, 'edit'])->name('admin.useredit');

        Route::delete('/user/hapus/{id}', [Adminauth::class, 'hapus'])->name('admin.hapus');

        Route::prefix('dm')->group(function () {

            //Tupoksi
            Route::resource('tupoksis', TTupoksiController::class);
            Route::post('tupoksis/file', [TTupoksiController::class, 'storefile'])->name('tupoksis.storefile');
            Route::post('tupoksis/destroyfile', [TTupoksiController::class, 'destroyall'])->name('tupoksis.destroyall');
            //jabatan
            Route::resource('jabatans', TJabatanController::class);
            //periode
            Route::resource('periodes', TPeriodeController::class);
            Route::post('periodes/set', [TPeriodeController::class, 'set'])->name('periodes.set');
            //pegawai
            Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');

            //iku
            Route::resource('iku', IkuController::class)->except(['destroy']);
            Route::post('hapusiku', [IkuController::class, 'destroy'])->name('iku.destroyy');
            Route::get('tabeliku/{id}', [IkuController::class, 'gettupok'])->name('iku.tabeliku');
            Route::post('itemiku', [IkuController::class, 'storetupok'])->name('iku.storeitem');
            Route::post('hapusikuitem', [IkuController::class, 'hapustupok'])->name('iku.hapustupok');

            Route::get('ikugetsi', [IkuController::class, 'getsi'])->name('iku.getsi');
            //status unit
            Route::resource('unit', UnitController::class)->except(['destroy']);
            Route::get('getu', [UnitController::class, 'getu'])->name('unit.get');
            Route::post('hapuss', [UnitController::class, 'destroy'])->name('unitt.hapuss');

            //jabatan
            Route::resource('jabatan', JabatanController::class)->except(['destroy', 'update']);
            Route::post('destroy', [JabatanController::class, 'destroy'])->name('jabatan.destroy');
            Route::post('update/{id}', [JabatanController::class, 'update']);
            Route::get('gethem', [JabatanController::class, 'gethem'])->name('jabatan.get');

            //tupoksi
            Route::resource('tupoksi', TupoksiController::class)->except(['destroy', 'create']);
            Route::get('showtupok/{id}', [TupoksiController::class, 'showtupok']);
            Route::post('hapustupok', [TupoksiController::class, 'destroy'])->name('tupoksi.destroy');
            Route::get('getsi', [TupoksiController::class, 'getsi'])->name('tupoksi.getsi');
            Route::post('itemtupoksi', [TupoksiController::class, 'storetupok'])->name('tupoksi.storeitem');
            Route::post('filetupoksi', [TupoksiController::class, 'storetupok2'])->name('tupoksi.storefileitem');
            Route::post('hapusitem', [TupoksiController::class, 'hapusitem'])->name('tupoksi.hmi');
            Route::get('tabeltupok/{id}', [TupoksiController::class, 'gettupok'])->name('tupoksi.tabeltupok');
            Route::post('hapustupokk', [TupoksiController::class, 'hapustupok'])->name('tupoksi.hapustupok');
            Route::get('edittupok/{id}', [TupoksiController::class, 'edittupok']);
            Route::post('updatetupok/{id}', [TupoksiController::class, 'updatetupok']);
        });
        Route::prefix('manajemen')->group(function () {
            Route::resource('m_pegawai', ManajemenPController::class);
            Route::get('periode-tahunan', [ManajemenPController::class, 'index2'])->name('m_pegawai.index2');
            Route::post('periode-tahunan/del', [ManajemenPController::class, 'delete'])->name('m_pegawai.delete2');

            Route::post('periode-set', [ManajemenPController::class, 'set'])->name('m_pegawai.set');

            Route::get('pegawai', [ManajemenPController::class, 'getpegawai'])->name('m_pegawai.get');
            Route::post('pegawai', [ManajemenPController::class, 'postpegawai'])->name('m_pegawai.post');
        });
        Route::prefix('monitoring')->group(function () {
            Route::get('/skp', [Monitoring::class, 'skp'])->name('skp.monitoring');
            Route::get('/logharian', [Monitoring::class, 'log'])->name('log.monitoring');
        });
    });




    #data master

});



Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::get('/api', [Admin::class, 'pegawai']);
Route::get('/apis', [Admin::class, 'ps'])->name('admin.sinkron');
Route::get('/relasis', [Admin::class, 'relasi'])->name('admin.relasi');
Route::get('/aps', [Admin::class, 'ppss']);
Route::get('/unit', [Admin::class, 'unit'])->name('admin.sinkronunit');
Route::get('/periods', [Admin::class, 'periode'])->name('admin.sinkronperiode');
Route::get('/jabatans', [Admin::class, 'jabatan'])->name('admin.sinkronjabatan');
Route::get('/jabatansfungsional', [Admin::class, 'jabatanfungsi'])->name('admin.sinkronjabfu');





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
