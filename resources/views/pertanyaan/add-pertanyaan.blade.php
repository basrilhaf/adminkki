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
												<a href="{{route('pertanyaan.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i>Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Jenis Jawaban</label>
                                                    <select id="add-jenis-pertanyaan" class="form-control mb-2">
                                                        <option value="">--Pilih Jenis Jawaban---</option>
                                                    </select>
                                                </div>
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Group Pertanyaan</label>
                                                    <select id="add-group-pertanyaan" class="form-control mb-2">
                                                        <option value="">--Pilih Group Pertanyaan---</option>
                                                    </select>
                                                </div>
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Pertanyaan</label>
                                                    <textarea name="" id="pertanyaan" cols="10" rows="2" class="form-control mb-2"></textarea>
                                                </div>

                                                <div class="mb-4 fv-row" id="divPilihan" style="display:none;">
                                                    <button id="addPilihan" class="btn btn-flex btn-warning h-40px fs-7 fw-bold mb-2"><span class="fa fa-plus"></span>Pilihan Jawaban</button><br>
                                                    <label class="required form-label">Pilihan Jawaban</label>
                                                    <input type="text" class="form-control mb-2" name="pilihanJawaban[]" id="pilihanJawaban">
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="addPertanyaanAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
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
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getReffJenisPertanyaan') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-jenis-pertanyaan');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.isi_kolom + '">' + data.keterangan + '</option>');
                        });
                    }
                });
                Swal.close();

                $('#add-jenis-pertanyaan').on('change', function() {
                    var selectedValue = $(this).val();
                    if (selectedValue == 'F' || selectedValue == '') {
                        $('#divPilihan').hide();
                    } else {
                        $('#divPilihan').show();
                    }
                });

                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getGroupPertanyaanOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-group-pertanyaan');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.id_pertanyaan_group + '">' + data.kode_group + '</option>');
                        });
                    }
                });
                Swal.close();

                // Add new form input
                $('#addPilihan').click(function () {
                    var newForm = `<input type="text" class="form-control mb-2" name="pilihanJawaban[]" id="pilihanJawaban">`;
                    $('#divPilihan').append(newForm);
                });


                $('#addPertanyaanAction').click(function(e) {
                    e.preventDefault();
                    var jenisJawaban = $('#add-jenis-pertanyaan').val();
                    var pertanyaan = $('#pertanyaan').val();
                    var group = $('#add-group-pertanyaan').val();
                    // alert(group);
                    var pilihanJawaban = [];
                    $('input[name="pilihanJawaban[]"]').each(function() {
                        pilihanJawaban.push($(this).val());
                    });
                    $.ajax({
                        url: "{{ route('addPertanyaanAction') }}",  // Update with your actual route
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  // CSRF token for security
                            jenis_jawaban: jenisJawaban,
                            pertanyaan: pertanyaan,
                            pertanyaan_group_id: group,
                            pilihan_jawaban: pilihanJawaban
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
            });


        </script>
		
        @include('layout.footer')