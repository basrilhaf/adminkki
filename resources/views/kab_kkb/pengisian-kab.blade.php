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
                                                                <input type="text" id="search-daterange-kab" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button id="submitKab" class="btn btn-primary rounded mt-4">Submit</button>
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
                                                                    <option value="KAB">KAB</option>
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
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kab-anggota" placeholder="Nama role" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kab-kelompok" placeholder="Nama role" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchKab" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchKab" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="card">
										<div class="card-header">
                                            <h2 class="mt-4">Anggota Bermasalah</h2>
                                        </div>
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableKab" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>Anggota</th>
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
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA ANGGOTA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kabDikunjungi-anggota" placeholder="Nama Anggota" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NAMA KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kabDikunjungi-kelompok" placeholder="Nama Kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchkabDikunjungi" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchkabDikunjungi" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
                                        <div class="card-header">
                                            <h2 class="mt-4">Anggota Sudah Dikunjungi</h2>
                                        </div>
                                        <div class="card-body py-4">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableDikunjungi" style="display: none;">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>Anggota</th>
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
                                    <div class="modal fade" id="modalEditKab" tabindex="-1" aria-labelledby="modalEditKabLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditKabLabel">Detail Anggota Bermasalah</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="formEditUser">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="hidden" id="id_ab">
                                                                <div class="mb-3">
                                                                    <label for="nama_ab" class="form-label">Nama AB</label>
                                                                    <input type="text" class="form-control" id="nama_ab" name="nama_ab" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="kelompok_ab" class="form-label">Kelompok AB</label>
                                                                    <input type="text" class="form-control" id="kelompok_ab" name="kelompok_ab" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="kelompok_ab" class="form-label">Sudah Dikunjungi?:</label>
                                                                    <select class="form-control" id="dikunjungi_ab"></select>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div id="sudah_dikunjungi" style="display: none;">
                                                                <div class="col-md-12" >
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_kunjungan_ab" class="form-label">Tanggal kunjungan Terakhir::</label>
                                                                        <input type="date" class="form-control" id="tanggal_dikunjungi_ab" placeholder="Enter additional details...">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="kelompok_ab" class="form-label">Apakah Bertemu Ibunya?:</label>
                                                                        <select class="form-control" id="bertemu_ibu_ab"></select>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="himbauan_ab" class="form-label">Hasil Edukasi::</label>
                                                                        <select class="form-control" id="himbauan_ab" multiple></select>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label>Isi lainnya dibawah ini: <span class="text-danger" style="font-size:12px;">(sertakan no "6." diawal, cth: 6. isi lainnya)</span></label>
                                                                        <textarea id="himbauan_ab2" class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Hasil pilihan himbauan:</label>
                                                                        <textarea disabled id="himbauan_hasil" class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="kelompok_ab" class="form-label">Penyebab Tanggung renteng:</label>
                                                                    <select class="form-control" id="penyebab_ab"></select>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" id="penyebab_lainnya_div" style="display: none;">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Isi lainnya dibawah ini: <span class="text-danger" style="font-size:12px;">(sertakan no "8." diawal, cth: 8. isi lainnya)</span></label>
                                                                    <textarea id="penyebab_ab2" class="form-control" cols="30" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div id="kabur_div" style="display: none;">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="kelompok_ab" class="form-label">Setoran Lancar?</label>
                                                                        <select class="form-control" id="setoran_lancar"></select>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="kelompok_ab" class="form-label">KC sudah kumpul awal?</label>
                                                                        <select class="form-control" id="motivasi"></select>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                       
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="pengisianKabAction">Submit</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        
                                    </script>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var tableKab;
                                            var tableDikunjungi;

                                            $('#submitKab').click(function () {
                                                $('#tableKab').show();
                                                $('#tableDikunjungi').show();
                                                if ($.fn.dataTable.isDataTable('#tableKab')) {
                                                    tableKab.ajax.reload();
                                                } else {
                                                    tableKab = $('#tableKab').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        ajax: {
                                                            url: "{{ route('getTableKab') }}",
                                                            data: function (d) {
                                                                d.anggota = $('#search-kab-anggota').val();
                                                                d.kelompok = $('#search-kab-kelompok').val();
                                                                d.daterange = $('#search-daterange-kab').val();
                                                            }
                                                        },
                                                        columns: [
                                                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                                            {data: 'nama_ab', name: 'nama_ab'},
                                                            {data: 'kelompok_ab', name: 'kelompok_ab'},
                                                            {data: 'tanggal_ab', name: 'tanggal_ab'},
                                                            {data: 'kode_ab', name: 'kode_ab'},
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
                                                            url: "{{ route('getTableKabDikunjungi') }}",
                                                            data: function (d) {
                                                                d.anggota = $('#search-kabDikunjungi-anggota').val();
                                                                d.kelompok = $('#search-kabDikunjungi-kelompok').val();
                                                                d.daterange = $('#search-daterange-kab').val();
                                                            }
                                                        },
                                                        columns: [
                                                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                                            {data: 'nama_ab', name: 'nama_ab'},
                                                            {data: 'kelompok_ab', name: 'kelompok_ab'},
                                                            {data: 'tanggal_ab', name: 'tanggal_ab'},
                                                            {data: 'kode_ab', name: 'kode_ab'},
                                                            {data: 'status', name: 'status'},
                                                            {data: 'action', name: 'action', orderable: false, searchable: false},
                                                        ]
                                                    });
                                                }
                                            });
                                            $('#searchkabDikunjungi').click(function () {
                                                $('#tablekabDikunjungi').DataTable().ajax.reload();
                                            });

                                            $('#resetSearchkabDikunjungi').click(function () {
                                                $('#search-kabDikunjungi-anggota').val('');
                                                $('#search-kabDikunjungi-kelompok').val('');
                                                if ($.fn.dataTable.isDataTable('#tableDikunjungi')) {
                                                    $('#tableDikunjungi').DataTable().ajax.reload();
                                                }
                                            });
                                        });

                                        $('#pengisianKabAction').click(function() {

                                            var formData = {
                                                id: $('#id_ab').val(),
                                                nama_ab: $('#nama_ab').val(),
                                                kelompok_ab: $('#kelompok_ab').val(),
                                                dikunjungi_ab: $('#dikunjungi_ab').val(),
                                                tanggal_dikunjungi_ab: $('#tanggal_dikunjungi_ab').val(),
                                                bertemu_ibu_ab: $('#bertemu_ibu_ab').val(),
                                                himbauan_ab: $('#himbauan_ab').val(), // Example: if you're using a multiple select or text fields
                                                himbauan_ab2: $('#himbauan_ab2').val(),
                                                penyebab_ab: $('#penyebab_ab').val(),
                                                penyebab_ab2: $('#penyebab_ab2').val(),
                                                setoran_lancar: $('#setoran_lancar').val(),
                                                motivasi: $('#motivasi').val(),
                                                _token: '{{ csrf_token() }}' // CSRF Token for security
                                            };
                                            // alert(formData);

                                            // Send AJAX request to update data
                                            $.ajax({
                                                url: '{{ route('updatePengisianAb') }}',
                                                method: 'POST',
                                                data: formData,
                                                success: function(response) {
                                                    Swal.fire({
                                                        title: 'Success',
                                                        text: 'Data Berhasil Disimpan',
                                                        icon: 'success'
                                                    }).then(function() {
                                                        $('#dikunjungi_ab').val('');
                                                        $('#tanggal_dikunjungi_ab').val('');
                                                        $('#bertemu_ibu_ab').val('');
                                                        $('#himbauan_ab').val('');
                                                        $('#himbauan_ab2').val('');
                                                        $('#penyebab_ab').val('');
                                                        $('#penyebab_ab2').val('');
                                                        $('#setoran_lancar').val('');
                                                        $('#setoran_lancar').val('');
                                                        $('#kabur_div').hide();
                                                        $('#sudah_dikunjungi').hide();
                                                        $('#penyebab_lainnya_div').hide();


                                                        $('#modalEditKab').modal('hide');
                                                        $('#tableKab').DataTable().ajax.reload();
                                                        // location.reload();  
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                                                }
                                            });
                                        });

                                        $(document).ready(function () {
                                            $('#sudah_dikunjungi').hide();
                                            $('body').on('click', '.btn-edit-kab', function () {
                                                var id = $(this).data('id'); 
                                                $.ajax({
                                                    url: '{{ route('getDetailAb', ['id' => '__id__']) }}'.replace('__id__', id),
                                                    method: 'GET',
                                                    success: function (response) {
                                                        $('#id_ab').val(response.id_ab);
                                                        $('#nama_ab').val(response.nama_ab);
                                                        $('#kelompok_ab').val(response.kelompok_ab);
                                                        $('#tanggal_ab').val(response.tanggal_ab);
                                                        $('#kode_ab').val(response.kode_ab);
                                                        $('#status').val(response.status);
                                                        $('#dikunjungi_ab').val(response.dikunjungi_ab);
                                                        $('#himbauan_hasil').val(response.himbauan_ab);
                                                        fetchDikunjungi(response.dikunjungi_ab);
                                                        $('#penyebab_ab').val(response.penyebab_ab);
                                                        fetchPenyebab(response.penyebab_ab); 
                                                        $('#bertemu_ibu_ab').val(response.bertemu_ibu_ab);
                                                        fetchBertemuIbu(response.bertemu_ibu_ab); 
                                                        $('#himbauan_ab').val(response.himbauan_ab);
                                                        fetchHimbauan(response.himbauan_ab);
                                                        $('#setoran_lancar').val(response.setoran_lancar_ab);
                                                        fetchSetoranLancar(response.setoran_lancar_ab); 
                                                        $('#motivasi').val(response.motivasi_kc_ab);
                                                        fetchMotivasi(response.motivasi_kc_ab); 
                                                        
                                                        

                                                        $('#modalEditKab').modal('show');
                                                    },
                                                    error: function () {
                                                        alert('Terjadi kesalahan saat mengambil data.');
                                                    }
                                                });
                                            });

                                            $('#dikunjungi_ab').change(function() {
                                                if ($(this).val() == '11') {
                                                    $('#sudah_dikunjungi').show();
                                                } else {
                                                    $('#sudah_dikunjungi').hide();
                                                }
                                            });
                                            $('#penyebab_ab').change(function() {
                                                if ($(this).val() == 'Kabur') {
                                                    $('#kabur_div').show();
                                                } else {
                                                    $('#kabur_div').hide();
                                                }
                                                if ($(this).val() == 'lainnya') {
                                                    $('#penyebab_lainnya_div').show();
                                                } else {
                                                    $('#penyebab_lainnya_div').hide();
                                                }
                                                
                                            });

                                            function fetchHimbauan(himbauan_ab) {
                                                var $select = $('#himbauan_ab');
                                                $select.empty();
                                                $select.append('<option value="">--Pilih Himbauan---</option>');
                                                $select.append('<option value="1. Tanya Kenapa DTR & Ingatkan aturan">1. Tanya Kenapa DTR & Ingatkan aturan</option>');
                                                $select.append('<option value="2. Semangati & berikan solusi">2. Semangati & berikan solusi</option>');
                                                $select.append('<option value="3. Buat surat peringatan pelunasan">3. Buat surat peringatan pelunasan</option>');
                                                $select.append('<option value="4. Akan pelunasan segera">4. Akan pelunasan segera</option>');
                                                $select.append('<option value="5. FU penganggung jawab/keluarga">5. FU penganggung jawab/keluarga</option>');
                                                $select.select2();
                                            }
                                            
                                            function fetchSetoranLancar(setoran_lancar_ab) {
                                                var $select = $('#setoran_lancar');
                                                var selected_0 = '';
                                                var selected_1 = '';
                                                var selected_2 = '';
                                                if (setoran_lancar_ab === 'Lancar') {
                                                    selected_0 = 'selected';
                                                }
                                                if (setoran_lancar_ab === 'Telat') {
                                                    selected_1 = 'selected';
                                                }
                                                if (setoran_lancar_ab === 'Berat') {
                                                    selected_2 = 'selected';
                                                }
                                                
                                                $select.empty();
                                                $select.append('<option value="">--Pilih Status Setoran---</option>');
                                                $select.append('<option value="Lancar" ' + selected_0 + '>Lancar</option>');
                                                $select.append('<option value="Telat" ' + selected_1 + '>Telat</option>');
                                                $select.append('<option value="Berat" ' + selected_2 + '>Berat</option>');
                                                $select.select2();
                                            }
                                            function fetchMotivasi(motivasi_kc_ab) {
                                                var $select = $('#motivasi');
                                                var selected_0 = '';
                                                var selected_1 = '';
                                                if (motivasi_kc_ab === '0') {
                                                    selected_0 = 'selected';
                                                }
                                                if (motivasi_kc_ab === '1') {
                                                    selected_1 = 'selected';
                                                }
                                                
                                                $select.empty();
                                                $select.append('<option value="">--Pilih Status Motivasi---</option>');
                                                $select.append('<option value="0" ' + selected_0 + '>Belum</option>');
                                                $select.append('<option value="1" ' + selected_1 + '>Sudah</option>');
                                                $select.select2();
                                            }
                                            function fetchBertemuIbu(bertemu_ibu_ab) {
                                                var $select = $('#bertemu_ibu_ab');
                                                var selected_0 = '';
                                                var selected_1 = '';
                                                if (bertemu_ibu_ab === '0') {
                                                    selected_0 = 'selected';
                                                }
                                                if (bertemu_ibu_ab === '1') {
                                                    selected_1 = 'selected';
                                                }
                                                

                                                $select.empty();
                                                $select.append('<option value="">--Pilih Status---</option>');
                                                $select.append('<option value="0" ' + selected_0 + '>Tidak</option>');
                                                $select.append('<option value="1" ' + selected_1 + '>Ya</option>');
                                                $select.select2();
                                            }
                                            function fetchDikunjungi(dikunjungi) {
                                                var $select = $('#dikunjungi_ab');
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
                                                $select.append('<option value="11" ' + selected_1 + '>Sudah</option>');
                                                $select.append('<option value="22" ' + selected_2 + '>Tidak Bisa Dikunjungi</option>');
                                                $select.select2();
                                            }
                                            function fetchPenyebab(penyebab) {
                                                var $select = $('#penyebab_ab');
                                                var selected_Kabur = '';
                                                var selected_skt = '';
                                                var selected_kel_skt = ''; // Fixed variable name
                                                var selected_Pulkam = '';
                                                var selected_pindah = '';
                                                var selected_usaha = '';
                                                var selected_blm = '';
                                                var selected_lainnya = '';

                                                // Set the selected option based on the value
                                                if (penyebab === 'Kabur') {
                                                    selected_Kabur = 'selected';
                                                }
                                                if (penyebab === 'skt') {
                                                    selected_skt = 'selected';
                                                }
                                                if (penyebab === 'kel-skt') {
                                                    selected_kel_skt = 'selected'; // Fixed variable name
                                                }
                                                if (penyebab === 'Pulkam') {
                                                    selected_Pulkam = 'selected';
                                                }
                                                if (penyebab === 'pindah') {
                                                    selected_pindah = 'selected';
                                                }
                                                if (penyebab === 'usaha') {
                                                    selected_usaha = 'selected';
                                                }
                                                if (penyebab === 'blm') {
                                                    selected_blm = 'selected';
                                                }
                                                if (penyebab === 'lainnya') {
                                                    selected_lainnya = 'selected';
                                                }

                                                $select.empty();
                                                $select.append('<option value="">--Pilih Penyebab---</option>');
                                                $select.append('<option value="Kabur" ' + selected_Kabur + '>1. Kabur</option>');
                                                $select.append('<option value="skt" ' + selected_skt + '>2. Ibu tsb sakit</option>');
                                                $select.append('<option value="kel-skt" ' + selected_kel_skt + '>3. Keluarga ibu sakit</option>');
                                                $select.append('<option value="Pulkam" ' + selected_Pulkam + '>4. Pulkam</option>');
                                                $select.append('<option value="pindah" ' + selected_pindah + '>5. Pindah rumah</option>');
                                                $select.append('<option value="usaha" ' + selected_usaha + '>6. Usaha tidak jalan / sepi</option>');
                                                $select.append('<option value="blm" ' + selected_blm + '>7. Belum ada penjelasan</option>');
                                                $select.append('<option value="lainnya" ' + selected_lainnya + '>8. Lainnya</option>');

                                                $select.select2();
                                            }
                                        });

                                        $('#formKabAction').on('click', function(e) {
                                            e.preventDefault(); 
                                            var jenis = $('#form-jenis-kab').val();
                                            var cabang = $('#form-cabang-kab').val();
                                            var tanggal = $('#form-tanggal-kab').val();
                                            var daterange = $('#search-daterange-kab').val();
                                            if (!jenis || !daterange) {
                                                alert('Jenis dan rentan tanggal tidak boleh kosong.');
                                                return;
                                            }
                            
                                            var url = "{{ route('pdfFormKab') }}" + "?jenis=" + jenis + "&cabang=" + cabang + "&tanggal=" + tanggal + "&daterange=" + daterange;
                                            var link = document.createElement('a');
                                            link.href = url;
                                            link.target = "_blank"; 
                                            link.click();
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
            flatpickr("#search-daterange-kab", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
		
        @include('layout.footer')