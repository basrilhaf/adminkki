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
                }        
                $('#laporanKompilasiAction').click(function () {
                    $('#kompilasiTable').show();  
                    initializeDataTable();
                });
        
            });
        </script>


        @include('layout.footer')