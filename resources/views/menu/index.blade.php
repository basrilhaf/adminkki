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
											<div class="d-flex align-items-center gap-2 gap-lg-3">
												<a href="{{route('menu.addMenu')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold""><i class="fa fa-plus"></i>Menu</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA MENU:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-menu-nama" placeholder="Nama menu" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">URL MENU:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-menu-url" placeholder="Url menu" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchMenu" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchMenu" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="laravel_datatable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama</th>
														<th class="min-w-125px">Url</th>
														<th class="min-w-125px">Jenis Menu</th>
														<th class="min-w-125px">Status</th>
														<th class="min-w-100px">Actions</th>
													</tr>
												</thead>
											
											</table>
											<!--end::Table-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Card-->
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
		
        <script type="text/javascript">
            $(document).ready(function () {
                $('#laravel_datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('menu.getMenu') }}",
                        data: function (d) {
                            d.nama_menu = $('#search-menu-nama').val();
                            d.url_menu = $('#search-menu-url').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama_menu', name: 'nama_menu'},
                        {data: 'url', name: 'url'},
                        {data: 'is_master_field', name: 'is_master_field'},
                        {data: 'status_field', name: 'status_field'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchMenu').click(function () {
                    $('#laravel_datatable').DataTable().ajax.reload();
                });
                $('#resetSearchMenu').click(function () {
                    $('#search-menu-nama').val('');
                    $('#search-menu-url').val('');
                    $('#laravel_datatable').DataTable().ajax.reload();
                });

				$(document).on('click', '.btn-delete-menu', function() {
                    var menuId = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data menu ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika dikonfirmasi, lakukan AJAX request
                            $.ajax({
                                url: "{{ route('deleteMenuAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",  
                                    id_menu: menuId
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