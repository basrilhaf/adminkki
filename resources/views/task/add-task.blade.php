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
												<a href="{{route('tasklist.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Nama Kegiatan</label>
                                                        <input type="text" id="add-task-nama" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Tanggal Kegiatan</label>
                                                        <input type="date" id="add-task-tanggal" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="card px-4 mb-4">
                                                        <div class="card-body">
                                                            <h2>Domisili Kegiatan</h2>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Provinsi Domisili</label>
                                                                    <select id="add-task-provinsi" class="form-control mb-2">
                                                                        <option value="">--Pilih Provinsi---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Kota/Kabupaten Domisili</label>
                                                                    <select id="add-task-kota" class="form-control mb-2">
                                                                        <option value="">--Pilih Kota/Kabupaten---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Kecamatan Domisili</label>
                                                                    <select id="add-task-kecamatan" class="form-control mb-2">
                                                                        <option value="">--Pilih Kecamatan---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Kelurahan Domisili</label>
                                                                    <select id="add-task-kelurahan" class="form-control mb-2">
                                                                        <option value="">--Pilih Kelurahan---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Surveyor</label>
                                                        <select id="add-task-surveyor" class="form-control mb-2">
                                                            <option value="">--Pilih Surveyor---</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Jenis Kegiatan</label>
                                                        <select id="add-task-jenis" class="form-control mb-2">
                                                            <option value="">--Pilih Jenis Kegiatan---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Objek</label>
                                                        <select id="add-task-objek" class="form-control mb-2">
                                                            <option value="">--Pilih Objek---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="card px-4 mb-4">
                                                        <div class="card-body" id="divPilihan">
                                                            <h2>Pertanyaan</h2>
                                                            <div class="col-md-6">
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Kode Pertanyaan</label>
                                                                    <select id="add-task-kode_pertanyaan" class="form-control mb-2">
                                                                        <option value="">--Pilih Kode Pertanyaan---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button id="addPertanyaan" class="btn btn-flex btn-warning h-40px fs-7 fw-bold mb-4"><i class="fa fa-plus"></i>Pertanyaan</button><br>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="addTaskAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"> <i class="fa fa-save"></i>SIMPAN DRAFT</button>
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
                $('#addTaskAction').click(function(e) {
                    e.preventDefault();
                    var nama = $('#add-task-nama').val();
                    var tanggal = $('#add-task-tanggal').val();
                    var kelurahan = $('#add-task-kelurahan').val();
                    var surveyor = $('#add-task-surveyor').val();
                    var jenis = $('#add-task-jenis').val();
                    var objek = $('#add-task-objek').val();
                    
                    var pertanyaan = [];
                    $('select[name="pertanyaan[]"]').each(function() {
                        pertanyaan.push($(this).val());
                    });
                    $.ajax({
                        url: "{{ route('addTaskAction') }}", 
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  
                            nama: nama,
                            tanggal: tanggal,
                            kelurahan: kelurahan,
                            surveyor: surveyor,
                            jenis: jenis,
                            objek: objek,
                            pertanyaan: pertanyaan
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data Berhasil Disimpan',
                                icon: 'success'
                            }).then(function() {
                                location.reload();  
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                        }
                    });
                });
            });


            $(document).ready(function() {
                var selectCounter = 0;
                $('#addPertanyaan').click(function () {
                    $('#addPertanyaan').hide();
                    var id_pertanyaan_group = $('#add-task-kode_pertanyaan').val();
                    var url = "{{ route('getPertanyaanTask', ':id_pertanyaan_group') }}";
                    url = url.replace(':id_pertanyaan_group', id_pertanyaan_group);
                    $.ajax({
                        url: url,  
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var selectId = 'select-pertanyaan-' + selectCounter++;
                            var rowId = 'row-' + selectCounter;
                            var newSelect = `<div class="row" id="${rowId}"><div class="col-md-1"><button class="btn btn-danger btn-sm deleteRow pt-2" data-row="${rowId}">HAPUS</button></div><div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control mb-2 select-pertanyaan" name="pertanyaan[]" id="${selectId}">
                                    <option value="">Pilih Pertanyaan</option>`;

                            data.forEach(function(item) {
                                newSelect += `<option value="${item.concat_id}">${item.pertanyaan}</option>`;
                            });
                            newSelect += `</select></div></div><div class="col-md-5"><div class="detailData" id="detailData-${selectCounter}"></div></div><hr></div>`;
                            $('#divPilihan').append(newSelect);
                            $('.select-pertanyaan').select2();

                            $('#' + selectId).on('change', function() {
                                var selectedValue = $(this).val();
                                var detailContainer = $('#detailData-' + selectCounter); 

                                fetchDetailData(selectedValue, detailContainer);
                                $('#addPertanyaan').show();
                            });

                            $('.deleteRow').on('click', function() {
                                var rowIdToDelete = $(this).data('row');
                                $('#' + rowIdToDelete).remove();
                                $('#addPertanyaan').show();
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching data: ', error);
                        }
                    });
                });

                function fetchDetailData(value, detailContainer) {
                    var splitValue = value.split("||");
                    var id = splitValue[0];
                    var jenis = splitValue[1];
                    $.ajax({
                        url: '{{ route('getPilihanPertanyaanTask') }}',  // Update with your server-side script URL
                        method: 'GET',
                        data: { id: id },
                        dataType: 'json',
                        success: function(data) {

                            if (jenis === 'F') {
                                detailHtml = `<input type="text" class="form-control" disabled value="Jawaban merupakan free text"></input>`;
                                detailHtml += `</ul>`;
                                detailContainer.html(detailHtml);
                            } else {
                                var detailHtml = `<p>Pilihan Jawaban:</p><ul>`;
                                data.forEach(function(item) {
                                    if (jenis === 'S') {
                                        detailHtml += `<input type="radio" id="radio_${item.id_pertanyaan_pilihan}" name="radio_pilihan" value="${item.id_pertanyaan_pilihan}">
                                                    <label for="radio_${item.id_pertanyaan_pilihan}">${item.pilihan}</label><br>`;
                                    } else if (jenis === 'M') {
                                        detailHtml += `<input type="checkbox" id="checkbox_${item.id_pertanyaan_pilihan}" name="checkbox_pilihan[]" value="${item.id_pertanyaan_pilihan}">
                                                    <label for="checkbox_${item.id_pertanyaan_pilihan}">${item.pilihan}</label><br>`;
                                    } else {
                                    }
                                });
                                detailHtml += `</ul>`;
                                detailContainer.html(detailHtml); 
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching detail data: ', error);
                        }
                    });
                }
            });
            
        
            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getProvinsi') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-task-provinsi');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.provinsi_kode + '">' + data.provinsi_nama + '</option>');
                        });
                        select.select2({
                            placeholder: "--Pilih Provinsi---",
                            allowClear: true
                        });
                        Swal.close();
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => { Swal.showLoading() }, allowOutsideClick: false });
                var selectProvinsi = $('#add-task-provinsi');
                var selectKota = $('#add-task-kota');
                selectProvinsi.select2({ placeholder: "--Pilih Provinsi---",allowClear: true });
                selectKota.select2({ placeholder: "--Pilih Kota/Kabupaten---", allowClear: true });

                selectProvinsi.on('change', function() {
                    var selectedProvinsi = $(this).val();
                    if (selectedProvinsi !== '') {
                        $.ajax({
                            url: "{{ route('getKotaByProvinsi') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: { provinsi_kode: selectedProvinsi },
                            success: function(data) {
                                selectKota.empty();
                                selectKota.append('<option value="">--Pilih Kota/Kabupaten---</option>');
                                data.forEach(function(data) {
                                    selectKota.append('<option value="' + data.kabkota_kode + '">' + data.kabkota_nama + '</option>');
                                });
                                selectKota.trigger('change');
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kota' });
                            }
                        });
                    } else {
                        selectKota.empty().trigger('change');
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => { Swal.showLoading() }, allowOutsideClick: false });
                var selectKota = $('#add-task-kota');
                var selectKecamatan = $('#add-task-kecamatan');
                selectKota.select2({ placeholder: "--Pilih Kota/Kabupaten---",allowClear: true });
                selectKecamatan.select2({ placeholder: "--Pilih Kecamatan---", allowClear: true });

                selectKota.on('change', function() {
                    var selectedKota = $(this).val();
                    if (selectedKota !== '') {
                        $.ajax({
                            url: "{{ route('getKecamatanByKota') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: { kabkota_kode: selectedKota },
                            success: function(data) {
                                selectKecamatan.empty();
                                selectKecamatan.append('<option value="">--Pilih Kecamatan---</option>');
                                data.forEach(function(data) {
                                    selectKecamatan.append('<option value="' + data.kecamatan_kode + '">' + data.kecamatan_nama + '</option>');
                                });
                                selectKecamatan.trigger('change');
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kota' });
                            }
                        });
                    } else {
                        selectKecamatan.empty().trigger('change');
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => { Swal.showLoading() }, allowOutsideClick: false });
                var selectKecamatan = $('#add-task-kecamatan');
                var selectKelurahan = $('#add-task-kelurahan');
                selectKecamatan.select2({ placeholder: "--Pilih Kecamatan---",allowClear: true });
                selectKelurahan.select2({ placeholder: "--Pilih kelurahan---", allowClear: true });

                selectKecamatan.on('change', function() {
                    var selectedKecamatan = $(this).val();
                    if (selectedKecamatan !== '') {
                        $.ajax({
                            url: "{{ route('getKelurahanByKecamatan') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: { kecamatan_kode: selectedKecamatan },
                            success: function(data) {
                                selectKelurahan.empty();
                                selectKelurahan.append('<option value="">--Pilih Kelurahan---</option>');
                                data.forEach(function(data) {
                                    selectKelurahan.append('<option value="' + data.kelurahan_kode + '">' + data.kelurahan_nama + '</option>');
                                });
                                selectKelurahan.trigger('change');
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kota' });
                            }
                        });
                    } else {
                        selectKelurahan.empty().trigger('change');
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => { Swal.showLoading() }, allowOutsideClick: false });
                var selectKelurahan = $('#add-task-kelurahan');
                var selectSurveyor = $('#add-task-surveyor');
                selectKelurahan.select2({ placeholder: "--Pilih Kelurahan---",allowClear: true });
                selectSurveyor.select2({ placeholder: "--Pilih Surveyor---", allowClear: true });

                selectKelurahan.on('change', function() {
                    var selectedKelurahan = $(this).val();
                    if (selectedKelurahan !== '') {
                        $.ajax({
                            url: "{{ route('getSurveyorByKelurahan') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: { kelurahan_kode: selectedKelurahan },
                            success: function(data) {
                                selectSurveyor.empty();
                                selectSurveyor.append('<option value="">--Pilih Kelurahan---</option>');
                                data.forEach(function(data) {
                                    selectSurveyor.append('<option value="' + data.id_user + '">' + data.nama + '</option>');
                                });
                                selectSurveyor.trigger('change');
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data surveyor' });
                            }
                        });
                    } else {
                        selectSurveyor.empty().trigger('change');
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $('#add-task-jenis').select2({ placeholder: "--Pilih Kegiatan---",allowClear: true });
                $.ajax({
                    url: "{{ route('getReffKegiatanTask') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-task-jenis');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.isi_kolom + '">' + data.keterangan + '</option>');
                        });
                    }
                });

                $('#add-task-kode_pertanyaan').select2({ placeholder: "--Pilih Kode Pertanyaan---",allowClear: true });
                $.ajax({
                    url: "{{ route('getGroupPertanyaanOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-task-kode_pertanyaan');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.id_pertanyaan_group + '">' + data.kode_group + '</option>');
                        });
                    }
                });
                Swal.close();

            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => { Swal.showLoading() }, allowOutsideClick: false });
                var selectKecamatan = $('#add-task-kecamatan');
                var selectObjek = $('#add-task-objek');
                selectKecamatan.select2({ placeholder: "--Pilih Kecamatan---",allowClear: true });
                selectObjek.select2({ placeholder: "--Pilih Objek---", allowClear: true });

                selectKecamatan.on('change', function() {
                    var selectedKecamatan = $(this).val();
                    if (selectedKecamatan !== '') {
                        $.ajax({
                            url: "{{ route('getObjekTask') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: { kecamatan_kode: selectedKecamatan },
                            success: function(data) {
                                selectObjek.empty();
                                selectObjek.append('<option value="">--Pilih Objek---</option>');
                                data.forEach(function(data) {
                                    selectObjek.append('<option value="' + data.id_wakaf + '">' + data.guna + ' - ' + data.status + '</option>');
                                });
                                selectKelurahan.trigger('change');
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kota' });
                            }
                        });
                    } else {
                        selectObjek.empty().trigger('change');
                    }
                });
                Swal.close();
            });

            

        </script>
		
        @include('layout.footer')