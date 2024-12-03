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
												<a href="{{route('user.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Nama</label>
                                                        <input type="text" id="add-user-nama" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Email</label>
                                                        <input type="text" id="add-user-email" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Password</label>
                                                        <input type="text" id="add-user-password" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Jenis</label>
                                                        <select id="add-user-jenis" class="form-control mb-2">
                                                            <option value="">--Pilih Jenis User---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Cabang</label>
                                                        <select id="add-user-cabang" class="form-control mb-2">
                                                            <option value="">--Pilih Cabang---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                
                                               
                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="addUserAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"> <i class="fa fa-save"></i>SIMPAN</button>
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
                $('#addUserAction').click(function(e) {
                    e.preventDefault();
                    var nama = $('#add-user-nama').val();
                    var email = $('#add-user-email').val();
                    var password = $('#add-user-password').val();
                    var jenis = $('#add-user-jenis').val();
                    var cabang = $('#add-user-cabang').val();
                    
                    $.ajax({
                        url: "{{ route('addUserAction') }}", 
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  
                            nama: nama,
                            email: email,
                            password: password,
                            jenis: jenis,
                            cabang: cabang
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
                });
            });
        
            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getCabangOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-user-cabang');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.id + '">' + data.nama + '</option>');
                        });
                        select.select2({
                            placeholder: "--Pilih Cabang---",
                            allowClear: true
                        });
                        Swal.close();
                    }
                });
                Swal.close();
            });
            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getReffJenisUserOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-user-jenis');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.value + '">' + data.isi + '</option>');
                        });
                        select.select2({
                            placeholder: "--Pilih Jenis---",
                            allowClear: true
                        });
                        Swal.close();
                    }
                });
                Swal.close();
            });
            
            
            
            

        </script>
		
        @include('layout.footer')