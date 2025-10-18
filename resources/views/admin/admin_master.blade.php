<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Repunext</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.ico')}}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!-- FontAwesome Icons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" ></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
		<style>
			.ui-datepicker-trigger{ float: right; margin-top: -30px; z-index: auto; padding-right: 9px; cursor: pointer; }
			.form-control { border: 1px solid #b9b9b9 !important; }
			#kt_toolbar{ padding: 15px 15px 30px 15px !important; }
			td{vertical-align: middle;}
		</style>
	</head>
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
		<script>
		 @if(Session::has('message'))
		 var type = "{{ Session::get('alert-type','info') }}"
		 switch(type){
		    case 'info':
		    toastr.info(" {{ Session::get('message') }} ");
		    break;
		    case 'success':
		    toastr.success(" {{ Session::get('message') }} ");
		    break;
		    case 'warning':
		    toastr.warning(" {{ Session::get('message') }} ");
		    break;
		    case 'error':
		    toastr.error(" {{ Session::get('message') }} ");
		    break;
		 }
		 @endif
		</script>
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				@include('admin.body.sidebar')
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					@include('admin.body.header')
					@yield('admin')
					@include('admin.body.footer')
				</div>
			</div>
		</div>
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
		</div>
		<script src="{{asset('backend/assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('backend/assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/account/settings/signin-methods.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/account/settings/profile-details.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/account/settings/deactivate-account.js')}}"></script>
		<script src="{{asset('backend/assets/js/widgets.bundle.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/widgets.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/utilities/modals/create-app.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/utilities/modals/users-search.js')}}"></script> 
		<script src="{{asset('backend/assets/js/custom/apps/ecommerce/sales/listing.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/apps/user-management/users/list/table.js')}}"></script> 
		<script src="{{asset('backend/assets/js/custom/apps/ecommerce/catalog/products.js')}}"></script>
		<script src="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
		<script src="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script> 
		<script src="{{asset('backend/assets/js/custom/apps/ecommerce/reports/views/views.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" ></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> 
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
		<script src="{{asset('backend/assets/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>	
		
		<!-- Dropdown Functionality -->
		<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Initialize dropdown functionality
			initializeDropdowns();
		});

		function initializeDropdowns() {
			// Grid icon dropdown
			const gridButton = document.querySelector('[data-kt-menu-trigger="click"][data-kt-menu-attach="parent"]');
			const gridDropdown = gridButton ? gridButton.nextElementSibling : null;
			
			if (gridButton && gridDropdown) {
				gridButton.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					gridDropdown.classList.toggle('show');
				});
			}
			
			// User profile dropdown
			const userButton = document.querySelector('#kt_header_user_menu_toggle .cursor-pointer');
			const userDropdown = userButton ? userButton.nextElementSibling : null;
			
			if (userButton && userDropdown) {
				userButton.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					userDropdown.classList.toggle('show');
				});
			}
			
			// Close dropdowns when clicking outside
			document.addEventListener('click', function(e) {
				if (!e.target.closest('[data-kt-menu-trigger]') && !e.target.closest('.menu-sub')) {
					document.querySelectorAll('.menu-sub').forEach(dropdown => {
						dropdown.classList.remove('show');
					});
				}
			});
		}

		// jQuery fallback for dropdowns
		$(document).ready(function() {
			// Grid icon dropdown
			$('[data-kt-menu-trigger="click"][data-kt-menu-attach="parent"]').on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$(this).next('.menu-sub').toggleClass('show');
			});
			
			// User profile dropdown
			$('#kt_header_user_menu_toggle .cursor-pointer').on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$(this).next('.menu-sub').toggleClass('show');
			});
			
			// Close dropdowns when clicking outside
			$(document).on('click', function(e) {
				if (!$(e.target).closest('[data-kt-menu-trigger], .menu-sub').length) {
					$('.menu-sub').removeClass('show');
				}
			});
		});
		</script>

	

		<script>
		tinymce.init({
		    selector: "#tinymce_basic", height : "400", statusbar: false, menubar: false,
		    toolbar: [ "styleselect fontsizeselect fontselect| bold italic | link image | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | autolink | code preview"],
		    plugins : "advlist autolink link image lists charmap print preview code",
			relative_urls: false, 
		    remove_script_host: false, 
			image_dimensions: false,
			setup: function (editor) {
				editor.on('BeforeSetContent', function (e) { 
					if (e.content) {
						e.content = e.content.replace(/(<img[^>]+)(?:width|height)="[^"]*"/g, '$1');
					}
				});
			}
		});</script>

		<!-- Idle Timeout Script -->
		<script>
			// Set global URLs for the idle timeout handler
			window.resetSessionUrl = '{{ route("reset-session") }}';
			window.loginUrl = '{{ route("login") }}';
		</script>
		<script src="{{ asset('js/idle-timeout.js') }}"></script>
	</body>
</html>
