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
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">Tanggal:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-daterange-laporan" placeholder="Periode" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">Cabang:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <select class="form-control form-control-solid ps-13" id="cari-cabang-laporan">
                                                            <option value="0">Semua Cabang</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <a href="#" id="laporanPeriodeAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> Submit
                                                    </a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            flatpickr("#cari-daterange-laporan", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
        <script>
            $('#laporanPeriodeAction').on('click', function(e) {
                e.preventDefault(); 
                var tanggal = $('#cari-daterange-laporan').val();
                var cabang = $('#cari-cabang-laporan').val();
                if (!tanggal) {
                    alert('Please select a date.');
                    return;
                }

                var url = "{{ route('pdfLaporanPeriode') }}" + "?tanggal=" + tanggal + "&cabang=" + cabang;
                var link = document.createElement('a');
                link.href = url;
                link.target = "_blank"; // Membuka link di tab baru
                link.click();
            });
        </script>

        @include('layout.footer')