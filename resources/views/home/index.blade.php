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
								<div id="kt_app_content" class="app-content bg-dark">
									<div id="kt_app_toolbar" class="app-toolbar d-flex flex-column py-6">
										<div class="app-toolbar-wrapper d-flex align-items-center flex-stack flex-wrap gap-2 py-4 w-100">
											<div class="page-title d-flex flex-column justify-content-center gap-2 me-3">
												<h1 class="page-heading d-flex flex-column justify-content-center text-white fw-bolder fs-1 m-0">{{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											
										</div>
									</div>
									<!--begin::Card-->
                                    
									<div class="card bg-dark">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
											<img src="{{ asset('assets/beranda.png') }}" style="width: 100%;" alt="">
											<img src="{{ asset('assets/beranda2.png') }}" style="width: 100%;" alt="">
											<img src="{{ asset('assets/beranda3.png') }}" style="width: 100%;" alt="">
											<div class="mt-5">
												@foreach($alur as $alur)
													<div class="row justify-content-center" style="width: 60%; margin: auto;">
														<div class="col-md-6">
															<div class="card bg-dark text-white">
																<div class="card-body">
																	<p class="badge badge-primary" style="height: 20px;">{{ $alur->urutan }}</p>
																	<p class="text-danger">{{ $alur->tanggal }}</p>
																	<p>{{ $alur->judul }}</p>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="card">
																<div class="card-body">
																	<p>{{ $alur->deskripsi}}</p>
																	<a class="text-danger" href="{{ $alur->url }}">{{ $alur->text_url }}</a><br>
																	<?php 
																		if($alur->url2 !== ''){
																	?>
																	<a class="text-danger" href="{{ $alur->url2 }}">{{ $alur->text_url2 }}</a><br>
																	<?php } ?>
																</div>
															</div>
														</div>
														<hr class="text-white mt-4">
													</div>
													<p></p>
												@endforeach
											</div>
											
											{{-- <h1 class="text-primary text-center my-4">HOME APLIKASI MANAGEMENT TASK SURVEY</h1> --}}
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
		
        @include('layout.footer')