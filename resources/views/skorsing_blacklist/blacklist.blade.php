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
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0"> {{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
                                            <button type="button" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addBlacklistModal">
                                                <i class="fa fa-plus"></i>Blacklist
                                            </button>
                                            <div class="modal fade" id="addBlacklistModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Form Tambah Blacklist:</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">ID Anggota Blacklist:</label>
                                                                    <input type="text" class="form-control" id="add-id-bl" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Setoran Ke-:</label>
                                                                    <input type="text" class="form-control" id="add-setoran-bl" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Alasan:</label>
                                                                    <textarea class="form-control" id="add-alasan-bl"></textarea>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3 text-end">
                                                                <button type="submit" class="btn btn-primary" id="buttonAddBlAction">Submit</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
										</div>
									</div>
									<!--begin::Card-->
                                    
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">ID ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-id-bl" placeholder="no kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-bl" placeholder="Nama kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchBl" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchBl" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                    <div class="card-header">
                                            <h2 class="pt-4">Anggota Blacklist</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="anggotaBlacklistTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">ID Anggota</th>
                                                        <th class="min-w-100px">Nama Anggota</th>
                                                        <th class="">Set Ke</th>
                                                        <th class="min-w-125px">Alasan</th>
                                                        <th class="min-w-100px">Action</th>
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">ID ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-id-rk" placeholder="no kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-rk" placeholder="Nama kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchRk" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchRk" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                        <div class="card-header">
                                            <h2 class="pt-4">Rekomendasi Blacklist (Kabur)</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="rekomendasiTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">ID Anggota</th>
														<th class="min-w-100px">Nama Anggota</th>
                                                        <th class="min-w-100px">Kelompok</th>
                                                        <th class="">Cabang</th>
                                                        <th class="">Set Masalah Terakhir</th>
                                                        <th class="">Status</th>
                                                       
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
                $('#anggotaBlacklistTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getAnggotaBlacklist') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-bl').val();
                            d.id = $('#search-id-bl').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'id_anggota_bl', name: 'id_anggota_bl'},
                        {data: 'anggota_bl', name: 'anggota_bl'},
                        {data: 'set_ke_bl', name: 'set_ke_bl'},
                        {data: 'alasan_bl', name: 'alasan_bl'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchBl').click(function () {
                    $('#anggotaBlacklistTable').DataTable().ajax.reload();
                });
                $('#resetSearchBl').click(function () {
                    $('#search-nama-bl').val('');
                    $('#search-id-bl').val('');
                    $('#anggotaBlacklistTable').DataTable().ajax.reload();
                });

                
                $('#rekomendasiTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getRekomendasiBlacklist') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-rk').val();
                            d.id = $('#search-id-rk').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'id_anggota_ab', name: 'id_anggota_ab'},
                        {data: 'nama_ab', name: 'nama_ab'},
                        {data: 'kelompok_ab', name: 'kelompok_ab'},
                        {data: 'cabang_ab', name: 'cabang_ab'},
                        {data: 'max_set', name: 'max_set'},
                        {data: 'status', name: 'status', orderable: false, searchable: false},
                    ]
                });
                $('#searchRk').click(function () {
                    $('#rekomendasiTable').DataTable().ajax.reload();
                });
                $('#resetSearchRk').click(function () {
                    $('#search-nama-rk').val('');
                    $('#search-id-rk').val('');
                    $('#rekomendasiTable').DataTable().ajax.reload();
                });

				$(document).on('click', '.btn-delete-bl', function() {
                    var idBl = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data kegiatan ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deleteBlacklistAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",  
                                    id: idBl
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