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
                                                    <label class="form-label fs-6 fw-bold">Tanggal:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-daterange-laporan" placeholder="Periode" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3 mt-9">
                                                    <button id="laporanRangkumanAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Submit</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-2">
                                                    <a href="#" id="exportDownloadLink" class="btn btn-flex btn-warning h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> Export Excel
                                                    </a>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="#" id="pdfLaporanRangkumanAction" class="btn btn-flex btn-success h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> Export PDF
                                                    </a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    
									<div class="card">
                                        <div class="card-header">
                                            <h2 class="pt-4">Kelompok Bermasalah</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="rangkumanKelompokTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">Cabang</th>
                                                        <th class="min-w-100px">Jumlah Kelompok</th>
														<th class="min-w-100px">Telat</th>
                                                        <th class="min-w-100px">Berat</th>
                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="pt-4">Anggota Bermasalah</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="rangkumanAnggotaTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">Cabang</th>
                                                        <th class="min-w-100px">Jumlah Anggota DTR</th>
														<th class="min-w-100px">Kode 2</th>
                                                        <th class="min-w-100px">Kode 4A</th>
                                                        <th class="min-w-100px">Kode 4B</th>
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
                var rangkumanAnggotaTable;   
                var rangkumanKelompokTable;     
                function initializeDataTable() {
                    if ($.fn.dataTable.isDataTable('#rangkumanAnggotaTable')) {
                        rangkumanAnggotaTable.ajax.reload();
                    } else {
                        // Otherwise, initialize the DataTable
                        rangkumanAnggotaTable = $('#rangkumanAnggotaTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getLaporanRangkumanAb') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                {data: 'cabang_ab', name: 'cabang_ab'},
                                {data: 'jumlah', name: 'jumlah', orderable: false, searchable: false},
                                {data: 'kode2', name: 'kode2', orderable: false, searchable: false},
                                {data: 'kode4a', name: 'kode4a', orderable: false, searchable: false},
                                {data: 'kode4b', name: 'kode4b', orderable: false, searchable: false}
                            ]
                        });
                    }

                    if ($.fn.dataTable.isDataTable('#rangkumanKelompokTable')) {
                        rangkumanKelompokTable.ajax.reload();
                    } else {
                        // Otherwise, initialize the DataTable
                        rangkumanKelompokTable = $('#rangkumanKelompokTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getLaporanRangkumanKb') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                {data: 'cabang_kb', name: 'cabang_kb'},
                                {data: 'jumlah', name: 'jumlah', orderable: false, searchable: false},
                                {data: 'telat', name: 'telat', orderable: false, searchable: false},
                                {data: 'berat', name: 'berat', orderable: false, searchable: false}
                            ]
                        });
                    }
                }
        
                $('#laporanRangkumanAction').click(function () {
                    $('#rangkumanAnggotaTable').show();  
                    $('#rangkumanKelompokTable').show();
                    
                    initializeDataTable();  
                });

                $('#exportDownloadLink').on('click', function(e) {
                    e.preventDefault(); 
                    var selectedDate = $('#cari-daterange-laporan').val();                            
                    if (!selectedDate) {
                        alert('Please select a date.');
                        return;
                    }
                    window.location.href = "{{ route('exportDownloadRangkumanMasalah') }}" + "?daterange=" + selectedDate;
                });

                $('#pdfLaporanRangkumanAction').on('click', function(e) {
                    e.preventDefault(); 
                    var daterange = $('#cari-daterange-laporan').val();
                    if (!daterange) {
                        alert('Please select a date.');
                        return;
                    }

                    var url = "{{ route('pdfLaporanRangkuman') }}" + "?daterange=" + daterange;
                    var link = document.createElement('a');
                    link.href = url;
                    link.target = "_blank"; // Membuka link di tab baru
                    link.click();
                });
        
                
            });
        </script>
        @include('layout.footer')