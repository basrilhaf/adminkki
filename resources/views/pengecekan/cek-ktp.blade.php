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
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(1):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp1-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(2):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp2-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(3):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp3-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(4):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp4-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(5):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp5-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(6):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp6-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(7):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp7-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(8):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp8-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(9):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp9-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(10):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp10-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NO KTP(11):</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-ktp11-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3 mt-9">
                                                    <button id="cekKtpAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Submit</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-anggota-cek" placeholder="Nama Anggota" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">KELOMPOK TERAKHIR:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kelompok-cek" placeholder="NO KTP" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchKelompok" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearcKelompok" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
										<div class="card-body py-4" style="overflow-x: auto;">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="cekAnggotaTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-100px">ID</th>
                                                        <th class="min-w-100px">Nama</th>
                                                        <th class="min-w-100px">Klpk Terakhir</th>
                                                        <th class="min-w-100px">Status</th>
														<th class="min-w-100px">Aktif/Tidak Aktif</th>
                                                        <th class="min-w-100px">KTP</th>
                                                        <th class="min-w-100px">Pinjaman</th>
                                                        <th class="min-w-100px">DTR 2</th>
                                                        <th class="min-w-100px">DTR 4A</th>
                                                        <th class="min-w-100px">DTR 4B</th>
                                                        <th class="min-w-100px">Action</th>
                                                        
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
<!-- 		
        <script type="text/javascript">
            $(document).ready(function () {
                $('#kelompokTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getMasalahKelompok') }}",
                        data: function (d) {
                            d.nama = $('#search-nama-kelompok').val();
                            d.nomor = $('#search-nomr-kelompok').val();
                            d.cabang = $('#search-cabang-kelompok').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'kelompok_kb', name: 'kelompok_kb'},
                        {data: 'cabang_kb', name: 'cabang_kb'},
                        {data: 'jumlah', name: 'jumlah'},
                        {data: 'kode3a', name: 'kode3a'},
                        {data: 'kode3b', name: 'kode3b'},
                        {data: 'pkp_dkb', name: 'pkp_dkb'},
                        {data: 'kc_dkb', name: 'kc_dkb'},
                        {data: 'pkp_dkb', name: 'pkp_dkb'},
                        {data: 'kc_dkb', name: 'kc_dkb'},
                        {data: 'pkp_dkb', name: 'pkp_dkb'},
                        {data: 'kc_dkb', name: 'kc_dkb'},
                        {data: 'pkp_dkb', name: 'pkp_dkb'},
                        {data: 'kc_dkb', name: 'kc_dkb'},
                        {data: 'pkp_dkb', name: 'pkp_dkb'},
                        {data: 'kc_dkb', name: 'kc_dkb'},
                        {data: 'pkp_dkb', name: 'pkp_dkb'},
                        {data: 'kc_dkb', name: 'kc_dkb'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchKelompok').click(function () {
                    $('#kelompokTable').DataTable().ajax.reload();
                });
                $('#resetSearchKelompok').click(function () {
                    $('#search-nama-kelompok').val('');
                    $('#search-nomor-kelompok').val('');
                    $('#search-cabang-kelompok').val('');
                    $('#kelompokTable').DataTable().ajax.reload();
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
        }); -->
        </script>
        @include('layout.footer')