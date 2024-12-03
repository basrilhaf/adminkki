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
                                            <input type="hidden" id="detail-id_user-user" value="{{ session('id_user') }}">
                                            <div class="row">
                                                
                                                <div class="col-md-12 card pl-2">
                                                    <div class="row card">
                                                        <div class="card-body">
                                                            <div class="col-md-12">
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Password Baru</label>
                                                                    <input type="password" id="detail-passwordnew-user" class="form-control mb-2">
                                                                </div>
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Konfirmasi Password Baru</label>
                                                                    <input type="password" id="detail-konfpasswordnew-user" class="form-control mb-2">
                                                                </div>
                                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                                    <button id="updatePasswordAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>UBAH PASSWORD</button>
                                                                </div>
                                                            </div>
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
                $('#updatePasswordAction').click(function(e) {
                    e.preventDefault();
                    
                    var id_user = $('#detail-id_user-user').val();
                    var passwordnew = $('#detail-passwordnew-user').val();
                    var passwordkonf = $('#detail-konfpasswordnew-user').val();
                    
                    if(passwordnew !== passwordkonf){
                        Swal.fire('Error', 'Konfirmasi password tidak sama', 'error');
                    }else{
                        $.ajax({
                            url: "{{ route('updatePasswordAction') }}",  // Update with your actual route
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",  // CSRF token for security
                                id_user: id_user,
                                passwordnew: passwordnew,
                                passwordkonf: passwordkonf
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Password Berhasil Diubah',
                                    icon: 'success'
                                }).then(function() {
                                    location.reload();  // Reload the page after the alert is closed
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                            }
                        });
                    }
                });


            });

        </script>
		
        @include('layout.footer')