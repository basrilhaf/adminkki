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
												<a href="{{route('role.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <input type="hidden" id="detail-id_role-role" value="{{$id_role}}">
                                            <div class="row">
                                               
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Nama Role</label>
                                                        <input type="text" id="detail-nama-role" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Kode Role</label>
                                                        <input type="text" id="detail-kode-role" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Kode Role</label>
                                                        <textarea  id="detail-keterangan-role" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="updateRoleAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
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
                $('#updateRoleAction').click(function(e) {
                    e.preventDefault();
                    
                    var id_role = $('#detail-id_role-role').val();
                    var nama_role = $('#detail-nama-role').val();
                    var kode_role = $('#detail-kode-role').val();
                    var keterangan_role = $('#detail-keterangan-role').val();
                    
                    $.ajax({
                        url: "{{ route('updateRoleAction') }}",  // Update with your actual route
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  // CSRF token for security
                            id_role: id_role,
                            nama_role: nama_role,
                            kode_role: kode_role,
                            keterangan_role: keterangan_role
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data Berhasil Disimpan',
                                icon: 'success'
                            }).then(function() {
                                location.reload();  // Reload the page after the alert is closed
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                        }
                    });
                });


                var id_role = $('#detail-id_role-role').val();
                var url = "{{ route('role.showDetailRole', ':id_role') }}";
                url = url.replace(':id_role', id_role);
                
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        // alert(response)
                        $('#detail-nama-role').val(response.nama_role);
                        $('#detail-kode-role').val(response.kode_role);
                        $('#detail-keterangan-role').val(response.keterangan_role);
                        

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Dimuat', 'error');
                    }
                });

                
                
            });

        </script>
		
        @include('layout.footer')