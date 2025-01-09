<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AksesMenuController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
// use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\registrasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KabKkbController;
use App\Http\Controllers\AuditTrailsController;
use App\Http\Controllers\PkpCabangController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PengecekanController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\SkorsingBlacklistController;
use App\Http\Controllers\TabunganSetoranController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/', \App\Http\Controllers\DashboardController::class);



// route yang terpakai 
// route login 
Route::resource('/login', \App\Http\Controllers\LoginController::class);
Route::post('/loginAction', [LoginController::class, 'loginAction'])->name('loginAction');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// route dashboard 
Route::resource('/dashboard', \App\Http\Controllers\DashboardController::class);
Route::get('/dashboardAnggota', [DashboardController::class, 'dashboardAnggota'])->name('dashboardAnggota');
Route::get('/chartAnggotaBermasalah', [DashboardController::class, 'chartAnggotaBermasalah'])->name('chartAnggotaBermasalah');
Route::get('/chartKelompokTelat', [DashboardController::class, 'chartKelompokTelat'])->name('chartKelompokTelat');
Route::get('/chartKelompokBerat', [DashboardController::class, 'chartKelompokBerat'])->name('chartKelompokBerat');
Route::get('/getDataTotalDashboard', [DashboardController::class, 'getDataTotalDashboard'])->name('getDataTotalDashboard');
Route::get('/chartPencairanAnggota', [DashboardController::class, 'chartPencairanAnggota'])->name('chartPencairanAnggota');
Route::get('/chartPencairanKelompok', [DashboardController::class, 'chartPencairanKelompok'])->name('chartPencairanKelompok');
Route::get('/chartCabangAnggota', [DashboardController::class, 'chartCabangAnggota'])->name('chartCabangAnggota');
Route::get('/chartCabangKelompok', [DashboardController::class, 'chartCabangKelompok'])->name('chartCabangKelompok');



// route KAB/KKB 
Route::resource('/kab_kkb', \App\Http\Controllers\KabKkbController::class);
Route::get('/pengisianKab', [KabKkbController::class, 'pengisianKab'])->name('pengisianKab');
Route::get('/getTableKab', [KabKkbController::class, 'getTableKab'])->name('getTableKab');
Route::get('/getTableKabDikunjungi', [KabKkbController::class, 'getTableKabDikunjungi'])->name('getTableKabDikunjungi');
Route::get('/getDetailAb/{id}', [KabKkbController::class, 'getDetailAb'])->name('getDetailAb');
Route::post('/updatePengisianAb', [KabKkbController::class, 'updatePengisianAb'])->name('updatePengisianAb');
Route::get('/editABDikunjungi/{id}', [KabKkbController::class, 'editABDikunjungi'])->name('editABDikunjungi');
Route::get('/historyKunjunganKab', [KabKkbController::class, 'historyKunjunganKab'])->name('historyKunjunganKab');
Route::post('/deleteHistorynAction', [KabKkbController::class, 'deleteHistorynAction'])->name('deleteHistorynAction');
Route::get('/statusKabKkb', [KabKkbController::class, 'statusKabKkb'])->name('statusKabKkb');
Route::get('/formBelumDikunjungiDikumpulkan', [KabKkbController::class, 'formBelumDikunjungiDikumpulkan'])->name('formBelumDikunjungiDikumpulkan');
Route::get('/formKelompokBermasalah', [KabKkbController::class, 'formKelompokBermasalah'])->name('formKelompokBermasalah');
Route::get('/getTableFormKelompokBermasalahKab', [KabKkbController::class, 'getTableFormKelompokBermasalahKab'])->name('getTableFormKelompokBermasalahKab');
Route::get('/rangkumanDtr', [KabKkbController::class, 'rangkumanDtr'])->name('rangkumanDtr');
Route::get('/getTableRangkumanDtr', [KabKkbController::class, 'getTableRangkumanDtr'])->name('getTableRangkumanDtr');


