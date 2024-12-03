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
											{{-- <div class="d-flex align-items-center gap-2 gap-lg-3">
												<a href="{{route('user.addUser')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-plus"></i>User</a>
											</div> --}}
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NAMA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-user-nama" placeholder="Nama role" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">EMAIL:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-user-email" placeholder="Nama role" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NIM:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-user-nim" placeholder="Kode role" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="searchUser" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchUser" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableProgressProposal">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama</th>
														<th class="min-w-125px">Email</th>
														<th class="min-w-125px">NIM</th>
                                                        <th class="min-w-125px">REVISI?</th>
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
                var table = $('#tableProgressProposal').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getProgressProposal') }}",
                        data: function (d) {
                            d.nama = $('#search-user-nama').val();
                            d.email = $('#search-user-email').val();
                            d.nim = $('#search-user-nim').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama'},
                        {data: 'email', name: 'email'},
                        {data: 'nim', name: 'nim'},
                        {data: 'revisi', name: 'revisi'},
                        {data: 'status', name: 'status'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });

                $('#searchUser').click(function () {
                    table.ajax.reload();
                });
                
                $('#resetSearchUser').click(function () {
                    $('#search-user-nama').val('');
                    $('#search-user-email').val('');
                    $('#search-user-nim').val('');
                    table.ajax.reload();
                });

                // Event delegation for dynamically added elements
                $(document).on('click', '.ajukan-diterima', function() {
                    let alurId = $(this).data('id');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan menerima progress ini.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, ajukan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route("ajukanDiterima") }}',
                                type: 'POST',
                                data: {
                                    id: alurId,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    Swal.fire('Sukses', 'Progress berhasil diperbarui', 'success').then(function() {
                                        table.ajax.reload(); // Reload table data
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire('Error', 'Gagal memperbarui progress', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.ajukan-ditolak', function() {
                    let alurId = $(this).data('id');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan menolak progress ini.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, ajukan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route("ajukanDitolak") }}',
                                type: 'POST',
                                data: {
                                    id: alurId,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    Swal.fire('Sukses', 'Progress berhasil diperbarui', 'success').then(function() {
                                        table.ajax.reload(); // Reload table data
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire('Error', 'Gagal memperbarui progress', 'error');
                                }
                            });
                        }
                    });
                });
            });

            
            
        </script>
        @include('layout.footer')