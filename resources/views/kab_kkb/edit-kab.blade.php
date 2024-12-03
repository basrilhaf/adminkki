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
                                            <input type="hidden" id="detail-id_ab-ab" value="{{$id_ab}}">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="required form-label">Nama Anggota:</label>
                                                            <input type="text" class="form-control" id="detail-nama-ab"></input>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="required form-label">Nama Kelompok:</label>
                                                            <input type="text" class="form-control" id="detail-kelompok-ab"></input>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Sudah Dikunjungi</label>
                                                                <select class="form-control" id="detail-dikunjungi-ab"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" id="detail-tanggal_dikunjungi-ab-div" style="display: none;">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Tanggal kunjungan Terakhir:</label>
                                                                <input type="date" name="" class="form-control" id="detail-tanggal_dikunjungi-ab">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" id="detail-bertemu_ibu-ab-div" style="display: none;">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Apakah Bertemu Ibunya?</label>
                                                                <select class="form-control" id="detail-bertemu_ibu-ab"></select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-12">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Penyebab Tanggung renteng:</label>
                                                                <select class="form-control" id="detail-penyebab-ab"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" id="detail-setoran_lancar-ab-div" style="display: none;">
                                                            <div class="mb-4 fv-row">
                                                                <label class="required form-label">Setoran Lancar?</label>
                                                                <select class="form-control" id="detail-setoran_lancar-ab"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" id="detail-himbauan-ab-div" style="none;">
                                                            <div class="mb-3">
                                                                <label for="himbauan_ab" class="form-label">Hasil Edukasi::</label>
                                                                <select class="form-control" id="detail-himbauan-ab" multiple></select>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label>Isi lainnya dibawah ini: <span class="text-danger" style="font-size:12px;">(sertakan no "6." diawal, cth: 6. isi lainnya)</span></label>
                                                                <textarea id="detail-himbauan-ab2" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                            <button id="EditPengisianKabAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-body py-4">
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableHistory">
                                                                <thead>
                                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                                        <th>No</th>
                                                                        <th>Tanggal</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
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
                $('#EditPengisianKabAction').click(function() {
                    var formData = {
                        id: $('#detail-id_ab-ab').val(),
                        nama_ab: $('#detail-nama-ab').val(),
                        kelompok_ab: $('#detail-kelompok-ab').val(),
                        dikunjungi_ab: $('#detail-dikunjungi-ab').val(),
                        tanggal_dikunjungi_ab: $('#detail-tanggal_dikunjungi-ab').val(),
                        bertemu_ibu_ab: $('#detail-bertemu_ibu-ab').val(),
                        himbauan_ab: $('#detail-himbauan-ab').val(),
                        himbauan_ab2: $('#detail-himbauan-ab2').val(),
                        penyebab_ab: $('#detail-penyebab-ab').val(),
                        penyebab_ab2: $('#detail-penyebab-ab2').val(),
                        setoran_lancar: $('#detail-setoran_lancar-ab').val(),
                        motivasi: $('#motivasi').val(),
                        _token: '{{ csrf_token() }}' 
                    };
                    // alert(formData);

                    // Send AJAX request to update data
                    $.ajax({
                        url: '{{ route('updatePengisianAb') }}',
                        method: 'POST',
                        data: formData,
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

                var id_ab = $('#detail-id_ab-ab').val();
                var url = "{{ route('getDetailAb', ':id_ab') }}";
                url = url.replace(':id_ab', id_ab);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        
                        $('#detail-nama-ab').val(response.nama_ab);
                        $('#detail-kelompok-ab').val(response.kelompok_ab);
                        $('#detail-dikunjungi-ab').val(response.dikunjungi_ab);
                        fetchDikunjungi(response.dikunjungi_ab);
                        $('#detail-tanggal_dikunjungi-ab').val(response.tanggal_dikunjungi_ab);
                        $('#detail-penyebab-ab').val(response.penyebab_ab);
                        fetchPenyebab(response.penyebab_ab);
                        $('#detail-bertemu_ibu-ab').val(response.bertemu_ibu_ab);
                        fetchBertemuIbu(response.bertemu_ibu_ab);
                        $('#detail-setoran_lancar-ab').val(response.setoran_lancar_ab);
                        fetchSetoranLancar(response.setoran_lancar_ab);
                        $('#detail-himbauan-ab').val(response.himbauan_ab);
                        fetchHimbauan(response.himbauan_ab);
                        
                        if(response.dikunjungi_ab === '1'){
                            $('#detail-tanggal_dikunjungi-ab-div').show();
                            $('#detail-bertemu_ibu-ab-div').show();
                            $('#detail-penyebab-ab-div').show();
                            $('#detail-himbauan-ab-div').show();
                            if(response.penyebab_ab === '1. Kabur'){
                                $('#detail-setoran_lancar-ab-div').show();
                            }else{
                                $('#detail-setoran_lancar-ab-div').hide();
                            }
                        }else{
                            $('#detail-tanggal_dikunjungi-ab-div').hide();
                            $('#detail-bertemu_ibu-ab-div').hide();
                            $('#detail-penyebab-ab-div').hide();
                            $('#detail-himbauan-ab-div').hide();
                        }

                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                    }
                });
                $('#detail-penyebab-ab').change(function() {
                    if ($(this).val() === 'Kabur') {
                            $('#detail-setoran_lancar-ab-div').show();
                    } else {
                        $('#detail-setoran_lancar-ab-div').hide();
                    }
                                         
                });
                $('#detail-dikunjungi-ab').change(function() {
                    if ($(this).val() === '11') {
                        $('#detail-tanggal_dikunjungi-ab-div').show();
                        $('#detail-bertemu_ibu-ab-div').show();
                        $('#detail-penyebab-ab-div').show();
                        $('#detail-himbauan-ab-div').show();
                    } else {
                        $('#detail-tanggal_dikunjungi-ab-div').hide();
                        $('#detail-bertemu_ibu-ab-div').hide();
                        $('#detail-penyebab-ab-div').hide();
                        $('#detail-himbauan-ab-div').hide();
                    }
                                         
                });

                function fetchDikunjungi(dikunjungi) {
                    var $select = $('#detail-dikunjungi-ab');
                    var selected_0 = '';
                    var selected_1 = '';
                    var selected_2 = '';
                    if (dikunjungi === '0') { selected_0 = 'selected'; }
                    if (dikunjungi === '1') { selected_1 = 'selected'; }
                    if (dikunjungi === '2') { selected_2 = 'selected'; }
                    $select.empty();
                    $select.append('<option value="">--Pilih Status---</option>');
                    $select.append('<option value="0" ' + selected_0 + '>Belum</option>');
                    $select.append('<option value="11" ' + selected_1 + '>Sudah</option>');
                    $select.append('<option value="22" ' + selected_2 + '>Tidak Bisa Dikunjungi</option>');
                    $select.select2();
                }
                function fetchPenyebab(penyebab) {
                    var $select = $('#detail-penyebab-ab');
                    var selected_Kabur = '';
                    var selected_skt = '';
                    var selected_kel_skt = ''; 
                    var selected_Pulkam = '';
                    var selected_pindah = '';
                    var selected_usaha = '';
                    var selected_blm = '';
                    var selected_lainnya = '';

                    if (penyebab === '1. Kabur') { selected_Kabur = 'selected'; }
                    if (penyebab === '2. Ibu tsb sakit') { selected_skt = 'selected'; }
                    if (penyebab === '3. Keluarga ibu sakit') { selected_kel_skt = 'selected';  }
                    if (penyebab === '4. Pulkam') { selected_Pulkam = 'selected'; }
                    if (penyebab === '5. Pindah rumah') { selected_pindah = 'selected'; }
                    if (penyebab === '6. Usaha tidak jalan / sepi') { selected_usaha = 'selected'; }
                    if (penyebab === '7. Belum ada penjelasan') { selected_blm = 'selected'; }
                    if (penyebab === 'lainnya') { selected_lainnya = 'selected'; }

                    $select.empty();
                    $select.append('<option value="' + penyebab + '" selected>' + penyebab + '</option>');
                    $select.append('<option value="Kabur" ' + selected_Kabur + '>1. Kabur</option>');
                    $select.append('<option value="skt" ' + selected_skt + '>2. Ibu tsb sakit</option>');
                    $select.append('<option value="kel-skt" ' + selected_kel_skt + '>3. Keluarga ibu sakit</option>');
                    $select.append('<option value="Pulkam" ' + selected_Pulkam + '>4. Pulkam</option>');
                    $select.append('<option value="pindah" ' + selected_pindah + '>5. Pindah rumah</option>');
                    $select.append('<option value="usaha" ' + selected_usaha + '>6. Usaha tidak jalan / sepi</option>');
                    $select.append('<option value="blm" ' + selected_blm + '>7. Belum ada penjelasan</option>');
                    $select.append('<option value="lainnya" ' + selected_lainnya + '>8. Lainnya</option>');
                    $select.select2();
                }
                function fetchBertemuIbu(bertemu_ibu_ab) {
                    var $select = $('#detail-bertemu_ibu-ab');
                    var selected_0 = '';
                    var selected_1 = '';
                    if (bertemu_ibu_ab === '0') { selected_0 = 'selected'; }
                    if (bertemu_ibu_ab === '1') { selected_1 = 'selected'; }
                    
                    $select.empty();
                    $select.append('<option value="">--Pilih Status---</option>');
                    $select.append('<option value="0" ' + selected_0 + '>Tidak</option>');
                    $select.append('<option value="1" ' + selected_1 + '>Ya</option>');
                    $select.select2();
                }
                function fetchSetoranLancar(setoran_lancar_ab) {
                    var $select = $('#detail-setoran_lancar-ab');
                    var selected_0 = '';
                    var selected_1 = '';
                    var selected_2 = '';
                    if (setoran_lancar_ab === 'Lancar') { selected_0 = 'selected'; }
                    if (setoran_lancar_ab === 'Telat') { selected_1 = 'selected'; }
                    if (setoran_lancar_ab === 'Berat') { selected_2 = 'selected'; }
                                                
                    $select.empty();
                    $select.append('<option value="">--Pilih Status Setoran---</option>');
                    $select.append('<option value="Lancar" ' + selected_0 + '>Lancar</option>');
                    $select.append('<option value="Telat" ' + selected_1 + '>Telat</option>');
                    $select.append('<option value="Berat" ' + selected_2 + '>Berat</option>');
                    $select.select2();
                }
                function fetchHimbauan(himbauan_ab) {
                    var $select = $('#detail-himbauan-ab');
                    $select.empty();
                    $select.append('<option value="' + himbauan_ab + '" selected>' + himbauan_ab + '</option>');
                    $select.append('<option value="1. Tanya Kenapa DTR & Ingatkan aturan">1. Tanya Kenapa DTR & Ingatkan aturan</option>');
                    $select.append('<option value="2. Semangati & berikan solusi">2. Semangati & berikan solusi</option>');
                    $select.append('<option value="3. Buat surat peringatan pelunasan">3. Buat surat peringatan pelunasan</option>');
                    $select.append('<option value="4. Akan pelunasan segera">4. Akan pelunasan segera</option>');
                    $select.append('<option value="5. FU penganggung jawab/keluarga">5. FU penganggung jawab/keluarga</option>');
                    $select.select2();
                }

                $('#tableHistory').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('historyKunjunganKab') }}",
                        data: function (d) {
                            d.id_ab = $('#detail-id_ab-ab').val();
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'status_bertemu', name: 'status_bertemu'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });

            });
            $(document).on('click', '.btn-delete-history', function() {
                    var historyId = $(this).data('id');
                    Swal.fire({
                        title: 'Konfirmasi', text: 'Apakah Anda yakin menghapus data history ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya', cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deleteHistorynAction') }}", 
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",  
                                    id_kunjungan: historyId
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

        </script>
		
        @include('layout.footer')