// route audit trails 
Route::resource('/auditTrails', \App\Http\Controllers\AuditTrailsController::class);
Route::get('/getAuditTrails', [AuditTrailsController::class, 'getAuditTrails'])->name('getAuditTrails');


// route pkp & cabang 
Route::resource('/pkpCabang', \App\Http\Controllers\PkpCabangController::class);
Route::get('/getPkp', [PkpCabangController::class, 'getPkp'])->name('getPkp');
Route::post('/deletePkpAction', [PkpCabangController::class, 'deletePkpAction'])->name('deletePkpAction');
Route::get('/getCabang', [PkpCabangController::class, 'getCabang'])->name('getCabang');
Route::post('/deleteCabangAction', [PkpCabangController::class, 'deleteCabangAction'])->name('deleteCabangAction');
Route::get('/getCabangOption', [PkpCabangController::class, 'getCabangOption'])->name('getCabangOption');
Route::post('/addPkpAction', [PkpCabangController::class, 'addPkpAction'])->name('addPkpAction');
Route::get('/getKcOption', [PkpCabangController::class, 'getKcOption'])->name('getKcOption');
Route::post('/addCabangAction', [PkpCabangController::class, 'addCabangAction'])->name('addCabangAction');
Route::get('/editPkp/{id}', [PkpCabangController::class, 'editPkp'])->name('editPkp');
Route::get('/showDetailPkp/{id}', [PkpCabangController::class, 'showDetailPkp'])->name('showDetailPkp');
Route::post('/updatePkpAction', [PkpCabangController::class, 'updatePkpAction'])->name('updatePkpAction');
Route::get('/editCabang/{id}', [PkpCabangController::class, 'editCabang'])->name('editCabang');
Route::get('/getReffJenisUserOption', [PkpCabangController::class, 'getReffJenisUserOption'])->name('getReffJenisUserOption');
Route::get('/getPkpOption', [PkpCabangController::class, 'getPkpOption'])->name('getPkpOption');


// route ganti password 
Route::get('/gantiPassword', [PkpCabangController::class, 'gantiPassword'])->name('gantiPassword');


// route kelompok 
Route::resource('/kelompokAktif', \App\Http\Controllers\KelompokController::class);
Route::get('/masalahKelompok', [KelompokController::class, 'masalahKelompok'])->name('masalahKelompok');
Route::get('/getMasalahKelompok', [KelompokController::class, 'getMasalahKelompok'])->name('getMasalahKelompok');
Route::get('/cariKelompok', [KelompokController::class, 'cariKelompok'])->name('cariKelompok');
Route::get('/getKelompokAktif', [KelompokController::class, 'getKelompokAktif'])->name('getKelompokAktif');
Route::get('/exportKelompok', [KelompokController::class, 'exportKelompok'])->name('exportKelompok');
Route::get('/getCariKelompok', [KelompokController::class, 'getCariKelompok'])->name('getCariKelompok');
Route::get('/detailKelompok/{kode_group1}', [KelompokController::class, 'detailKelompok'])->name('detailKelompok');
Route::get('/getDetailKelompok/{kode_group1}', [KelompokController::class, 'getDetailKelompok'])->name('getDetailKelompok');
Route::get('/getAnggotaKelompok', [KelompokController::class, 'getAnggotaKelompok'])->name('getAnggotaKelompok');
Route::get('/getCariDownloadKelompok', [KelompokController::class, 'getCariDownloadKelompok'])->name('getCariDownloadKelompok');
Route::get('/downloadKelompok', [KelompokController::class, 'downloadKelompok'])->name('downloadKelompok');
Route::get('/exportDownloadKelompok', [KelompokController::class, 'exportDownloadKelompok'])->name('exportDownloadKelompok');
Route::get('/dataKelompok', [KelompokController::class, 'dataKelompok'])->name('dataKelompok');
Route::get('/getSemuaKelompok', [KelompokController::class, 'getSemuaKelompok'])->name('getSemuaKelompok');
Route::get('/getCekKelompokOption', [KelompokController::class, 'getCekKelompokOption'])->name('getCekKelompokOption');
Route::post('/addMasalahKelompokAction', [KelompokController::class, 'addMasalahKelompokAction'])->name('addMasalahKelompokAction');
Route::get('/exportDownloadRangkumanMk', [KelompokController::class, 'exportDownloadRangkumanMk'])->name('exportDownloadRangkumanMk');
Route::get('/exportDownloadHistoryMk', [KelompokController::class, 'exportDownloadHistoryMk'])->name('exportDownloadHistoryMk');
Route::post('/deleteMasalahKelompokAction', [KelompokController::class, 'deleteMasalahKelompokAction'])->name('deleteMasalahKelompokAction');


