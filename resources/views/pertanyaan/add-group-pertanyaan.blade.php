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
											<div class="d-flex align-items-center gap-2 gap-lg-3">
                                                <a href="{{route('pertanyaan.index')}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"><span class="fa fa-rotate px-2"> </span>Kembali</a>
                                                
											</div>
										</div>
									</div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label class="form-label fs-6 fw-bold">Group:</label>
                                                            <div class="d-flex align-items-center position-relative my-1">
                                                                <input type="text" class="form-control form-control-solid ps-13" id="search-group-group" placeholder="Group" />
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 mt-9">
                                                            <button id="searchGroup" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                            <button id="resetSearchGroup" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                        </div>
                                                    </div>                                            
                                                </div>
                                            </div>
                                            <div class="card">
                                                
                                                <!--begin::Card body-->
                                                <div class="card-body py-4">
                                                    <!--begin::Table-->
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="groupTable">
                                                        <thead>
                                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                                <th>No</th>
                                                                <th class="min-w-125px">Group</th>
                                                                <th class="min-w-125px">Status</th>
                                                                <th class="min-w-125px">Keterangan</th>
                                                                <th class="min-w-100px">Actions</th>
                                                            </tr>
                                                        </thead>
                                                    
                                                    </table>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        
                                                        <div class="mb-4 fv-row">
                                                            <label class="required form-label">Kode Group</label>
                                                            <input type="text" class="form-control mb-2" id="add-group-kode">
                                                        </div>
                                                        <div class="mb-4 fv-row">
                                                            <label class="required form-label">Keterangan</label>
                                                            <textarea name="" id="add-group-keterangan" cols="10" rows="2" class="form-control mb-2"></textarea>
                                                        </div>
                                                        <div class="mb-4 fv-row">
                                                            <label class="required form-label">Status</label>
                                                            <select id="add-group-status" class="form-control mb-2">
                                                                <option value="">--Pilih Status---</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mt-9">
                                                            <button id="addGroupPertanyaanAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<!--begin::Card-->
									<!--end::Card-->
								</div>
                                <div class="modal fade modal-xl" id="detailModalGroup" tabindex="-1" role="dialog" aria-labelledby="detailModalGroupLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel">Detail Data</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" id="edit-group-pertanyaan_group_id">
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Kode Group:</label>
                                                    <input type="text" class="form-control" id="edit-group-kode">
                                                </div> 
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Keterangan:</label>
                                                    <textarea id="edit-group-keterangan" class="form-control" cols="30" rows="10"></textarea>
                                                </div> 
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Status:</label>
                                                    <select id="edit-group-status" class="form-control">
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-4 fv-row">
                                                    <button id="updateGroupPertanyaanAction" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"> <i class="fa fa-save"></i> Update Group</button>
                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
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
            $(document).ready(function () {
                $('#updateGroupPertanyaanAction').click(function(e) {
                    e.preventDefault();
                    
                    var id_pertanyaan_group = $('#edit-group-pertanyaan_group_id').val();
                    var kode_group = $('#edit-group-kode').val();
                    var keterangan = $('#edit-group-keterangan').val();
                    var status_group = $('#edit-group-status').val();
                    $.ajax({
                        url: "{{ route('updateGroupPertanyaanAction') }}",  
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  
                            id_pertanyaan_group: id_pertanyaan_group,
                            kode_group: kode_group,
                            keterangan: keterangan,
                            status_group: status_group
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Group Berhasil Diubah',
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


                $('#addGroupPertanyaanAction').click(function(e) {
                    e.preventDefault();
                    var kode_group = $('#add-group-kode').val();
                    var keterangan = $('#add-group-keterangan').val();
                    var status = $('#add-group-status').val();
                   
                    $.ajax({
                        url: "{{ route('addGroupPertanyaanAction') }}",  // Update with your actual route
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  // CSRF token for security
                            kode_group: kode_group,
                            keterangan: keterangan,
                            status: status
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data Berhasil Disimpan',
                                icon: 'success'
                            }).then(function() {
                                location.reload();  // Reload the page after the alert is closed
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                        }
                    });
                });


                $('#groupTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('pertanyaan.getGroupPertanyaan') }}",
                        data: function (d) {
                            d.group = $('#search-group-group').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'kode_group', name: 'kode_group'},
                        {data: 'status', name: 'status'},
                        {data: 'keterangan', name: 'keterangan'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchGroup').click(function () {
                    $('#groupTable').DataTable().ajax.reload();
                });
                $('#resetSearchGroup').click(function () {
                    $('#search-group-group').val('');
                    $('#groupTable').DataTable().ajax.reload();
                });

                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getReffStatusPertanyaangroup') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-group-status');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.isi_kolom + '">' + data.keterangan + '</option>');
                        });
                    }
                });
                Swal.close();
            });

            $(document).on('click', '.btn-edit-group', function() {
                var id_group_pertanyaan = $(this).data('id');
                var url = "{{ route('pertanyaan.showDetailgroupPertanyaan', ':id_group_pertanyaan') }}";
                url = url.replace(':id_group_pertanyaan', id_group_pertanyaan);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {

                        $('#edit-group-kode').val(response.kode_group);
                        $('#edit-group-keterangan').val(response.keterangan);
                        $('#edit-group-status').val(response.status_group);
                        $('#edit-group-pertanyaan_group_id').val(response.id_pertanyaan_group);

                            $.ajax({
                                url: '{{ route('getReffStatusPertanyaangroup') }}',
                                method: 'GET',
                                success: function(data) {
                                    // alert(data);
                                    var $select = $('#edit-group-status');
                                    $select.empty();
                                    $select.append('<option value="">--Pilih Status---</option>');
                                    data.forEach(function(data) {
                                        var selected = '';
                                        if (data.isi_kolom === response.status_group) {
                                            selected = 'selected';
                                        }
                                        $select.append('<option value="' + data.isi_kolom + '" ' + selected + '>' + data.keterangan + '</option>');                            
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });

                            $('#detailModalGroup').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Tampilkan pesan kesalahan jika terjadi kesalahan dalam permintaan Ajax
                        }
                    });


                });
            $(document).on('click', '.close', function() {
                $('#detailModalGroup').modal('hide');
            });


            $(document).on('click', '.btn-delete-group', function() {
                var pertanyaanGroupId = $(this).data('id');
                Swal.fire({
                    title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data group ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('deleteGroupPertanyaanAction') }}", 
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",  
                                id_pertanyaan_group: pertanyaanGroupId
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
        </script>
        @include('layout.footer')