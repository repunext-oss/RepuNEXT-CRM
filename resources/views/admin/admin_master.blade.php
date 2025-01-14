<!DOCTYPE html>
<html lang="en">
	<head>
		<title>xyz</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.svg')}}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
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
		<script src="{{asset('backend/assets/js/custom/apps/user-management/roles/list/add.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/apps/user-management/roles/list/update-role.js')}}"></script>

		<script src="{{asset('backend/assets/js/custom/apps/user-management/users/list/table.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/apps/user-management/users/list/export-users.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/apps/user-management/users/list/add.js')}}"></script>
		<script src="{{asset('backend/assets/js/custom/apps/ecommerce/catalog/products.js')}}"></script>
		<script src="{{asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
		<script src="{{asset('backend/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" ></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	</body>
</html>
