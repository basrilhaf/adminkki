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
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Cabang: </label>
                                                                <select class="form-control" id="search-cabang-rat">
                                                                    <option value="01">1</option>
                                                                    <option value="02">2</option>
                                                                    <option value="03">3</option>
                                                                    <option value="04">4</option>
                                                                    <option value="05">5</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="daterange">Hari Setoran: </label>
                                                                <select class="form-control" id="search-hari-rat">
                                                                    <option value="2">Senin</option>
                                                                    <option value="3">Selasa</option>
                                                                    <option value="4">Rabu</option>
                                                                    <option value="5">Kamis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 pt-4">
                                                            <a href="#" id="hadirAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                                <i class="fa fa-download"></i> PDF Daftar Hadir
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3 pt-4">
                                                            <a href="#" id="tanggapanAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                                <i class="fa fa-download"></i> PDF Tanggapan
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
                                    <script>
                                        $('#hadirAction').on('click', function(e) {
                                            e.preventDefault(); 
                                            var hari = $('#search-hari-rat').val();
                                            var cabang = $('#search-cabang-rat').val();
                                            if (!hari) {
                                                alert('Please select a hari.');
                                                return;
                                            }
                            
                                            var url = "{{ route('pdfHadirRat') }}" + "?hari=" + hari + "&cabang=" + cabang;
                                            var link = document.createElement('a');
                                            link.href = url;
                                            link.target = "_blank"; 
                                            link.click();
                                        });

                                        $('#tanggapanAction').on('click', function(e) {
                                            e.preventDefault(); 
                                            var hari = $('#search-hari-rat').val();
                                            var cabang = $('#search-cabang-rat').val();
                                            if (!hari) {
                                                alert('Please select a hari.');
                                                return;
                                            }
                            
                                            var url = "{{ route('pdfTanggapanRat') }}" + "?hari=" + hari + "&cabang=" + cabang;
                                            var link = document.createElement('a');
                                            link.href = url;
                                            link.target = "_blank"; 
                                            link.click();
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