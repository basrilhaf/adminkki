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
												<a href="{{route('cariKelompok');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Kelompok:</label>
                                                        <input type="text" class="form-control" id="detail-nama-kelompok" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Anggota:</label>
                                                        <input type="text" class="form-control" id="detail-jml_anggota-kelompok" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Pinjaman:</label>
                                                        <input type="text" class="form-control" id="detail-jml_pinjaman-kelompok" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">PKP:</label>
                                                        <input type="text" class="form-control" id="detail-pkp-kelompok" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Tanggal Cair:</label>
                                                        <input type="text" class="form-control" id="detail-tgl_cair-kelompok" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Tanggal Perkiraan BTAB:</label>
                                                        <input type="text" class="form-control" id="detail-tgl_btab-kelompok" disabled>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <input type="hidden" id="detail-kode_group1" value="{{$kode_group1}}">
                                    <input type="hidden" id="detail-param" value="{{$param}}">
									<div class="card mt-4">
                                        <div class="card-header">
                                            <h2 class="pt-4">List Anggota</h2>
                                        </div>
                                        
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="anggotaKelompokTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">ID</th>
                                                        <th class="min-w-100px">Anggota</th>
														<th class="min-w-100px">Pinjaman</th>                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr>
                                    <div class="card mt-4">
                                        <div class="card-header">
                                            <h2 class="pt-4">List Masalah Kelompok</h2>
                                        </div>
                                        
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="masalahKelompokTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">Tanggal</th>
                                                        <th class="min-w-100px">Set-ke</th>
														<th class="min-w-100px">Kode</th>  
                                                        <th class="min-w-100px">Menit Telat</th>                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr>
                                    <div class="card mt-4">
                                        <div class="card-header">
                                            <h2 class="pt-4">Rangkuman Anggota bermasalah</h2>
                                        </div>
                                        
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="masalahAnggotaKelompokTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-125px">ID Anggota</th>
                                                        <th class="min-w-100px">Nama Anggota</th>
														<th class="min-w-100px">Cabang</th>  
                                                        <th class="min-w-100px">Jumlah DTR</th>                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
 		
        <script type="text/javascript">
            $(document).ready(function () {
                $('#anggotaKelompokTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getAnggotaKelompok') }}",
                        data: function (d) {
                            d.kode_group1 = $('#detail-param').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'nasabah_id', name: 'nasabah_id'},
                        {data: 'NAMA_NASABAH', name: 'NAMA_NASABAH'},
                        {data: 'jml_pinjaman', name: 'jml_pinjaman'},
                    ]
                });
                $('#masalahAnggotaKelompokTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getMasalahAnggotaKelompok') }}",
                        data: function (d) {
                            d.tanggal_cair = $('#detail-tgl_cair-kelompok').val();
                            d.kelompok = $('#detail-nama-kelompok').val();
                            d.tanggal_btab = $('#detail-tgl_btab-kelompok').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'id_anggota_ab', name: 'id_anggota_ab'},
                        {data: 'nama_ab', name: 'nama_ab'},
                        {data: 'cabang_ab', name: 'cabang_ab'},
                        {data: 'dtr', name: 'dtr'},
                    ]
                });

                var param = $('#detail-param').val();
                var url = "{{ route('getDetailKelompok', ':param') }}";
                url = url.replace(':param', param);
                // alert(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-nama-kelompok').val(response.deskripsi_group1);
                        $('#detail-jml_anggota-kelompok').val(response.jumlah_anggota);
                        $('#detail-jml_pinjaman-kelompok').val(response.jumlah_pinjaman);
                        $('#detail-pkp-kelompok').val(response.deskripsi_group2);
                        $('#detail-tgl_cair-kelompok').val(response.tgl_realisasi);
                        $('#detail-tgl_btab-kelompok').val(response.tgl_jatuh_tempo);
                        
                        $('#masalahKelompokTable').DataTable().ajax.reload();
                        setTimeout(function() {
                            $('#masalahAnggotaKelompokTable').DataTable().ajax.reload();
                        }, 300);

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });

                $('#masalahKelompokTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getHistoryMasalahKelompok') }}",
                        data: function (d) {
                            d.kelompok = $('#detail-nama-kelompok').val();
                            d.tanggal_cair = $('#detail-tgl_cair-kelompok').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'tanggal_kb', name: 'tanggal_kb'},
                        {data: 'setoran_kb', name: 'setoran_kb'},
                        {data: 'kode_kb', name: 'kode_kb'},
                        {data: 'menit_kb', name: 'menit_kb'},
                    ]
                });
                
            });
        </script>
        @include('layout.footer')