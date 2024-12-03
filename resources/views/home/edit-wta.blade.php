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
												<a href="{{route('wta');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <input type="hidden" id="edit-id-wta" value="{{$wta->id}}">
                                            <div class="row">
                                                <div class="col-md-12 card">
                                                    
                                                    <div class="row my-6 mx-6">
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Berkas transkrip nilai</label><br>
																<a href="{{ Storage::url($wta->transkrip) }}" target="_blank">Lihat File: {{ basename($wta->transkrip) }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Status:</label><br>
                                                                <select class="form-control" id="edit-transkrip-wta">
                                                                    <option value="">---Pilih Status---</option>
                                                                    <option <?php if($wta->v_transkrip == "Y"){ echo "selected"; } ?> value="Y">Diverifikasi</option>
                                                                    <option <?php if($wta->v_transkrip == "T"){ echo "selected"; } ?> value="T">Ditolak</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Sertifikat seminar sebagai peserta</label><br>
																<a href="{{ Storage::url($wta->seminar) }}" target="_blank">Lihat File: {{ basename($wta->seminar) }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Status:</label><br>
                                                                <select class="form-control" id="edit-seminar-wta">
                                                                    <option value="">---Pilih Status---</option>
                                                                    <option <?php if($wta->v_seminar == "Y"){ echo "selected"; } ?> value="Y">Diverifikasi</option>
                                                                    <option <?php if($wta->v_seminar == "T"){ echo "selected"; } ?> value="T">Ditolak</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Proposal PKM sebagai ketua</label><br>
																<a href="{{ Storage::url($wta->pkm) }}" target="_blank">Lihat File: {{ basename($wta->pkm) }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Status:</label><br>
                                                                <select class="form-control" id="edit-pkm-wta">
                                                                    <option value="">---Pilih Status---</option>
                                                                    <option <?php if($wta->v_pkm == "Y"){ echo "selected"; } ?> value="Y">Diverifikasi</option>
                                                                    <option <?php if($wta->v_pkm == "T"){ echo "selected"; } ?> value="T">Ditolak</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Bukti Pembayaran</label><br>
                                                                <a href="{{ Storage::url($wta->pembayaran) }}" target="_blank">Lihat File: {{ basename($wta->pembayaran) }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Status:</label><br>
                                                                <select class="form-control" id="edit-pembayaran-wta">
                                                                    <option value="">---Pilih Status---</option>
                                                                    <option <?php if($wta->v_pembayaran == "Y"){ echo "selected"; } ?> value="Y">Diverifikasi</option>
                                                                    <option <?php if($wta->v_pembayaran == "T"){ echo "selected"; } ?> value="T">Ditolak</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        
                                                        <div class="col-md-12 mt-9 mb-4 d-flex justify-content-end">
                                                            <button id="updateVerifikasiWtaAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
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



            $(document).ready(function() {
                $(document).ready(function() {
                    $('#updateVerifikasiWtaAction').on('click', function(e) {
                        e.preventDefault();
                        
                        // Ambil nilai dari setiap select option
                        let wtaId = $('#edit-id-wta').val();
                        let transkripStatus = $('#edit-transkrip-wta').val();
                        let seminarStatus = $('#edit-seminar-wta').val();
                        let pkmStatus = $('#edit-pkm-wta').val();
                        let pembayaranStatus = $('#edit-pembayaran-wta').val();

                        // Validasi: cek jika semua nilai tidak boleh kosong
                        if (!transkripStatus || !seminarStatus || !pkmStatus || !pembayaranStatus) {
                            alert('Semua status harus dipilih.');
                            return; // Jika ada nilai kosong, hentikan proses
                        }

                        // Jika semua nilai sudah diisi, kirimkan data menggunakan Ajax
                        $.ajax({
                            url: '{{ route("verifikasiWtaAction") }}',
                            type: 'POST',
                            data: {
                                id: wtaId,
                                transkrip: transkripStatus,
                                seminar: seminarStatus,
                                pkm: pkmStatus,
                                pembayaran: pembayaranStatus,
                                _token: '{{ csrf_token() }}'
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



            });

        </script>
		
        @include('layout.footer')