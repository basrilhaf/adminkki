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
                                                        <select id="detail-jenis-menu" class="form-control mb-2">
                                                            <option value="">--Pilih Jenis Menu---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row" id="divMasterMenu">
                                                        <label class="required form-label">Master Menu</label>
                                                        <select id="detail-master_menu-menu" class="form-control mb-2">
                                                            <option value="">--Pilih Status---</option>
                                                        </select>
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
                                                        <select id="detail-status-menu" class="form-control mb-2">
                                                            <option value="">--Pilih Status---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="updateMenuAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
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
                $('#updateMenuAction').click(function(e) {
                    e.preventDefault();
                    
                    var id_menu = $('#detail-id_menu-menu').val();
                    // alert(id_menu);
                    var nama_menu = $('#detail-nama-menu').val();
                    var url = $('#detail-url-menu').val();
                    var is_master = $('#detail-jenis-menu').val();
                    var master_menu = $('#detail-master_menu-menu').val();
                    var urutan = $('#detail-urutan-menu').val();
                    var icon = $('#detail-icon-menu').val();
                    var keterangan = $('#detail-keterangan-menu').val();
                    var status_menu = $('#detail-status-menu').val();
                    
                    $.ajax({
                        url: "{{ route('updateMenuAction') }}",  // Update with your actual route
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
                            status_menu: status_menu,
                            id_menu: id_menu
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


                var id_menu = $('#detail-id_menu-menu').val();
                var url = "{{ route('menu.showDetailMenu', ':id_menu') }}";
                url = url.replace(':id_menu', id_menu);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-nama-menu').val(response.nama_menu);
                        $('#detail-url-menu').val(response.url);
                        $('#detail-jenis-menu').val(response.is_master);
                        $('#detail-master_menu-menu').val(response.master_menu);
                        $('#detail-urutan-menu').val(response.urutan);
                        $('#detail-icon-menu').val(response.icon);
                        $('#detail-keterangan-menu').val(response.keterangan);
                        $('#detail-status-menu').val(response.status_menu);

                        if (response.is_master === 'N') {
                            $('#divMasterMenu').show();
                            
                        } else {
                            $('#divMasterMenu').hide();
                        }
                        $('#detail-status-menu').val(response.status_menu);
                        fetchStatus(response);
                        $('#detail-jenis-menu').val(response.is_master);
                        fetchJenis(response);
                        $('#detail-master_menu-menu').val(response.master_menu);
                        fetchMasterMenu(response);

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });

                function fetchMasterMenu(response) {
                    var KegiatanUrl = "{{ route('menu.getMasterMenu') }}";
                    $.ajax({
                        url: KegiatanUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-master_menu-menu');
                            $select.empty();
                            $select.append('<option value="">--Pilih Master Menu---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.id_menu === response.master_menu) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.id_menu + '" ' + selected + '>' + data.nama_menu + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Master Menu data');
                        }
                    });
                }

                function fetchJenis(response) {
                    var KegiatanUrl = "{{ route('getReffJenisMenu') }}";
                    $.ajax({
                        url: KegiatanUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-jenis-menu');
                            $select.empty();
                            $select.append('<option value="">--Pilih Jenis Menu---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.isi_kolom === response.is_master) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.isi_kolom + '" ' + selected + '>' + data.keterangan + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Jenis Menu data');
                        }
                    });
                }

                function fetchStatus(response) {
                    var KegiatanUrl = "{{ route('getReffStatusMenu') }}";
                    $.ajax({
                        url: KegiatanUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-status-menu');
                            $select.empty();
                            $select.append('<option value="">--Pilih Status---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.isi_kolom === response.status_menu) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.isi_kolom + '" ' + selected + '>' + data.keterangan + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Status data');
                        }
                    });
                }

                $('#detail-jenis-menu').on('change', function() {
                    var selectedValue = $(this).val();
                    if (selectedValue == 'N') {
                        $('#divMasterMenu').show();
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
                        $('#divMasterMenu').hide();
                    }
                });
            });

        </script>
		
        @include('layout.footer')