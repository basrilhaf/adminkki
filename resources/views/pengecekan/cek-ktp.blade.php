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
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(1):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp1-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(2):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp2-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(3):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp3-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(4):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp4-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(5):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp5-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(6):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp6-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(7):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp7-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(8):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp8-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(9):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp9-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(10):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp10-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(11):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp11-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3 mt-9">
                                                    <button id="cekKtpAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Submit</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                   
                                    
									<div class="card">
										<div class="card-body py-4" style="overflow-x: auto;">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="cekKtpTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-100px">ID</th>
                                                        <th class="min-w-100px">Nama</th>
                                                        <th class="min-w-100px">KTP</th>
                                                        <th class="min-w-100px">Kelompok Terakhir</th>
                                                        <th class="min-w-100px">DTR </th>
                                                        <th class="min-w-100px">Sanksi </th>
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
                var cekKtpTable;        
                function initializeDataTable() {
                    if ($.fn.dataTable.isDataTable('#cekKtpTable')) {
                        cekKtpTable.ajax.reload();
                    } else {
                        // alert($('#cari-ktp1-cek').val());
                        cekKtpTable = $('#cekKtpTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getCekKtp') }}",
                                data: function (d) {
                                    d.ktp1 = $('#cari-ktp1-cek').val();
                                    d.ktp2 = $('#cari-ktp2-cek').val();
                                    d.ktp3 = $('#cari-ktp3-cek').val();
                                    d.ktp4 = $('#cari-ktp4-cek').val();
                                    d.ktp5 = $('#cari-ktp5-cek').val();
                                    d.ktp6 = $('#cari-ktp6-cek').val();
                                    d.ktp7 = $('#cari-ktp7-cek').val();
                                    d.ktp8 = $('#cari-ktp8-cek').val();
                                    d.ktp9 = $('#cari-ktp9-cek').val();
                                    d.ktp10 = $('#cari-ktp10-cek').val();
                                    d.ktp11 = $('#cari-ktp11-cek').val();
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                {data: 'nasabah_id', name: 'nasabah_id'},
                                {data: 'NAMA_NASABAH', name: 'NAMA_NASABAH'},
                                {data: 'no_id', name: 'no_id'},
                                {data: 'kelompok', name: 'kelompok', orderable: false, searchable: false},
                                {data: 'dtr', name: 'dtr', orderable: false, searchable: false},
                                {data: 'sanksi', name: 'sanksi', orderable: false, searchable: false},
                                {data: 'action', name: 'action', orderable: false, searchable: false}
                            ]
                        });
                    }
                }
        
                $('#cekKtpAction').click(function () {
                    $('#cekKtpTable').show(); 
                    initializeDataTable(); 
                });
        
            });
        </script>
        @include('layout.footer')