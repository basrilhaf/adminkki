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
                                    
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                    <hr>
                                    <div class="card mb-2">
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">No Kelompok:</label>
                                                    <input type="text" class="form-control" id="detail-no_kelompok-rtk" value="{{$detail->no_kelompok}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Nama Kelompok SIKKI:</label>
                                                    <input type="text" class="form-control" id="detail-nama_kelompok-rtk" value="{{$detail->nama_kelompok}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Nama Kelompok RTK:</label>
                                                    <input type="text" class="form-control" id="detail-nama_kelompok_rtk-rtk" value="{{$detail->nama_kelompok_rtk}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Jumlah Anggota:</label>
                                                    <input type="text" class="form-control" id="detail-jumlah_anggota-rtk" value="{{$detail->jumlah_anggota}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">% Cicilan Setsus:</label>
                                                    <input type="text" class="form-control" id="detail-setsus-rtk" value="{{$detail->setsus}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Cabang:</label>
                                                    <input type="text" class="form-control" id="detail-cabang-rtk" value="{{$detail->cabang}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Hari:</label>
                                                    <input type="text" class="form-control" id="detail-hari-rtk" value="{{$detail->hari}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">BTAB/BTK:</label>
                                                    <input type="text" class="form-control" id="detail-btab_btk-rtk" value="{{$detail->btab_btk}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Jumlah Setoran Mingguan(RTK):</label>
                                                    <input type="text" class="form-control" id="detail-set_mingguan_rtk-rtk" value="{{$detail->set_mingguan_rtk}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Jumlah Setoran Khusus/Acuan:</label>
                                                    <input type="text" class="form-control" id="detail-set_khusus-rtk" value="{{$detail->set_khusus}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Setoran Ke- (RTK):</label>
                                                    <input type="text" class="form-control" id="detail-set_ke_rtk-rtk" value="{{$detail->set_ke_rtk}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Durasi:</label>
                                                    <input type="text" class="form-control" id="detail-durasi-rtk" value="{{$detail->durasi}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Jumlah Setoran Mingguan (SIKKI):</label>
                                                    <input type="text" class="form-control" id="detail-set_mingguan_sikki-rtk" value="{{$detail->set_mingguan_sikki}}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Setoran Ke- (SIKKI):</label>
                                                    <input type="text" class="form-control" id="detail-set_ke_sikki-rtk" value="{{$detail->set_ke_sikki}}">
                                                </div>                                                

                                                <div class="col-md-4  pt-4">
                                                    <input type="hidden" class="form-control" id="detail-id-rtk" value="{{$id}}">
                                                    <button id="editRtkAction" class="btn btn-flex btn-success h-40px fs-7 fw-bold"> <i class="fa fa-save"></i>Update</button>
                                                </div>
                                               
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    
                                    <hr>
                                    

                                    <script type="text/javascript">
                                         $(document).ready(function() {
                                           
                                            $('#editRtkAction').click(function(e) {
                                                e.preventDefault();
                                                
                                                var no_kelompok = $('#detail-no_kelompok-rtk').val();
                                                var nama_kelompok_sikki = $('#detail-nama_kelompok-rtk').val();
                                                var nama_kelompok_rtk = $('#detail-nama_kelompok_rtk-rtk').val();
                                                var jumlah_anggota = $('#detail-jumlah_anggota-rtk').val();
                                                var cicilan_setsus = $('#detail-setsus-rtk').val();
                                                var cabang = $('#detail-cabang-rtk').val();
                                                var hari = $('#detail-hari-rtk').val();
                                                var btab_btk = $('#detail-btab_btk-rtk').val();
                                                var setoran_mingguan_rtk = $('#detail-set_mingguan_rtk-rtk').val();
                                                var setoran_khusus = $('#detail-set_khusus-rtk').val();
                                                var setoran_ke_rtk = $('#detail-set_ke_rtk-rtk').val();
                                                var durasi = $('#detail-durasi-rtk').val();
                                                var setoran_mingguan_sikki = $('#detail-set_mingguan_sikki-rtk').val();
                                                var setoran_ke_sikki = $('#detail-set_ke_sikki-rtk').val();
                                                var id = $('#detail-id-rtk').val();

                                                
                                                $.ajax({
                                                    url: "{{ route('updateRtkAction') }}",  // Update with your actual route
                                                    type: 'POST',
                                                    data: {
                                                        _token: "{{ csrf_token() }}",  // CSRF token for security
                                                        no_kelompok: no_kelompok,
                                                        nama_kelompok_sikki: nama_kelompok_sikki,
                                                        nama_kelompok_rtk: nama_kelompok_rtk,
                                                        jumlah_anggota: jumlah_anggota,
                                                        cicilan_setsus: cicilan_setsus,
                                                        cabang: cabang,
                                                        hari: hari,
                                                        btab_btk: btab_btk,
                                                        setoran_mingguan_rtk: setoran_mingguan_rtk,
                                                        setoran_khusus: setoran_khusus,
                                                        setoran_ke_rtk: setoran_ke_rtk,
                                                        durasi: durasi,
                                                        setoran_mingguan_sikki: setoran_mingguan_sikki,
                                                        setoran_ke_sikki: setoran_ke_sikki,
                                                        id: id
                                                    },
                                                    success: function(response) {
                                                        Swal.fire({
                                                            title: 'Success',
                                                            text: 'Data Berhasil Disimpan',
                                                            icon: 'success'
                                                        }).then(function() {
                                                            location.reload();  // Reload the page after the alert is closed
                                                        });
                                                    },
                                                    error: function(xhr, status, error) {
                                                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                                                    }
                                                });
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
            flatpickr("#search-daterange-tabLapangan", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id"
            });
        </script>
		
        @include('layout.footer')