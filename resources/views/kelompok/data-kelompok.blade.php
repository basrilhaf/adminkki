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
                                                <div class="col-md-9">
                                                    <label class="form-label fs-6 fw-bold">KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-kelompok" placeholder="nama kelompok" />
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
														<th class="min-w-125px">Kelompok</th>
                                                        <th class="min-w-100px">PKP Proses</th>
                                                        <th class="min-w-100px">KC Proses</th>
														<th class="min-w-100px">PKP FSK</th>
                                                        <th class="min-w-100px">Cabang</th>
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
		
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dataKelompokTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getPjKelompok') }}",
                        data: function (d) {
                            d.kelompok = $('#search-nama-kelompok').val();
                           
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'kelompok_dkb', name: 'kelompok_dkb'},
                        {data: 'pkp_dkb', name: 'pkp_dkb'},
                        {data: 'kc_dkb', name: 'kc_dkb'},
                        {data: 'nama', name: 'nama'},
                        {data: 'cabang_dkb', name: 'cabang_dkb'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                        
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
                
                $(document).on('click', '.btn-delete-pj', function() {
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deletePjKelompokAction') }}", 
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
        @include('layout.footer')