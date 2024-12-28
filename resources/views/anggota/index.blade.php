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
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="row">
                                                
                                                <div class="col-md-12">
                                                    <a href="{{ url('exportAnggota') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-download"></i>Export Excel</a>
                                                    {{-- <button id="downloadAnggotaAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-download"></i>Export Excel</button> --}}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NAMA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-anggota" placeholder="nama" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">KTP:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-ktp-anggota" placeholder="ktp" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kelompok-anggota" placeholder="kelompok" />
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-md-3 mt-9">
                                                    <button id="searchAnggota" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchAnggota" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                        
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="anggotaTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama</th>
                                                        <th class="min-w-100px">ID</th>
														<th class="min-w-100px">Kelompok</th>
                                                        <th class="min-w-100px">Cabang</th>
                                                        <th class="min-w-100px">Pinjaman</th>
                                                        <th class="min-w-100px">Periode</th>
                                                        <th class="min-w-100px">No KTP</th>
                                                        <th></th>
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
                $('#anggotaTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getAnggotaAktif') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-anggota').val();
                            d.kelompok = $('#search-kelompok-anggota').val();
                            d.ktp = $('#search-ktp-anggota').val();
                        }
                    },
                    
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'NAMA_NASABAH', name: 'NAMA_NASABAH'},
                        {data: 'nasabah_id', name: 'nasabah_id'},
                        {data: 'DESKRIPSI_GROUP1', name: 'DESKRIPSI_GROUP1'},
                        {data: 'kode_kantor', name: 'kode_kantor'},
                        { 
                            data: 'jml_pinjaman',name: 'jml_pinjaman',
                            render: function (data, type, row) { return 'Rp ' + new Intl.NumberFormat('id-ID', { style: 'decimal', }).format(data); }
                        },
                        {data: 'jml_angsuran', name: 'jml_angsuran', orderable: false, searchable: false},
                        {data: 'no_id', name: 'no_id'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchAnggota').click(function () {
                    $('#anggotaTable').DataTable().ajax.reload();
                });
                $('#resetSearchAnggota').click(function () {
                    // alert('disini');
                    $('#search-nama-anggota').val('');
                    $('#search-ktp-anggota').val('');
                    $('#search-kelompok-anggota').val('');
                    $('#anggotaTable').DataTable().ajax.reload();
                });


            });
        </script>
        @include('layout.footer')