// route anggota 
Route::resource('/anggotaAktif', \App\Http\Controllers\AnggotaController ::class);
Route::get('/masalahAnggota', [AnggotaController::class, 'masalahAnggota'])->name('masalahAnggota');
Route::get('/getMasalahAnggota', [AnggotaController::class, 'getMasalahAnggota'])->name('getMasalahAnggota');
Route::get('/cariAnggota', [AnggotaController::class, 'cariAnggota'])->name('cariAnggota');
Route::get('/historyAnggota', [AnggotaController::class, 'historyAnggota'])->name('historyAnggota');
Route::get('/getAnggotaAktif', [AnggotaController::class, 'getAnggotaAktif'])->name('getAnggotaAktif');
Route::get('/exportAnggota', [AnggotaController::class, 'exportAnggota'])->name('exportAnggota');
Route::get('/getCariAnggota', [AnggotaController::class, 'getCariAnggota'])->name('getCariAnggota');
Route::get('/detailAnggota/{nasabah_id}', [AnggotaController::class, 'detailAnggota'])->name('detailAnggota');
Route::get('/getHistoryAnggota', [AnggotaController::class, 'getHistoryAnggota'])->name('getHistoryAnggota');
Route::get('/getDetailAnggota/{nasabah_id}', [AnggotaController::class, 'getDetailAnggota'])->name('getDetailAnggota');
Route::get('/downloadAnggotaAktif', [AnggotaController::class, 'downloadAnggotaAktif'])->name('downloadAnggotaAktif');
Route::get('/downloadAnggota', [AnggotaController::class, 'downloadAnggota'])->name('downloadAnggota');
Route::get('/getSemuaAnggota', [AnggotaController::class, 'getSemuaAnggota'])->name('getSemuaAnggota');
Route::get('/exportSemuaAnggota', [AnggotaController::class, 'exportSemuaAnggota'])->name('exportSemuaAnggota');
Route::get('/exportDownloadHistoryAnggota', [AnggotaController::class, 'exportDownloadHistoryAnggota'])->name('exportDownloadHistoryAnggota');
Route::get('/getCekAnggota', [AnggotaController::class, 'getCekAnggota'])->name('getCekAnggota');
Route::get('/getCekKtp', [AnggotaController::class, 'getCekKtp'])->name('getCekKtp');
Route::get('/getCekAnggotaValue', [AnggotaController::class, 'getCekAnggotaValue'])->name('getCekAnggotaValue');


// route setoran dan tabungan 
Route::resource('/tabunganLapangan', \App\Http\Controllers\TabunganSetoranController ::class);
Route::get('/getTableTabLapangan', [TabunganSetoranController::class, 'getTableTabLapangan'])->name('getTableTabLapangan');
Route::get('/exportDownloadTabunganLapangan', [TabunganSetoranController::class, 'exportDownloadTabunganLapangan'])->name('exportDownloadTabunganLapangan');
Route::get('/tabunganKantor', [TabunganSetoranController::class, 'tabunganKantor'])->name('tabunganKantor');
Route::get('/getTableTabKantor', [TabunganSetoranController::class, 'getTableTabKantor'])->name('getTableTabKantor');
Route::get('/exportDownloadTabunganKantor', [TabunganSetoranController::class, 'exportDownloadTabunganKantor'])->name('exportDownloadTabunganKantor');
Route::get('/setoranTabungan', [TabunganSetoranController::class, 'setoranTabungan'])->name('setoranTabungan');
Route::get('/getTableSetTab', [TabunganSetoranController::class, 'getTableSetTab'])->name('getTableSetTab');
Route::get('/exportDownloadSetoranTabungan', [TabunganSetoranController::class, 'exportDownloadSetoranTabungan'])->name('exportDownloadSetoranTabungan');
Route::get('/setoran', [TabunganSetoranController::class, 'setoran'])->name('setoran');
Route::get('/getTableSet', [TabunganSetoranController::class, 'getTableSet'])->name('getTableSet');
Route::get('/exportDownloadSetoran', [TabunganSetoranController::class, 'exportDownloadSetoran'])->name('exportDownloadSetoran');


