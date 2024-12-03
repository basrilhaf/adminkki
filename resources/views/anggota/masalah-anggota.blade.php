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
                                                    <button type="button" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addAbModal">
                                                        <i class="fa fa-plus"></i>Tambah
                                                    </button>
                                                    <button type="button" class="btn btn-flex btn-success h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addCabangModal">
                                                        <i class="fa fa-download"></i>Export Rangkuman
                                                    </button>
                                                    <button type="button" class="btn btn-flex btn-warning h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addCabangModal">
                                                        <i class="fa fa-download"></i>Export History
                                                    </button>
                                                </div>
                                            </div>
											

                                            <!-- Modal add PKP-->
                                            <div class="modal fade" id="addAbModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Form Tambah Anggota Bermasalah</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">ID Anggota:</label>
                                                                    <input type="text" class="form-control" id="add-id_anggota-ab" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Setoran Ke-:</label>
                                                                    <input type="text" class="form-control" id="add-setoran_ke-ab" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Tanggal Bermasalah:</label>
                                                                    <input type="date" class="form-control" id="add-tanggal-ab" required>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Kode:</label>
                                                                    <select class="form-control" id="add-is_kc-pkp">
                                                                        <option value="2">2</option>
                                                                        <option value="4A">4A</option>
                                                                        <option value="4B">4B</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Menit Telat:</label>
                                                                    <input type="number" class="form-control" id="add-menit-ab" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Cabang:</label>
                                                                    <select class="form-control" id="add-cabang-ab">
                                                                        <option value="">--Pilih Cabang---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">PKP:</label>
                                                                    <select class="form-control" id="add-pkp-ab">
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
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-anggota-ma" placeholder="ANGGOTA" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kelompok-ma" placeholder="KELOMPOK" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchMa" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchMa" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                       
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="masalahAnggotaTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-125px">Anggota</th>
														<th class="min-w-125px">Kelompok</th>
                                                        <th class="min-w-100px">Cabang</th>
														<th class="min-w-100px">DTR</th>
                                                        <th class="min-w-100px">DTR 2</th>
                                                        <th class="min-w-100px">DTR 4A</th>
                                                        <th class="min-w-100px">DTR 4B</th>
														<th class="min-w-100px">Actions</th>
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
                $('#masalahAnggotaTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getMasalahAnggota') }}",
                        data: function (d) {
                            d.anggota = $('#search-anggota-ma').val();
                            d.kelompok = $('#search-kelompok-ma').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama_ab', name: 'nama_ab'},
                        {data: 'kelompok_ab', name: 'kelompok_ab'},
                        {data: 'cabang_ab', name: 'cabang_ab'},
                        {data: 'jumlah', name: 'jumlah'},
                        {data: 'kode2', name: 'kode2'},
                        {data: 'kode4a', name: 'kode4a'},
                        {data: 'kode4b', name: 'kode4b'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchMa').click(function () {
                    $('#masalahAnggotaTable').DataTable().ajax.reload();
                });
                $('#resetSearchMa').click(function () {
                    $('#search-anggota-ma').val('');
                    $('#search-kelompok-ma').val('');
                    $('#masalahAnggotaTable').DataTable().ajax.reload();
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
                
            });
            
            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getCabangOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-cabang-ab');
                        select.empty();  // Hapus opsi yang lama
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
                    url: "{{ route('getPkpOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-pkp-ab');
                        select.append('<option value="">--Pilih PKP--</option>');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.id + '">' + data.nama + '</option>');
                        });
                        select.select2({
                            placeholder: "--Pilih PKP---",
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
                let cabangPkp = $('#add-cabang-ab').val();

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
                            $('#addAbModal').modal('hide');
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