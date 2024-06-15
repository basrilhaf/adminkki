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
                                                <button style="display: none;" id="buttonPublishTask" class="btn btn-flex btn-success h-40px fs-7 fw-bold"> <i class="fa fa-save"></i> Publish</button>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <input type="hidden" id="detail-task-id" value="{{$id_task}}">
                                            <div class="row">
                                                <div class="alert alert-success text-center" role="alert" id="alert-publish" style="display: none;">
                                                    Published
                                                </div>
                                                <div class="alert alert-warning text-center" role="alert" id="alert-draft" style="display: none;">
                                                    Draft
                                                </div>
                                                <div class="card mb-4">
                                                    <h2 class="my-4">Data Task</h2>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Nama Kegiatan</label>
                                                                <input type="text" id="detail-task-nama" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Tanggal Kegiatan</label>
                                                                <input type="date" id="detail-task-tanggal" class="form-control mb-2">
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
                                                                            <select id="detail-task-provinsi" class="form-control mb-2">
                                                                                <option value="">--Pilih Provinsi---</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="mb-4 fv-row">
                                                                            <label class="required form-label">Kota/Kabupaten Domisili</label>
                                                                            <select id="detail-task-kota" class="form-control mb-2">
                                                                                <option value="">--Pilih Kota/Kabupaten---</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="mb-4 fv-row">
                                                                            <label class="required form-label">Kecamatan Domisili</label>
                                                                            <select id="detail-task-kecamatan" class="form-control mb-2">
                                                                                <option value="">--Pilih Kecamatan---</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="mb-4 fv-row">
                                                                            <label class="required form-label">Kelurahan Domisili</label>
                                                                            <select id="detail-task-kelurahan" class="form-control mb-2">
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
                                                                <select id="detail-task-surveyor" class="form-control mb-2">
                                                                    <option value="">--Pilih Surveyor---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Jenis Kegiatan</label>
                                                                <select id="detail-task-kegiatan" class="form-control mb-2">
                                                                    <option value="">--Pilih Jenis Kegiatan---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Objek</label>
                                                                <select id="detail-task-objek" class="form-control mb-2">
                                                                    <option value="">--Pilih Objek---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-12 mb-4 d-flex align-items-center gap-2 gap-lg-3">
                                                            <button id="updateTaskAction" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"> <i class="fa fa-save"></i> Update Task</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="card px-4 mb-4">
                                                        <div class="card-body" >
                                                            <h2>List Pertanyaan</h2>
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="tablePertanyaanTask">
                                                                <thead>
                                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                                        <th>No Urut</th>
                                                                        <th class="min-w-125px">Pertanyaan</th>
                                                                        <th>Pilihan Jawaban</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="card px-4 mb-4">
                                                        <div class="card-body" id="divPilihan">
                                                            <h2>Tambah Pertanyaan</h2>
                                                            <div class="col-md-6">
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Group Pertanyaan</label>
                                                                    <select id="detail-task-kode_pertanyaan" class="form-control mb-2">
                                                                        <option value="">--Pilih Group Pertanyaan---</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button id="addPertanyaan" class="btn btn-flex btn-primary h-40px fs-7 fw-bold mb-4"><i class="fa fa-plus"></i>Baris Pertanyaan</button><br>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button id="addTaskPertanyaanAction" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"> <i class="fa fa-save"></i> Tambah Pertanyaan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="modal fade modal-xl" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="detail-id_task_pertanyaan">
                        <input type="hidden" id="detail-pertanyaan_id">
                        <input type="hidden" id="detail-group_id">
                        
                        <div class="mb-4 fv-row">
                            <label class="required form-label">Pertanyaan saat ini:</label>
                            <input type="text" class="form-control" id="detail-task_pertanyaan">
                        </div>
                        <div class="mb-4 fv-row">
                            <label class="required form-label">Group pertanyaan saat ini:</label>
                            <input type="text" class="form-control" id="detail-kode_group">
                        </div> <hr>
                        <div class="mb-4 fv-row">
                            <label class="required form-label">Group Pertanyaan</label>
                            <select id="detail-task-kode_pertanyaan-modal" class="form-control mb-2">
                                {{-- <option value="">--Pilih Group Pertanyaan---</option> --}}
                            </select>
                        </div>
                        <div class="mb-4 fv-row">
                            <label class="required form-label">Pertanyaan baru:</label>
                            <select id="list-pertanyaan-baru" class="form-control">
                                <option value="">--Pilih Pertanyaan---</option>
                            </select>
                        </div>
                        <div class="mb-4 fv-row">
                            <button id="updateTaskPertanyaanAction" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"> <i class="fa fa-save"></i> Update Pertanyaan</button>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).on('click', '.close', function() {
                $('#detailModal').modal('hide');
            });


            $('#addTaskPertanyaanAction').click(function(e) {
                e.preventDefault();
                var task_id = $('#detail-task-id').val();
                    
                var pertanyaan = [];
                $('select[name="pertanyaan[]"]').each(function() {
                    pertanyaan.push($(this).val());
                });
                $.ajax({
                    url: "{{ route('addTaskPertanyaanAction') }}", 
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",  
                        task_id: task_id,
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

            var selectCounter = 0;
            $('#addPertanyaan').click(function () {
                $('#addPertanyaan').hide();
                var id_pertanyaan_group = $('#detail-task-kode_pertanyaan').val();
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
                        url: '{{ route('getPilihanPertanyaanTask') }}',  
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

            $(document).ready(function() {
                $('#detail-task-kode_pertanyaan-modal').on('change', function() {
                    var id_pertanyaan_group = $('#detail-task-kode_pertanyaan-modal').val();
                    var url = "{{ route('getPertanyaanTask', ':id_pertanyaan_group') }}";
                    url = url.replace(':id_pertanyaan_group', id_pertanyaan_group);
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(data) {
                            $('#list-pertanyaan-baru').empty();
                            $.each(data, function(index, item) {
                                $('#list-pertanyaan-baru').append('<option value="' + item.id_pertanyaan + '">' + item.pertanyaan + '</option>');
                            });
                            // fetchKodePertanyaanModal(id_pertanyaan_group);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
                
                $(document).on('click', '.btn-view-detail', function() {
                    var id_task_pertanyaan = $(this).data('id');
                    var split_id = id_task_pertanyaan.split("|||");
                    var group_id = split_id[1];
                    var url = "{{ route('task.showDetailTaskPertanyaan', ':id_task_pertanyaan') }}";
                    url = url.replace(':id_task_pertanyaan', id_task_pertanyaan);
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {

                            $('#detail-task_pertanyaan').val(response.pertanyaan).prop('disabled', true);
                            $('#detail-id_task_pertanyaan').val(response.id_task_pertanyaan);
                            $('#detail-pertanyaan_id').val(response.pertanyaan_id);
                            $('#detail-kode_group').val(response.kode_group).prop('disabled', true);
                            $('#detail-group_id').val(group_id);

                            
                            fetchKodePertanyaanModal(response);
                            $('#detailModal').modal('show');

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });


                });

                function fetchKodePertanyaanModal(id_pertanyaan_group) {
                    var kodeUrl = "{{ route('getGroupPertanyaanOption') }}";
                    $.ajax({
                        url: kodeUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-task-kode_pertanyaan-modal');
                            $select.empty();
                            $select.append('<option value="">--Pilih group pertanyaan---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                
                                $select.append('<option value="' + data.id_pertanyaan_group + '" ' + selected + '>' + data.kode_group + '</option>'); 
                            });
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching kegiatan data');
                        }
                    });
                }


                $('#updateTaskAction').click(function(e) {
                    e.preventDefault();
                    var id_task = $('#detail-task-id').val();
                    var nama = $('#detail-task-nama').val();
                    var tanggal = $('#detail-task-tanggal').val();
                    var kelurahan = $('#detail-task-kelurahan').val();
                    var surveyor = $('#detail-task-surveyor').val();
                    var jenis = $('#detail-task-kegiatan').val();
                    var objek = $('#detail-task-objek').val();
                    
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin ingin mengubah data task ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('editTaskAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}", 
                                    nama: nama,
                                    tanggal: tanggal,
                                    kelurahan: kelurahan,
                                    surveyor: surveyor,
                                    jenis: jenis,
                                    objek: objek, 
                                    id_task: id_task
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
                        }
                    });
                });

                $('#updateTaskPertanyaanAction').click(function(e) {
                    e.preventDefault();
                    var id_task_pertanyaan = $('#detail-id_task_pertanyaan').val();
                    var pertanyaan_baru = $('#list-pertanyaan-baru').val();
                    
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin ingin mengubah data pertanyaan task ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('editTaskPertanyaanAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}", 
                                    id_task_pertanyaan: id_task_pertanyaan,
                                    pertanyaan_baru: pertanyaan_baru
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
                        }
                    });
                });
            });


            $(document).ready(function() {
                var id_task = $('#detail-task-id').val();
                var url = "{{ route('task.showDetailTask', ':id_task') }}";
                url = url.replace(':id_task', id_task);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-task-nama').val(response.nama_task);
                        $('#detail-task-tanggal').val(response.tanggal_task);
                        $('#detail-task-surveyor').val(response.surveyor);
                        $('#detail-task-kelurahan').val(response.kelurahan_nama);
                        $('#detail-task-kecamatan').val(response.kecamatan_nama);
                        $('#detail-task-kota').val(response.kabkota_nama);
                        $('#detail-task-provinsi').val(response.provinsi_nama);
                        $('#detail-task-kegiatan').val(response.kegiatan);
                        $('#detail-task-objek').val(response.objek);
                        
                        if (response.publish_task === 'Y') {
                            $('#buttonPublishTask').hide();
                            $('#alert-publish').show();
                            $('#alert-draft').hide();
                        } else {
                            $('#buttonPublishTask').show();
                            $('#alert-publish').hide();
                            $('#alert-draft').show();
                        }
                        $('#detail-task-kegiatan').val(response.kegiatan_task);
                        fetchKegiatan(response);
                        $('#detail-task-provinsi').val(response.provinsi_kode);
                        fetchProvinsi(response);
                        $('#detail-task-kota').val(response.kabkota_kode);
                        fetchKota(response.provinsi_kode,response.kabkota_kode);
                        $('#detail-task-kecamatan').val(response.kecamatan_kode);
                        fetchKecamatan(response.kabkota_kode,response.kecamatan_kode);
                        $('#detail-task-kelurahan').val(response.kelurahan_kode);
                        fetchKelurahan(response.kecamatan_kode,response.kelurahan_kode);
                        $('#detail-task-surveyor').val(response.user_id);
                        fetchSurveyor(response.kelurahan_kode,response.user_id);

                        var wakaf_id = response.wakaf_id;
                        $('#detail-task-objek').val(wakaf_id); // Set value first
                        fetchObject(response.kecamatan_kode, wakaf_id);
                        
                        fetchKodePertanyaan(response);
                        

                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            $('#dataDetail').html('<p>Data not found</p>');
                        } else {
                            $('#dataDetail').html('<p>An error occurred</p>');
                        }
                    }
                });
                $('#detail-task-provinsi').on('change', function() {
                    var selectedProvinsi = $(this).val();
                    var kabkota_kode = '';
                    $('#detail-task-kecamatan').empty().append('<option value="">--Pilih Kecamatan---</option>');
                    $('#detail-task-kelurahan').empty().append('<option value="">--Pilih Kelurahan---</option>');
                    fetchKota(selectedProvinsi,kabkota_kode);
                });
                $('#detail-task-kota').on('change', function() {
                    var selectedKota = $(this).val();
                    var kecamatan_kode = '';
                    $('#detail-task-kelurahan').empty().append('<option value="">--Pilih Kelurahan---</option>');
                    fetchKecamatan(selectedKota,kecamatan_kode);
                });
                $('#detail-task-kecamatan').on('change', function() {
                    var selectedKecamatan = $(this).val();
                    var kelurahan_kode = '';
                    var wakaf_id = '';
                    fetchObject(selectedKecamatan,wakaf_id);
                    fetchKelurahan(selectedKecamatan,kelurahan_kode);
                });
                $('#detail-task-kelurahan').on('change', function() {
                    var selectedKelurahan = $(this).val();
                    var user_id = '';
                    fetchSurveyor(selectedKelurahan,user_id);
                });


                function fetchProvinsi(response) {
                    var provinsiUrl = "{{ route('getProvinsi') }}";
                    $.ajax({
                        url: provinsiUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-task-provinsi');
                            $select.empty();
                            $select.append('<option value="">--Pilih Provinsi---</option>');
                            data.forEach(function(dataProvinsi) {
                                var selected = '';
                                if (dataProvinsi.provinsi_kode === response.provinsi_kode) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataProvinsi.provinsi_kode + '" ' + selected + '>' + dataProvinsi.provinsi_nama + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Provinsi data');
                        }
                    });
                }

                function fetchKodePertanyaan(response) {
                    var kodeUrl = "{{ route('getGroupPertanyaanOption') }}";
                    $.ajax({
                        url: kodeUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-task-kode_pertanyaan');
                            $select.empty();
                            $select.append('<option value="">--Pilih group pertanyaan---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                
                                $select.append('<option value="' + data.id_pertanyaan_group + '" ' + selected + '>' + data.kode_group + '</option>'); 
                            });
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching kegiatan data');
                        }
                    });
                }


                function fetchKota(selectedProvinsi,kabkota_kode) {
                    var kotaUrl = "{{ route('getKotaByProvinsi') }}";
                    $.ajax({
                        url: kotaUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { provinsi_kode: selectedProvinsi },
                        success: function(data) {
                            var $select = $('#detail-task-kota');
                            $select.empty();
                            $select.append('<option value="">--Pilih Kota---</option>');
                            data.forEach(function(dataKota) {
                                var selected = '';
                                if (dataKota.kabkota_kode === kabkota_kode) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataKota.kabkota_kode + '" ' + selected + '>' + dataKota.kabkota_nama + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Kabupaten/kota data');
                        }
                    });
                }

                function fetchKecamatan(selectedkota,kecamatan_kode) {
                    var kecamatanUrl = "{{ route('getKecamatanByKota') }}";
                    $.ajax({
                        url: kecamatanUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { kabkota_kode: selectedkota },
                        success: function(data) {
                            var $select = $('#detail-task-kecamatan');
                            $select.empty();
                            $select.append('<option value="">--Pilih Kecamatan---</option>');
                            data.forEach(function(dataKecamatan) {
                                var selected = '';
                                if (dataKecamatan.kecamatan_kode === kecamatan_kode) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataKecamatan.kecamatan_kode + '" ' + selected + '>' + dataKecamatan.kecamatan_nama + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Kecamatan data');
                        }
                    });
                }

                function fetchKelurahan(selectedKecamatan,kelurahan_kode) {
                    var kelurahanUrl = "{{ route('getKelurahanByKecamatan') }}";
                    $.ajax({
                        url: kelurahanUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { kecamatan_kode: selectedKecamatan },
                        success: function(data) {
                            var $select = $('#detail-task-kelurahan');
                            $select.empty();
                            $select.append('<option value="">--Pilih Kelurahan---</option>');
                            data.forEach(function(dataKelurahan) {
                                var selected = '';
                                if (dataKelurahan.kelurahan_kode === kelurahan_kode) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataKelurahan.kelurahan_kode + '" ' + selected + '>' + dataKelurahan.kelurahan_nama + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Kelurahan data');
                        }
                    });
                }

                function fetchSurveyor(selectedKelurahan,user_id) {
                    var surveyorUrl = "{{ route('getSurveyorByKelurahan') }}";
                    $.ajax({
                        url: surveyorUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { kelurahan_kode: selectedKelurahan },
                        success: function(data) {
                            var $select = $('#detail-task-surveyor');
                            $select.empty();
                            $select.append('<option value="">--Pilih Surveyor---</option>');
                            data.forEach(function(dataSurveyor) {
                                var selected = '';
                                if (dataSurveyor.id_user === user_id) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataSurveyor.id_user + '" ' + selected + '>' + dataSurveyor.nama + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Surveyor data');
                        }
                    });
                }

                function fetchObject(selectedKecamatan,wakaf_id) {
                    // alert(wakaf_id);
                    var objectUrl = "{{ route('getObjekTask') }}";
                    $.ajax({
                        url: objectUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { kecamatan_kode: selectedKecamatan },
                        success: function(data) {
                            var $select = $('#detail-task-objek');
                            $select.empty();
                            $select.append('<option value="">--Pilih Objek---</option>');
                            data.forEach(function(dataObjek) {
                                var selected = '';
                                if (dataObjek.id_wakaf === wakaf_id) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataObjek.id_wakaf + '" ' + selected + '>' + dataObjek.guna + ' - ' + dataObjek.status + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Objek data');
                        }
                    });
                }

                function fetchKegiatan(response) {
                    var KegiatanUrl = "{{ route('getReffKegiatanTask') }}";
                    $.ajax({
                        url: KegiatanUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-task-kegiatan');
                            $select.empty();
                            $select.append('<option value="">--Pilih kegiatan---</option>');
                            data.forEach(function(dataKegiatan) {
                                var selected = '';
                                if (dataKegiatan.isi_kolom === response.kegiatan_task) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataKegiatan.isi_kolom + '" ' + selected + '>' + dataKegiatan.keterangan + '</option>'); // Adjust based on your object properties
                            });
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching kegiatan data');
                        }
                    });
                }

                

            });

            $(document).ready(function () {
                var id_task = $('#detail-task-id').val();
                var url = "{{ route('task.detailTaskPertanyaan', ':id_task') }}";
                url = url.replace(':id_task', id_task);
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $('#tablePertanyaanTask').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
                        type: 'GET'
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'pertanyaan', name: 'pertanyaan'},
                        {data: 'list_pilihan_field', name: 'list_pilihan_field', orderable: false, searchable: false},
                        {data: 'view_detail', name: 'view_detail', orderable: false, searchable: false},
                    ],
                    drawCallback: function() {
                        // Reinitialize Select2 on draw
                        $('.select2').select2();
                    }
                });
                $('.select2').select2();
                Swal.close();
               
            });

            $(document).on('click', '.btn-delete', function() {
                var taskId = $(this).data('id');
                Swal.fire({
                    title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data pertanyaan ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, lakukan AJAX request
                        $.ajax({
                            url: "{{ route('deleteTaskPertanyaanAction') }}", 
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",  
                                id_task_pertanyaan: taskId
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


        $(document).ready(function() {
            $('#buttonPublishTask').click(function(e) {
                e.preventDefault();
                var id_task = $('#detail-task-id').val();
                // alert(id_task);
                // Menampilkan alert konfirmasi
                Swal.fire({
                    title: 'Konfirmasi', text: 'Apakah Anda yakin ingin mempublikasikan task ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, lakukan AJAX request
                        $.ajax({
                            url: "{{ route('publishTaskAction') }}", 
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",  
                                id_task: id_task
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
                    }
                });
            });
        });

    </script>
		
        @include('layout.footer')