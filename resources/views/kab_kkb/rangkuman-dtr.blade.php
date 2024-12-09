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
                                                    <h2 class="mt-6">Filter</h2>
                                                </div>
                                                <div class="card-body py-4">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="daterange">Rentang Tanggal: </label>
                                                                <input type="text" id="search-daterange-dtr" name="daterange" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="daterange">Cabang: </label>
                                                                <select name="cabang" id="search-cabang-dtr" class="form-control">
                                                                    <option value="0">Semua Cabang</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button id="submitKab" class="btn btn-primary rounded mt-4">Submit</button>
                                                            <button id="submitExcelKab" style="display: none;" class="btn btn-warning rounded mt-4">Export Excel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                    <hr>
                                    
                                    <div class="card">
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="tableKab" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>Penyebab DTR</th>
                                                        <th>Jumlah</th>
													</tr>
												</thead>
											</table>
											<!--end::Table-->
										</div>
										<!--end::Card body-->
									</div>
                                    <!--begin::Card-->
                                    <hr>
                                    <script>
                                        // script form ke-6
                                        $(document).ready(function() {
                                            
                                            $('#submitExcelKab').click(function(e) {
                                                e.preventDefault(); 
                                                var daterange = $('#search-daterange-dtr').val();
                                                var cabang = $('#search-cabang-dtr').val();
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
                                        // end script form ke-6
                                    </script>

                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var tableKab;
                                            var tableDikunjungi;

                                            $('#submitKab').click(function () {
                                                if($('#search-daterange-dtr').val() === ''){
                                                    alert("masukkan tanggal");
                                                }
                                                $('#tableKab').show();
                                                $('#submitExcelKab').show();
                                                
                                                if ($.fn.dataTable.isDataTable('#tableKab')) {
                                                    tableKab.ajax.reload();
                                                } else {
                                                    tableKab = $('#tableKab').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        ajax: {
                                                            url: "{{ route('getTableRangkumanDtr') }}",
                                                            data: function (d) {
                                                                d.cabang = $('#search-cabang-dtr').val();
                                                                d.daterange = $('#search-daterange-dtr').val();
                                                            }
                                                        },
                                                        columns: [
                                                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                                            {data: 'penyebab_ab', name: 'penyebab_ab'},
                                                            {data: 'jumlah', name: 'jumlah'},
                                                            
                                                        ]
                                                    });
                                                }

                                                
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
            flatpickr("#search-daterange-dtr", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
		
        @include('layout.footer')