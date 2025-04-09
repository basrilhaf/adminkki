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
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">List {{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
                                            <div class="d-flex align-items-center gap-2 gap-lg-3">
												<a href="{{route('cekTabungan.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Anggota:</label>
                                                        <input type="text" class="form-control" id="detail-nama-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">No ID Anggota:</label>
                                                        <input type="text" class="form-control" id="detail-id-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">No KTP:</label>
                                                        <input type="text" class="form-control" id="detail-ktp-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Saldo Anggota:</label>
                                                        <input type="text" class="form-control" id="total_tabungan" disabled>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
									<div class="card mt-4">
                                        <div class="card-header">
                                            <h2 class="pt-4">History Tabungan</h2>
                                        </div>
                                        <input type="hidden" id="detail-nasabah_id" value="{{$nasabah_id}}">
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="historyTabunganTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th>Tanggal</th>
														<th>Tipe</th>
                                                        <th class="min-w-100px">Jumlah</th>
                                                        <th class="min-w-125px">Keterangan</th>
                                                        
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
 		
        <script type="text/javascript">
            $(document).ready(function () {
                $('#historyTabunganTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getCekTabunganAnggota') }}",
                        data: function (d) {
                            d.nasabah_id = $('#detail-nasabah_id').val();
                        },
                        // Handle the data after fetching from server
                        dataSrc: function (json) {
                            // Initialize total variables for TRANS_TYPE 100 and 200
                            let totalPokok100 = 0;
                            let totalPokok200 = 0;

                            // Loop through the rows and accumulate totals
                            json.data.forEach(function (row) {
                                if (row.KODE_TRANS === '100') {
                                    totalPokok100 += parseFloat(row.POKOK);
                                }else if (row.KODE_TRANS === '113') {
                                    totalPokok100 += parseFloat(row.POKOK);
                                
                                } else if (row.KODE_TRANS === '200') {
                                    totalPokok200 += parseFloat(row.POKOK);
                                }
                            });

                            // Calculate the difference
                            let totalTabungan = totalPokok100 - totalPokok200;

                            // Format the result and update the input field with id 'total_tabungan'
                            $('#total_tabungan').val('Rp ' + totalTabungan.toLocaleString('id-ID'));

                            // Return the data to be rendered in the table
                            return json.data;
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'TGL_TRANS', name: 'TGL_TRANS'},
                        {data: 'TRANS_TYPE', name: 'TRANS_TYPE'},
                        {
                            data: 'POKOK',
                            name: 'POKOK',
                            render: function (data, type, row) {
                                return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
                            }
                        },
                        {data: 'deskripsi_keterangan', name: 'deskripsi_keterangan'},
                    ]
                });

                var nasabah_id = $('#detail-nasabah_id').val();
                var url = "{{ route('getDetailAnggota', ':nasabah_id') }}";
                url = url.replace(':nasabah_id', nasabah_id);
                // alert(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-nama-anggota').val(response.NAMA_NASABAH);
                        $('#detail-id-anggota').val(response.nasabah_id);
                        $('#detail-ktp-anggota').val(response.no_id);
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });
            });
        </script>
        @include('layout.footer')