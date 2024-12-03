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
												<a href="/home" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
											{{-- <div class="d-flex align-items-center gap-2 gap-lg-3">
												<a href="{{route('user.addUser')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-plus"></i>User</a>
											</div> --}}
										</div>
									</div>
									
									<div class="card">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                        <th>No</th>
														<th class="min-w-125px">Proposal</th>
														<th class="min-w-125px">Dosen</th>
                                                        <th class="min-w-125px">STATUS</th>
													</tr>
												</thead>
                                                <tbody>
                                                    @foreach($alur as $alur)

                                                    <?php 
                                                    if($alur->status_progress == "N"){
                                                        $disabled = 'disabled';
                                                        $button = 'warning';
                                                        $text = "Menunggu Verifikasi";
                                                    }else if($alur->status_progress == "T"){
                                                        $disabled = '';
                                                        $button = 'dark';
                                                        $text = "Ajukan Selesai";
                                                    }else if($alur->status_progress == "Y"){
                                                        $disabled = 'disabled';
                                                        $button = 'success';
                                                        $text = "Verifikasi Diterima";
                                                    }else{
                                                        $disabled = '';
                                                        $button = 'secondary';
                                                        $text = "Ajukan Selesai";
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>{{ $alur->urutan }}</td>
                                                        <td>{{ $alur->progress }}</td>
                                                        <td>{{ $alur->penanggung_jawab }}</td>
                                                        <td><button {{$disabled}} class="btn btn-{{$button}} ajukan-selesai" data-id="{{ $alur->id }}">{{$text}}</button></td>
                                                    </tr>
													
												@endforeach
                                                </tbody>
											
											</table>
											<!--end::Table-->
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
        <script type="text/javascript">
            $(document).ready(function() {
                $('.ajukan-selesai').on('click', function() {
                    // Ambil ID dari data-id tombol yang diklik
                    let alurId = $(this).data('id');
                    let userId = '{{ session("id_user2") }}'; // Ambil id_user dari session
        
                    // Tampilkan konfirmasi SweetAlert
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan mengajukan selesai untuk progress ini.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, ajukan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika konfirmasi "Ya", jalankan proses AJAX
                            $.ajax({
                                url: '{{ route("ajukanSelesai") }}', // Pastikan route mengarah ke controller yang tepat
                                type: 'POST',
                                data: {
                                    id: alurId,
                                    id_user: userId,
                                    _token: '{{ csrf_token() }}' // CSRF Token
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Sukses',
                                        text: 'Progress berhasil diperbarui',
                                        icon: 'success'
                                    }).then(function() {
                                        location.reload(); // Reload halaman setelah alert ditutup
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire('Error', 'Gagal memperbarui progress', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>
		
        @include('layout.footer')