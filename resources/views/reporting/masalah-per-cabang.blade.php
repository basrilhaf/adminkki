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
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-daterange-laporan" placeholder="Periode" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">Cabang:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <select class="form-control form-control-solid ps-13" id="cari-cabang-laporan">
                                                            <?php if(session('id_role2') != 2){?>
                                                                <option value="<?php echo session('cabang');?>"><?php echo session('cabang');?></option>
                                                            <?php } else {?>
                                                                <option value="0">Semua Cabang</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="masalahCabangAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Submit</button>
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
                                                    <a href="#" id="pdfmasalahCabangAction" class="btn btn-flex btn-success h-40px fs-7 fw-bold">
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
                                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="masalahKelompokCabangTable">
                                                    <thead>
                                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                            <th>No</th>
                                                            <th class="min-w-100px">Tanggal</th>
                                                            <th class="">Cabang</th>
                                                            <th class="min-w-100px">Kelompok</th>
                                                            <th class="min-w-100px">Set Ke</th>
                                                            <th class="min-w-100px">Menit Telat</th>
                                                            <th >Kode</th>
                                                            <th class="min-w-100px">PKP Proses</th>
                                                            <th class="min-w-100px">KC Proses</th>
                                                            <th class="min-w-100px">History</th>
                                                        </tr>
                                                    </thead>
                                                
                                                </table>
                                            </div>
                                        </div>
                                    <hr>
                                    {{-- <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">Anggota:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-anggota-ak" placeholder="no kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">Cabang:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-cabang-ak" placeholder="Nama kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchAk" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchAk" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div> --}}
									<div class="card">
                                        <div class="card-header">
                                            <h2 class="pt-4">Anggota Bermasalah</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="masalahAnggotaCabangTable" >
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">Tanggal</th>
                                                        <th class="">ID</th>
														<th class="min-w-100px">Anggota</th>
                                                        <th class="min-w-100px">Kelompok</th>
                                                        <th class="">Cabang</th>
                                                        <th class="">DTR</th>
                                                        <th class="">Set Ke-</th>
                                                        <th class="min-w-100px">Menit Telat</th>
                                                        <th class="">History</th>
                                                        
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
              

                var masalahAnggotaCabangTable;
                var masalahKelompokCabangTable;

                function initializeDataTable() {
                   

                    // Initialize or reload masalahKelompokCabangTable
                    if (masalahKelompokCabangTable) {
                        console.log("Reloading DataTable for masalahKelompokCabangTable");
                        masalahKelompokCabangTable.ajax.reload();
                    } else {
                        console.log("Initializing DataTable for masalahKelompokCabangTable");
                        masalahKelompokCabangTable = $('#masalahKelompokCabangTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getMasalahCabangKb') }}",
                                data: function (d) {
                                    console.log("Data sent to server:", d);
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    d.cabang = $('#cari-cabang-laporan').val();
                                }
                            },
                            columns: [
                                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                                { data: 'tanggal_kb', name: 'tanggal_kb' },
                                { data: 'cabang_kb', name: 'cabang_kb' },
                                { data: 'kelompok_kb', name: 'kelompok_kb' },
                                { data: 'setoran_kb', name: 'setoran_kb' },
                                { data: 'kode_kb', name: 'kode_kb' },
                                { data: 'menit_kb', name: 'menit_kb' },
                                { data: 'pkp_dkb', name: 'pkp_dkb' },
                                { data: 'kc_dkb', name: 'kc_dkb' },
                                { data: 'history', name: 'history', orderable: false, searchable: false }
                            ]
                        });
                    }

                    // Initialize or reload masalahAnggotaCabangTable
                    if (masalahAnggotaCabangTable) {
                        console.log("Reloading DataTable for masalahAnggotaCabangTable");
                        masalahAnggotaCabangTable.ajax.reload();
                    } else {
                        console.log("Initializing DataTable for masalahAnggotaCabangTable");
                        masalahAnggotaCabangTable = $('#masalahAnggotaCabangTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getMasalahCabangAb') }}",
                                data: function (d) {
                                    d.daterange = $('#cari-daterange-laporan').val();
                                    d.cabang = $('#cari-cabang-laporan').val();
                                }
                            },
                            columns: [
                                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                                { data: 'tanggal_ab', name: 'tanggal_ab' },
                                { data: 'id_anggota_ab', name: 'id_anggota_ab' },
                                { data: 'nama_ab', name: 'nama_ab' },
                                { data: 'kelompok_ab', name: 'kelompok_ab' },
                                { data: 'cabang_ab', name: 'cabang_ab' },
                                { data: 'kode_ab', name: 'kode_ab' },
                                { data: 'setoran_ab', name: 'setoran_ab' },
                                { data: 'menit_ab', name: 'menit_ab' },
                                { data: 'dtr', name: 'dtr', orderable: false, searchable: false }
                            ]
                        });
                    }
                }

                $('#masalahCabangAction').click(function () {
                    $('#masalahAnggotaCabangTable').show();  
                    $('#masalahKelompokCabangTable').show();
                    setTimeout(function () {
                        initializeDataTable();
                    }, 100);  
                });

                $('#exportDownloadLink').on('click', function(e) {
                    e.preventDefault(); 
                    var selectedDate = $('#cari-daterange-laporan').val();  
                    var cabang = $('#cari-cabang-laporan').val();                            
                    if (!selectedDate) {
                        alert('Please select a date.');
                        return;
                    }
                    window.location.href = "{{ route('exportDownloadMasalahPerCabang') }}" + "?daterange=" + selectedDate + "&cabang=" + cabang;
                });

                $('#pdfmasalahCabangAction').on('click', function(e) {
                    e.preventDefault(); 
                    var daterange = $('#cari-daterange-laporan').val();
                    var cabang = $('#cari-cabang-laporan').val();   
                    if (!daterange) {
                        alert('Please select a date.');
                        return;
                    }
                    
                    var url = "{{ route('pdfMasalahPerCabangAction') }}" + "?daterange=" + daterange + "&cabang=" + cabang;
                    var link = document.createElement('a');
                    link.href = url;
                    link.target = "_blank"; // Open the link in a new tab
                    link.click();
                });

            });


        </script>
        @include('layout.footer')