// route pengecekan 
Route::resource('/cekTabungan', \App\Http\Controllers\PengecekanController ::class);
Route::get('/cekKelompok', [PengecekanController::class, 'cekKelompok'])->name('cekKelompok');
Route::get('/cekAnggota', [PengecekanController::class, 'cekAnggota'])->name('cekAnggota');
Route::get('/cekKtp', [PengecekanController::class, 'cekKtp'])->name('cekKtp');
Route::get('/cekTabunganAnggota/{nasabah_id}', [PengecekanController::class, 'cekTabunganAnggota'])->name('cekTabunganAnggota');
Route::get('/getCekTabunganAnggota', [PengecekanController::class, 'getCekTabunganAnggota'])->name('getCekTabunganAnggota');


// route reporting 
Route::resource('/laporanHarian', \App\Http\Controllers\ReportingController ::class);
Route::get('/laporanMingguan', [ReportingController::class, 'laporanMingguan'])->name('laporanMingguan');
Route::get('/laporanPeriode', [ReportingController::class, 'laporanPeriode'])->name('laporanPeriode');
Route::get('/laporanKompilasi', [ReportingController::class, 'laporanKompilasi'])->name('laporanKompilasi');
Route::get('/rangkumanMasalah', [ReportingController::class, 'rangkumanMasalah'])->name('rangkumanMasalah');
Route::get('/masalahPerCabang', [ReportingController::class, 'masalahPerCabang'])->name('masalahPerCabang');

// route skorsing & blacklist 
Route::resource('/skorsing', \App\Http\Controllers\SkorsingBlacklistController ::class);
Route::get('/blacklist', [SkorsingBlacklistController::class, 'blacklist'])->name('blacklist');
Route::get('/getAnggotaBlacklist', [SkorsingBlacklistController::class, 'getAnggotaBlacklist'])->name('getAnggotaBlacklist');
Route::get('/getRekomendasiBlacklist', [SkorsingBlacklistController::class, 'getRekomendasiBlacklist'])->name('getRekomendasiBlacklist');
Route::post('/deleteBlacklistAction', [SkorsingBlacklistController::class, 'deleteBlacklistAction'])->name('deleteBlacklistAction');
Route::post('/addBlacklistAction', [SkorsingBlacklistController::class, 'addBlacklistAction'])->name('addBlacklistAction');
Route::get('/getAnggotaSkorsing', [SkorsingBlacklistController::class, 'getAnggotaSkorsing'])->name('getAnggotaSkorsing');
Route::post('/deleteSkorsingAction', [SkorsingBlacklistController::class, 'deleteSkorsingAction'])->name('deleteSkorsingAction');
Route::get('/getRekomendasiSkorsing', [SkorsingBlacklistController::class, 'getRekomendasiSkorsing'])->name('getRekomendasiSkorsing');
Route::post('/addSkorsingAction', [SkorsingBlacklistController::class, 'addSkorsingAction'])->name('addSkorsingAction');


// end route yang terpakai 




