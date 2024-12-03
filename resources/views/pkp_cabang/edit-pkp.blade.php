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
												<a href="{{route('pkpCabang.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <input type="hidden" id="detail-id-pkp" value="{{$id_pkp}}">
                                            <div class="row">
                                               
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Nama:</label>
                                                        <input type="text" id="detail-nama-pkp" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">NIK</label>
                                                        <input type="text" id="detail-nik-pkp" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Email</label>
                                                        <input type="text" id="detail-email-pkp" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">PKP/KC?</label>
                                                        <select class="form-control" id="detail-is_kc-pkp"></select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Cabang</label>
                                                        <select id="detail-cabang-pkp" class="form-control mb-2">
                                                            <option value="">--Pilih Cabang---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Password <span class="text-danger fs-10">isi password jika ingin mengubah password</span></label>
                                                        <input type="password" id="detail-password-pkp" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="updatePkpAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
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
                $('#updatePkpAction').click(function(e) {
                    e.preventDefault();
                    
                    var id = $('#detail-id-pkp').val();
                    
                    var nama = $('#detail-nama-pkp').val();
                    var nik = $('#detail-nik-pkp').val();
                    var email = $('#detail-email-pkp').val();
                    var is_kc = $('#detail-is_kc-pkp').val();
                    var cabang = $('#detail-cabang-pkp').val();
                    var password = $('detail-password-pkp').val();
                    
                    $.ajax({
                        url: "{{ route('updatePkpAction') }}", 
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  
                            id: id,
                            nik:nik,
                            nama: nama,
                            email: email,
                            is_kc: is_kc,
                            cabang: cabang,
                            password: password
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


                var id = $('#detail-id-pkp').val();
                var url = "{{ route('showDetailPkp', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-nama-pkp').val(response.nama);
                        $('#detail-nik-pkp').val(response.nik);
                        $('#detail-email-pkp').val(response.email_pkp);

                        $('#detail-is_kc-pkp').val(response.is_kc);
                        fetchIsKc(response.is_kc);
                        $('#detail-cabang-pkp').val(response.cabang);
                        fetchCabang(response.cabang);

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });

                function fetchIsKc(is_kc) {
                    var $select = $('#detail-is_kc-pkp');
                    var selected_0 = '';
                    var selected_1 = '';
                    if (is_kc === '0') { selected_0 = 'selected'; }
                    if (is_kc === '1') { selected_1 = 'selected'; }
                    
                    $select.empty();
                    $select.append('<option value="">--Pilih Jenis---</option>');
                    $select.append('<option value="0" ' + selected_0 + '>PKP</option>');
                    $select.append('<option value="1" ' + selected_1 + '>KC</option>');
                    $select.select2();
                }

                
                function fetchCabang(cabang) {
                    var url = "{{ route('getCabangOption') }}";
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-cabang-pkp');
                            $select.empty();
                            $select.append('<option value="">--Pilih Cabang---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.id === cabang) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.id + '" ' + selected + '>' + data.nama + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Master provinsi data');
                        }
                    });
                }

            });

        </script>
		
        @include('layout.footer')