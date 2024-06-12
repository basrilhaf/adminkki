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
												<a href="{{route('task.addTask')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-plus"></i>Task</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NAMA KEGIATAN:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-task-nama" placeholder="Nama kegiatan" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">TANGGAL KEGIATAN:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="date" class="form-control form-control-solid ps-13" id="search-task-tanggal" placeholder="Tanggal kegiatan" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">SURVEYOR:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-task-surveyor" placeholder="Nama surveyor" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="searchTask" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchTask" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableTask">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Kode</th>
                                                        <th class="min-w-125px">Nama</th>
														<th class="min-w-125px">Tanggal</th>
														<th class="min-w-125px">Surveyor</th>
                                                        <th class="min-w-125px">is_finish</th>
                                                        <th class="min-w-125px">Status</th>
														<th class="min-w-100px">Actions</th>
													</tr>
												</thead>
											
											</table>
											<!--end::Table-->
										</div>
										<!--end::Card body-->
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
            $(document).ready(function () {
                $('#tableTask').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('task.getTask') }}",
                        data: function (d) {
                            d.nama_task = $('#search-task-nama').val();
                            d.tanggal_task = $('#search-task-tanggal').val();
                            d.surveyor = $('#search-task-surveyor').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'kode_task', name: 'kode_task'},
                        {data: 'nama_task', name: 'nama_task'},
                        {data: 'tanggal_task', name: 'tanggal_task'},
                        {data: 'nama', name: 'nama'},
                        {data: 'is_finish', name: 'is_finish'},
                        {data: 'status_publish', name: 'status_publish'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#searchTask').click(function () {
                    $('#tableTask').DataTable().ajax.reload();
                });
                $('#resetSearchTask').click(function () {
                    $('#search-task-nama').val('');
                    $('#search-task-tanggal').val('');
                    $('#search-task-surveyor').val('');
                    $('#tableTask').DataTable().ajax.reload();
                });

                $(document).on('click', '.btn-delete-task', function() {
                var taskId = $(this).data('id');
                Swal.fire({
                    title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data task ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, lakukan AJAX request
                        $.ajax({
                            url: "{{ route('deleteTaskAction') }}", 
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",  
                                id_task: taskId
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
        </script>
        @include('layout.footer')