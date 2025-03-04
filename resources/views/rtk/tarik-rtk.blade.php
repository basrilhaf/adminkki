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
                                                    <h2 class="mt-6">Filter</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Tanggal: </label>
                                                                <input type="date" id="search-tanggal-rtk" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Hari: </label>
                                                                <select name="" id="search-hari-rtk" class="form-control">
                                                                    <option value="Senin">Senin</option>
                                                                    <option value="Selasa">Selasa</option>
                                                                    <option value="Rabu">Rabu</option>
                                                                    <option value="Kamis">Kamis</option>
                                                                    <option value="Jumat">Jumat</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Cabang: </label>
                                                                <select name="" id="search-cabang-rtk" class="form-control">
                                                                    <?php if(session('id_role2') != 2){?>
                                                                        <option value="<?php echo session('cabang');?>"><?php echo session('cabang');?></option>
                                                                    <?php } else {?>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button id="submitRtk" class="btn btn-primary rounded mt-4">Submit</button>
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
                                        <div class="row" id="buttonDiv" style="display: none;">
                                                <div class="col-md-2">
                                                    <a href="#" id="exportDownloadLink" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> PDF RTK
                                                    </a>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="#" id="exportDownloadLink2" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> PDF PJK
                                                    </a>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="#" id="exportDownloadLink3" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> PDF RTK Setsus
                                                    </a>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2">
                                                    <button id="setoranKePlus" class="btn btn-flex btn-success h-40px fs-7 fw-bold"> <i class="fa fa-save"></i>Setoran Ke +1</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button id="setoranKeMinus" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"> <i class="fa fa-save"></i>Setoran Ke -1</button>
                                                </div>
                                                
                                                

                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="card mb-2">
                                        @if (session('success'))
                                            <div style="color: green; background: #d4edda; padding: 10px; margin-bottom: 10px;">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div style="color: rgb(255, 85, 0); background: #d4edda; padding: 10px; margin-bottom: 10px;">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">Upload Data dari RTK:</label>
                                                    <form action="{{ route('importExcelRtk') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <button class="btn btn-primary" type="submit">Upload</button>
                                                                </div>
                                                            </div>
                                                        </div>                                                    
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Upload Data dari SIKKI:</label>
                                                    <form action="{{ route('importExcelRtkUssi') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <button class="btn btn-primary" type="submit">Upload</button>
                                                                </div>
                                                            </div>
                                                        </div>                                                    
                                                    </form>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card">
										<div class="card-header">
                                            <h2 class="mt-4">List Kelompok RTK</h2>
                                        </div>
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableRtk" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>Action</th>
                                                        <th class="min-w-125px">Kelompok</th>
                                                        <th>BTAB/BTK</th>
                                                        <th class="min-w-125px">Setoran RTK</th>
                                                        <th class="min-w-125px"></th>
                                                        <th class="min-w-125px"></th>
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
                                            var tableRtk;

                                            $('#submitRtk').click(function () {
                                                $('#tableRtk').show();
                                                $('#buttonDiv').show();
                                                
                                                if ($.fn.dataTable.isDataTable('#tableRtk')) {
                                                    tableRtk.ajax.reload();
                                                } else {
                                                    tableRtk = $('#tableRtk').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        ajax: {
                                                            url: "{{ route('getTableRtk') }}",
                                                            data: function (d) {
                                                                d.tanggal = $('#search-tanggal-rtk').val();
                                                                d.hari = $('#search-hari-rtk').val();
                                                                d.cabang = $('#search-cabang-rtk').val();
                                                            }
                                                        },
                                                        columns: [
                                                            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                                            {data: 'action', name: 'action', orderable: false, searchable: false},
                                                            {data: 'kelompk_html', name: 'kelompk_html', orderable: false, searchable: false},
                                                            {data: 'btab_btk', name: 'btab_btk'},
                                                            {data: 'setoran_mingguan', name: 'setoran_mingguan', orderable: false, searchable: false},
                                                            {data: 'acuan', name: 'acuan', orderable: false, searchable: false},
                                                            {data: 'cabang_hari', name: 'cabang_hari', orderable: false, searchable: false},
                                                        ]
                                                    });
                                                }

                                            });

                                            $('#exportDownloadLink').on('click', function(e) {
                                                e.preventDefault(); 

                                                var tanggal = $('#search-tanggal-rtk').val();
                                                var hari = $('#search-hari-rtk').val();
                                                var cabang = $('#search-cabang-rtk').val();
                                                
                                                if (!tanggal) {
                                                    alert('Please select a date.');
                                                    return;
                                                }

                                                var url = "{{ route('pdfRtk') }}" + "?tanggal=" + tanggal + "&hari=" + hari + "&cabang=" + cabang;
                                                var link = document.createElement('a');
                                                link.href = url;
                                                link.target = "_blank"; 
                                                link.click();

                                            });

                                            $('#exportDownloadLink2').on('click', function(e) {
                                                e.preventDefault(); 

                                                var tanggal = $('#search-tanggal-rtk').val();
                                                var hari = $('#search-hari-rtk').val();
                                                var cabang = $('#search-cabang-rtk').val();
                                                
                                                if (!tanggal) {
                                                    alert('Please select a date.');
                                                    return;
                                                }

                                                var url = "{{ route('pdfPjk') }}" + "?tanggal=" + tanggal + "&hari=" + hari + "&cabang=" + cabang;
                                                var link = document.createElement('a');
                                                link.href = url;
                                                link.target = "_blank"; 
                                                link.click();

                                            });

                                            $('#exportDownloadLink3').on('click', function(e) {
                                                e.preventDefault(); 

                                                var tanggal = $('#search-tanggal-rtk').val();
                                                var hari = $('#search-hari-rtk').val();
                                                var cabang = $('#search-cabang-rtk').val();
                                                
                                                if (!tanggal) {
                                                    alert('Please select a date.');
                                                    return;
                                                }

                                                var url = "{{ route('pdfSetsus') }}" + "?tanggal=" + tanggal + "&hari=" + hari + "&cabang=" + cabang;
                                                var link = document.createElement('a');
                                                link.href = url;
                                                link.target = "_blank"; 
                                                link.click();

                                            });

                                            $(document).ready(function() {
                                                $('#setoranKePlus').click(function(e) {
                                                    e.preventDefault();
                                                    var hari = $('#search-hari-rtk').val();
                                                    var cabang = $('#search-cabang-rtk').val();
                                                    var action = 'plus';

                                                    Swal.fire({
                                                        title: 'Konfirmasi',
                                                        text: 'Apakah Anda yakin mengubah setoran ke +1?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Ya, Simpan!',
                                                        cancelButtonText: 'Batal'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            $.ajax({
                                                                url: "{{ route('setoranKeAction') }}", 
                                                                type: 'POST',
                                                                data: {
                                                                    _token: "{{ csrf_token() }}",  
                                                                    hari: hari,
                                                                    cabang: cabang,
                                                                    action: action
                                                                },
                                                                success: function(response) {
                                                                    Swal.fire({
                                                                        title: 'Success',
                                                                        text: 'Data Berhasil Disimpan',
                                                                        icon: 'success'
                                                                    }).then(function() {
                                                                        location.reload();  
                                                                    });
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                                                                }
                                                            });
                                                        }
                                                    });
                                                });
                                            });

                                            $(document).ready(function() {
                                                $('#setoranKeMinus').click(function(e) {
                                                    e.preventDefault();
                                                    var hari = $('#search-hari-rtk').val();
                                                    var cabang = $('#search-cabang-rtk').val();
                                                    var action = 'plus';

                                                    Swal.fire({
                                                        title: 'Konfirmasi',
                                                        text: 'Apakah Anda mengubah setoran ke -1?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Ya, Simpan!',
                                                        cancelButtonText: 'Batal'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            $.ajax({
                                                                url: "{{ route('setoranKeMinusAction') }}", 
                                                                type: 'POST',
                                                                data: {
                                                                    _token: "{{ csrf_token() }}",  
                                                                    hari: hari,
                                                                    cabang: cabang,
                                                                    action: action
                                                                },
                                                                success: function(response) {
                                                                    Swal.fire({
                                                                        title: 'Success',
                                                                        text: 'Data Berhasil Disimpan',
                                                                        icon: 'success'
                                                                    }).then(function() {
                                                                        location.reload();  
                                                                    });
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                                                                }
                                                            });
                                                        }
                                                    });
                                                });
                                            });

                                            $(document).on('click', '.btn-delete-rtk', function() {
                                                var id = $(this).data('id');
                                                Swal.fire({
                                                    title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data rtk ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $.ajax({
                                                            url: "{{ route('deleteRtkAction') }}", 
                                                            type: 'POST',
                                                            data: {
                                                                _token: "{{ csrf_token() }}",  
                                                                id: id
                                                            },
                                                            success: function(response) {
                                                                Swal.fire({
                                                                    title: 'Success',
                                                                    text: 'Data Berhasil Dihapus',
                                                                    icon: 'success'
                                                                }).then(function() {
                                                                    location.reload();  
                                                                });
                                                            },
                                                            error: function(xhr, status, error) {
                                                                Swal.fire('Error', 'Data Gagal Dihapus', 'error');
                                                            }
                                                        });
                                                    }
                                                });

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