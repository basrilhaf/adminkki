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
                                            <button type="button" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addSkorsingModal">
                                                <i class="fa fa-plus"></i>Skorsing
                                            </button>
                                            <div class="modal fade" id="addSkorsingModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Form Tambah Skorsing:</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">ID Anggota Blacklist:</label>
                                                                    <input type="text" class="form-control" id="add-id-sk" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Mulai Skorsing:</label>
                                                                    <input type="date" class="form-control" id="add-mulai-sk" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Lama Skorsing:</label>
                                                                    <input type="number" step="1" min="0" class="form-control" id="add-lama-sk" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Satuan:</label>
                                                                    <select id="add-satuan-sk" class="form-control">
                                                                        <option value="month">Bulan</option>
                                                                        <option value="week">Minggu</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3 text-end">
                                                                <button type="submit" class="btn btn-primary" id="buttonAddSkAction">Submit</button>
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
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-id-sk" placeholder="ID" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-sk" placeholder="Nama" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchSk" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchSk" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                    <div class="card-header">
                                            <h2 class="pt-4">Anggota Skorsing</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="anggotaSkorsingTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">ID Anggota</th>
                                                        <th class="min-w-100px">Nama Anggota</th>
                                                        <th class="min-w-100px">KTP</th>
                                                        <th class="min-w-125px">Tanggal Mulai</th>
                                                        <th class="min-w-100px">Tanggal Akhir</th>
                                                        <th>Action</th>
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
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-id-rkSk" placeholder="ID" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nama-rkSk" placeholder="Nama " />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchRkSk" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchRkSk" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                        <div class="card-header">
                                            <h2 class="pt-4">Rekomendasi Skorsing</h2>
                                        </div>
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="rekomendasiSkTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">ID Anggota</th>
														<th class="min-w-100px">Nama Anggota</th>
                                                        <th class="min-w-100px">Kelompok</th>
                                                        <th class="">Kasus DTR</th>
                                                        <th class="">Kategori</th>
                                                       
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
                $('#anggotaSkorsingTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getAnggotaSkorsing') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-sk').val();
                            d.id = $('#search-id-sk').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'id_anggota_sk', name: 'id_anggota_sk'},
                        {data: 'nama_sk', name: 'nama_sk'},
                        {data: 'ktp_sk', name: 'ktp_sk'},
                        {data: 'mulai_sk', name: 'mulai_sk'},
                        {data: 'selesai_sk', name: 'selesai_sk'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchSk').click(function () {
                    $('#anggotaSkorsingTable').DataTable().ajax.reload();
                });
                $('#resetSearchSk').click(function () {
                    $('#search-nama-sk').val('');
                    $('#search-id-sk').val('');
                    $('#anggotaSkorsingTable').DataTable().ajax.reload();
                });

                
                $('#rekomendasiSkTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getRekomendasiSkorsing') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-rkSk').val();
                            d.id = $('#search-id-rkSk').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'id_anggota_ab', name: 'id_anggota_ab'},
                        {data: 'nama_ab', name: 'nama_ab'},
                        {data: 'kelompok_ab', name: 'kelompok_ab'},
                        {data: 'dtr', name: 'dtr', orderable: false, searchable: false},
                        {data: 'status', name: 'status', orderable: false, searchable: false},
                    ]
                });
                $('#searchRkSk').click(function () {
                    $('#rekomendasiSkTable').DataTable().ajax.reload();
                });
                $('#resetSearchRkSk').click(function () {
                    $('#search-nama-rkSk').val('');
                    $('#search-id-rkSk').val('');
                    $('#rekomendasiSkTable').DataTable().ajax.reload();
                });

				$(document).on('click', '.btn-delete-sk', function() {
                    var idBl = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data kegiatan ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deleteSkorsingAction') }}", 
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
                
            $('#buttonAddSkAction').click(function(e) {
                e.preventDefault();

                let id = $('#add-id-sk').val();
                let mulai = $('#add-mulai-sk').val();
                let lama = $('#add-lama-sk').val();
                let satuan = $('#add-satuan-sk').val();

                $.ajax({
                    url: "{{ route('addSkorsingAction') }}", 
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        id: id,
                        mulai: mulai,
                        lama: lama,
                        satuan: satuan
                        
                    },
                    success: function(response) {
                        Swal.fire({
                        title: response.icon,
                        text: response.message,
                        icon: response.icon
                        }).then(function() {
                            if(response.icon === 'success'){
                                $('#addSkorsingModal').modal('hide');
                                location.reload();  
                            }
                            
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Anggota Gagal Ditambahkan', 'error');
                    }
                    
                });
            });
        });
        </script>
        @include('layout.footer')