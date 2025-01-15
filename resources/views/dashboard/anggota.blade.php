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
                                    
									<div class="card">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
											<div class="row">
												<div class="col-md-3">
													<div class="card card-flush h-md-50 mb-xl-10 bg-primary">
														<div class="card-header pt-3">
															<div class="card-title d-flex flex-column">
																<div class="d-flex align-items-center">
																	<span class="fs-1hx fw-bold text-white me-2 lh-1 ls-n2" id="data-kumpulan-aktif">Memuat data...</span>
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
													<div class="card card-flush h-md-50 mb-xl-10 bg-danger">
														<div class="card-header pt-3">
															<div class="card-title d-flex flex-column">
																<div class="d-flex align-items-center">
																	<span class="fs-1hx fw-bold text-white me-2 lh-1 ls-n2" id="data-anggota-aktif-dgn-md">Memuat data...</span>
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
												<div class="col-md-3">
													<div class="card card-flush h-md-50 mb-xl-10 bg-warning">
														<div class="card-header pt-3">
															<div class="card-title d-flex flex-column">
																<div class="d-flex align-items-center">
																	<span class="fs-1hx fw-bold text-white me-2 lh-1 ls-n2" id="data-tabungan-anggota-aktif">Memuat data...</span>
																</div>
																<span class="text-white pt-1 fw-semibold fs-6">Total Tabungan Anggota Aktif</span>
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
																	<span class="fs-1hx fw-bold text-white me-2 lh-1 ls-n2" id="data-tabungan-semua-anggota">Memuat data...</span>
																</div>
																<span class="text-white pt-1 fw-semibold fs-7">Total Tabungan Semua Anggota</span>
															</div>
														</div>
														<!--end::Header-->
														<!--begin::Card body-->
														<div class="card-body d-flex align-items-end pb-4 mb-4">
															
														</div>
														<!--end::Card body-->
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="card card-flush">
														<div class="card-header">
															<h2 class="mt-4">Pencairan</h2>
															<div>
																<div class="col-md-12" id="div-tahun-chart">
																	<div class="mb-4 fv-row">
																		<label class="required form-label">Tahun:</label>
																		<select id="tahun-chart" class="form-control mb-2">
																			<option <?php if(date('Y')=='2022'){ echo "selected";  }  ?> value="2022">2022</option>
																			<option <?php if(date('Y')=='2023'){ echo "selected";  }  ?> value="2023">2023</option>
																			<option <?php if(date('Y')=='2024'){ echo "selected";  }  ?> value="2024">2024</option>
																			<option <?php if(date('Y')=='2025'){ echo "selected";  }  ?> value="2025">2025</option>
																			<option <?php if(date('Y')=='2026'){ echo "selected";  }  ?> value="2026">2026</option>
																			<option <?php if(date('Y')=='2027'){ echo "selected";  }  ?> value="2027">2027</option>
																			<option <?php if(date('Y')=='2028'){ echo "selected";  }  ?> value="2028">2028</option>
																		</select>
																	</div>
																</div>
															</div>
														</div>
														<div class="card-body">
															<div class="accordion accordion-flush" id="accordionFlushExample">
																<div class="accordion-item">
																  <h2 class="accordion-header">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
																	  Anggota
																	</button>
																  </h2>
																  <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
																	<div class="accordion-body">
																		<canvas id="apChart" width="400" height="200"></canvas>
																	</div>
																  </div>
																</div>
																<div class="accordion-item">
																  <h2 class="accordion-header">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
																	  Kelompok
																	</button>
																  </h2>
																  <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
																	<div class="accordion-body">
																		<canvas id="kpChart" width="400" height="200"></canvas>
																	</div>
																  </div>
																</div>
																
															  </div>
															  <script>
																$(document).ready(function() {
																	var chart;
																	var chart2;
																	updateChartData();
																	updateChartData2();
																	function updateChartData() {
																		var tahun = $('#tahun-chart').val();
																		var data = {
																			tahun: tahun
																		};
																		$.ajax({
																			url: "{{ route('chartPencairanAnggota') }}", // Ganti dengan URL yang sesuai
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

																	function updateChartData2() {
																		var tahun = $('#tahun-chart').val();
																		var data = {
																			tahun: tahun
																		};
																		$.ajax({
																			url: "{{ route('chartPencairanKelompok') }}", // Ganti dengan URL yang sesuai
																			method: 'GET',
																			data: data,
																			success: function(response) {
																				updateChart2(response);
																			},
																			error: function(xhr, status, error) {
																				console.error('Error fetching chart data:', error);
																			}
																		});
																	}
																	
																	function updateChart(data) {
																		if (chart) { chart.destroy(); }
																		var ctx = document.getElementById('apChart').getContext('2d');
																		chart = new Chart(ctx, {
																			type: 'line', 
																			data: {
																				labels: data.bulan, 
																				datasets: [{
																					label: 'Total Anggota Pencairan',
																					data: data.jumlah, 
																					borderColor: 'rgb(75, 192, 192)',
																					backgroundColor: 'rgba(75, 192, 192, 0.2)',
																					fill: true
																				}]
																			},
																			options: {
																				responsive: true, scales: { y: { beginAtZero: true } }
																			}
																		});
																	}

																	function updateChart2(data) {
																		if (chart2) { chart2.destroy(); }
																		var ctx2 = document.getElementById('kpChart').getContext('2d');
																		chart2 = new Chart(ctx2, {
																			type: 'line', 
																			data: {
																				labels: data.bulan, 
																				datasets: [{
																					label: 'Total Kelompok Pencairan',
																					data: data.jumlah, 
																					borderColor: 'rgb(75, 192, 192)',
																					backgroundColor: 'rgba(75, 192, 192, 0.2)',
																					fill: true
																				}]
																			},
																			options: {
																				responsive: true, scales: { y: { beginAtZero: true } }
																			}
																		});
																	}

																	$('#tahun-chart').change(function() {
																		updateChartData();
																		updateChartData2();
																	});
																});
															</script>
														
															</div>

													</div>
												</div>
												<div class="col-md-6">
													<div class="card card-flush">
														<div class="card-header">
															<h2 class="mt-4">Cabang</h2>
															
														</div>
														<div class="card-body">
															<div class="accordion accordion-flush" id="accordionFlushExample2">
																<div class="accordion-item">
																  <h2 class="accordion-header">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne2" aria-expanded="false" aria-controls="flush-collapseOne">
																	  Anggota Aktif
																	</button>
																  </h2>
																  <div id="flush-collapseOne2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample2">
																	<div class="accordion-body">
																		<canvas id="acChart" width="400" height="200"></canvas>
																	</div>
																  </div>
																</div>
																<div class="accordion-item">
																  <h2 class="accordion-header">
																	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo2" aria-expanded="false" aria-controls="flush-collapseTwo">
																	  Kelompok Aktif
																	</button>
																  </h2>
																  <div id="flush-collapseTwo2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample2">
																	<div class="accordion-body">
																		<canvas id="kcChart" width="400" height="200"></canvas>
																	</div>
																  </div>
																</div>
																
															  </div>
															  <script>
																$(document).ready(function() {
																	var chart;
																	var chart2;
																	updateChartData();
																	updateChartData2();
																	function updateChartData() {
																		var tahun = $('#tahun-chart').val();
																		var data = {
																			tahun: tahun
																		};
																		$.ajax({
																			url: "{{ route('chartCabangAnggota') }}", // Ganti dengan URL yang sesuai
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

																	function updateChartData2() {
																		var tahun = $('#tahun-chart').val();
																		var data = {
																			tahun: tahun
																		};
																		$.ajax({
																			url: "{{ route('chartCabangKelompok') }}", // Ganti dengan URL yang sesuai
																			method: 'GET',
																			data: data,
																			success: function(response) {
																				updateChart2(response);
																			},
																			error: function(xhr, status, error) {
																				console.error('Error fetching chart data:', error);
																			}
																		});
																	}
																	
																	function updateChart(data) {
																		if (chart) { chart.destroy(); }
																		var ctx = document.getElementById('acChart').getContext('2d');
																		chart = new Chart(ctx, {
																			type: 'bar', 
																			data: {
																				labels: data.bulan, 
																				datasets: [{
																					label: 'Total Anggota Aktif',
																					data: data.jumlah, 
																					borderColor: 'rgb(75, 192, 192)',
																					backgroundColor: 'rgba(75, 192, 192, 0.2)',
																					fill: true
																				}]
																			},
																			options: {
																				responsive: true, scales: { y: { beginAtZero: true } }
																			}
																		});
																	}

																	function updateChart2(data) {
																		if (chart2) { chart2.destroy(); }
																		var ctx2 = document.getElementById('kcChart').getContext('2d');
																		chart2 = new Chart(ctx2, {
																			type: 'bar', 
																			data: {
																				labels: data.bulan, 
																				datasets: [{
																					label: 'Total Kelompok Aktif',
																					data: data.jumlah, 
																					borderColor: 'rgb(75, 192, 192)',
																					backgroundColor: 'rgba(75, 192, 192, 0.2)',
																					fill: true
																				}]
																			},
																			options: {
																				responsive: true, scales: { y: { beginAtZero: true } }
																			}
																		});
																	}

																	
																});
															</script>
														
															</div>

													</div>
												</div>
												{{-- <div class="col-md-6">
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
												</div> --}}
												{{-- <div class="col-md-6">
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
												</div> --}}
											</div>
											
										</div>
										<!--end::Card body-->
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
						$('#data-tabungan-anggota-aktif').text(formatRupiah(data.tabungan_anggota_aktif)); 
						$('#data-tabungan-semua-anggota').text(formatRupiah(data.tabungan_semua_anggota)); 

						function formatRupiah(amount) {
							return new Intl.NumberFormat('id-ID', {
								style: 'currency',
								currency: 'IDR'
							}).format(amount);
						}
                    },
					error: function(xhr, status, error) {
						console.error('Terjadi kesalahan: ' + error);
						$('#data-anggota-aktif-dgn-md').text('Gagal memuat data');
						$('#data-anggota-aktif-tnp-md').text('Gagal memuat data');
						$('#data-kumpulan-aktif').text('Gagal memuat data');
						$('#data-kelompok-aktif').text('Gagal memuat data');
						$('#data-tabungan-anggota-aktif').text('Gagal memuat data');
						$('#data-tabungan-semua-anggota').text('Gagal memuat data');
					}
                });
                Swal.close();
            });
		</script>
		
        @include('layout.footer')