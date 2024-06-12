<!DOCTYPE html>

<html lang="en">
	<head>
<base href="../../../" />
		<title>Login Management Wakaf - KEMENAG</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - The World's #1 Selling Bootstrap Admin Template by KeenThemes" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Metronic by Keenthemes" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

		<!--end::Fonts-->
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->
		<style>
            .single-menu{
                font-size: 1.1rem;
                font-weight: 600; 
                color:white;
            }
        </style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
		
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<div id="kt_app_hero" class="app-hero py-6">
						<div id="kt_app_hero_container" class="app-container container-xxl d-flex">
							<div class="d-flex flex-stack flex-wrap flex-lg-nowrap flex-row-fluid gap-4 gap-lg-10 mb-10">
								<div class="d-flex align-items-center me-3">
								</div>
							</div>
						</div>
					</div>
					<div class="app-container container-xxl">
						<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
							<div class="d-flex flex-column flex-column-fluid">
								<div id="kt_app_content" class="app-content">
									
									<div class="card py-4">
										
										<!--begin::Card body-->
										<div class="card-body py-4">
                                            <!--begin::Hero content-->
											<div class="d-flex align-items-center h-lg-300px p-5 p-lg-15">
                                                <!--begin::Wrapper-->
												<div class="flex-equal d-flex justify-content-center align-items-end ms-5">
													<!--begin::Illustration-->
													<img src="assets/media/illustrations/sketchy-1/20.png" alt="" class="mw-100 mh-125px mh-lg-275px mb-lg-n12" />
													<!--end::Illustration-->
												</div>
												<!--end::Wrapper-->
												<!--begin::Wrapper-->
												<div class="d-flex flex-column align-items-start justift-content-center flex-equal me-5 mt-5">
													<!--begin::Title-->
                                                    <div class="center-container">
                                                        <h1 class="fw-bolder fs-1 my-4 text-primary">LOGIN APLIKASI</h1>
                                                    </div>
													
													<!--end::Title-->
													<!--begin::Input group-->
													<div class="position-relative w-100 mb-4 mt-4">
                                                        <label for="" class="form-label fs-5 fw-semibold mb-2">Username / Email :</label>
														<input type="text" class="form-control fs-4 py-4 mb-4 ps-14 text-gray-700 placeholder-gray-500 mw-500px" name="search" id="login-username" placeholder="Masukkan username/email..." />
													</div>
                                                    <div class="position-relative w-100  mb-2">
                                                        <label for="" class="form-label fs-5 fw-semibold mb-2">Password :</label>
														<input type="password" class="form-control fs-4 py-4 ps-14 text-gray-700 placeholder-gray-500 mw-500px" name="search" id="login-password" placeholder="Masukkan password..." />
													</div>

                                                    <div class="position-relative w-100  mb-4">
                                                        <div class="col-md-12 mt-9 d-flex justify-content-end">
                                                            <button id="loginAction" class="btn btn-flex btn-primary h-40px fs-7 fw-bold mb-8"><i class="fa-solid fa-right-to-bracket"></i>SIGN IN</button>
                                                        </div>
													</div>
													<!--end::Input group-->
												</div>
												<!--end::Wrapper-->
												
											</div>
											<!--end::Hero content-->
											
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

        <script>
            $(document).ready(function() {
                $('#loginAction').on('click', function(e) {
                    e.preventDefault();
    
                    var username = $('#login-username').val();
                    var password = $('#login-password').val();
    
                    $.ajax({
                        url: '{{ route("loginAction") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            username: username,
                            password: password
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({ icon: 'success', title: 'Success', text: 'Berhasil Login!',timer: 5000, });
                                window.location.href = '/home'; // Redirect to home page or any other page
                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: response.message, });
                                // alert(response.message); // Display error message
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            var message = '';
                            $.each(errors, function(key, value) {
                                message += value[0] + '\n';
                            });
                            Swal.fire({ icon: 'error', title: 'Error', text: message, });
                            // alert(message); // Display validation errors
                        }
                    });
                });
            });
        </script>
		
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/table.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/export-users.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/user-management/users/list/add.js') }}"></script>
		<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
		<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
		<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>