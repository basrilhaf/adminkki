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
												<h1 class="page-heading d-flex flex-column justify-content-center text-primary fw-bolder fs-1 m-0">{{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											
										</div>
									</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Filter Tanggal</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label for="daterange">Rentang Tanggal: </label>
                                                                <input type="text" id="search-daterange-kkb" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button id="submitKkb" class="btn btn-primary rounded mt-4">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Form</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Tanggal: </label>
                                                                <input type="date" id="form-tanggal-kab" name="tanggal" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Cabang: </label>
                                                                <select name="" id="form-cabang-kab" class="form-control">
                                                                    <?php if(session('id_role2') != 2){?>
                                                                        <option value="<?php echo session('cabang');?>"><?php echo session('cabang');?></option>
                                                                    <?php } else {?>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Jenis: </label>
                                                                <select name="" id="form-jenis-kab" class="form-control">
                                                                    <option value="KKB">KKB</option>
                                                                    <option value="Rekap">Rekap</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-9">
                                                            <a href="#" id="formKabAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                                <i class="fa fa-download"></i> Submit
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                    <hr>
                                    <div class="card mb-2 mt-4">
                                        <div class="card-body">
                                            <div class="row">
                                                
                                                <div class="col-md-8">
                                                    <label class="form-label fs-6 fw-bold">NAMA KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kkb-kelompok" placeholder="Nama Kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchKkb" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchKkb" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="card">
										<div class="card-header">
                                            <h2 class="mt-4">Kelompok Bermasalah</h2>
                                        </div>
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableKkb" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>Kelompok</th>
                                                        <th>Tanggal</th>
                                                        <th>Kasus</th>
                                                        <th>Status</th>
                                                        <th></th>
													</tr>
												</thead>
											
											</table>
											<!--end::Table-->
										</div>
										<!--end::Card body-->
									</div>
                                    <!--begin::Card-->
                                    <hr>
                                    <div class="card mb-2 mt-4">
                                        <div class="card-body">
                                            <div class="row">
                                                
                                                <div class="col-md-8">
                                                    <label class="form-label fs-6 fw-bold">NAMA KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kkbDikunjungi-kelompok" placeholder="Nama Kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchkkbDikunjungi" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchkkbDikunjungi" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">Kelompok Sudah Dikumpulkan</h2>
                                        </div>
                                        <div class="card-body py-4">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableDikunjungi" style="display: none;">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>Kelompok</th>
                                                        <th>Tanggal</th>
                                                        <th>Kasus</th>
                                                        <th>Status</th>
                                                        <th></th>
													</tr>
												</thead>
											</table>
                                        </div>
									</div>
									<!--end::Card-->

                                    <!-- Modal Edit User -->
                                    <div class="modal fade" id="modalEditKkb" tabindex="-1" aria-labelledby="modalEditKkbLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditKkbLabel">Detail Kelompok Bermasalah</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="formEditUser">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="hidden" id="id_kb">
                                                                <div class="mb-3">
                                                                    <label for="kelompok_ab" class="form-label">Kelompok Bermasalah</label>
                                                                    <input type="text" class="form-control" id="kelompok_kb" name="kelompok_kb" disabled>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label for="kelompok_ab" class="form-label">Tanggal Bermasalah</label>
                                                                    <input type="text" class="form-control" id="tanggal_kb" name="tanggal_kb" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="mb-3">
                                                                    <label for="kelompok_ab" class="form-label">Kode</label>
                                                                    <input type="text" class="form-control" id="kode_kb" name="kode_kb" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Sudah Dikumpulkan?:</label>
                                                                    <select class="form-control" id="dikumpulkan_kb"></select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Tanggal dikumpulkan:</label>
                                                                    <input type="date" class="form-control" id="tanggal_dikumpulkan_kb" name="tanggal_dikumpulkan_kb">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Jumlah Anggota Dikumpulkan:</label>
                                                                    <input type="number" class="form-control" id="jumlah_dikumpulkan_kb" name="jumlah_dikumpulkan_kb">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">Hasil Pembahasan?:</label>
                                                                    <select class="form-control" id="pembahasan_kb"></select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-12" id="">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Pembahasan Lainnya: <span class="text-danger" style="font-size:12px;">(sertakan no "6." diawal, cth: 6. isi lainnya)</span></label>
                                                                    <textarea id="pembahasan_lainnya_kb" class="form-control" cols="30" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        
                                                       
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="pengisianKkbAction">Submit</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var tableKab;
                                            var tableDikunjungi;

                                            $('#submitKkb').click(function () {
                                                $('#tableKkb').show();
                                                $('#tableDikunjungi').show();
                                                if ($.fn.dataTable.isDataTable('#tableKkb')) {
                                                    tableKab.ajax.reload();
                                                } else {
                                                    tableKab = $('#tableKkb').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        ajax: {
                                                            url: "{{ route('getTableKkb') }}",
                                                            data: function (d) {
                                                                d.kelompok = $('#search-kkb-kelompok').val();
                                                                d.daterange = $('#search-daterange-kkb').val();
                                                            }
                                                        },
                                                        columns: [
                                                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                                            {data: 'kelompok_kb', name: 'kelompok_kb'},
                                                            {data: 'tanggal_kb', name: 'tanggal_kb'},
                                                            {data: 'kode_kb', name: 'kode_kb'},
                                                            {data: 'status', name: 'status'},
                                                            {data: 'action', name: 'action', orderable: false, searchable: false},
                                                        ]
                                                    });
                                                }

                                                if ($.fn.dataTable.isDataTable('#tableDikunjungi')) {
                                                    tableDikunjungi.ajax.reload();
                                                } else {
                                                    tableDikunjungi = $('#tableDikunjungi').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        ajax: {
                                                            url: "{{ route('getTableKkbDikunjungi') }}",
                                                            data: function (d) {
                                                                d.kelompok = $('#search-kkbDikunjungi-kelompok').val();
                                                                d.daterange = $('#search-daterange-kkb').val();
                                                            }
                                                        },
                                                        columns: [
                                                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                                            {data: 'kelompok_kb', name: 'kelompok_kb'},
                                                            {data: 'tanggal_kb', name: 'tanggal_kb'},
                                                            {data: 'kode_kb', name: 'kode_kb'},
                                                            {data: 'status', name: 'status'},
                                                            {data: 'action', name: 'action', orderable: false, searchable: false},
                                                        ]
                                                    });
                                                }
                                            });
                                            $('#searchKkb').click(function () {
                                                $('#tableKkb').DataTable().ajax.reload();
                                            });
                                            $('#searchkkbDikunjungi').click(function () {
                                                $('#tableDikunjungi').DataTable().ajax.reload();
                                            });

                                            $('#resetSearchKkb').click(function () {
                                                $('#search-kkb-kelompok').val('');
                                                if ($.fn.dataTable.isDataTable('#tableKkb')) {
                                                    $('#tableKkb').DataTable().ajax.reload();
                                                }
                                            });
                                            $('#resetSearchkkbDikunjungi').click(function () {
                                                $('#search-kkbDikunjungi-kelompok').val('');
                                                if ($.fn.dataTable.isDataTable('#tableDikunjungi')) {
                                                    $('#tableDikunjungi').DataTable().ajax.reload();
                                                }
                                            });
                                        });

                                        $('#pengisianKkbAction').click(function() {
                                            var formData = {
                                                id: $('#id_kb').val(),
                                                kelompok_kb: $('#kelompok_kb').val(),
                                                dikumpulkan_kb: $('#dikumpulkan_kb').val(),
                                                tanggal_dikumpulkan_kb: $('#tanggal_dikumpulkan_kb').val(),
                                                jumlah_dikumpulkan_kb: $('#jumlah_dikumpulkan_kb').val(),
                                                pembahasan_kb: $('#pembahasan_kb').val(),
                                                pembahasan_lainnya_kb: $('#pembahasan_lainnya_kb').val(),
                                                _token: '{{ csrf_token() }}' 
                                            };
                                            
                                            $.ajax({
                                                url: '{{ route('updatePengisianKb') }}',
                                                method: 'POST',
                                                data: formData,
                                                success: function(response) {
                                                    Swal.fire({
                                                        title: 'Success',
                                                        text: 'Data Berhasil Disimpan',
                                                        icon: 'success'
                                                    }).then(function() {
                                                        $('#dikumpulkan_kb').val('');
                                                        $('#tanggal_dikumpulkan_kb').val('');
                                                        $('#jumlah_dikumpulkan_kb').val('');
                                                        $('#pembahasan_kb').val('');
                                                        $('#pembahasan_lainnya_kb').val('');
                                                       


                                                        $('#modalEditKkb').modal('hide');
                                                        $('#tableKkb').DataTable().ajax.reload();
                                                        // location.reload();  
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    Swal.fire('Error', error, 'error');
                                                }
                                            });
                                        });

                                        $(document).ready(function () {
                                            $('body').on('click', '.btn-edit-kab', function () {
                                                var id = $(this).data('id'); 
                                                $.ajax({
                                                    url: '{{ route('getDetailKb', ['id' => '__id__']) }}'.replace('__id__', id),
                                                    method: 'GET',
                                                    success: function (response) {
                                                        $('#id_kb').val(response.id_kb);
                                                        $('#kelompok_kb').val(response.kelompok_kb);
                                                        $('#tanggal_kb').val(response.tanggal_kb);
                                                        $('#kode_kb').val(response.kode_kb);

                                                        $('#tanggal_dikumpulkan_kb').val(response.tanggal_dikumpulkan_kb);
                                                        $('#jumlah_dikumpulkan_kb').val(response.jumlah_dikumpulkan_kb);
                                                        $('#pembahasan_lainnya_kb').val(response.pembahasan_kb);
                                                        
                                                        fetchDikunjungi(response.dikumpulkan_kb);
                                                        fetchPembahasan(response.pembahasan_kb); 


                                                        $('#modalEditKkb').modal('show');
                                                    },
                                                    error: function () {
                                                        alert('Terjadi kesalahan saat mengambil data.');
                                                    }
                                                });
                                            });
                                          
                                            function fetchDikunjungi(dikunjungi) {
                                                var $select = $('#dikumpulkan_kb');
                                                var selected_0 = '';
                                                var selected_1 = '';
                                                var selected_2 = '';
                                                if (dikunjungi === '0') {
                                                    selected_0 = 'selected';
                                                }
                                                if (dikunjungi === '1') {
                                                    selected_1 = 'selected';
                                                }
                                                if (dikunjungi === '2') {
                                                    selected_2 = 'selected';
                                                }

                                                $select.empty();
                                                $select.append('<option value="">--Pilih Status---</option>');
                                                $select.append('<option value="0" ' + selected_0 + '>Belum</option>');
                                                $select.append('<option value="1" ' + selected_1 + '>Sudah</option>');
                                                $select.select2();
                                            }
                                            function fetchPembahasan(pembahasan) {
                                                var $select = $('#pembahasan_kb');
                                                var selected_0 = '';
                                                var selected_1 = '';
                                                var selected_2 = '';
                                                var selected_3 = '';
                                                var selected_4 = '';
                                                if (pembahasan === '1. Dalami masalah & Ingatkan aturan') {
                                                    selected_0 = 'selected';
                                                }
                                                if (pembahasan === '2. Semangati dan berikan solusi') {
                                                    selected_1 = 'selected';
                                                }
                                                if (pembahasan === '3. Buat surat peringatan pelunasan') {
                                                    selected_2 = 'selected';
                                                }
                                                if (pembahasan === '4. Akan pelunasan minggu depan') {
                                                    selected_3 = 'selected';
                                                }
                                                if (pembahasan === '5. Datangi yang belum kumpul') {
                                                    selected_4 = 'selected';
                                                }

                                                $select.empty();
                                                $select.append('<option value="">--Pilih Status---</option>');
                                                $select.append('<option value="1. Dalami masalah & Ingatkan aturan" ' + selected_0 + '>1. Dalami masalah & Ingatkan aturan</option>');
                                                $select.append('<option value="2. Semangati dan berikan solusi" ' + selected_1 + '>2. Semangati dan berikan solusi</option>');
                                                $select.append('<option value="3. Buat surat peringatan pelunasan" ' + selected_2 + '>3. Buat surat peringatan pelunasan</option>');
                                                $select.append('<option value="4. Akan pelunasan minggu depan" ' + selected_3 + '>4. Akan pelunasan minggu depan</option>');
                                                $select.append('<option value="5. Datangi yang belum kumpul" ' + selected_4 + '>5. Datangi yang belum kumpul</option>');
                                                $select.select2();
                                            }
                                            
                                            $('#formKabAction').on('click', function(e) {
                                                e.preventDefault(); 
                                                var jenis = $('#form-jenis-kab').val();
                                                var cabang = $('#form-cabang-kab').val();
                                                var tanggal = $('#form-tanggal-kab').val();
                                                var daterange = $('#search-daterange-kkb').val();
                                                if (!jenis) {
                                                    alert('Please select a jenis.');
                                                    return;
                                                }
                                
                                                var url = "{{ route('pdfFormKab') }}" + "?jenis=" + jenis + "&cabang=" + cabang + "&tanggal=" + tanggal + "&daterange=" + daterange;
                                                var link = document.createElement('a');
                                                link.href = url;
                                                link.target = "_blank"; 
                                                link.click();
                                            });
                                        });

                            
                                    </script>
									
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
        
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#search-daterange-kkb", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
		
        @include('layout.footer')