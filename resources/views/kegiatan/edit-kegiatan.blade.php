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
												<a href="{{route('kegiatan.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <input type="hidden" id="detail-id_kegiatan-kegiatan" value="{{$id_kegiatan}}">
                                            <div class="row">
                                               
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Nama Kegiatan</label>
                                                        <input type="text" id="detail-kegiatan-kegiatan" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Kode Kegiatan</label>
                                                        <input type="text" id="detail-kode-kegiatan" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Status Kegiatan</label>
                                                        <select id="detail-status-kegiatan" class="form-control mb-2">
                                                            <option value="">--Pilih Status---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="updateKegiatanAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
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
                $('#updateKegiatanAction').click(function(e) {
                    e.preventDefault();
                    
                    var id_kegiatan = $('#detail-id_kegiatan-kegiatan').val();
                    var nama = $('#detail-kegiatan-kegiatan').val();
                    var kode = $('#detail-kode-kegiatan').val();
                    var status = $('#detail-status-kegiatan').val();
                    
                    $.ajax({
                        url: "{{ route('updateKegiatanAction') }}", 
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  
                            id_kegiatan: id_kegiatan,
                            nama: nama,
                            kode: kode,
                            status: status
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


                var id_kegiatan = $('#detail-id_kegiatan-kegiatan').val();
                var url = "{{ route('kegiatan.showDetailKegiatan', ':id_kegiatan') }}";
                url = url.replace(':id_kegiatan', id_kegiatan);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-kegiatan-kegiatan').val(response.keterangan);
                        $('#detail-kode-kegiatan').val(response.isi_kolom);
                        $('#detail-status-kegiatan').val(response.status_show);
                        

                        $('#detail-status-kegiatan').val(response.status_show);
                        fetchStatus(response.status_show);

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });

                function fetchStatus(status_show) {
                    var $select = $('#detail-status-kegiatan');
                    var selected_y = '';
                    var selected_n = '';
                    if (status_show === 'Y') {
                        selected_y = 'selected';
                    }
                    if (status_show === 'N') {
                        selected_n = 'selected';
                    }
                    $select.empty();
                    $select.append('<option value="">--Pilih Status---</option>');
                    $select.append('<option value="Y" ' + selected_y + '>Aktif</option><option value="N" ' + selected_n + '>Tidak Aktif</option>');
                    $select.select2();

                }

            });

        </script>
		
        @include('layout.footer')