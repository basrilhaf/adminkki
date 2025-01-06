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
                                                    <label class="form-label fs-6 fw-bold">KEYWORD:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="cari-keyword-anggota" placeholder="KEYWORD" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">CARI BERDASARKAN:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <select class="form-control form-control-solid ps-13" id="cari-berdasarkan-anggota">
                                                            <option value="3">ID Anggota</option>
                                                            <option value="1">Nama</option>
                                                            <option value="2">No. KTP</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="cariAnggotaAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Submit</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
									<div class="card">
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="cariAnggotaTable" style="display: none">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">ID</th>
                                                        <th class="min-w-100px">Nama</th>
														<th class="min-w-100px">Klpk Terakhir</th>
                                                        <th class="min-w-100px">Jumlah Pinjaman</th>
                                                        <th class="min-w-100px">KTP</th>
                                                        <th class="min-w-100px">DTR</th>
                                                        <th class="min-w-100px">Action</th>
                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr>
                                    
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
        <script>
            $(document).ready(function () {
                var cariAnggotaTable; // Define the DataTable variable
        
                // Function to initialize the DataTable or reload it
                function initializeDataTable() {
                    // Only initialize the DataTable if it's not already initialized
                    if ($.fn.dataTable.isDataTable('#cariAnggotaTable')) {
                        // If DataTable is already initialized, just reload the data
                        cariAnggotaTable.ajax.reload();
                    } else {
                        // Otherwise, initialize the DataTable
                        cariAnggotaTable = $('#cariAnggotaTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('getCekAnggota') }}",
                                data: function (d) {
                                    d.keyword = $('#cari-keyword-anggota').val();
                                    d.cari = $('#cari-berdasarkan-anggota').val();
                                    d.nama = $('#search-nama-anggota').val();
                                    d.kelompok = $('#search-kelompok-anggota').val();
                                }
                            },
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                {data: 'nasabah_id', name: 'nasabah_id'},
                                {data: 'NAMA_NASABAH', name: 'NAMA_NASABAH'},
                                {data: 'DESKRIPSI_GROUP1', name: 'DESKRIPSI_GROUP1'},
                                {
                                    data: 'jml_pinjaman',
                                    name: 'jml_pinjaman',
                                    render: function (data, type, row) {
                                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
                                    }
                                },
                                {data: 'no_id', name: 'no_id'},
                                {data: 'dtr', name: 'dtr', orderable: false, searchable: false},
                                {data: 'action', name: 'action', orderable: false, searchable: false}
                            ]
                        });
                    }
                }
        
                // Event listener for the search button
                $('#cariAnggotaAction').click(function () {
                    $('#cariAnggotaTable').show();  // Show the table when the search button is clicked
                    initializeDataTable();  // Initialize or reload DataTable based on the current filters
                });
        
                // Event listener for the reset search button
                $('#resetSearchCariAnggota').click(function () {
                    // Clear the search fields
                    $('#search-nama-anggota').val('');
                    $('#search-kelompok-anggota').val('');
        
                    // Reload the DataTable with cleared filters
                    initializeDataTable();
                });
        
                // Event listener for the "Search" button click
                $('#searchCariAnggota').click(function () {
                    // Reload the DataTable with the current filters
                    initializeDataTable();
                });
            });
        </script>


        @include('layout.footer')