// route home 
Route::resource('/home', \App\Http\Controllers\HomeController::class);
Route::get('/daftarWTA', [HomeController::class, 'daftarWTA'])->name('daftarWTA');
Route::post('/daftarWTAAction', [HomeController::class, 'daftarWTAAction'])->name('daftarWTAAction');
Route::post('/daftarWTAUlangAction', [HomeController::class, 'daftarWTAUlangAction'])->name('daftarWTAUlangAction');
Route::get('getFakultas', [HomeController::class, 'getFakultas'])->name('getFakultas');
Route::get('/getProdiByFakultas', [HomeController::class, 'getProdiByFakultas'])->name('getProdiByFakultas');
Route::get('getAngkatan', [HomeController::class, 'getAngkatan'])->name('getAngkatan');
Route::get('/homeAdm', [HomeController::class, 'homeAdm'])->name('homeAdm');

// wta 
Route::get('/wta', [HomeController::class, 'wta'])->name('wta');
Route::get('getWta', [HomeController::class, 'getWta'])->name('getWta');
Route::get('/editWta/{id_wta}', [HomeController::class, 'editWta'])->name('editWta');
Route::post('/verifikasiWtaAction', [HomeController::class, 'verifikasiWtaAction'])->name('verifikasiWtaAction');

// dosen PA 
Route::get('/dosenPA', [HomeController::class, 'dosenPA'])->name('dosenPA');
Route::get('/getMhs', [HomeController::class, 'getMhs'])->name('getMhs');
Route::get('/pilihDosen/{id_user}', [HomeController::class, 'pilihDosen'])->name('pilihDosen');
Route::get('getDosen', [HomeController::class, 'getDosen'])->name('getDosen');
Route::post('/pilihDosenAction', [HomeController::class, 'pilihDosenAction'])->name('pilihDosenAction');
Route::get('/dosenPaMhs', [HomeController::class, 'dosenPaMhs'])->name('dosenPaMhs');

// dosen penguji
Route::get('/dosenUji', [HomeController::class, 'dosenUji'])->name('dosenUji');
Route::get('/pilihDosenUji/{id_user}', [HomeController::class, 'pilihDosenUji'])->name('pilihDosenUji');
Route::get('/dosenPengujiMhs', [HomeController::class, 'dosenPengujiMhs'])->name('dosenPengujiMhs');

// workshop TA 
Route::get('/workshopTa', [HomeController::class, 'workshopTa'])->name('workshopTa');
Route::post('/uploadWorkshopAction', [HomeController::class, 'uploadWorkshopAction'])->name('uploadWorkshopAction');
Route::get('/workshopTaAdm', [HomeController::class, 'workshopTaAdm'])->name('workshopTaAdm');
Route::get('getWorkshopTa', [HomeController::class, 'getWorkshopTa'])->name('getWorkshopTa');
Route::get('/editWorkshopTa/{id_workshop_ta}', [HomeController::class, 'editWorkshopTa'])->name('editWorkshopTa');
Route::post('/verifikasiWorkshopTaAction', [HomeController::class, 'verifikasiWorkshopTaAction'])->name('verifikasiWorkshopTaAction');


// workshop Mendeley
Route::get('/workshopMendeley', [HomeController::class, 'workshopMendeley'])->name('workshopMendeley');
Route::post('/uploadMendeleypAction', [HomeController::class, 'uploadMendeleypAction'])->name('uploadMendeleypAction');
Route::get('/workshopMendeleyAdm', [HomeController::class, 'workshopMendeleyAdm'])->name('workshopMendeleyAdm');
Route::get('getWorkshopMendeley', [HomeController::class, 'getWorkshopMendeley'])->name('getWorkshopMendeley');
Route::get('/editWorkshopMendeley/{id_workshop_mendeley}', [HomeController::class, 'editWorkshopMendeley'])->name('editWorkshopMendeley');
Route::post('/verifikasiWorkshopMendeleyAction', [HomeController::class, 'verifikasiWorkshopMendeleyAction'])->name('verifikasiWorkshopMendeleyAction');


