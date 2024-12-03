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
									<!--begin::Card-->
                                    {{-- <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NAMA:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-user-nama" placeholder="Nama role" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">FAKULTAS:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-user-fakultas" placeholder="Fakultas" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fs-6 fw-bold">NIM:</label>
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <input type="text" class="form-control form-control-solid ps-13" id="search-user-nim" placeholder="Kode role" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-9">
                                                    <button id="searchUser" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-search"></i>Cari</button>
                                                    <button id="resetSearchUser" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"><i class="fa fa-rotate"></i>Reset</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div> --}}
									<div class="card">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th class="min-w-125px">Nama Dosen</th>
														<th class="min-w-125px">Peran</th>
													</tr>
												</thead>
                                                <tbody>
                                                    @foreach($dosen as $dosen)
                                                    <tr>
                                                        <td>{{ $dosen->nama_dosen }}</td>
                                                        <td>Dosen Pendamping Akademik</td>
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
		
        @include('layout.footer')