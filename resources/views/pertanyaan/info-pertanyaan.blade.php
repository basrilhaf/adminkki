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
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0"> {{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											<div class="d-flex align-items-center gap-2 gap-lg-3">
												<a href="{{route('pertanyaan.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i>Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                
                                                <div class="mb-4 fv-row">
                                                    <input type="hidden" id="edit-id_pertanyaan-pertanyaan" value="{{$id_pertanyaan}}">
                                                    <label class="required form-label">Jenis Jawaban</label>
                                                    <input type="text" id="edit-jenis-pertanyaan" class="form-control mb-2">
                                                    
                                                </div>
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Pertanyaan</label>
                                                    <textarea name="" id="edit-pertanyaan-pertanyaan" cols="10" rows="2" class="form-control mb-2"></textarea>
                                                </div>
                                                <div class="col-md-4 mt-4 mb-4">
                                                </div>

                                                <div class="mb-4 fv-row" id="divPilihan" style="display:none;">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card px-4 mb-4">
                                                                <div class="card-body" >
                                                                    <h2>List Pilihan Jawaban</h2>
                                                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="tablePilihanPertanyaan">
                                                                        <thead>
                                                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                                                <th></th>
                                                                                <th>Pilihan Jawaban</th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                    </div>
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
            $(document).ready(function () {
                var id_pertanyaan = $('#edit-id_pertanyaan-pertanyaan').val();
                var url = "{{ route('pertanyaan.showPilihanPertanyaan', ':id_pertanyaan') }}";
                url = url.replace(':id_pertanyaan', id_pertanyaan);
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $('#tablePilihanPertanyaan').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
                        type: 'GET'
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'pilihan', name: 'pilihan'},
                    ],
                    drawCallback: function() {
                        // Reinitialize Select2 on draw
                        $('.select2').select2();
                    }
                });
                $('.select2').select2();
                Swal.close();            
            });

         

            

            
        
            $(document).ready(function() {
                var id_pertanyaan = $('#edit-id_pertanyaan-pertanyaan').val();
                var url = "{{ route('pertanyaan.showDetailPertanyaan', ':id_pertanyaan') }}";
                url = url.replace(':id_pertanyaan', id_pertanyaan);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#edit-jenis-pertanyaan').val(response.jenis_pertanyaan).prop('disabled', true);
                        $('#edit-pertanyaan-pertanyaan').val(response.pertanyaan).prop('disabled', true);

                        // fetch 
                        $('#edit-jenis-pertanyaan').val(response.jenis_pertanyaan);
                        fetchJenisPertanyaan(response.jenis_pertanyaan);
                        if (response.jenis_pertanyaan == 'F' || response.jenis_pertanyaan == '') {
                            $('#divPilihan').hide();
                        } else {
                            $('#divPilihan').show();
                        }
                        

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });
               

                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                function fetchJenisPertanyaan(jenis_pertanyaan) {
                    var jpUrl = "{{ route('getReffJenisPertanyaan') }}";
                    $.ajax({
                        url: jpUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#edit-jenis-pertanyaan');
                            $select.empty();
                            $select.append('<option value="">--Pilih Jenis Pertanyaan---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.isi_kolom === jenis_pertanyaan) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.isi_kolom + '" ' + selected + '>' + data.keterangan + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Master Jenis Kelamin data');
                        }
                    });
                }
                Swal.close();

                $('#add-jenis-pertanyaan').on('change', function() {
                    var selectedValue = $(this).val();
                    if (selectedValue == 'F' || selectedValue == '') {
                        $('#divPilihan').hide();
                    } else {
                        $('#divPilihan').show();
                    }
                });

                // Add new form input
                $('#addPilihan').click(function () {
                    var newForm = `<input type="text" class="form-control mb-2" name="pilihanJawaban[]" id="pilihanJawaban">`;
                    $('#divPilihanPertanyaan').append(newForm);
                });

                $('#edit-jenis-pertanyaan').on('change', function() {
                    var selectedValue = $(this).val();
                    if (selectedValue == 'F' || selectedValue == '') {
                        $('#divPilihan').hide();
                    } else {
                        $('#divPilihan').show();
                    }
                });


               
            });


        </script>
		
        @include('layout.footer')