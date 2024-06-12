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
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">Form {{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											<div class="d-flex align-items-center gap-2 gap-lg-3">
												<a href="{{route('menu.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <input type="hidden" id="detail-id_menu-menu" value="{{$id_menu}}">
                                            <div class="row">
                                               
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Nama Menu</label>
                                                        <input type="text" id="detail-nama-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">URL</label>
                                                        <input type="text" id="detail-url-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Jenis Menu</label>
                                                        <input type="text" id="detail-jenis-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row" id="divMasterMenu">
                                                        <label class="required form-label">Master Menu</label>
                                                        <input type="text" id="detail-master_menu-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Urutan Menu</label>
                                                        <input type="text" id="detail-urutan-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Icon Menu</label>
                                                        <input type="text" id="detail-icon-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Keterangan</label>
                                                        <textarea class="form-control" id="detail-keterangan-menu" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Status Menu</label>
                                                        <input type="text" id="detail-status-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                
                                            </div>                                            
                                        </div>
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
            $(document).ready(function() {
                var id_menu = $('#detail-id_menu-menu').val();
                var url = "{{ route('menu.showDetailMenu', ':id_menu') }}";
                url = url.replace(':id_menu', id_menu);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-nama-menu').val(response.nama_menu).prop('disabled', true);
                        $('#detail-url-menu').val(response.url).prop('disabled', true);
                        $('#detail-jenis-menu').val(response.jenis_menu_nama).prop('disabled', true);
                        $('#detail-master_menu-menu').val(response.master_menu_nama).prop('disabled', true);
                        $('#detail-urutan-menu').val(response.urutan).prop('disabled', true);
                        $('#detail-icon-menu').val(response.icon).prop('disabled', true);
                        $('#detail-keterangan-menu').val(response.keterangan).prop('disabled', true);
                        $('#detail-status-menu').val(response.status_menu_nama).prop('disabled', true);

                        if (response.is_master === 'N') {
                            $('#divMasterMenu').show();
                            
                        } else {
                            $('#divMasterMenu').hide();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });
            });

        </script>
		
        @include('layout.footer')