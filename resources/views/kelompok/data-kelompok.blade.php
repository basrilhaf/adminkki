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
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">List {{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    {{-- <div class="card">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-9">
                                                    <label class="form-label fs-6 fw-bold">Download Kelompok PCA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="date" class="form-control form-control-solid ps-13" id="download-tanggal-kelompok" placeholder="nama" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="downloadKelompokAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Excel PCA</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div> --}}
                                    
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NAMA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-kelompok" placeholder="nama kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">ID:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-id-kelompok" placeholder="ID" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">STATUS:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <select name="" id="search-status-kelompok" class="form-control form-control-solid ps-13">
                                                            <option value="0">Semua</option>
                                                            <option value="1">Aktif</option>
                                                            <option value="2">Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                              
                                                
                                                <div class="col-md-3 mt-9">
                                                    <button id="searchKelompok" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearcKelompok" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    
									<div class="card">
                                        
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="dataKelompokTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama</th>
                                                        <th class="min-w-100px">ID</th>
                                                        <th class="min-w-100px">Tanggal Pencairan</th>
														<th class="min-w-100px">Status</th>
                                                        
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
		
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dataKelompokTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getSemuaKelompok') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-kelompok').val();
                            d.id = $('#search-id-kelompok').val();
                            d.status = $('#search-status-kelompok').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'deskripsi_group1', name: 'deskripsi_group1'},
                        {data: 'kode_group1', name: 'kode_group1'},
                        {data: 'tgl_realisasi', name: 'tgl_realisasi'},
                        {data: 'status', name: 'status'}
                        
                        
                    ]
                });
                $('#searchKelompok').click(function () {
                    $('#dataKelompokTable').DataTable().ajax.reload();
                });
                $('#resetSearcKelompok').click(function () {
                    $('#search-nama-kelompok').val('');
                    $('#search-id-kelompok').val('');
                    $('#search-status-kelompok').val('');
                    $('#dataKelompokTable').DataTable().ajax.reload();
                });


            });
            

        </script>
        @include('layout.footer')