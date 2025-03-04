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
                                                    <button type="button" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#addMasalahKelompokModal">
                                                        <i class="fa fa-plus"></i>Tambah
                                                    </button>
                                                    <a href="#" id="exportDownloadRangkuman" class="btn btn-flex btn-success h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> Export Rangkuman
                                                    </a>
                                                    <a href="#" id="exportDownloadHistory" class="btn btn-flex btn-warning h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> Export History
                                                    </a>

                                                   
                                                </div>
                                            </div>
											

                                            <!-- Modal add PKP-->
                                            <div class="modal fade" id="addMasalahKelompokModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Form Tambah Kelompok Bermasalah:</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">No Kelompok:</label>
                                                                    <input type="text" class="form-control" id="add-no_kelompok-kb" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mt-4">
                                                                    <button class="btn btn-primary" id="cek-kelompok-kb">Cek</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Pilih Kelompok:</label>
                                                                    <select class="form-control" id="add-kelompok-kb"></select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Setoran Ke:</label>
                                                                    <input step="0.01" min="0" type="number" class="form-control" id="add-set_ke-kb" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Tanggal Bermasalah:</label>
                                                                    <input type="date" class="form-control" id="add-tanggal-kb" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Kode:</label>
                                                                    <select class="form-control" id="add-kode-kb">
                                                                        <option value="3A">3A</option>
                                                                        <option value="3B">3B</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Menit Telat (Opsional):</label>
                                                                    <input step="1" min="0" type="number" class="form-control" id="add-menit-kb" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Cabang:</label>
                                                                    <select class="form-control" id="add-cabang-kb">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">KC:</label>
                                                                    <select class="form-control" id="add-kc-kb">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">PKP FSK:</label>
                                                                    <select class="form-control" id="add-pkp-kb">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3 text-end">
                                                                <button type="submit" class="btn btn-primary" id="buttonAddMkAction">Submit</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            {{-- end modal add pkp  --}}
                                            
                                           
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <label class="form-label fs-6 fw-bold">KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kelompok-mk" placeholder="Kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3 mt-9">
                                                    <button id="searchMk" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchMk" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                        
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="masalahKelompokTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Kelompok</th>
                                                        <th class="min-w-125px">Tanggal Pencairan</th>
                                                        <th class="min-w-100px">Cabang</th>
														<th class="min-w-100px">Masalah</th>
                                                        <th class="min-w-100px">Telat</th>
                                                        <th class="min-w-100px">Berat</th>
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
                $('#masalahKelompokTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getMasalahKelompok') }}",
                        data: function (d) {
                            d.kelompok = $('#search-kelompok-mk').val();
                            d.pkp = $('#search-pkp-mk').val();
                            d.kc = $('#search-kc-mk').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'kelompok_kb', name: 'kelompok_kb'},
                        { 
                            data: 'tanggal_pencairan_kb', 
                            name: 'tanggal_pencairan_kb',
                            render: function(data, type, row) {
                                return data ? data.substring(0, 10) : ''; 
                            }
                        },
                        {data: 'cabang_kb', name: 'cabang_kb'},
                        {data: 'jumlah', name: 'jumlah'},
                        {data: 'kode3a', name: 'kode3a'},
                        {data: 'kode3b', name: 'kode3b'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchMk').click(function () {
                    $('#masalahKelompokTable').DataTable().ajax.reload();
                });
                $('#resetSearchMk').click(function () {
                    $('#search-kelompok-mk').val('');
                    $('#search-pkp-mk').val('');
                    $('#search-kc-mk').val('');
                    $('#masalahKelompokTable').DataTable().ajax.reload();
                });


				$(document).on('click', '.btn-delete-mk', function() {
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data Masalah Kelompok ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deleteMasalahKelompokAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",  
                                    id: id
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

                $('#exportDownloadRangkuman').on('click', function(e) {
                    e.preventDefault(); 
                    window.location.href = "{{ route('exportDownloadRangkumanMk') }}";
                });

                $('#exportDownloadHistory').on('click', function(e) {
                    e.preventDefault(); 
                    window.location.href = "{{ route('exportDownloadHistoryMk') }}";
                });
               
            });
            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getCabangOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-cabang-kb');
                        select.append('<option value="">--Pilih Cabang--</option>');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.nama + '">' + data.nama + '</option>');
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
                        var select = $('#add-kc-kb');
                        select.append('<option value="">--Pilih KC--</option>');
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
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getPkpOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-pkp-kb');
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
                $('#cek-kelompok-kb').click(function(e) {
                    e.preventDefault();
                    var noKelompok = $('#add-no_kelompok-kb').val(); 
                    if (noKelompok) {
                        $.ajax({
                            url: "{{ route('getCekKelompokOption') }}",  
                            method: 'GET',
                            data: { no_kelompok: noKelompok },
                            // alert(data);
                            success: function(response) {
                                if (response.success) {
                                    var kelompokOptions = '<option value="">Pilih Kelompok</option>';
                                    // alert(response.kelompok);
                                    $.each(response.kelompok, function(index, kelompok) {
                                        kelompokOptions += '<option value="' + kelompok.kode_group1 + '~~' + kelompok.deskripsi_group1 + '~~' + kelompok.tgl_realisasi + '">' + kelompok.deskripsi_group1 + ' [' + kelompok.tgl_realisasi + ']' + '</option>';
                                    });
                                    $('#add-kelompok-kb').html(kelompokOptions); 
                                } else {
                                    alert('Kelompok tidak ditemukan!');
                                }
                            },
                            error: function() {
                                alert('Terjadi kesalahan, coba lagi!');
                            }
                        });
                    } else {
                        alert('No Kelompok tidak boleh kosong!');
                    }
                });
            });

            $(document).ready(function() {
            
            
                
            $('#buttonAddMkAction').click(function(e) {
                e.preventDefault();

                let kelompok = $('#add-kelompok-kb').val();
                let setke = $('#add-set_ke-kb').val();
                let tanggal = $('#add-tanggal-kb').val();
                let kode = $('#add-kode-kb').val();
                let cabang = $('#add-cabang-kb').val();
                let kc = $('#add-kc-kb').val();
                let menit = $('#add-menit-kb').val();
                let pkp = $('#add-pkp-kb').val();

                $.ajax({
                    url: "{{ route('addMasalahKelompokAction') }}", 
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        kelompok: kelompok,
                        setke: setke,
                        tanggal: tanggal,
                        kode: kode,
                        menit: menit,
                        cabang: cabang,
                        kc: kc,
                        pkp: pkp
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
                        Swal.fire('Error', 'Masalah Kelompok Gagal Ditambahkan', 'error');
                    }
                    
                });
            });
        });
        </script>
        @include('layout.footer')