// progress proposal 
Route::get('/progresProposal', [HomeController::class, 'progresProposal'])->name('progresProposal');
Route::post('/ajukan-selesai', [HomeController::class, 'ajukanSelesai'])->name('ajukanSelesai');
Route::get('/progressProposalAdm', [HomeController::class, 'progressProposalAdm'])->name('progressProposalAdm');
Route::get('getProgressProposal', [HomeController::class, 'getProgressProposal'])->name('getProgressProposal');
Route::post('/ajukanDiterima', [HomeController::class, 'ajukanDiterima'])->name('ajukanDiterima');
Route::post('/ajukanDitolak', [HomeController::class, 'ajukanDitolak'])->name('ajukanDitolak');

// progress revisi proposal
Route::get('/progresRevisiProposal', [HomeController::class, 'progresRevisiProposal'])->name('progresRevisiProposal');
Route::post('/ajukan-selesai-revisi', [HomeController::class, 'ajukanSelesaiRevisi'])->name('ajukanSelesaiRevisi');

// pengumpulan proposal 
Route::get('/pengumpulanProposal/{priode}', [HomeController::class, 'pengumpulanProposal'])->name('pengumpulanProposal');
Route::post('/uploadProposalpAction', [HomeController::class, 'uploadProposalpAction'])->name('uploadProposalpAction');
Route::get('/ujianProposalAdm', [HomeController::class, 'ujianProposalAdm'])->name('ujianProposalAdm');
Route::get('getUjianProposal', [HomeController::class, 'getUjianProposal'])->name('getUjianProposal');
Route::get('/editDaftarUjian/{id_daftar_proposal}', [HomeController::class, 'editDaftarUjian'])->name('editDaftarUjian');
Route::post('/verifikasiUjianProposalAction', [HomeController::class, 'verifikasiUjianProposalAction'])->name('verifikasiUjianProposalAction');
Route::get('/jadwalProposal', [HomeController::class, 'jadwalProposal'])->name('jadwalProposal');

// TA 
Route::get('/progresTa', [HomeController::class, 'progresTa'])->name('progresTa');
Route::post('/ajukan-selesai-ta', [HomeController::class, 'ajukanSelesaiTa'])->name('ajukanSelesaiTa');
Route::get('/progressTaAdm', [HomeController::class, 'progressTaAdm'])->name('progressTaAdm');
Route::get('getProgressTa', [HomeController::class, 'getProgressTa'])->name('getProgressTa');
Route::post('/ajukanDiterimaTa', [HomeController::class, 'ajukanDiterimaTa'])->name('ajukanDiterimaTa');
Route::post('/ajukanDitolakTa', [HomeController::class, 'ajukanDitolakTa'])->name('ajukanDitolakTa');

// pengumpulan TA
Route::get('/pengumpulanTa/{priode}', [HomeController::class, 'pengumpulanTa'])->name('pengumpulanTa');
Route::post('/uploadTaAction', [HomeController::class, 'uploadTaAction'])->name('uploadTaAction');
Route::get('getUjianTa', [HomeController::class, 'getUjianTa'])->name('getUjianTa');
Route::get('/editDaftarUjianTa/{id_daftar_ta}', [HomeController::class, 'editDaftarUjianTa'])->name('editDaftarUjianTa');
Route::post('/verifikasiUjianTaAction', [HomeController::class, 'verifikasiUjianTaAction'])->name('verifikasiUjianTaAction');
Route::get('/jadwalTa', [HomeController::class, 'jadwalTa'])->name('jadwalTa');


// pengumpulan TA 
Route::get('/ujianTaAdm', [HomeController::class, 'ujianTaAdm'])->name('ujianTaAdm');

