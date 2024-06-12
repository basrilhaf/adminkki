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
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">{{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											<div class="d-flex align-items-center gap-2 gap-lg-3">
												<a href="{{route('menu.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Nama Menu</label>
                                                        <input type="text" id="add-nama-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">URL Menu</label>
                                                        <input type="text" id="add-url-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Jenis Menu</label>
                                                    <select id="add-jenis-menu" class="form-control mb-2">
                                                        <option value="">--Pilih Jenis Jawaban---</option>
                                                    </select>
                                                </div>
                                               
                                                <div class="mb-4 fv-row" id="divPilihan" style="display:none;">
                                                    <label class="required form-label">Master Menu</label>
                                                    <select id="add-master_menu-menu" class="form-control mb-2">
                                                        <option value="">--Pilih Master Menu---</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Urutan Menu</label>
                                                        <input type="text" id="add-urutan-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Icon Menu</label>
                                                        <input type="text" id="add-icon-menu" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Keterangan</label>
                                                        <textarea  id="add-keterangan-menu" class="form-control mb-2"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Status Menu</label>
                                                        <select id="add-status-menu" class="form-control mb-2">
                                                            <option value="">--Pilih Status---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="addMenuAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
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
                $('#addMenuAction').click(function(e) {
                    e.preventDefault();
                    var nama_menu = $('#add-nama-menu').val();
                    var url = $('#add-url-menu').val();
                    var is_master = $('#add-jenis-menu').val();
                    var master_menu = $('#add-master_menu-menu').val();
                    var urutan = $('#add-urutan-menu').val();
                    var icon = $('#add-icon-menu').val();
                    var keterangan = $('#add-keterangan-menu').val();
                    var status_menu = $('#add-status-menu').val();
                    
                    $.ajax({
                        url: "{{ route('addMenuAction') }}",  // Update with your actual route
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  // CSRF token for security
                            nama_menu: nama_menu,
                            url: url,
                            is_master: is_master,
                            master_menu: master_menu,
                            urutan: urutan,
                            icon: icon,
                            keterangan: keterangan,
                            status_menu: status_menu
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

                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getReffJenisMenu') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-jenis-menu');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.isi_kolom + '">' + data.keterangan + '</option>');
                        });
                    }
                });
                $.ajax({
                    url: "{{ route('getReffStatusMenu') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-status-menu');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.isi_kolom + '">' + data.keterangan + '</option>');
                        });
                    }
                });
                Swal.close();

                $('#add-jenis-menu').on('change', function() {
                    var selectedValue = $(this).val();
                    if (selectedValue == 'N') {
                        $('#divPilihan').show();
                        $.ajax({
                            url: "{{ route('menu.getMasterMenu') }}",
                            method: 'GET',
                            success: function(data) {
                                var select = $('#add-master_menu-menu');
                                select.empty(); 
                                select.append('<option value="">--Pilih Master Menu---</option>');
                                data.forEach(function(data) {
                                    select.append('<option value="' + data.id_menu + '">' + data.nama_menu + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching options:', error);
                            }
                        });
                    } else {
                        $('#divPilihan').hide();
                    }
                });

            });


        </script>
		
        @include('layout.footer')