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
												<a href="{{route('user.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <input type="hidden" id="detail-id_user-user" value="{{$id_user}}">
                                            <div class="row">
                                                <div class="col-md-12 card">
                                                    
                                                    <div class="row">
                                                    
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Nama</label>
                                                                <input type="text" id="detail-nama-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Email</label>
                                                                <input type="text" id="detail-email-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Jenis Kelamin</label>
                                                                <input type="text" id="detail-jenis_kelamin-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">No Telepon/HP</label>
                                                                <input type="text" id="detail-no_telepon-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Role Aplikasi</label>
                                                                <input type="text" id="detail-role-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Status User Aplikasi</label>
                                                                <input type="text" id="detail-status-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Alamat</label>
                                                                <textarea name="" id="detail-alamat-user" cols="10" rows="2" class="form-control mb-2"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Username Aplikasi</label>
                                                                <input type="text" id="detail-username-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h2>Domisili Tugas</h2>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="mb-4 fv-row">
                                                                        <label class="required form-label">Provinsi Domisili</label>
                                                                        <input type="text" id="detail-provinsi-user" class="form-control mb-2">
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-4 fv-row">
                                                                        <label class="required form-label">Kota/Kabupaten Domisili</label>
                                                                        <input type="text" id="detail-kota-user" class="form-control mb-2">
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-4 fv-row">
                                                                        <label class="required form-label">Kecamatan Domisili</label>
                                                                        <input type="text" id="detail-kecamatan-user" class="form-control mb-2">
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-4 fv-row">
                                                                        <label class="required form-label">Kelurahan Domisili</label>
                                                                        <input type="text" id="detail-kelurahan-user" class="form-control mb-2">
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mt-9 mb-4 d-flex justify-content-end">
                                                            <button id="updateUserAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
                                                        </div>
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
               
                var id_user = $('#detail-id_user-user').val();
                var url = "{{ route('user.showDetailUser', ':id_user') }}";
                url = url.replace(':id_user', id_user);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-nama-user').val(response.nama).prop('disabled', true);
                        $('#detail-email-user').val(response.email).prop('disabled', true);
                        $('#detail-jenis_kelamin-user').val(response.jenis_kelamin_nama).prop('disabled', true);
                        $('#detail-no_telepon-user').val(response.no_telepon).prop('disabled', true);
                        $('#detail-role-user').val(response.nama_role).prop('disabled', true);
                        $('#detail-status-user').val(response.status_nama).prop('disabled', true);
                        $('#detail-alamat-user').val(response.alamat).prop('disabled', true);
                        $('#detail-username-user').val(response.username).prop('disabled', true);
                        $('#detail-provinsi-user').val(response.provinsi_nama).prop('disabled', true);
                        $('#detail-kota-user').val(response.kabkota_nama).prop('disabled', true);
                        $('#detail-kecamatan-user').val(response.kecamatan_nama).prop('disabled', true);
                        $('#detail-kelurahan-user').val(response.kelurahan_nama).prop('disabled', true);
                        

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Dimuat', 'error');
                    }
                });
               

            });

        </script>
		
        @include('layout.footer')