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
												<h1 class="page-heading d-flex flex-column justify-content-center text-primary fw-bolder fs-1 m-0">{{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											
										</div>
									</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Filter Tanggal</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Tanggal: </label>
                                                                <input type="text" id="search-daterange-tabKantor" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Tipe: </label>
                                                                <select id="search-tipe-tabKantor" class="form-control">
                                                                    <option value="0">Menambah & Mencairkan Tabungan</option>
                                                                    <option value="200">Mencairkan Tabungan</option>
                                                                    <option value="100">Menambah Tabungan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Kode: </label>
                                                                <select id="search-kode-tabKantor" class="form-control">
                                                                    <option value="0">Ketiganya</option>
                                                                    <option value="200">Tabungan Pribadi (200)</option>
                                                                    <option value="201">Simpok (201)</option>
                                                                    <option value="203">Simjib (203)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button id="submitTabKantor" class="btn btn-primary rounded mt-4">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                    <hr>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <a href="#" id="exportDownloadLink" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> Export Excel
                                                    </a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="card">
										<div class="card-header">
                                            <h2 class="mt-4">List Tabungan Kantor</h2>
                                        </div>
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableTabKantor" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>TGL_TRANS</th>
                                                        <th>JAM_TRANS</th>
                                                        <th>TRANS_ID_SOURCE</th>
                                                        <th>KETERANGAN</th>
                                                        <th>AMOUNT</th>
                                                        <th>KODE</th>
                                                        <th>DIRECTION</th>
                                                        <th>ID ANGGOTA</th>
                                                        <th>NAMA ANGGOTA</th>
                                                        <th>TOTAL TABUNGAN</th>
													</tr>
												</thead>
											
											</table>
											<!--end::Table-->
										</div>
										<!--end::Card body-->
									</div>
                                    <!--begin::Card-->
                                    <hr>
                                    

                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var tableTabKantor;

                                            $('#submitTabKantor').click(function () {
                                                $('#tableTabKantor').show();
                                                if ($.fn.dataTable.isDataTable('#tableTabKantor')) {
                                                    tableTabKantor.ajax.reload();
                                                } else {
                                                    tableTabKantor = $('#tableTabKantor').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        ajax: {
                                                            url: "{{ route('getTableTabKantor') }}",
                                                            data: function (d) {
                                                                d.daterange = $('#search-daterange-tabKantor').val();
                                                                d.tipe = $('#search-tipe-tabKantor').val();
                                                                d.kode = $('#search-kode-tabKantor').val();
                                                            }
                                                        },
                                                        columns: [
                                                            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                                            {data: 'TGL_TRANS', name: 'TGL_TRANS'},
                                                            {data: 'jam_trans', name: 'jam_trans'},
                                                            {data: 'TRANS_ID_SOURCE', name: 'TRANS_ID_SOURCE'},
                                                            {data: 'KETERANGAN', name: 'KETERANGAN'},
                                                            {data: 'POKOK', name: 'POKOK'},
                                                            {data: 'KODE_TRANS', name: 'KODE_TRANS'},
                                                            {data: 'tipe_trans', name: 'tipe_trans', orderable: false, searchable: false},
                                                            {data: 'nasabah_id', name: 'nasabah_id'},
                                                            {data: 'NAMA_NASABAH', name: 'NAMA_NASABAH'},
                                                            {data: 'saldo_akhir', name: 'saldo_akhir', orderable: false, searchable: false},
                                                        ]
                                                    });
                                                }

                                            });

                                            $('#exportDownloadLink').on('click', function(e) {
                                                e.preventDefault(); 

                                                // Get the selected date from the input field
                                                var selectedDate = $('#search-daterange-tabKantor').val();
                                                var tipe = $('#search-tipe-tabKantor').val();
                                                var kode = $('#search-kode-tabKantor').val();
                                                
                                                if (!selectedDate) {
                                                    alert('Please select a date.');
                                                    return;
                                                }

                                                window.location.href = "{{ route('exportDownloadTabunganKantor') }}" + "?daterange=" + selectedDate + "&kode=" + kode + "&tipe=" + tipe;
                                            });
                                            
                                        });


                            
                                    </script>
									
								</div>
								<!--end::Content-->
							</div>
							<!--end::Content wrapper-->
							
						</div>
						<!--end:::Main-->
					</div>
					<!--end::Wrapper container-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
        
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#search-daterange-tabKantor", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
		
        @include('layout.footer')