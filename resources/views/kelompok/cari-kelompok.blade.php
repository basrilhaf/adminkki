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
                                                <div class="col-md-9">
                                                    <label class="form-label fs-6 fw-bold">NAMA KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-nama-kelompok" placeholder="nama" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="cariKelompokAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Submit</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
									<div class="card">
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="cariKelompokTable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama</th>
                                                        <th class="min-w-100px">Durasi</th>
                                                        <th class="min-w-100px">Tanggal Pencairan</th>
                                                        <th class="min-w-100px">Tanggal Perkiraan BTAB</th>
                                                        <th class="min-w-100px">Action</th>
                                                        
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
        <script>
            $(document).ready(function () {
                var cariKelompokTable;        
                function initializeDataTable() {
                    if ($.fn.dataTable.isDataTable('#cariKelompokTable')) {
                        cariKelompokTable.ajax.reload();
                    } else {
                        // Otherwise, initialize the DataTable
                        cariKelompokTable = $('#cariKelompokTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getCariKelompok') }}",
                                data: function (d) {
                                    d.keyword = $('#cari-nama-kelompok').val();
                                    
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                {data: 'deskripsi_group1', name: 'deskripsi_group1'},
                                {data: 'jml_angsuran', name: 'jml_angsuran'},
                                {data: 'tgl_realisasi', name: 'tgl_realisasi'},
                                {data: 'tgl_jatuh_tempo', name: 'tgl_jatuh_tempo'},
                                {data: 'action', name: 'action', orderable: false, searchable: false}
                            ]
                        });
                    }
                }
        
                // Event listener for the search button
                $('#cariKelompokAction').click(function () {
                    $('#cariKelompokTable').show();  // Show the table when the search button is clicked
                    initializeDataTable();  // Initialize or reload DataTable based on the current filters
                });
        
                $('#resetSearchCariKelompok').click(function () {
                    $('#cari-nama-kelompok').val('');
                    initializeDataTable();
                });
        
                $('#searchCariKelompok').click(function () {
                    initializeDataTable();
                });
            });
        </script>

        @include('layout.footer')