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
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">Form {{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											<div class="d-flex align-items-center gap-2 gap-lg-3">
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <input type="hidden" id="detail-id_user-user" value="{{$id_user}}">
                                            <div class="row">
                                                <div class="col-md-8 card">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Nama</label>
                                                                <input type="text" id="detail-nama-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Email</label>
                                                                <input type="text" id="detail-email-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Fakultas</label>
                                                                <select id="detail-fakultas-user" class="form-control mb-2">
                                                                    <option value="">--Pilih fakultas---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Prodi</label>
                                                                <select id="detail-prodi-user" class="form-control mb-2">
                                                                    <option value="">--Pilih prodi---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Angkatan</label>
                                                                <select id="detail-angkatan-user" class="form-control mb-2">
                                                                    <option value="">--Pilih Angkatan---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">NIM</label>
                                                                <input type="text" id="detail-nim-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Dosen Pendamping Akademik</label>
                                                                <input type="text" disabled id="detail-pa-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        

                                                        <div class="col-md-12 mt-9 mb-4 d-flex justify-content-end">
                                                            <button id="updateUserAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="col-md-4 card pl-2">
                                                    <div class="row card">
                                                        <div class="card-body">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12 d-flex justify-content-center">
                                                                    <img id="detail-foto-user" alt="User Image" style="width: 100px; height: 100px;">
                                                                </div>
                                                                <div class="col-md-12 mt-3 d-flex justify-content-center">
                                                                    <input type="file" id="input-foto-user" accept="image/*" class="form-control" />
                                                                </div>
                                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                                    <button id="updateFotoAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>UBAH FOTO</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row card">
                                                        <div class="card-body">
                                                            <div class="col-md-12">
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Password Baru</label>
                                                                    <input type="password" id="detail-passwordnew-user" class="form-control mb-2">
                                                                </div>
                                                                <div class="mb-4 fv-row">
                                                                    <label class="required form-label">Konfirmasi Password Baru</label>
                                                                    <input type="password" id="detail-konfpasswordnew-user" class="form-control mb-2">
                                                                </div>
                                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                                    <button id="updatePasswordAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>UBAH PASSWORD</button>
                                                                </div>
                                                            </div>
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
        <script type="text/javascript">
            $(document).on('click', '#updateFotoAction', function(e) {
                e.preventDefault();

                let formData = new FormData();
                let foto = $('#input-foto-user')[0].files[0]; 
                let id_user = $('#detail-id_user-user').val(); 

                if (foto) {
                    formData.append('foto', foto);
                    formData.append('id_user', id_user); // Tambahkan id_user ke FormData

                    $.ajax({
                        url: "{{ route('updatePhotoAction', ':id_user') }}".replace(':id_user', id_user), // Update URL dengan ID pengguna
                        type: 'POST',
                        data: formData, // Gunakan formData
                        processData: false, // Pastikan ini diset ke false
                        contentType: false, // Pastikan ini diset ke false
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Berhasil', response.message, 'success');
                                $('#detail-foto-user').attr('src', response.foto); // Update tampilan foto
                            } else {
                                Swal.fire('Gagal', 'Foto gagal diperbarui', 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Ada kesalahan pada server', 'error');
                        }
                    });
                } else {
                    Swal.fire('Peringatan', 'Pilih foto terlebih dahulu', 'warning');
                }
            });


            $(document).ready(function() {
                $('#updatePasswordAction').click(function(e) {
                    e.preventDefault();
                    
                    var id_user = $('#detail-id_user-user').val();
                    var passwordnew = $('#detail-passwordnew-user').val();
                    var passwordkonf = $('#detail-konfpasswordnew-user').val();
                    
                    if(passwordnew !== passwordkonf){
                        Swal.fire('Error', 'Konfirmasi password tidak sama', 'error');
                    }else{
                        $.ajax({
                            url: "{{ route('updatePasswordAction') }}",  // Update with your actual route
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",  // CSRF token for security
                                id_user: id_user,
                                passwordnew: passwordnew,
                                passwordkonf: passwordkonf
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Password Berhasil Diubah',
                                    icon: 'success'
                                }).then(function() {
                                    location.reload();  // Reload the page after the alert is closed
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                            }
                        });
                    }
                });

                $('#updateUserAction').click(function(e) {
                    e.preventDefault();
                    
                    var id_user = $('#detail-id_user-user').val();
                    var nama_user = $('#detail-nama-user').val();
                    var email = $('#detail-email-user').val();
                    var fakultas = $('#detail-fakultas-user').val();
                    var prodi = $('#detail-prodi-user').val();
                    var angkatan = $('#detail-angkatan-user').val();
                    var nim = $('#detail-nim-user').val();
                    
                    $.ajax({
                        url: "{{ route('updateUserAction') }}",  // Update with your actual route
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  // CSRF token for security
                            id_user: id_user,
                            nama_user: nama_user,
                            email: email,
                            fakultas: fakultas,
                            prodi: prodi,
                            angkatan: angkatan,
                            nim: nim
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


                var id_user = $('#detail-id_user-user').val();
                var url = "{{ route('user.showDetailUser', ':id_user') }}";
                var image = "{{ asset('assets/media/avatars/user.png') }}";
                url = url.replace(':id_user', id_user);
                // alert(image);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-nama-user').val(response.nama);
                        $('#detail-fakultas-user').val(response.nama_fakultas);
                        $('#detail-prodi-user').val(response.nama_prodi);
                        $('#detail-nim-user').val(response.nim);
                        $('#detail-angkatan-user').val(response.nama_angkatan);
                        $('#detail-email-user').val(response.email);
                        $('#detail-pa-user').val(response.pa);

                        // fetch 
                        
                        $('#detail-fakultas-user').val(response.fakultas);
                        fetchFakultas(response.fakultas);
                        $('#detail-prodi-user').val(response.prodi);
                        fetchProdi(response.prodi,response.fakultas);
                        $('#detail-angkatan-user').val(response.angkatan);
                        fetchAngkatan(response.angkatan);

                        $('#detail-foto-user').attr('src', response.foto ? response.foto : image);

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });
                $('#detail-fakultas-user').on('change', function() {
                    var selectedFakultas = $(this).val();
                    var prodi = '';
                    fetchProdi(prodi,selectedFakultas);
                });

                
                function fetchFakultas(fakultas) {
                    var jkUrl = "{{ route('getFakultas') }}";
                    $.ajax({
                        url: jkUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-fakultas-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Fakultas---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.id === fakultas) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.id + '" ' + selected + '>' + data.fakultas + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching fakultas data');
                        }
                    });
                }

                function fetchProdi(prodi,fakultas) {
                    var kotaUrl = "{{ route('getProdiByFakultas') }}";
                    $.ajax({
                        url: kotaUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { fakultas: fakultas },
                        success: function(data) {
                            var $select = $('#detail-prodi-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Prodi---</option>');
                            data.forEach(function(dataprodi) {
                                var selected = '';
                                if (dataprodi.id === prodi) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataprodi.id + '" ' + selected + '>' + dataprodi.prodi + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching prodi data');
                        }
                    });
                }

                function fetchAngkatan(angkatan) {
                    var akUrl = "{{ route('getAngkatan') }}";
                    $.ajax({
                        url: akUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-angkatan-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Angkatan---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.id === angkatan) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.id + '" ' + selected + '>' + data.angkatan + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Angkatan data');
                        }
                    });
                }

            });

        </script>
		
        @include('layout.footer')