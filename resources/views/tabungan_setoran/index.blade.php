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
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label for="daterange">Rentang Tanggal: </label>
                                                                <input type="text" id="search-daterange-tabLapangan" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button id="submitTabLapangan" class="btn btn-primary rounded mt-4">Submit</button>
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
                                            <h2 class="mt-4">List Tabungan Lapangan</h2>
                                        </div>
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableTabLapangan" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>ID Anggota</th>
                                                        <th>Nama Anggota</th>
                                                        <th>Amount</th>
                                                        <th>Kelompok</th>
                                                        <th>Created At</th>
                                                        <th>Total Tabungan</th>
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
                                            var tableTabLapangan;

                                            $('#submitTabLapangan').click(function () {
                                                $('#tableTabLapangan').show();
                                                if ($.fn.dataTable.isDataTable('#tableTabLapangan')) {
                                                    tableTabLapangan.ajax.reload();
                                                } else {
                                                    tableTabLapangan = $('#tableTabLapangan').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        ajax: {
                                                            url: "{{ route('getTableTabLapangan') }}",
                                                            data: function (d) {
                                                                d.daterange = $('#search-daterange-tabLapangan').val();
                                                            }
                                                        },
                                                        columns: [
                                                            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                                            {data: 'nasabah_id', name: 'nasabah_id'},
                                                            {data: 'NAMA_NASABAH', name: 'NAMA_NASABAH'},
                                                            {data: 'POKOK', name: 'POKOK'},
                                                            {data: 'deskripsi_group1', name: 'deskripsi_group1'},
                                                            {data: 'jam_trans', name: 'jam_trans'},
                                                            {data: 'saldo_akhir', name: 'saldo_akhir', orderable: false, searchable: false},
                                                        ]
                                                    });
                                                }

                                            });

                                            $('#exportDownloadLink').on('click', function(e) {
                                                e.preventDefault(); 

                                                // Get the selected date from the input field
                                                var selectedDate = $('#search-daterange-tabLapangan').val();
                                                
                                                if (!selectedDate) {
                                                    alert('Please select a date.');
                                                    return;
                                                }

                                                window.location.href = "{{ route('exportDownloadTabunganLapangan') }}" + "?daterange=" + selectedDate;
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
            flatpickr("#search-daterange-tabLapangan", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
		
        @include('layout.footer')