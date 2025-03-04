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
												<a href="{{route('cariAnggota');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
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
                                                        <label class="form-label">Tanggal Lahir:</label>
                                                        <input type="text" class="form-control" id="detail-tgl_lahir-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Usia:</label>
                                                        <input type="text" class="form-control" id="detail-usia-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">No Telepon:</label>
                                                        <input type="text" class="form-control" id="detail-telepon-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat:</label>
                                                        <input type="text" class="form-control" id="detail-alamat-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Kelempok:</label>
                                                        <input type="text" class="form-control" id="detail-kelompok-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Total Pinjaman:</label>
                                                        <input type="text" class="form-control" id="detail-pinjaman-anggota" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Tanggal Pencairan:</label>
                                                        <input type="text" class="form-control" id="detail-tgl_cair-anggota" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
									<div class="card mt-4">
                                        <div class="card-header">
                                            <h2 class="pt-4">History Pinjaman</h2>
                                        </div>
                                        <input type="hidden" id="detail-nasabah_id" value="{{$nasabah_id}}">
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="historyAnggotaTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Nama Kelompok</th>
                                                        <th class="min-w-100px">Tanggal Cair</th>
														<th class="min-w-100px">Pinjaman</th>
                                                        <th class="min-w-100px">Periode</th>
                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr>
                                    <div class="card mt-4">
                                        <div class="card-header">
                                            <h2 class="pt-4">History Masalah</h2>
                                        </div>
                                        <input type="hidden" id="detail-nasabah_id" value="{{$nasabah_id}}">
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="historyAnggotaMasalahTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Kelompok</th>
                                                        <th class="min-w-100px">Set Ke</th>
														<th class="min-w-100px">Tanggal</th>                                                        
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
                $('#historyAnggotaTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getHistoryAnggota') }}",
                        data: function (d) {
                            d.nasabah_id = $('#detail-nasabah_id').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'deskripsi_group1', name: 'deskripsi_group1'},
                        {data: 'tgl_realisasi', name: 'tgl_realisasi'},
                        {data: 'jml_pinjaman', name: 'jml_pinjaman'},
                        {data: 'jml_angsuran', name: 'jml_angsuran'},
                    ]
                });

                
                $('#historyAnggotaMasalahTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getHistoryMasalahAnggota') }}",
                        data: function (d) {
                            d.nasabah_id = $('#detail-nasabah_id').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'kelompok_ab', name: 'kelompok_ab'},
                        {data: 'setoran_ab', name: 'setoran_ab'},
                        {data: 'tanggal_ab', name: 'tanggal_ab'},
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
                        $('#detail-tgl_lahir-anggota').val(response.tgllahir);
                        $('#detail-telepon-anggota').val(response.TELPON);
                        $('#detail-alamat-anggota').val(response.ALAMAT);
                        $('#detail-kelompok-anggota').val(response.deskripsi_group1);
                        $('#detail-pinjaman-anggota').val(response.jml_pinjaman);
                        $('#detail-tgl_cair-anggota').val(response.tgl_realisasi);

                        var tgllahir = response.tgllahir; // Pastikan formatnya 'YYYY-MM-DD'
                        var tanggalLahir = new Date(tgllahir);
                        var today = new Date();
                        var usia = today.getFullYear() - tanggalLahir.getFullYear();
                        var m = today.getMonth() - tanggalLahir.getMonth();
                        if (m < 0 || (m === 0 && today.getDate() < tanggalLahir.getDate())) {
                            usia--; 
                        }
                        $('#detail-usia-anggota').val(usia);

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });
            });
        </script>
        @include('layout.footer')