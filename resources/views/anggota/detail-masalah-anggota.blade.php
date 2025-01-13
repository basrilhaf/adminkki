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
												<a href="{{route('masalahAnggota');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
                                            <input type="hidden" id="detail-id-ma" value="{{$id_ma}}">
										</div>
									</div>
									<!--begin::Card-->
                                   
									<div class="card">
                                       
										<div class="card-body py-4">
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="detailMasalahAnggotaTable">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th>No</th>
                                                        <th class="min-w-125px">Anggota</th>
														<th class="min-w-125px">Kelompok</th>
                                                        <th class="min-w-100px">Tanggal</th>
														<th class="min-w-100px">Set ke-</th>
                                                        <th class="min-w-100px">Kode</th>
                                                        <th class="min-w-100px">Menit</th>
                                                        <th class="min-w-100px">PKP FSK</th>
														<th class="min-w-100px">Actions</th>
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
            $(document).ready(function() {
                $('#cek-anggota-ab').click(function(e) {
                    e.preventDefault();
                    
                    var idAnggota = $('#add-id_anggota-ab').val();  // Get the ID Anggota
                    
                    if (idAnggota) {
                        $.ajax({
                            url: "{{ route('getCekAnggotaValue') }}",  // Laravel route to handle the request
                            method: 'GET',
                            data: { id_anggota: idAnggota },  // Send the ID Anggota as parameter
                            success: function(response) {
                                if (response.success) {
                                    $('#add-anggota-ab').val(response.data.NAMA_NASABAH);
                                    $('#add-kelompok-ab').val(response.data.deskripsi_group1);
                                    $('#add-id_sikki-ab').val(response.data.nasabah_id);
                                } else {
                                    alert('Data tidak ditemukan!');
                                }
                            },
                            error: function() {
                                alert('Terjadi kesalahan, coba lagi!');
                            }
                        });
                    } else {
                        alert('ID Anggota tidak boleh kosong!');
                    }
                });
            });
            

            $(document).ready(function () {
                $('#detailMasalahAnggotaTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getDetailMasalahAnggota') }}",
                        data: function (d) {
                           
                            d.id_ma = $('#detail-id-ma').val();
                            
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama_ab', name: 'nama_ab'},
                        {data: 'kelompok_ab', name: 'kelompok_ab'},
                        {data: 'tanggal_ab', name: 'tanggal_ab'},
                        {data: 'setoran_ab', name: 'setoran_ab'},
                        {data: 'kode_ab', name: 'kode_ab'},
                        {data: 'menit_ab', name: 'menit_ab'},
                        {data: 'nama', name: 'nama'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
                


				$(document).on('click', '.btn-delete-detail-ma', function() {
                    var maId = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data masalah ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deleteDetailMaAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",  
                                    id_ab: maId
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Data Berhasil Dihapus',
                                        icon: 'success'
                                    }).then(function() {
                                        location.reload();  
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire('Error', 'Data Gagal Dihapus', 'error');
                                }
                            });
                        }
                    });

                });
                
            });
            
           
        
        </script>
        @include('layout.footer')