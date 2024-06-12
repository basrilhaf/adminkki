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
												<a href="{{route('user.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
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
                                                                <label class="required form-label">Jenis Kelamin</label>
                                                                <select id="detail-jenis_kelamin-user" class="form-control mb-2">
                                                                    <option value="">--Pilih Jenis Kelamin---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">No Telepon/HP</label>
                                                                <input type="text" id="detail-no_telepon-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Role Aplikasi</label>
                                                                <select id="detail-role-user" class="form-control mb-2">
                                                                    <option value="">--Pilih Jenis Role---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Status User Aplikasi</label>
                                                                <select id="detail-status-user" class="form-control mb-2">
                                                                    <option value="">--Pilih Jenis Status---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Alamat</label>
                                                                <textarea name="" id="detail-alamat-user" cols="10" rows="2" class="form-control mb-2"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Username Aplikasi</label>
                                                                <input type="text" id="detail-username-user" class="form-control mb-2">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h2>Domisili Tugas</h2>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="mb-4 fv-row">
                                                                        <label class="required form-label">Provinsi Domisili</label>
                                                                        <select id="detail-provinsi-user" class="form-control mb-2">
                                                                            <option value="">--Pilih Provinsi---</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-4 fv-row">
                                                                        <label class="required form-label">Kota/Kabupaten Domisili</label>
                                                                        <select id="detail-kota-user" class="form-control mb-2">
                                                                            <option value="">--Pilih Kota/Kabupaten---</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-4 fv-row">
                                                                        <label class="required form-label">Kecamatan Domisili</label>
                                                                        <select id="detail-kecamatan-user" class="form-control mb-2">
                                                                            <option value="">--Pilih Kecamatan---</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-4 fv-row">
                                                                        <label class="required form-label">Kelurahan Domisili</label>
                                                                        <select id="detail-kelurahan-user" class="form-control mb-2">
                                                                            <option value="">--Pilih Kelurahan---</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
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
                    var jenis_kelamin = $('#detail-jenis_kelamin-user').val();
                    var no_telepon = $('#detail-no_telepon-user').val();
                    var role_id = $('#detail-role-user').val();
                    var status = $('#detail-status-user').val();
                    var alamat = $('#detail-alamat-user').val();
                    var username = $('#detail-username-user').val();
                    var kelurahan_id = $('#detail-kelurahan-user').val();
                    
                    $.ajax({
                        url: "{{ route('updateUserAction') }}",  // Update with your actual route
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  // CSRF token for security
                            id_user: id_user,
                            nama_user: nama_user,
                            email: email,
                            jenis_kelamin: jenis_kelamin,
                            no_telepon: no_telepon,
                            role_id: role_id,
                            status: status,
                            alamat: alamat,
                            username: username,
                            kelurahan_id: kelurahan_id
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
                url = url.replace(':id_user', id_user);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#detail-nama-user').val(response.nama);
                        $('#detail-email-user').val(response.email);
                        $('#detail-jenis_kelamin-user').val(response.jenis_kelamin);
                        $('#detail-no_telepon-user').val(response.no_telepon);
                        $('#detail-role-user').val(response.role_id);
                        $('#detail-status-user').val(response.status);
                        $('#detail-alamat-user').val(response.alamat);
                        $('#detail-username-user').val(response.username);
                        $('#detail-provinsi-user').val(response.provinsi_kode);
                        $('#detail-kota-user').val(response.kabkota_kode);
                        $('#detail-kecamatan-user').val(response.kecamatan_kode);
                        $('#detail-kelurahan-user').val(response.kelurahan_kode);

                        // fetch 
                        $('#detail-role-user').val(response.role_id);
                        fetchRole(response);
                        $('#detail-status-user').val(response.status);
                        fetchStatus(response.status);
                        $('#detail-jenis_kelamin-user').val(response.jenis_kelamin);
                        fetchJenisKelamin(response.jenis_kelamin);
                        $('#detail-provinsi-user').val(response.provinsi_kode);
                        fetchProvinsi(response.provinsi_kode);
                        $('#detail-provinsi-user').val(response.provinsi_kode);
                        fetchKota(response.provinsi_kode,response.kabkota_kode);
                        $('#detail-kota-user').val(response.kabkota_kode);
                        fetchKecamatan(response.kabkota_kode,response.kecamatan_kode);
                        $('#detail-kecamatan-user').val(response.kecamatan_kode);
                        fetchKelurahan(response.kecamatan_kode,response.kelurahan_kode);
                        $('#detail-kelurahan-user').val(response.kelurahan_kode);


                        

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });
                $('#detail-provinsi-user').on('change', function() {
                    var selectedProvinsi = $(this).val();
                    var kabkota_kode = '';
                    $('#detail-kecamatan-user').empty().append('<option value="">--Pilih Kecamatan---</option>');
                    $('#detail-kelurahan-user').empty().append('<option value="">--Pilih Kelurahan---</option>');
                    fetchKota(selectedProvinsi,kabkota_kode);
                });
                $('#detail-kota-user').on('change', function() {
                    var selectedKota = $(this).val();
                    var kecamatan_kode = '';
                    $('#detail-kelurahan-user').empty().append('<option value="">--Pilih Kelurahan---</option>');
                    fetchKecamatan(selectedKota,kecamatan_kode);
                });
                $('#detail-kecamatan-user').on('change', function() {
                    var selectedKecamatan = $(this).val();
                    var kelurahan_kode = '';
                    var wakaf_id = '';
                    fetchKelurahan(selectedKecamatan,kelurahan_kode);
                });

                function fetchKelurahan(selectedKecamatan,kelurahan_kode) {
                    var kelurahanUrl = "{{ route('getKelurahanByKecamatan') }}";
                    $.ajax({
                        url: kelurahanUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { kecamatan_kode: selectedKecamatan },
                        success: function(data) {
                            var $select = $('#detail-kelurahan-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Kelurahan---</option>');
                            data.forEach(function(dataKelurahan) {
                                var selected = '';
                                if (dataKelurahan.kelurahan_kode === kelurahan_kode) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataKelurahan.kelurahan_kode + '" ' + selected + '>' + dataKelurahan.kelurahan_nama + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Kelurahan data');
                        }
                    });
                }

                function fetchKecamatan(selectedkota,kecamatan_kode) {
                    var kecamatanUrl = "{{ route('getKecamatanByKota') }}";
                    $.ajax({
                        url: kecamatanUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { kabkota_kode: selectedkota },
                        success: function(data) {
                            var $select = $('#detail-kecamatan-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Kecamatan---</option>');
                            data.forEach(function(dataKecamatan) {
                                var selected = '';
                                if (dataKecamatan.kecamatan_kode === kecamatan_kode) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataKecamatan.kecamatan_kode + '" ' + selected + '>' + dataKecamatan.kecamatan_nama + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Kecamatan data');
                        }
                    });
                }

                function fetchKota(selectedProvinsi,kabkota_kode) {
                    var kotaUrl = "{{ route('getKotaByProvinsi') }}";
                    $.ajax({
                        url: kotaUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { provinsi_kode: selectedProvinsi },
                        success: function(data) {
                            var $select = $('#detail-kota-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Kota/Kabupaten---</option>');
                            data.forEach(function(dataKota) {
                                var selected = '';
                                if (dataKota.kabkota_kode === kabkota_kode) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + dataKota.kabkota_kode + '" ' + selected + '>' + dataKota.kabkota_nama + '</option>');                            
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Kabupaten/kota data');
                        }
                    });
                }

                function fetchProvinsi(provinsi_kode) {
                    var url = "{{ route('getProvinsi') }}";
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-provinsi-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Provinsi---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.provinsi_kode === provinsi_kode) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.provinsi_kode + '" ' + selected + '>' + data.provinsi_nama + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Master provinsi data');
                        }
                    });
                }

                function fetchJenisKelamin(jenis_kelamin) {
                    var jkUrl = "{{ route('getReffJenisKelaminUser') }}";
                    $.ajax({
                        url: jkUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-jenis_kelamin-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Status---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.isi_kolom === jenis_kelamin) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.isi_kolom + '" ' + selected + '>' + data.keterangan + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Master Jenis Kelamin data');
                        }
                    });
                }

                function fetchStatus(status) {
                    var statusUrl = "{{ route('getReffStatusUser') }}";
                    $.ajax({
                        url: statusUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-status-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Status---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.isi_kolom === status) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.isi_kolom + '" ' + selected + '>' + data.keterangan + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Master status data');
                        }
                    });
                }

                function fetchRole(response) {
                    var KegiatanUrl = "{{ route('getRoleUser') }}";
                    $.ajax({
                        url: KegiatanUrl,
                        type: 'GET',
                        success: function(data) {
                            var $select = $('#detail-role-user');
                            $select.empty();
                            $select.append('<option value="">--Pilih Role---</option>');
                            data.forEach(function(data) {
                                var selected = '';
                                if (data.id_role === response.role_id) {
                                    selected = 'selected';
                                }
                                $select.append('<option value="' + data.id_role + '" ' + selected + '>' + data.nama_role + '</option>'); // Adjust based on your object properties
                            });
                            $select.select2();
                        },
                        error: function(xhr) {
                            console.error('An error occurred while fetching Master role data');
                        }
                    });
                }

            });

        </script>
		
        @include('layout.footer')