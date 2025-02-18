@include('layout.header')
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<div id="kt_app_hero" class="app-hero py-6">
						<div id="kt_app_hero_container" class="app-container container-xxl d-flex">
							<div class="d-flex flex-stack flex-wrap flex-lg-nowrap flex-row-fluid gap-4 gap-lg-10 mb-10">
								<div class="d-flex align-items-center me-3">
									<h1 class="page-heading d-flex text-white fw-bolder fs-2 flex-column justify-content-center my-0">{{$menu}}
								</div>
							</div>
						</div>
					</div>
					<div class="app-container container-xxl">
						<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
							<div class="d-flex flex-column flex-column-fluid">
								<div id="kt_app_content" class="app-content">
									<div id="kt_app_toolbar" class="app-toolbar d-flex flex-column py-6">
										<div class="app-toolbar-wrapper d-flex align-items-center flex-stack flex-wrap gap-2 py-4 w-100">
											<div class="page-title d-flex flex-column justify-content-center gap-2 me-3">
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0"> {{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">Tanggal:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-daterange-laporan" placeholder="DATERANGE" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">Cabang:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <select class="form-control form-control-solid ps-13" id="cari-cabang-laporan">
                                                            <option value="0">Semua Cabang</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="laporanKompilasiAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Submit</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <br>
                                    <!-- <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NO KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nomor-history" placeholder="no kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">KELOMPOK TERAKHIR:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kelompok-history" placeholder="Nama kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchKelompok" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearcKelompok" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div> -->
									<div class="card">
										<div class="card-body py-4" style="overflow-x: auto;">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="kompilasiTable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-100px">Cabang</th>
														<th class="min-w-100px">Pencairan</th>
                                                        <th class="min-w-100px">BTAB</th>
                                                        <th class="min-w-100px">Menabung di Lapangan</th>
                                                        <th class="min-w-100px">Menabung di Kantor</th>
                                                        <th class="min-w-100px">Tarik Tabungan di Kantor</th>
                                                        <th class="min-w-100px">Anggota Aktif</th>
                                                        <th class="min-w-100px">Anggota DTR</th>
                                                        <th class="min-w-100px">Kelompok Telat</th>
                                                        <th class="min-w-100px">Kelompok Berat</th> 
                                                        {{-- <th class="min-w-100px">Agt Meninggal</th>
                                                        <th class="min-w-100px">Agt Pelunasan</th>
                                                        
                                                        --}}
													</tr>
												</thead>
											
											</table>
										</div>
									</div><br>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">Rangkuman Anggota</h2>
                                        </div>
                                        <div class="card-body"  id="RAsum" style="display: none">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Agt Aktif:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumAgtAktif">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Klpk Aktif:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumKlpkAktif">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Kumpulan:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumKumpulanAktif">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml PKP:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumPkp">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Rata2 Agt per Klpk:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumAgtPerKlpk">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Rata2 Agt per Kumpulan:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumAgtPerKumpulan">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Rata2 Agt per PKP:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumAgtPerPkp">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										<div class="card-body py-4" style="overflow-x: auto;">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="RATable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-100px">PKP</th>
														<th class="min-w-100px">Anggota Aktif</th>
                                                        <th class="min-w-100px">Kelompok Aktif</th>
                                                        <th class="min-w-100px">Kumpulan Aktif</th>
                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div><br>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">Rangkuman Tabungan</h2>
                                        </div>
                                        <div class="card-body"  id="RTsum" style="display: none">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Vol Trx Menabung:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumTrxMenabung">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Agt Menabung (unik):</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumAgtMenabung">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Nominal Menabung:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumNominalMenabung">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Rata2 Agt Menabung:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumRataAgtMenabung">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
										<div class="card-body py-4" style="overflow-x: auto;">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="RTTable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-100px">PKP</th>
														<th class="min-w-100px">TRX Tab Pribadi</th>
                                                        <th class="min-w-100px">Vol Tab Pribadi</th>
                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <br>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">Rangkuman DTR</h2>
                                        </div>
                                        <div class="card-body"  id="RDTRsum" style="display: none">
                                            <div class="row">
                                               
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Kasus DTR:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumDTR">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml TRX:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumTrx">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>% Kasus DTR:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumPercentDTR">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
										<div class="card-body py-4" style="overflow-x: auto;">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="RDTRTable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-100px">PKP</th>
														<th class="min-w-100px">Jumlah DTR</th>
                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <br>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">Kelompok Cair</h2>
                                        </div>
                                        <div class="card-body"  id="RCairsum" style="display: none">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Kelompok Cair:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumKelompokCair">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Anggota Cair:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumAnggotaCair">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Nominal Dicairkan</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumNominalCair">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Rata2 Pinjaman Cair</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumRataCair">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
										<div class="card-body py-4" style="overflow-x: auto;">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="RCairTable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-100px">Kelompok</th>
														<th class="min-w-100px">Anggota</th>
                                                        <th class="min-w-100px">Nominal Cair</th>
                                                        <th class="min-w-100px">PKP JPK</th>
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <br>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">Kelompok BTAB</h2>
                                        </div>
                                        <div class="card-body"  id="RBtabsum" style="display: none">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Kelompok Selesai:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumKelompokBtab">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml Anggota Btab:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumAnggotaBtab">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>Jml BTAB Dicairkan</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p id="sumNominalBtab">memuat data...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
										<div class="card-body py-4" style="overflow-x: auto;">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="RBtabTable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-100px">Kelompok</th>
														<th class="min-w-100px">BTAB Cair</th>
                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr>
                                    
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#cari-daterange-laporan", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
        <script>
            $(document).ready(function () {
                var kompilasiTable;        
                var RATable; 
                var RTTable;
                var RDTRTable;
                var RCairTable;
                var RBtabTable;
                function initializeDataTable() {
                    if ($.fn.dataTable.isDataTable('#kompilasiTable')) {
                        kompilasiTable.ajax.reload();
                    } else {
                        kompilasiTable = $('#kompilasiTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getDataTableKompilasi') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    d.cabang = $('#cari-cabang-laporan').val();
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                {data: 'KODE_KANTOR', name: 'KODE_KANTOR'},
                                {data: 'kelompok_cair', name: 'kelompok_cair'},
                                {data: 'kelompok_btab', name: 'kelompok_btab'},
                                {data: 'tab_lapangan', name: 'tab_lapangan'},
                                {data: 'tab_kantor', name: 'tab_kantor'},
                                {data: 'ambil_tab', name: 'ambil_tab'},
                                {data: 'anggota_aktif', name: 'anggota_aktif'},
                                {data: 'dtr', name: 'dtr'},
                                {data: 'kel_telat', name: 'kel_telat'},
                                {data: 'kel_berat', name: 'kel_berat'},
                                
                            ]
                        });
                    }

                    if ($.fn.dataTable.isDataTable('#RATable')) {
                        RATable.ajax.reload();
                    } else {
                        RATable = $('#RATable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getDataTableRAKompilasi') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    d.cabang = $('#cari-cabang-laporan').val();
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                {data: 'deskripsi_group2', name: 'deskripsi_group2'},
                                {data: 'anggota_aktif', name: 'anggota_aktif'},
                                {data: 'kelompok_aktif', name: 'kelompok_aktif'},
                                {data: 'kumpulan_aktif', name: 'kumpulan_aktif'},
                                
                                
                            ]
                        });
                    }

                    if ($.fn.dataTable.isDataTable('#RTTable')) {
                        RTTable.ajax.reload();
                    } else {
                        RTTable = $('#RTTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getDataTableRTKompilasi') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    d.cabang = $('#cari-cabang-laporan').val();
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                {data: 'deskripsi_group2', name: 'deskripsi_group2'},
                                {data: 'anggota_tabung', name: 'anggota_tabung'},
                                { 
                                    data: 'total_tabung', 
                                    name: 'total_tabung',
                                    render: function(data, type, row) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                                    }
                                }
                                
                                
                            ]
                        });
                    }

                    if ($.fn.dataTable.isDataTable('#RDTRTable')) {
                        RDTRTable.ajax.reload();
                    } else {
                        RDTRTable = $('#RDTRTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getDataTableRDTRKompilasi') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    d.cabang = $('#cari-cabang-laporan').val();
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                {data: 'deskripsi_group2', name: 'deskripsi_group2'},
                                {data: 'anggota_dtr', name: 'anggota_dtr'}
                                
                                
                            ]
                        });
                    }
                    
                    if ($.fn.dataTable.isDataTable('#RCairTable')) {
                        RCairTable.ajax.reload();
                    } else {
                        RCairTable = $('#RCairTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getDataTableRCairKompilasi') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    d.cabang = $('#cari-cabang-laporan').val();
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                {data: 'deskripsi_group1', name: 'deskripsi_group1'},
                                {data: 'jumlah_anggota', name: 'jumlah_anggota'},
                                { 
                                    data: 'jumlah_cair', 
                                    name: 'jumlah_cair',
                                    render: function(data, type, row) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                                    }
                                },
                                {data: 'deskripsi_group2', name: 'deskripsi_group2'},
                                
                                
                            ]
                        });
                    }
                    
                    if ($.fn.dataTable.isDataTable('#RBtabTable')) {
                        RBtabTable.ajax.reload();
                    } else {
                        RBtabTable = $('#RBtabTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getDataTableRBtabKompilasi') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    d.cabang = $('#cari-cabang-laporan').val();
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                {data: 'deskripsi_group1', name: 'deskripsi_group1'},
                                { 
                                    data: 'btab_cair', 
                                    name: 'btab_cair',
                                    render: function(data, type, row) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                                    }
                                }
                                
                                
                            ]
                        });
                    }

                }        

                function loadSumData() {
                    $.ajax({
                        url: "{{ route('getRAsumData') }}",
                        type: "GET",
                        data: {
                            daterange: $('#cari-daterange-laporan').val(),
                            cabang: $('#cari-cabang-laporan').val()
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#sumAgtAktif').text(response.anggota_aktif);
                                $('#sumKlpkAktif').text(response.kelompok_aktif);
                                $('#sumKumpulanAktif').text(response.kumpulan_aktif);
                                $('#sumPkp').text(response.pkp);
                                $('#sumAgtPerKlpk').text(response.agt_per_kelompok);
                                $('#sumAgtPerKumpulan').text(response.agt_per_kumpulan);
                                $('#sumAgtPerPkp').text(response.agt_per_pkp);

                                $('#sumTrxMenabung').text(response.trx_menabung);
                                $('#sumAgtMenabung').text(response.agt_menabung);
                                $('#sumNominalMenabung').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.nominal_menabung));
                                $('#sumRataAgtMenabung').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.rata_agt_menabung));
                                
                                $('#sumDTR').text(response.jumlah_dtr);
                                $('#sumTrx').text(response.jumlah_trx);
                                $('#sumPercentDTR').text(response.percent_dtr);

                                $('#sumKelompokCair').text(response.kelompok_cair);
                                $('#sumAnggotaCair').text(response.anggota_cair);
                                $('#sumNominalCair').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.nominal_cair));
                                $('#sumRataCair').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.rata_cair));

                                $('#sumKelompokBtab').text(response.kelompok_btab);
                                $('#sumAnggotaBtab').text(response.anggota_btab);
                                $('#sumNominalBtab').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.nominal_btab));


                                
                            } else {
                                console.error("Gagal mengambil data.");
                            }
                        },
                        error: function(xhr) {
                            console.error("Error: ", xhr);
                        }
                    });
                }

                $('#laporanKompilasiAction').click(function () {
                    $('#kompilasiTable').show();  
                    $('#RATable').show();  
                    $('#RTTable').show();  
                    $('#RDTRTable').show();
                    $('#RCairTable').show();
                    $('#RBtabTable').show();
                    $('#RAsum').show();
                    $('#RTsum').show();
                    $('#RDTRsum').show();
                    $('#RCairsum').show();
                    $('#RBtabsum').show();
                    
                    
                    
                    initializeDataTable();
                    loadSumData();
                });
        
            });
        </script>


        @include('layout.footer')