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
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label class="form-label fs-6 fw-bold">NAMA KOTA/KABUPATEN:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-wilayah-kabkota" placeholder="Nama Kota/kabupaten" />
                                                    </div>
                                                </div>
                                                <input type="hidden" id="provinsiKode" value="{{$provinsi_kode}}">
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchKabkota" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchKabkota" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableKabkota">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama Kota/Kabupaten</th>
                                                        <th></th>
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
                var provinsi_kode = $('#provinsiKode').val();
                // alert(provinsi_kode);
                var url = "{{ route('wilayah.showKota', ':provinsi_kode') }}";
                url = url.replace(':provinsi_kode', provinsi_kode);
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $('#tableKabkota').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
                        type: 'GET',
                        data: function (d) {
                            d.nama_kabkota = $('#search-wilayah-kabkota').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'kabkota_nama', name: 'kabkota_nama'},
                        {data: 'list_kecamatan_field', name: 'list_kecamatan_field', orderable: false, searchable: false},
                        
                    ]
                });
                Swal.close();
                $('#searchKabkota').click(function () {
                    $('#tableKabkota').DataTable().ajax.reload();
                });
                $('#resetSearchKabkota').click(function () {
                    $('#search-wilayah-kabkota').val('');
                    $('#tableKabkota').DataTable().ajax.reload();
                });
            });
        </script>
        @include('layout.footer')