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
                                            <div>
                                                <div class="">
                                                    <button type="button" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addPkpModal">
                                                        <i class="fa fa-plus"></i>PKP/KC
                                                    </button>
                                                    <button type="button" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addCabangModal">
                                                        <i class="fa fa-plus"></i>Cabang
                                                    </button>
                                                </div>
                                            </div>
											

                                            <!-- Modal add PKP-->
                                            <div class="modal fade" id="addPkpModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Form Tambah PKP/KC:</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nama PKP/KC:</label>
                                                                    <input type="text" class="form-control" id="add-nama-pkp" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">NIK PKP/KC:</label>
                                                                    <input type="text" class="form-control" id="add-nik-pkp" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Email PKP/KC:</label>
                                                                    <input type="text" class="form-control" id="add-email-pkp" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Password:</label>
                                                                    <input type="password" class="form-control" id="add-password-pkp" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">PKP/KC:</label>
                                                                    <select class="form-control" id="add-is_kc-pkp">
                                                                        <option value="0">PKP</option>
                                                                        <option value="1">KC</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Cabang:</label>
                                                                    <select class="form-control" id="add-cabang-pkp">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3 text-end">
                                                                <button type="submit" class="btn btn-primary" id="buttonAddPkpAction">Submit</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            {{-- end modal add pkp  --}}
                                            
                                            <!-- Modal add Cabang-->
                                            <div class="modal fade" id="addCabangModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Form Tambah Cabang:</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nama Cabang:</label>
                                                                    <input type="text" class="form-control" id="add-nama-cabang" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">KC:</label>
                                                                    <select class="form-control" id="add-kc-cabang">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3 text-end">
                                                                <button type="submit" class="btn btn-primary" id="buttonAddCabangAction">Submit</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            {{-- end modal add Cabang  --}}
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NAMA PKP/KC:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-pkp" placeholder="Nama" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">JENIS:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <select id="search-jenis-pkp" class="form-control form-control-solid ps-13">
                                                            <option value="">--Pilih Jenis--</option>
                                                            <option value="0">PKP</option>
                                                            <option value="1">KC</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">CABANG:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-cabang-pkp" placeholder="Cabang" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3 mt-9">
                                                    <button id="searchPkp" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchPkp" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">PKP</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="PkpTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama PKP/KC</th>
                                                        <th class="min-w-125px">Email</th>
														<th class="min-w-100px">Jenis</th>
                                                        <th class="min-w-100px">Cabang</th>
														<th class="min-w-100px">Actions</th>
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr>
                                    <div class="card mb-2 mt-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <label class="form-label fs-6 fw-bold">NAMA CABANG:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-cabang" placeholder="Nama" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3 mt-9">
                                                    <button id="searchCabang" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchCabang" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">Cabang</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="CabangTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama Cabang</th>
                                                        <th class="min-w-125px">KC</th>
														<th class="min-w-100px">Actions</th>
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
		
        <script type="text/javascript">
            $(document).ready(function () {
                $('#PkpTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getPkp') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-pkp').val();
                            d.jenis = $('#search-jenis-pkp').val();
                            d.cabang = $('#search-cabang-pkp').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama'},
                        {data: 'email_pkp', name: 'email_pkp'},
                        {data: 'jenis', name: 'jenis'},
                        {data: 'nama_cabang', name: 'nama_cabang'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchPkp').click(function () {
                    $('#PkpTable').DataTable().ajax.reload();
                });
                $('#resetSearchPkp').click(function () {
                    $('#search-nama-pkp').val('');
                    $('#search-jenis-pkp').val('');
                    $('#search-cabang-pkp').val('');
                    $('#PkpTable').DataTable().ajax.reload();
                });

                $('#CabangTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getCabang') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-cabang').val();
                           
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama'},
                        {data: 'nama_kc', name: 'email_pkp'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchCabang').click(function () {
                    $('#CabangTable').DataTable().ajax.reload();
                });
                $('#resetSearchCabang').click(function () {
                    $('#search-nama-cabang').val('');
                    $('#CabangTable').DataTable().ajax.reload();
                });

				$(document).on('click', '.btn-delete-pkp', function() {
                    var pkpId = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data kegiatan ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deletePkpAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",  
                                    id_pkp: pkpId
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
                $(document).on('click', '.btn-delete-cabang', function() {
                    var cabangId = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data kegiatan ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deleteCabangAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",  
                                    id_cabang: cabangId
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
            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getCabangOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-cabang-pkp');
                        select.append('<option value="">--Pilih Cabang--</option>');
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
                    url: "{{ route('getKcOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-kc-cabang');
                        select.append('<option value="">--Pilih Cabang--</option>');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.id + '">' + data.nama + '</option>');
                        });
                        select.select2({
                            placeholder: "--Pilih KC---",
                            allowClear: true
                        });
                        Swal.close();
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
            
                
            
            $('#buttonAddCabangAction').click(function(e) {
                e.preventDefault();

                let nama = $('#add-nama-cabang').val();
                let kc = $('#add-kc-cabang').val();
                

                $.ajax({
                    url: "{{ route('addCabangAction') }}", 
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        nama: nama,
                        kc: kc
                    },
                    success: function(response) {
                        Swal.fire({
                        title: 'Success',
                        text: 'Cabang Berhasil Ditambahkan',
                        icon: 'success'
                        }).then(function() {
                            $('#addCabangModal').modal('hide');
                            location.reload();  
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Cabang Gagal Ditambahkan', 'error');
                    }
                    
                });
            });
                
            $('#buttonAddPkpAction').click(function(e) {
                e.preventDefault();

                let namaPkp = $('#add-nama-pkp').val();
                let nikPkp = $('#add-nik-pkp').val();
                let emailPkp = $('#add-email-pkp').val();
                let passwordPkp = $('#add-password-pkp').val();
                let isKcPkp = $('#add-is_kc-pkp').val();
                let cabangPkp = $('#add-cabang-pkp').val();

                $.ajax({
                    url: "{{ route('addPkpAction') }}", 
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        nama_pkp: namaPkp,
                        nik_pkp: nikPkp,
                        email_pkp: emailPkp,
                        password_pkp: passwordPkp,
                        is_kc_pkp: isKcPkp,
                        cabang_pkp: cabangPkp
                    },
                    success: function(response) {
                        Swal.fire({
                        title: 'Success',
                        text: 'PKP/KC Berhasil Ditambahkan',
                        icon: 'success'
                        }).then(function() {
                            $('#addPkpModal').modal('hide');
                            location.reload();  
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'PKP/KC Gagal Ditambahkan', 'error');
                    }
                    
                });
            });
        });
        </script>
        @include('layout.footer')