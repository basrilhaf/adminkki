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
									<!--begin::Card-->
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
									<div class="card">										
										<div class="card-body py-4">
											<div class="row">
												<div class="col-md-3">
													<div class="card card-flush h-md-50 mb-xl-10 bg-primary">
														<div class="card-header pt-3">
															<div class="card-title d-flex flex-column">
																<div class="d-flex align-items-center">
																	<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-kumpulan-aktif">Memuat data...</span>
																</div>
																<span class="text-white pt-1 fw-semibold fs-6">Total Kumpulan Aktif</span>
															</div>
														</div>
														<!--end::Header-->
														<!--begin::Card body-->
														<div class="card-body d-flex align-items-end pb-4 mb-4">
															
														</div>
														<!--end::Card body-->
													</div>
												</div>
												<div class="col-md-3">
													<div class="card card-flush h-md-50 mb-xl-10 bg-warning">
														<div class="card-header pt-3">
															<div class="card-title d-flex flex-column">
																<div class="d-flex align-items-center">
																	<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-kelompok-aktif">Memuat data...</span>
																</div>
																<span class="text-white pt-1 fw-semibold fs-6">Total Kelompok Aktif</span>
															</div>
														</div>
														<!--end::Header-->
														<!--begin::Card body-->
														<div class="card-body d-flex align-items-end pb-4 mb-4">
															
														</div>
														<!--end::Card body-->
													</div>
												</div>
												<div class="col-md-3">
													<div class="card card-flush h-md-50 mb-xl-10 bg-success">
														<div class="card-header pt-3">
															<div class="card-title d-flex flex-column">
																<div class="d-flex align-items-center">
																	<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-anggota-aktif-tnp-md">Memuat data...</span>
																</div>
																<span class="text-white pt-1 fw-semibold fs-7">Total Anggota Aktif (tanpa MD)</span>
															</div>
														</div>
														<!--end::Header-->
														<!--begin::Card body-->
														<div class="card-body d-flex align-items-end pb-4 mb-4">
															
														</div>
														<!--end::Card body-->
													</div>
												</div>
												<div class="col-md-3">
													<div class="card card-flush h-md-50 mb-xl-10 bg-danger">
														<div class="card-header pt-3">
															<div class="card-title d-flex flex-column">
																<div class="d-flex align-items-center">
																	<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-anggota-aktif-dgn-md">Memuat data...</span>
																</div>
																<span class="text-white pt-1 fw-semibold fs-7">Total Anggota Aktif (dengan MD)</span>
															</div>
														</div>
														<!--end::Header-->
														<!--begin::Card body-->
														<div class="card-body d-flex align-items-end pb-4 mb-4">
															
														</div>
														<!--end::Card body-->
													</div>
												</div>
												<div class="col-md-12">
													<div class="card">
														<div class="card-body">
															<div class="row">
																<div class="col-md-3">
																	<div class="mb-4 fv-row">
																		<label class="required form-label">Cabang</label>
																		<select id="cabang-chart" class="form-control mb-2">
																		</select>
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="mb-4 fv-row">
																		<label class="required form-label">Filter By:</label>
																		<select id="filter-by-chart" class="form-control mb-2">
																			<option value="thn">Tahun</option>
																			<option value="tgl">Tanggal</option>
																		</select>
																	</div>
																</div>
																<div class="col-md-3" id="div-tahun-chart">
																	<div class="mb-4 fv-row">
																		<label class="required form-label">Tahun:</label>
																		<select id="tahun-chart" class="form-control mb-2">
																			<option <?php if(date('Y')=='2022'){ echo "selected";  }  ?> value="2022">2022</option>
																			<option <?php if(date('Y')=='2023'){ echo "selected";  }  ?> value="2023">2023</option>
																			<option <?php if(date('Y')=='2024'){ echo "selected";  }  ?> value="2024">2024</option>
																			<option <?php if(date('Y')=='2025'){ echo "selected";  }  ?> value="2025">2025</option>
																			<option <?php if(date('Y')=='2026'){ echo "selected";  }  ?> value="2026">2026</option>
																			<option <?php if(date('Y')=='2027'){ echo "selected";  }  ?> value="2027">2027</option>
																		</select>
																	</div>
																</div>
																<div class="col-md-2" id="div-tampil-chart">
																	<div class="mb-4 fv-row">
																		<label class="required form-label">Tampil Berdasarkan:</label>
																		<select id="tampil-chart" class="form-control mb-2">
																			<option value="bul">Bulan</option>
																			<option value="min">Minggu</option>
																		</select>
																	</div>
																</div>
																<div class="col-md-3" id="div-tanggal-chart" style="display: none;">
																	<div class="mb-4 fv-row">
																		<label class="required form-label">Tanggal:</label>
																		<input type="text" id="tanggal-chart" class="form-control" placeholder="YYYY-MM-DD - YYYY-MM-DD">
																	</div>
																</div>
																<div class="col-md-2">
																	<div class="mt-4 fv-row">
																		<button class="btn btn-primary mt-2" id="buttonFilterChart">Submit</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<script>
													$('#filter-by-chart').change(function() {
														if ($(this).val() == 'thn') {
															$('#div-tahun-chart').show();
															$('#div-tampil-chart').show();
															$('#div-tanggal-chart').hide();
														} else {
															$('#div-tahun-chart').hide();
															$('#div-tampil-chart').hide();
															$('#div-tanggal-chart').show();
														}
														
														
													});
												</script>
												
												<div class="col-md-12">
													<div class="card card-flush">
														<div class="card-header">
															<h2 class="mt-4">Masalah Anggota</h2>
														</div>
														<div class="card-body">
															<canvas id="abChart" width="400" height="200"></canvas>
															<script>
																$(document).ready(function() {
																	var chart;
																	updateChartData();

																	function updateChartData() {
																		var cabang = $('#cabang-chart').val();
																		var filterBy = $('#filter-by-chart').val();
																		var tahun = $('#tahun-chart').val();
																		var tampilBerdasarkan = $('#tampil-chart').val();
																		var tanggal = $('#tanggal-chart').val(); 
																		var data = {
																			cabang: cabang,
																			filter_by: filterBy,
																			tampil_berdasarkan: tampilBerdasarkan,
																			tahun: tahun,
																			tanggal: tanggal
																		};
															
																		$.ajax({
																			url: "{{ route('chartAnggotaBermasalah') }}", // Ganti dengan URL yang sesuai
																			method: 'GET',
																			data: data,
																			success: function(response) {
																				updateChart(response);
																			},
																			error: function(xhr, status, error) {
																				console.error('Error fetching chart data:', error);
																			}
																		});
																	}
															
																	$('#buttonFilterChart').click(function() {
																		updateChartData();
																	});
															
																	function updateChart(data) {
																		if (chart) {
																			chart.destroy(); 
																		}
															
																		var ctx = document.getElementById('abChart').getContext('2d');
															
																		chart = new Chart(ctx, {
																			type: 'line', 
																			data: {
																				labels: data.bulan, 
																				datasets: [{
																					label: 'Total Masalah Anggota',
																					data: data.jumlah, 
																					borderColor: 'rgb(75, 192, 192)',
																					backgroundColor: 'rgba(75, 192, 192, 0.2)',
																					fill: true
																				}]
																			},
																			options: {
																				responsive: true,
																				scales: {
																					y: {
																						beginAtZero: true
																					}
																				}
																			}
																		});
																	}
																});
															</script>
														</div>

													</div>
												</div>
												<div class="col-md-6">
													<div class="card card-flush">
														<div class="card-header">
															<h2 class="mt-4">Kelompok Telat</h2>
														</div>
														<div class="card-body">
															<canvas id="ktChart" width="400" height="200"></canvas>
															<script>
																$(document).ready(function() {
																	var chart;
																	updateChartData();

																	function updateChartData() {
																		var cabang = $('#cabang-chart').val();
																		var filterBy = $('#filter-by-chart').val();
																		var tahun = $('#tahun-chart').val();
																		var tampilBerdasarkan = $('#tampil-chart').val();
																		var tanggal = $('#tanggal-chart').val(); 
																		var data = {
																			cabang: cabang,
																			filter_by: filterBy,
																			tampil_berdasarkan: tampilBerdasarkan,
																			tahun: tahun,
																			tanggal: tanggal
																		};
															
																		$.ajax({
																			url: "{{ route('chartKelompokTelat') }}", // Ganti dengan URL yang sesuai
																			method: 'GET',
																			data: data,
																			success: function(response) {
																				updateChart(response);
																			},
																			error: function(xhr, status, error) {
																				console.error('Error fetching chart data:', error);
																			}
																		});
																	}
															
																	$('#buttonFilterChart').click(function() {
																		updateChartData();
																	});
															
																	function updateChart(data) {
																		if (chart) {
																			chart.destroy(); 
																		}
															
																		var ctx = document.getElementById('ktChart').getContext('2d');
															
																		chart = new Chart(ctx, {
																			type: 'line', 
																			data: {
																				labels: data.bulan, 
																				datasets: [{
																					label: 'Total Kelompok Telat',
																					data: data.jumlah, 
																					borderColor: 'rgb(75, 192, 192)',
																					backgroundColor: 'rgba(75, 192, 192, 0.2)',
																					fill: true
																				}]
																			},
																			options: {
																				responsive: true,
																				scales: {
																					y: {
																						beginAtZero: true
																					}
																				}
																			}
																		});
																	}
																});
															</script>
														</div>

													</div>
												</div>
												<div class="col-md-6">
													<div class="card card-flush">
														<div class="card-header">
															<h2 class="mt-4">Kelompok Berat</h2>
														</div>
														<div class="card-body">
															<canvas id="kbChart" width="400" height="200"></canvas>
															<script>
																$(document).ready(function() {
																	var chart;
																	updateChartData();

																	function updateChartData() {
																		var cabang = $('#cabang-chart').val();
																		var filterBy = $('#filter-by-chart').val();
																		var tahun = $('#tahun-chart').val();
																		var tampilBerdasarkan = $('#tampil-chart').val();
																		var tanggal = $('#tanggal-chart').val(); 
																		var data = {
																			cabang: cabang,
																			filter_by: filterBy,
																			tampil_berdasarkan: tampilBerdasarkan,
																			tahun: tahun,
																			tanggal: tanggal
																		};
															
																		$.ajax({
																			url: "{{ route('chartKelompokBerat') }}", // Ganti dengan URL yang sesuai
																			method: 'GET',
																			data: data,
																			success: function(response) {
																				updateChart(response);
																			},
																			error: function(xhr, status, error) {
																				console.error('Error fetching chart data:', error);
																			}
																		});
																	}
															
																	$('#buttonFilterChart').click(function() {
																		updateChartData();
																	});
															
																	function updateChart(data) {
																		if (chart) {
																			chart.destroy(); 
																		}
															
																		var ctx = document.getElementById('kbChart').getContext('2d');
															
																		chart = new Chart(ctx, {
																			type: 'line', 
																			data: {
																				labels: data.bulan, 
																				datasets: [{
																					label: 'Total Kelompok Telat',
																					data: data.jumlah, 
																					borderColor: 'rgb(75, 192, 192)',
																					backgroundColor: 'rgba(75, 192, 192, 0.2)',
																					fill: true
																				}]
																			},
																			options: {
																				responsive: true,
																				scales: {
																					y: {
																						beginAtZero: true
																					}
																				}
																			}
																		});
																	}
																});
															</script>
														</div>

													</div>
												</div>
											</div>
											
										</div>
									</div>
									<!--end::Card-->
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
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script>
			flatpickr("#tanggal-chart", {
				mode: "range",
				dateFormat: "Y-m-d",
				locale: "id"
			});
			$(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getCabangOption') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#cabang-chart');
                        select.append('<option value="">Semua Cabang</option>');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.nama + '">' + data.nama + '</option>');
                        });
                        select.select2({
                            allowClear: true
                        });
                        Swal.close();
                    }
                });
                Swal.close();
            });
			$(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getDataTotalDashboard') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
						// alert(JSON.stringify(data));
                        $('#data-anggota-aktif-dgn-md').text(data.anggota_aktif_dgn_md); 
						$('#data-anggota-aktif-tnp-md').text(data.anggota_aktif_tanpa_md); 
						$('#data-kumpulan-aktif').text(data.kumpulan_aktif); 
						$('#data-kelompok-aktif').text(data.kelompok_aktif); 
                    },
					error: function(xhr, status, error) {
						console.error('Terjadi kesalahan: ' + error);
						$('#data-anggota-aktif-dgn-md').text('Gagal memuat data');
						$('#data-anggota-aktif-tnp-md').text('Gagal memuat data');
						$('#data-kumpulan-aktif').text('Gagal memuat data');
						$('#data-kelompok-aktif').text('Gagal memuat data');
					}
                });
                Swal.close();
            });
		</script>
		
        @include('layout.footer')