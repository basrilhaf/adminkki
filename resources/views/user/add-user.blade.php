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
												<a href="{{route('user.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Nama</label>
                                                        <input type="text" id="add-user-nama" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Email</label>
                                                        <input type="text" id="add-user-email" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Jenis Kelamin</label>
                                                        <select id="add-user-jenis_kelamin" class="form-control mb-2">
                                                            <option value="">--Pilih Jenis Kelamin---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">No Telepon/HP</label>
                                                        <input type="text" id="add-user-telepon" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Role Aplikasi</label>
                                                        <select id="add-user-role" class="form-control mb-2">
                                                            <option value="">--Pilih Jenis Role---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Status User Aplikasi</label>
                                                        <select id="add-user-status" class="form-control mb-2">
                                                            <option value="">--Pilih Jenis Status---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Alamat</label>
                                                        <textarea name="" id="add-user-alamat" cols="10" rows="2" class="form-control mb-2"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Username Aplikasi</label>
                                                        <input type="text" id="add-user-username" class="form-control mb-2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-4 fv-row">
                                                        <label class="required form-label">Password Aplikasi</label>
                                                        <input type="password" id="add-user-password" class="form-control mb-2">
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
                                                                <select id="add-user-provinsi" class="form-control mb-2">
                                                                    <option value="">--Pilih Provinsi---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Kota/Kabupaten Domisili</label>
                                                                <select id="add-user-kota" class="form-control mb-2">
                                                                    <option value="">--Pilih Kota/Kabupaten---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Kecamatan Domisili</label>
                                                                <select id="add-user-kecamatan" class="form-control mb-2">
                                                                    <option value="">--Pilih Kecamatan---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Kelurahan Domisili</label>
                                                                <select id="add-user-kelurahan" class="form-control mb-2">
                                                                    <option value="">--Pilih Kelurahan---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="addUserAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"> <i class="fa fa-save"></i>SIMPAN</button>
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
                $('#addUserAction').click(function(e) {
                    e.preventDefault();
                    var nama = $('#add-user-nama').val();
                    var email = $('#add-user-email').val();
                    var jenis_kelamin = $('#add-user-jenis_kelamin').val();
                    var telepon = $('#add-user-telepon').val();
                    var role = $('#add-user-role').val();
                    var status = $('#add-user-status').val();
                    var alamat = $('#add-user-alamat').val();
                    var username = $('#add-user-username').val();
                    var password = $('#add-user-password').val();
                    var kelurahan = $('#add-user-kelurahan').val();
                    
                    $.ajax({
                        url: "{{ route('addUserAction') }}", 
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  
                            nama: nama,
                            email: email,
                            jenis_kelamin: jenis_kelamin,
                            telepon: telepon,
                            role: role,
                            status: status,
                            alamat: alamat,
                            username: username,
                            password: password,
                            kelurahan: kelurahan
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data Berhasil Disimpan',
                                icon: 'success'
                            }).then(function() {
                                location.reload();  
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                        }
                    });
                });
            });
        
            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getProvinsi') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-user-provinsi');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.provinsi_kode + '">' + data.provinsi_nama + '</option>');
                        });
                        select.select2({
                            placeholder: "--Pilih Provinsi---",
                            allowClear: true
                        });
                        Swal.close();
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => { Swal.showLoading() }, allowOutsideClick: false });
                var selectProvinsi = $('#add-user-provinsi');
                var selectKota = $('#add-user-kota');
                selectProvinsi.select2({ placeholder: "--Pilih Provinsi---",allowClear: true });
                selectKota.select2({ placeholder: "--Pilih Kota/Kabupaten---", allowClear: true });

                selectProvinsi.on('change', function() {
                    var selectedProvinsi = $(this).val();
                    if (selectedProvinsi !== '') {
                        $.ajax({
                            url: "{{ route('getKotaByProvinsi') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: { provinsi_kode: selectedProvinsi },
                            success: function(data) {
                                selectKota.empty();
                                selectKota.append('<option value="">--Pilih Kota/Kabupaten---</option>');
                                data.forEach(function(data) {
                                    selectKota.append('<option value="' + data.kabkota_kode + '">' + data.kabkota_nama + '</option>');
                                });
                                selectKota.trigger('change');
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kota' });
                            }
                        });
                    } else {
                        selectKota.empty().trigger('change');
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => { Swal.showLoading() }, allowOutsideClick: false });
                var selectKota = $('#add-user-kota');
                var selectKecamatan = $('#add-user-kecamatan');
                selectKota.select2({ placeholder: "--Pilih Kota/Kabupaten---",allowClear: true });
                selectKecamatan.select2({ placeholder: "--Pilih Kecamatan---", allowClear: true });

                selectKota.on('change', function() {
                    var selectedKota = $(this).val();
                    if (selectedKota !== '') {
                        $.ajax({
                            url: "{{ route('getKecamatanByKota') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: { kabkota_kode: selectedKota },
                            success: function(data) {
                                selectKecamatan.empty();
                                selectKecamatan.append('<option value="">--Pilih Kecamatan---</option>');
                                data.forEach(function(data) {
                                    selectKecamatan.append('<option value="' + data.kecamatan_kode + '">' + data.kecamatan_nama + '</option>');
                                });
                                selectKecamatan.trigger('change');
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kota' });
                            }
                        });
                    } else {
                        selectKecamatan.empty().trigger('change');
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => { Swal.showLoading() }, allowOutsideClick: false });
                var selectKecamatan = $('#add-user-kecamatan');
                var selectKelurahan = $('#add-user-kelurahan');
                selectKecamatan.select2({ placeholder: "--Pilih Kecamatan---",allowClear: true });
                selectKelurahan.select2({ placeholder: "--Pilih kelurahan---", allowClear: true });

                selectKecamatan.on('change', function() {
                    var selectedKecamatan = $(this).val();
                    if (selectedKecamatan !== '') {
                        $.ajax({
                            url: "{{ route('getKelurahanByKecamatan') }}",
                            type: 'GET',
                            dataType: 'json',
                            data: { kecamatan_kode: selectedKecamatan },
                            success: function(data) {
                                selectKelurahan.empty();
                                selectKelurahan.append('<option value="">--Pilih Kelurahan---</option>');
                                data.forEach(function(data) {
                                    selectKelurahan.append('<option value="' + data.kelurahan_kode + '">' + data.kelurahan_nama + '</option>');
                                });
                                selectKelurahan.trigger('change');
                            },
                            error: function() {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data kota' });
                            }
                        });
                    } else {
                        selectKelurahan.empty().trigger('change');
                    }
                });
                Swal.close();
            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getReffJenisKelaminUser') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-user-jenis_kelamin');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.isi_kolom + '">' + data.keterangan + '</option>');
                        });
                    }
                });
                Swal.close();

            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getReffStatusUser') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-user-status');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.isi_kolom + '">' + data.keterangan + '</option>');
                        });
                    }
                });
                Swal.close();

            });

            $(document).ready(function() {
                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getRoleUser') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-user-role');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.id_role + '">' + data.nama_role + '</option>');
                        });
                    }
                });
                Swal.close();

            });

            


            
            

        </script>
		
        @include('layout.footer')