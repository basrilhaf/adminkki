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
								<div id="kt_app_content" class="app-content bg-white">
									<div id="kt_app_toolbar" class="app-toolbar d-flex flex-column py-6">
										<div class="app-toolbar-wrapper d-flex align-items-center flex-stack flex-wrap gap-2 py-4 w-100">
											<div class="page-title d-flex flex-column justify-content-center gap-2 me-3">
												<h1 class="page-heading d-flex flex-column justify-content-center text-primary fw-bolder fs-1 m-0">{{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											
										</div>
									</div>
									<!--begin::Card-->
                                    
									<div class="card bg-white">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
                                            
											<div class="mt-5">
                                                <form action="">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-4 text-end">
                                                            <a href="/home" class="btn btn-danger">Kembali</a>
                                                        </div>
														<?php  
															if($alur && $alur->v_berkas == "Y") {
																$button = "success";
																$text = "Diverifikasi";
																$disabled = "";
															}else if($alur && $alur->v_berkas == "T"){
																$disabled = "";
																$button = "danger";
																$text = "Ditolak";
															}else{
																$disabled = "";
																$button = "";
																$text = "";
															}
															
														?>
														

                                                        <div class="col-md-12 mb-6">
                                                            <div class="form-group">
                                                                <?php if($priode == 3){ ?>
                                                                    <label class="form-label">Pengumpulan TA <?php if(isset($alur)){ ?> <span class="badge badge-{{$button}}">{{$text}}</span> <?php }?></label><br>
																	<?php }else if($priode == 4){ ?>
																		<label class="form-label">Pengumpulan Revisi TA <?php if(isset($alur)){ ?> <span class="badge badge-{{$button}}">{{$text}}</span> <?php }?></label><br>
                                                                <?php } else {?>
                                                                    <label class="form-label">Pengumpulan TA Tahap {{$priode}} <?php if(isset($alur)){ ?> <span class="badge badge-{{$button}}">{{$text}}</span> <?php }?></label><br>
                                                                <?php }?>
                                                                
                                                                <span style="font-size: 10px;">Berkas berupa *pdf</span>
                                                                <input id="workshop" type="file" class="form-control" {{$disabled}}>
																@if($alur && $alur->berkas)
																	<a href="{{ Storage::url($alur->berkas) }}" target="_blank">File saat ini: {{ basename($alur->berkas) }}</a>
																@endif
                                                            </div>
                                                        </div>
                                                        
                                                        
														<?php 
														if (isset($alur) && $alur) {
															if ($alur->status == "N") {
																$warna = "warning";
																$disabled = "";
																$textbtn = 'Daftar Ujian TA';
															} elseif ($alur->status == "T") {
																$warna = "danger";
																$disabled = "";
																$textbtn = 'Ditolak';
															} elseif ($alur->status == "Y") {
																$warna = "success";
																$disabled = "";
																$textbtn = 'Terdaftar';
															} else {
																$warna = "secondary";
																$disabled = "";
																$textbtn = 'Daftar Ujian TA';
															}
														}else{
																$warna = "secondary";
																$disabled = "";
																$textbtn = 'Daftar Ujian TA';
														}
														?>
                                                        <div class="col-md-12 mb-6 text-end">
															<?php if($priode != 4){ ?>
                                                            <button type="submit" disabled class="btn btn-{{$warna}}">{{$textbtn}}</button>
															<?php if(isset($alur) && $alur->status == "T"){ ?>
																<button type="submit" id="button-uplad-pengumpulan" {{$disabled}} class="btn btn-secondary">Upload Berkas & Daftar</button>
																<?php } else {?>
																	<button type="submit" id="button-uplad-pengumpulan" {{$disabled}} class="btn btn-secondary">Upload Berkas & Daftar</button>
																<?php } ?>
															<?php } else {?>
																<?php if(isset($alur) && $alur->status == "T"){ ?>
																	<button type="submit" id="button-uplad-pengumpulan" {{$disabled}} class="btn btn-secondary">Upload Berkas</button>
																	<?php } else {?>
																		<button type="submit" id="button-uplad-pengumpulan" {{$disabled}} class="btn btn-secondary">Upload Berkas</button>
																	<?php } ?>
															<?php }?>
															
                                                        </div>
                                                    </div>

                                                </form>

											</div>
											
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
		<script>
			$(document).ready(function() {
				$('#button-uplad-pengumpulan').click(function(e) {
					e.preventDefault();
		
					var formData = new FormData();
					formData.append('workshop', $('#workshop')[0].files[0]);
					formData.append('_token', '{{ csrf_token() }}');
		
					$.ajax({
						url: "{{ route('uploadTaAction') }}",
						method: 'POST',
						data: formData,
						contentType: false,
						processData: false,
						success: function(response) {
                            if (response.success) {
                                Swal.fire({ icon: 'success', title: 'Success', text: response.message,timer: 5000, }).then(() => { window.location.reload(); });
                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: response.message, });
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            var message = '';
                            $.each(errors, function(key, value) {
                                message += value[0] + '\n';
                            });
                            Swal.fire({ icon: 'error', title: 'Error', text: message, });
                        }
					});
				});

			});
		</script>


        @include('layout.footer')