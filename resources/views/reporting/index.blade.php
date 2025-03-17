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
                                                        <input type="date" class="form-control form-control-solid ps-13" id="cari-tanggal-laporan" placeholder="TANGGAL" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">Cabang:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <select class="form-control form-control-solid ps-13" id="cari-cabang-laporan">
                                                            <?php if(session('id_role2') != 2){?>
                                                                <option value="<?php echo session('cabang');?>"><?php echo session('cabang');?></option>
                                                            <?php } else {?>
                                                                <option value="0">Semua Cabang</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            <?php }?>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-9">
                                                    <a href="#" id="laporanHarianAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> Submit
                                                    </a>
                                                    <a href="#" id="migrasiGagalbayarAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">
                                                        <i class="fa fa-download"></i> Migrasi Gagal Bayar
                                                    </a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">NO KELOMPOK:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-nomor-history" placeholder="no kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label class="form-label fs-6 fw-bold">KELOMPOK TERAKHIR:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-kelompok-history" placeholder="Nama kelompok" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 mt-9">
                                                    <button id="searchKelompok" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearcKelompok" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
									<div class="card">
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="historyTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
														<th class="min-w-100px">ID</th>
                                                        <th class="min-w-100px">No Kelompok</th>
														<th class="min-w-100px">Nama Kelompok</th>
                                                        <th class="min-w-100px">Jumlah Pinjaman</th>
                                                        <th class="min-w-100px">Cair</th>
                                                        <th class="min-w-100px">Periode</th>
                                                        <th class="min-w-100px">Status</th>
                                                        <th class="min-w-100px">Action</th>
                                                        
													</tr>
												</thead>
											
											</table>
										</div>
									</div>
                                    <hr> -->
                                    
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
        <script>
            $('#laporanHarianAction').on('click', function(e) {
                e.preventDefault(); 
                var tanggal = $('#cari-tanggal-laporan').val();
                var cabang = $('#cari-cabang-laporan').val();
                if (!tanggal) {
                    alert('Please select a date.');
                    return;
                }

                var url = "{{ route('pdfLaporanHarian') }}" + "?tanggal=" + tanggal + "&cabang=" + cabang;
                var link = document.createElement('a');
                link.href = url;
                link.target = "_blank"; // Membuka link di tab baru
                link.click();
            });

            
            $('#migrasiGagalbayarAction').on('click', function(e) {
                e.preventDefault(); 
                var tanggal = $('#cari-tanggal-laporan').val();
                var cabang = $('#cari-cabang-laporan').val();
                if (!tanggal || !cabang || cabang == 0) {
                    alert('tanggal tidak boleh kosong & pilih cabang tertentu (tidak bisa semua cabang)');
                    return;
                }

                var url = "{{ route('migrasiLapPeriode') }}" + "?tanggal=" + tanggal + "&cabang=" + cabang;
                var link = document.createElement('a');
                link.href = url;
                link.target = "_blank"; // Membuka link di tab baru
                link.click();
            });
        </script>

        @include('layout.footer')