// route user 
Route::resource('/user', \App\Http\Controllers\UserController::class);
Route::post('/updatePhotoAction', [UserController::class, 'updatePhotoAction'])->name('updatePhotoAction');
Route::get('get-user', [UserController::class, 'getUser'])->name('user.getUser');
Route::get('/addUser', [UserController::class, 'addUser'])->name('user.addUser');
Route::get('/getReffJenisKelaminUser', [UserController::class, 'getReffJenisKelaminUser'])->name('getReffJenisKelaminUser');
Route::get('/getRoleUser', [UserController::class, 'getRoleUser'])->name('getRoleUser');
Route::get('/getReffStatusUser', [UserController::class, 'getReffStatusUser'])->name('getReffStatusUser');
Route::get('/getProvinsi', [UserController::class, 'getProvinsi'])->name('getProvinsi');
Route::get('/getKotaByProvinsi', [UserController::class, 'getKotaByProvinsi'])->name('getKotaByProvinsi');
Route::get('/getKecamatanByKota', [UserController::class, 'getKecamatanByKota'])->name('getKecamatanByKota');
Route::get('/getKelurahanByKecamatan', [UserController::class, 'getKelurahanByKecamatan'])->name('getKelurahanByKecamatan');
Route::get('/getSurveyorByKelurahan', [UserController::class, 'getSurveyorByKelurahan'])->name('getSurveyorByKelurahan');
Route::post('/addUserAction', [UserController::class, 'addUserAction'])->name('addUserAction');
Route::get('/showDetailUser/{id_user}', [UserController::class, 'showDetailUser'])->name('user.showDetailUser');
Route::get('/editUser/{id_user}', [UserController::class, 'editUser'])->name('user.editUser');
Route::post('/updateUserAction', [UserController::class, 'updateUserAction'])->name('updateUserAction');
Route::post('/updatePasswordAction', [UserController::class, 'updatePasswordAction'])->name('updatePasswordAction');
Route::get('/infoUser/{id_user}', [UserController::class, 'infoUser'])->name('user.infoUser');
Route::post('/deleteUserAction', [UserController::class, 'deleteUserAction'])->name('deleteUserAction');
Route::get('/profilUser/{id_user}', [UserController::class, 'profilUser'])->name('user.profilUser');



// route menu 
Route::resource('/menu', \App\Http\Controllers\MenuController::class);
Route::get('get-menu', [MenuController::class, 'getMenu'])->name('menu.getMenu');
Route::get('/addMenu', [MenuController::class, 'addMenu'])->name('menu.addMenu');
Route::get('/getReffJenisMenu', [MenuController::class, 'getReffJenisMenu'])->name('getReffJenisMenu');
Route::get('/getMasterMenu', [MenuController::class, 'getMasterMenu'])->name('menu.getMasterMenu');
Route::get('/getReffStatusMenu', [MenuController::class, 'getReffStatusMenu'])->name('getReffStatusMenu');
Route::post('/addMenuAction', [MenuController::class, 'addMenuAction'])->name('addMenuAction');
Route::get('/infoMenu/{id_menu}', [MenuController::class, 'infoMenu'])->name('menu.infoMenu');
Route::get('/showDetailMenu/{id_menu}', [MenuController::class, 'showDetailMenu'])->name('menu.showDetailMenu');
Route::get('/editMenu/{id_menu}', [MenuController::class, 'editMenu'])->name('menu.editMenu');
Route::post('/updateMenuAction', [MenuController::class, 'updateMenuAction'])->name('updateMenuAction');
Route::post('/deleteMenuAction', [MenuController::class, 'deleteMenuAction'])->name('deleteMenuAction');

// route kegiatan 
Route::resource('/kegiatan', \App\Http\Controllers\KegiatanController::class);
Route::get('getKegiatan', [KegiatanController::class, 'getKegiatan'])->name('kegiatan.getKegiatan');
Route::get('/addKegiatan', [KegiatanController::class, 'addKegiatan'])->name('kegiatan.addKegiatan');
Route::post('/addKegiatanAction', [KegiatanController::class, 'addKegiatanAction'])->name('addKegiatanAction');
Route::get('/editKegiatan/{id_kegiatan}', [KegiatanController::class, 'editKegiatan'])->name('kegiatan.editKegiatan');
Route::post('/updateKegiatanAction', [KegiatanController::class, 'updateKegiatanAction'])->name('updateKegiatanAction');
Route::post('/deleteKegiatanAction', [KegiatanController::class, 'deleteKegiatanAction'])->name('deleteKegiatanAction');
Route::get('/showDetailKegiatan/{id_kegiatan}', [KegiatanController::class, 'showDetailKegiatan'])->name('kegiatan.showDetailKegiatan');

