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
												<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">{{$menu}}</h1>
												{!!$breadcrumb!!}
											</div>
											<div class="d-flex align-items-center gap-2 gap-lg-3">
												<a href="{{route('aksesmenu.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Kembali</a>
											</div>
										</div>
									</div>
									<!--begin::Card-->
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Role</label>
                                                    <select id="add-role-aksesmenu" class="form-control mb-2">
                                                        <option value="">--Pilih Role---</option>
                                                    </select>
                                                </div>                                               
                                                <div class="mb-4 fv-row" id="divPilihan" style="display:none;">
                                                    <label class="required form-label">Menu</label>
                                                    <div id="checkMenu">
                                                    </div>                                                    
                                                </div>
                                                
                                                <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                    <button id="addAksesMenuAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-save"></i>SIMPAN</button>
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
                $('#addAksesMenuAction').click(function(e) {
                    e.preventDefault();
                    var role_id = $('#add-role-aksesmenu').val();
                   
                    var menu_id = [];
                    $('input[name="checkbox_pilihan[]"]:checked').each(function() {
                        menu_id.push($(this).val());
                    });
                    
                    $.ajax({
                        url: "{{ route('addAksesMenuAction') }}",  // Update with your actual route
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",  // CSRF token for security
                            role_id: role_id,
                            menu_id: menu_id
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

                Swal.fire({ title: 'Loading...', text: 'Sedang memuat data', didOpen: () => {Swal.showLoading() }, allowOutsideClick: false });
                $.ajax({
                    url: "{{ route('getRoleAksesMenu') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var select = $('#add-role-aksesmenu');
                        data.forEach(function(data) {
                            select.append('<option value="' + data.id_role + '">' + data.nama_role + '</option>');
                        });
                    }
                });
                
                Swal.close();

                $('#add-role-aksesmenu').on('change', function() {
                    var id_role = $(this).val();
                    var url = "{{ route('aksesmenu.getMenu', ':id_role') }}";
                    url = url.replace(':id_role', id_role);

                    if (id_role !== '') {
                        $('#divPilihan').show();
                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(data) {
                                var select = $('#checkMenu');
                                var checkboxHtml = `<p>Pilihan Menu:</p><ul>`;
                                if(data.length === 0){
                                    checkboxHtml += `<h3>Semua menu sudah diakses</h3>`;
                                } else {
                                    
                                    data.forEach(function(data) {
                                        checkboxHtml += `<input type="checkbox" id="checkbox_${data.id_menu}" name="checkbox_pilihan[]" value="${data.id_menu}">
                                                        <label for="checkbox_${data.id_menu}">${data.nama_menu}</label><br>`;

                                    });
                                }
                                
                                checkboxHtml += `</ul>`;
                                select.html(checkboxHtml); 
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching options:', error);
                            }
                        });
                    } else {
                        $('#divPilihan').hide();
                    }
                });

            });


        </script>
		
        @include('layout.footer')