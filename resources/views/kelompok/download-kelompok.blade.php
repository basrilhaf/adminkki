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
                                    <div class="card mb-2">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-9">
                                                    <label class="form-label fs-6 fw-bold">TANGGAL:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="date" class="form-control form-control-solid ps-13" id="cari-tanggal-download" placeholder="tanggal" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="cariDownloadAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Submit</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
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
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="cariDownloadTable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama Kelompok</th>
                                                        <th class="min-w-100px">ID Anggota</th>
                                                        <th class="min-w-100px">Nama Anggota</th>
                                                        <th class="min-w-100px">Pinjaman</th>
                                                        <th class="min-w-100px">Durasi</th>
                                                        <th class="min-w-100px">Tanggal Cair</th>
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
                var cariDownloadTable;        
                function initializeDataTable() {
                    if ($.fn.dataTable.isDataTable('#cariDownloadTable')) {
                        cariDownloadTable.ajax.reload();
                    } else {
                        // Otherwise, initialize the DataTable
                        cariDownloadTable = $('#cariDownloadTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getCariDownloadKelompok') }}",
                                data: function (d) {
                                    d.tanggal = $('#cari-tanggal-download').val();
                                    
                                }
                            },
                            
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                {data: 'deskripsi_group1', name: 'deskripsi_group1'},
                                {data: 'nasabah_id', name: 'nasabah_id'},
                                {data: 'NAMA_NASABAH', name: 'NAMA_NASABAH'},
                                {data: 'jml_pinjaman', name: 'jml_pinjaman'},
                                {data: 'jml_angsuran', name: 'jml_angsuran'},
                                {data: 'tgl_realisasi', name: 'tgl_realisasi'}
                            ]
                        });
                    }
                }
        
                // Event listener for the search button
                $('#cariDownloadAction').click(function () {
                    $('#cariDownloadTable').show();  // Show the table when the search button is clicked
                    initializeDataTable();  // Initialize or reload DataTable based on the current filters
                });
        
                // $('#exportDownloadLink').on('click', function(e) {
                //     e.preventDefault();                    
                //     var selectedDate = $('#cari-tanggal-download').val();
                //     if (!selectedDate) {
                //         alert('Please select a date.');
                //         return;
                //     }

                //     $.ajax({
                //         url: "{{ route('exportDownloadKelompok') }}",
                //         type: 'GET',
                //         data: {
                //             tanggal: selectedDate  
                //         },
                //         success: function(response) {
                //             if (response) {
                //                 alert('Success to generate the Excel file.');
                //                 // window.location.href = response.download_url; 
                //             }
                //         }
                //     });
                // });

                $('#exportDownloadLink').on('click', function(e) {
                    e.preventDefault(); // Prevent the default anchor link action

                    // Get the selected date from the input field
                    var selectedDate = $('#cari-tanggal-download').val();
                    
                    if (!selectedDate) {
                        alert('Please select a date.');
                        return;
                    }

                    window.location.href = "{{ route('exportDownloadKelompok') }}" + "?tanggal=" + selectedDate;
                });
            });
        </script>

        @include('layout.footer')