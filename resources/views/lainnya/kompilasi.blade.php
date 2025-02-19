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
												<h1 class="page-heading d-flex flex-column justify-content-center text-primary fw-bolder fs-1 m-0">{{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											
										</div>
									</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Filter Tanggal</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="daterange">Tanggal Setoran: </label>
                                                                <input type="date" id="search-tanggal-kkb" name="daterange" class="form-control" placeholder="Tanggal Setoran">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="#" id="exportDownloadLink" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                                <i class="fa fa-download"></i> Export Pencairan
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="#" id="exportDownloadLink2" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                                <i class="fa fa-download"></i> Export Selesai
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                    <hr>
                                  
                                    
                                    <!--begin::Card-->
                                    <hr>
                                    

                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                           

                                            $('#exportDownloadLink').on('click', function(e) {
                                                e.preventDefault(); 
                                                var selectedDate = $('#search-tanggal-kkb').val();
                                                
                                                if (!selectedDate) {
                                                    alert('Please select a date.');
                                                    return;
                                                }

                                                window.location.href = "{{ route('exportDownloadPencairan') }}" + "?tanggal=" + selectedDate;
                                            });

                                            $('#exportDownloadLink2').on('click', function(e) {
                                                e.preventDefault(); 
                                                var selectedDate = $('#search-tanggal-kkb').val();
                                                
                                                if (!selectedDate) {
                                                    alert('Please select a date.');
                                                    return;
                                                }

                                                window.location.href = "{{ route('exportDownloadSelesai') }}" + "?tanggal=" + selectedDate;
                                            });
                                            
                                        });


                            
                                    </script>
									
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
        
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#search-tanggal-kkb", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
		
        @include('layout.footer')