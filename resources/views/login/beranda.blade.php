<!DOCTYPE html>

<html lang="en">
	<head>
<base href="../../../" />
		<title>Beranda || SIPETA</title>
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
	<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
		<!--begin::Header container-->
		<div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
			<!--begin::Header mobile toggle-->
			<div class="d-flex align-items-center d-lg-none ms-n3 me-2" title="Show sidebar menu">
				<div class="btn btn-icon btn-color-white btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
					<i class="ki-duotone ki-abstract-14 fs-2">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
				</div>
			</div>
			<!--end::Header mobile toggle-->
			<!--begin::Logo-->
			<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
				<a href="/home">
					<div class="bg-white px-4 py-4 rounded d-none d-lg-inline">
						<img alt="Logo" src="{{ asset('assets/media/logos/favicon.ico') }}" class="h-25px d-none d-lg-inline" />
					</div>
					<img alt="Logo" src="{{ asset('assets/media/logos/favicon.ico') }}" class="h-25px d-inline d-lg-none" />
				</a>
				
				
			</div>
			<!--end::Logo-->
			<!--begin::Header wrapper-->
			<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
				<!--begin::Menu wrapper-->
				<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
					<!--begin::Menu-->
					<div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">									
						<a href="/beranda" class="text-white mt-6" style="font-size: 20px;">BERANDA </a> <span style="color: transparent;"> ________</span>
						<a href="/login" class="text-white mt-6" style="font-size: 20px;">LOGIN</a>
						{{-- {!! $navbar !!} --}}
					</div>
					<!--end::Menu-->
				</div>
				<!--end::Menu wrapper-->
				<!--begin::Navbar-->
				<div class="app-navbar flex-shrink-0">
					<!--begin::User menu-->
					<div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
						<!--begin::Menu wrapper-->
						
						<!--begin::User account menu-->
						<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
							
							<!--end::Menu item-->
							<!--begin::Menu separator-->
							<div class="separator my-2"></div>
							<!--end::Menu separator-->
							<!--begin::Menu item-->
							<div class="menu-item px-5">
							</div>
							<!--end::Menu item-->
							
							<!--begin::Menu separator-->
							<div class="separator my-2"></div>
							<!--end::Menu separator-->
							
							<!--begin::Menu item-->
							<div class="menu-item px-5">
								<div class="col-md-12 d-flex justify-content-end">
									<button id="logoutButton" class="px-5 btn btn-danger text-white">Logout</button>
								</div>
								
							</div>
							<!--end::Menu item-->
						</div>
						<!--end::User account menu-->
						<!--end::Menu wrapper-->
					</div>
					<!--end::User menu-->
					
					<!--begin::Sidebar menu toggle-->
					<!--end::Sidebar menu toggle-->
				</div>
				<!--end::Navbar-->
			</div>
			<!--end::Header wrapper-->
		</div>
		<!--end::Header container-->
	</div>
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
											<div class="d-flex h-lg-300px">
                                                <!--begin::Wrapper-->
												<div class="flex-equal d-flex justify-content-left ms-5">
													<!--begin::Illustration-->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h1>SiPeTa</h1>
                                                            <p>Halo Mahasiswa,</p>
                                                            <p>Selamat datang di SiPeTa, platform resmi untuk penjadwalan dan pengelolaan tugas akhir anda,</p>
                                                            <p>Kami hadir untuk memudahkan proses penjadwalan, pengajuan, dan monitoring tugas akhir agar lebih efisien dan terstruktur.</p>
                                                            <p>Tugas akhir merupakan syarat kelulusan, dan disini anda dapat menulusuri semua informasi terkait tugas akhir. Mari berjuang bersama menuju kesuksesan!</p>
                                                        </div>
                                                        
                                                    </div>
													
                                                    
                                                    <br>
													<!--end::Illustration-->
												</div>
												<!--end::Wrapper-->
												<!--begin::Wrapper-->
												<div class="d-flex flex-column align-items-start justift-content-center flex-equal me-5 mt-5">
													<!--begin::Title-->
                                                    
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