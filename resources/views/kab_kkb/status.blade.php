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
                                                    <h2 class="mt-6">KAB/KKB Belum Dikunjungi/Dikumpulkan</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    <form action="{{route('formBelumDikunjungiDikumpulkan')}}" target=_blank method="GET">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="daterange">Tanggal: </label>
                                                                    <input type="text" id="search-daterange-form1" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="daterange">Cabang: </label>
                                                                    <select class="form-control" id="search-cabang-form1" name="cabang">
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="daterange">KAB/KKB: </label>
                                                                    <select class="form-control" id="search-kabkkb-form1" name="kabkkb">
                                                                        <option value="KAB">KAB</option>
                                                                        <option value="KKB">KKB</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button id="submitForm1" class="btn btn-primary rounded mt-4">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Form Laporan Nasabah/Kelompok Bermasalah & Laporan Kelompok Telat Berat</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    
                                                    <form action="{{route('formNasabahKelompokBermasalah')}}" target=_blank method="GET">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="daterange">Tanggal: </label>
                                                                    <input type="text" id="search-daterange-form1" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="daterange">Cabang: </label>
                                                                    <select class="form-control" id="search-cabang-form1" name="cabang">
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="daterange">KAB/KKB: </label>
                                                                    <select class="form-control" id="search-kabkkb-form1" name="kabkkb">
                                                                        <option value="KAB">KAB</option>
                                                                        <option value="KKB">KKB</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button id="submitForm1" class="btn btn-primary rounded mt-4">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <script>
                                        // script form ke-2
                                        $(document).ready(function() {
                                            $('#search-daterange-form2').daterangepicker({
                                                autoUpdateInput: false,  
                                                locale: { format: 'YYYY-MM-DD' } 
                                            });
                                            $('#submitForm2').click(function(e) {
                                                e.preventDefault(); 
                                                var daterange = $('#search-daterange-form2').val();
                                                var cabang = $('#search-cabang-form2').val();
                                                var kabkkb = $('#search-kabkkb-form2').val();
                                                if (daterange === '') {
                                                    alert('Tanggal harus dipilih.');
                                                    return;
                                                }
                                                var dateParts = daterange.split(' - ');
                                                var startDate = moment(dateParts[0], 'MM/DD/YYYY').format('YYYY-MM-DD');  
                                                var endDate = moment(dateParts[1], 'MM/DD/YYYY').format('YYYY-MM-DD');    
                                                var url = 'https://info.adminkki.com/2024_form_nasabah_kelompok_bermasalah.php';
                                                var params = {
                                                    daterange: daterange,  
                                                    cabang: cabang,
                                                    kab_kkb: kabkkb
                                                };
                                                window.open(url + '?' + $.param(params), '_blank');
                                            });
                                        });
                                        // end script form ke-2
                                    </script>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Export Excel Detail Penyebab DTR</h2>
                                                </div>
                                                
                                                <div class="card-body py-4">
                                                    <form action="{{route('excelDetailPenyebabDtr')}}" target=_blank method="GET">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="daterange">Tanggal: </label>
                                                                    <input type="text" id="search-daterange-form3" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="kabkkb">KAB/KKB: </label>
                                                                    <select class="form-control" id="search-kabkkb-form3" name="kabkkb">
                                                                        <option value="KAB">KAB</option>
                                                                        <option value="KKB">KKB</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button id="submitForm3" class="btn btn-primary rounded mt-4">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                   
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Jumlah Transaksi Setoran Bulanan</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    <form action="{{route('excelTransaksiSetoran')}}" target=_blank method="GET">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="daterange">Tanggal: </label>
                                                                    <input type="text" id="search-daterange-form4" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="col-md-2">
                                                                <button id="submitForm4" class="btn btn-primary rounded mt-4">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                   
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Export Excel Rangkuman Penyebab DTR</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="daterange">Tanggal: </label>
                                                                <input type="text" id="search-daterange-form5" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="cabang">Cabang: </label>
                                                                <select class="form-control" id="search-cabang-form5" name="cabang">
                                                                    <option value="0">Semua Cabang</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-md-2">
                                                            <button id="submitForm5" class="btn btn-primary rounded mt-4">Submit</button>
                                                        </div>
                                                    </div>
                                                    
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <script>
                                        // script form ke-2
                                        $(document).ready(function() {
                                            $('#search-daterange-form5').daterangepicker({
                                                autoUpdateInput: false,  
                                                locale: { format: 'YYYY-MM-DD' } 
                                            });
                                            $('#submitForm5').click(function(e) {
                                                e.preventDefault(); 
                                                var daterange = $('#search-daterange-form5').val();
                                                var cabang = $('#search-cabang-form5').val();
                                                if (daterange === '') {
                                                    alert('Tanggal harus dipilih.');
                                                    return;
                                                }
                                                var dateParts = daterange.split(' - ');
                                                var startDate = moment(dateParts[0], 'MM/DD/YYYY').format('YYYY-MM-DD');  
                                                var endDate = moment(dateParts[1], 'MM/DD/YYYY').format('YYYY-MM-DD');    
                                                var url = 'https://info.adminkki.com/2024_excel_rangkuman_dtr.php';
                                                var params = {
                                                    daterange: daterange,  
                                                    cabang: cabang
                                                };
                                                window.open(url + '?' + $.param(params), '_blank');
                                            });
                                        });
                                        // end script form ke-2
                                    </script>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Export Excel Penanganan LPAB</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="daterange">Tanggal: </label>
                                                                <input type="text" id="search-daterange-form6" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="cabang">Cabang: </label>
                                                                <select class="form-control" id="search-cabang-form6" name="cabang">
                                                                    <option value="0">Semua Cabang</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-md-2">
                                                            <button id="submitForm6" class="btn btn-primary rounded mt-4">Submit</button>
                                                        </div>
                                                    </div>
                                                    
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <script>
                                        // script form ke-6
                                        $(document).ready(function() {
                                            $('#search-daterange-form6').daterangepicker({
                                                autoUpdateInput: false,  
                                                locale: { format: 'YYYY-MM-DD' } 
                                            });
                                            $('#submitForm6').click(function(e) {
                                                e.preventDefault(); 
                                                var daterange = $('#search-daterange-form6').val();
                                                var cabang = $('#search-cabang-form6').val();
                                                if (daterange === '') {
                                                    alert('Tanggal harus dipilih.');
                                                    return;
                                                }
                                                var dateParts = daterange.split(' - ');
                                                var startDate = moment(dateParts[0], 'MM/DD/YYYY').format('YYYY-MM-DD');  
                                                var endDate = moment(dateParts[1], 'MM/DD/YYYY').format('YYYY-MM-DD');    
                                                var url = 'https://info.adminkki.com/2024_excel_penanganan_lpab.php';
                                                var params = {
                                                    daterange: daterange,  
                                                    cabang: cabang
                                                };
                                                window.open(url + '?' + $.param(params), '_blank');
                                            });
                                        });
                                        // end script form ke-6
                                    </script>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h2 class="mt-6">Export Excel Penanganan LPKB</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="daterange">Tanggal: </label>
                                                                <input type="text" id="search-daterange-form7" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="cabang">Cabang: </label>
                                                                <select class="form-control" id="search-cabang-form7" name="cabang">
                                                                    <option value="0">Semua Cabang</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-md-2">
                                                            <button id="submitForm7" class="btn btn-primary rounded mt-4">Submit</button>
                                                        </div>
                                                    </div>
                                                    
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <script>
                                        // script form ke-6
                                        $(document).ready(function() {
                                            $('#search-daterange-form7').daterangepicker({
                                                autoUpdateInput: false,  
                                                locale: { format: 'YYYY-MM-DD' } 
                                            });
                                            $('#submitForm7').click(function(e) {
                                                e.preventDefault(); 
                                                var daterange = $('#search-daterange-form7').val();
                                                var cabang = $('#search-cabang-form7').val();
                                                if (daterange === '') {
                                                    alert('Tanggal harus dipilih.');
                                                    return;
                                                }
                                                var dateParts = daterange.split(' - ');
                                                var startDate = moment(dateParts[0], 'MM/DD/YYYY').format('YYYY-MM-DD');  
                                                var endDate = moment(dateParts[1], 'MM/DD/YYYY').format('YYYY-MM-DD');    
                                                var url = 'https://info.adminkki.com/2024_excel_penanganan_lpkb.php';
                                                var params = {
                                                    daterange: daterange,  
                                                    cabang: cabang
                                                };
                                                window.open(url + '?' + $.param(params), '_blank');
                                            });
                                        });
                                        // end script form ke-6
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
            flatpickr("#search-daterange-form1", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
            flatpickr("#search-daterange-form2", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
            flatpickr("#search-daterange-form3", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
            flatpickr("#search-daterange-form4", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
            flatpickr("#search-daterange-form5", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
            flatpickr("#search-daterange-form6", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
		
        @include('layout.footer')