// route akses menu 
Route::resource('/aksesmenu', \App\Http\Controllers\AksesMenuController::class);
Route::get('get-aksesmenu', [AksesMenuController::class, 'getAksesMenu'])->name('aksesmenu.getAksesMenu');
Route::get('/addAksesMenu', [AksesMenuController::class, 'addAksesMenu'])->name('aksesmenu.addAksesMenu');
Route::get('/getRoleAksesMenu', [AksesMenuController::class, 'getRoleAksesMenu'])->name('getRoleAksesMenu');
Route::get('/getMenu/{id_role}', [AksesMenuController::class, 'getMenu'])->name('aksesmenu.getMenu');
Route::post('/addAksesMenuAction', [AksesMenuController::class, 'addAksesMenuAction'])->name('addAksesMenuAction');
Route::post('/deleteAksesMenuAction', [AksesMenuController::class, 'deleteAksesMenuAction'])->name('deleteAksesMenuAction');
Route::post('info-aksesmenu', [AksesMenuController::class, 'infoAksesMenu'])->name('aksesmenu.infoAksesMenu');
Route::post('edit-aksesmenu', [AksesMenuController::class, 'editAksesMenu'])->name('aksesmenu.editAksesMenu');
Route::post('delete-aksesmenu', [AksesMenuController::class, 'deleteAksesMenu'])->name('aksesmenu.deleteAksesMenu');



// route role 
Route::resource('/role', \App\Http\Controllers\RoleController::class);
Route::get('get-role', [RoleController::class, 'getRole'])->name('role.getRole');
Route::get('/addRole', [RoleController::class, 'addRole'])->name('role.addRole');
Route::post('/addRoleAction', [RoleController::class, 'addRoleAction'])->name('addRoleAction');
Route::get('/editRole/{id_role}', [RoleController::class, 'editRole'])->name('role.editRole');
Route::get('/showDetailRole/{id_role}', [RoleController::class, 'showDetailRole'])->name('role.showDetailRole');
Route::post('/updateRoleAction', [RoleController::class, 'updateRoleAction'])->name('updateRoleAction');
Route::post('/deleteRoleAction', [RoleController::class, 'deleteRoleAction'])->name('deleteRoleAction');


// route wilayah provinsi 
Route::resource('/wilayah', \App\Http\Controllers\WilayahController::class);
Route::get('get-provinsi', [WilayahController::class, 'getProvinsi'])->name('wilayah.getProvinsi');
Route::post('info-provinsi', [WilayahController::class, 'infoProvinsi'])->name('wilayah.infoProvinsi');
Route::post('edit-provinsi', [WilayahController::class, 'editProvinsi'])->name('wilayah.editProvinsi');
Route::post('delete-provinsi', [WilayahController::class, 'deleteProvinsi'])->name('wilayah.deleteProvinsi');
Route::get('/getKabkota', [WilayahController::class, 'getKabkota'])->name('wilayah.getKabkota');
Route::get('/showKota/{provinsi_kode}', [WilayahController::class, 'showKota'])->name('wilayah.showKota');
Route::get('/getKecamatan', [WilayahController::class, 'getKecamatan'])->name('wilayah.getKecamatan');
Route::get('/showKecamatan/{kabkota_kode}', [WilayahController::class, 'showKecamatan'])->name('wilayah.showKecamatan');
Route::get('/getKelurahan', [WilayahController::class, 'getKelurahan'])->name('wilayah.getKelurahan');
Route::get('/showKelurahan/{kecamatan_kode}', [WilayahController::class, 'showKelurahan'])->name('wilayah.showKelurahan');




// route registrasi
Route::resource('/registrasi', \App\Http\Controllers\RegistrasiController::class);
Route::post('/registrasiAction', [RegistrasiController::class, 'registrasiAction'])->name('registrasiAction');