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
															if($alur && $alur->v_workshop == "Y") {
																$button = "success";
																$text = "Diverifikasi";
																$disabled = "disabled";
															}else if($alur && $alur->v_workshop == "T"){
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
                                                                <label class="form-label">Upload bukti join webex <?php if(isset($alur)){ ?> <span class="badge badge-{{$button}}">{{$text}}</span> <?php }?></label><br>
                                                                <span style="font-size: 10px;">Berkas berupa berkas webex</span>
                                                                <input id="workshop" type="file" class="form-control" {{$disabled}}>
																@if($alur && $alur->workshop)
																	<a href="{{ Storage::url($alur->workshop) }}" target="_blank">File saat ini: {{ basename($alur->workshop) }}</a>
																@endif
                                                            </div>
                                                        </div>
                                                        
                                                        
														<?php 
														if (isset($alur) && $alur) {
															if ($alur->status == "N") {
																$warna = "warning";
																$disabled = "disabled";
																$textbtn = 'Verifikasi Berkas';
															} elseif ($alur->status == "T") {
																$warna = "danger";
																$disabled = "";
																$textbtn = 'Ditolak';
															} elseif ($alur->status == "Y") {
																$warna = "success";
																$disabled = "disabled";
																$textbtn = 'Terverifikasi';
															} else {
																$warna = "secondary";
																$disabled = "";
																$textbtn = 'Verifikasi Berkas';
															}
														}else{
																$warna = "secondary";
																$disabled = "";
																$textbtn = 'Verifikasi Berkas';
														}
														?>
                                                        <div class="col-md-12 mb-6 text-end">
                                                            <button type="submit" disabled class="btn btn-{{$warna}}">{{$textbtn}}</button>
															<?php if(isset($alur) && $alur->status == "T"){ ?>
                                                            <button type="submit" id="button-uplad-workshop" {{$disabled}} class="btn btn-secondary">Upload Berkas</button>
															<?php } else {?>
																<button type="submit" id="button-uplad-workshop" {{$disabled}} class="btn btn-secondary">Upload Berkas</button>
															<?php } ?>
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
				$('#button-uplad-workshop').click(function(e) {
					e.preventDefault();
		
					var formData = new FormData();
					formData.append('workshop', $('#workshop')[0].files[0]);
					formData.append('_token', '{{ csrf_token() }}');
		
					$.ajax({
						url: "{{ route('uploadWorkshopAction') }}",
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