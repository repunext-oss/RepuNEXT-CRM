@extends('admin.admin_master')
@section('admin')
<?php $rolerawdata = session('userRoles', []);?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div id="kt_content_container" class="container-xxl">
			<div class="row">
			<div class="col-md-12"> 
				<div class="card mb-5 mb-xl-10">
					<div class="card-header border-0 pt-6">
						<div class="d-flex align-items-center" id="kt_header_wrapper">
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-20 pb-5 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_wrapper'}">
								<h1 class="text-dark fw-bold my-1 fs-3 lh-1">Role Management</h1>
								<ul class="breadcrumb fw-semibold fs-8 my-1">
									<li class="breadcrumb-item text-muted">
										<a href="{route('dashboard')}}" class="text-muted">Home</a>
									</li>
									<li class="breadcrumb-item text-muted"> Role </li>
									<li class="breadcrumb-item text-muted"> List </li>
								</ul>
							</div>
						</div>
						@if(in_array("role_management_all",$rolerawdata, TRUE) || in_array("role_management_create",$rolerawdata, TRUE)|| in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<a href="#" class="btn btn-primary align-self-center" style="float: right;" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">Add Role</a> @endif
					</div>
				
					<br>
				</div>
				</div>
			</div>
		</div>
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-xxl">
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9"> 
				@foreach ($roles as $rolelist) 
				<div class="col-md-4"> 
					<div class="card card-flush h-md-100"> 
						<div class="card-header">
							<div class="card-title">
								<h2>{{ucwords($rolelist->role_name);}}</h2>
							</div>
						</div>
						<div class="card-body pt-1">
							<div class="d-flex flex-column text-gray-600">
							@if($rolelist->role=="kt_roles_select_all")
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>All Admin Controls</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Dealers</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Service Provider</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Pilots</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Farmers</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Master</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create User Management</div>
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>Read, Write, and, Create Role Management</div>
							@endif
							<?php $rolelists=explode(",",$rolelist->role);?>

							<!-- User Management -->
								@if(in_array("user_management_read",$rolelists, TRUE)||in_array("user_management_write",$rolelists, TRUE)||in_array("user_management_create",$rolelists, TRUE)||in_array("user_management_delete",$rolelists, TRUE)||in_array("user_management_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("user_management_all",$rolelists, TRUE))
										All User Management,
									@endif
									@if(in_array("user_management_read",$rolelists, TRUE))
										Read User Management,
									@endif
									@if(in_array("user_management_write",$rolelists, TRUE))
										Write User Management,
									@endif
									@if(in_array("user_management_create",$rolelists, TRUE))
										Create User Management
									@endif
									@if(in_array("user_management_delete",$rolelists, TRUE))
										delete User Management
									@endif
								</div>
								@endif

								<!-- Role MAnagement -->
								@if(in_array("role_management_read",$rolelists, TRUE)||in_array("role_management_write",$rolelists, TRUE)||in_array("role_management_create",$rolelists, TRUE)||in_array("role_management_all",$rolelists, TRUE)||in_array("role_management_delete",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("role_management_all",$rolelists, TRUE))
										Role Management All,
									@endif
									@if(in_array("role_management_read",$rolelists, TRUE))
										Role Management Read,
									@endif
									@if(in_array("role_management_write",$rolelists, TRUE))
										Role Management Write,
									@endif
									@if(in_array("role_management_create",$rolelists, TRUE))
										Role Management Create,
									@endif
									@if(in_array("role_management_delete",$rolelists, TRUE))
										Role Management Delete,
									@endif
								</div>
								@endif

								<!-- Call Center Management -->
								 <!-- Enquiry List -->
								@if(in_array("enquiry_read",$rolelists, TRUE)||in_array("enquiry_write",$rolelists, TRUE)||in_array("enquiry_create",$rolelists, TRUE)||in_array("enquiry_delete",$rolelists, TRUE)||in_array("enquiry_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("enquiry_all",$rolelists, TRUE))
										Enquiry Management All,
									@endif
									@if(in_array("enquiry_read",$rolelists, TRUE))
										Enquiry Management Read,
									@endif
									@if(in_array("enquiry_write",$rolelists, TRUE))
										Enquiry Management Write,
									@endif
									@if(in_array("enquiry_create",$rolelists, TRUE))
										Enquiry Management Create,
									@endif
									@if(in_array("enquiry_delete",$rolelists, TRUE))
										Enquiry Management delete,
									@endif
								</div>
								@endif

								<!-- Followup List -->
								@if(in_array("followup_read",$rolelists, TRUE)||in_array("followup_write",$rolelists, TRUE)||in_array("followup_create",$rolelists, TRUE)||in_array("followup_delete",$rolelists, TRUE)||in_array("followup_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("followup_all",$rolelists, TRUE))
										Followup Management All,
									@endif
									@if(in_array("followup_read",$rolelists, TRUE))
										Followup Management Read,
									@endif
									@if(in_array("followup_write",$rolelists, TRUE))
										Followup Management Write,
									@endif
									@if(in_array("followup_create",$rolelists, TRUE))
										Followup Management Create,
									@endif
									@if(in_array("followup_delete",$rolelists, TRUE))
										Followup Management delete,
									@endif
								</div>
								@endif

								<!-- Leave Management -->
								 <!-- Apply Leave -->
								 @if(in_array("leave_read",$rolelists, TRUE)||in_array("leave_write",$rolelists, TRUE)||in_array("leave_create",$rolelists, TRUE)||in_array("leave_delete",$rolelists, TRUE)||in_array("leave_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("leave_all",$rolelists, TRUE))
										Leave Management All,
									@endif
									@if(in_array("leave_read",$rolelists, TRUE))
										Leave Management Read,
									@endif
									@if(in_array("leave_write",$rolelists, TRUE))
										Leave Management Write,
									@endif
									@if(in_array("leave_create",$rolelists, TRUE))
										Leave Management Create,
									@endif
									@if(in_array("leave_delete",$rolelists, TRUE)) 
										Leave Management Delete,
									@endif
								</div>
								@endif

								<!-- Project Management -->
								 <!-- Service list -->
								@if(in_array("service_read",$rolelists, TRUE)||in_array("service_write",$rolelists, TRUE)||in_array("service_create",$rolelists, TRUE)||in_array("service_delete",$rolelists, TRUE)||in_array("service_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("service_all",$rolelists, TRUE))
										Service Management All,
									@endif
									@if(in_array("service_read",$rolelists, TRUE))
										Service Management Read,
									@endif
									@if(in_array("service_write",$rolelists, TRUE))
										Service Management Write,
									@endif
									@if(in_array("service_create",$rolelists, TRUE))
										Service Management Create,
									@endif
									@if(in_array("service_delete",$rolelists, TRUE))
										Service Management Delete,
									@endif
								</div>
								@endif

								<!-- project Details list -->
								@if(in_array("project_read",$rolelists, TRUE)||in_array("project_write",$rolelists, TRUE)||in_array("project_create",$rolelists, TRUE)||in_array("project_delete",$rolelists, TRUE)||in_array("project_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("project_all",$rolelists, TRUE))
										Project Management All,
									@endif
									@if(in_array("project_read",$rolelists, TRUE))
										Project Management Read,
									@endif
									@if(in_array("project_write",$rolelists, TRUE))
										Project Management Write,
									@endif
									@if(in_array("project_create",$rolelists, TRUE))
										Project Management Create,
									@endif
									@if(in_array("project_delete",$rolelists, TRUE))
										Project Management Delete,
									@endif
								</div>
								@endif

								<!-- TimeSheet  -->
								@if(in_array("timesheet_read",$rolelists, TRUE)||in_array("timesheet_write",$rolelists, TRUE)||in_array("timesheet_create",$rolelists, TRUE)||in_array("timesheet_delete",$rolelists, TRUE)||in_array("timesheet_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("timesheet_all",$rolelists, TRUE))
										 Timesheet All,
									@endif
									@if(in_array("timesheet_read",$rolelists, TRUE))
										Timesheet Read,
									@endif
									@if(in_array("timesheet_write",$rolelists, TRUE))
										Timesheet Write,
									@endif
									@if(in_array("timesheet_create",$rolelists, TRUE))
										Timesheet Create,
									@endif
									@if(in_array("timesheet_delete",$rolelists, TRUE))
										Timesheet Delete,
									@endif
								</div>
								@endif

								<!-- Task  TimeSheet yes
								Time
								@if(in_array("task_timesheet_read",$rolelists, TRUE)||in_array("task_timesheet_write",$rolelists, TRUE)||in_array("task_timesheet_create",$rolelists, TRUE)||in_array("task_timesheet_delete",$rolelists, TRUE)||in_array("task_timesheet_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("task_timesheet_all",$rolelists, TRUE))
										Task Timesheet All,
									@endif  
									@if(in_array("task_timesheet_read",$rolelists, TRUE))
										Task Timesheet Read,
									@endif
									@if(in_array("task_timesheet_write",$rolelists, TRUE))
										Task Timesheet Write,
									@endif
									@if(in_array("task_timesheet_create",$rolelists, TRUE))
										Task Timesheet Create,
									@endif
									@if(in_array("task_timesheet_delete",$rolelists, TRUE))
										Task Timesheet Delete,
									@endif
								</div>
								@endif -->


								<!-- TimeSheet Category -->

								@if(in_array("timesheet_category_read",$rolelists, TRUE)||in_array("timesheet_category_write",$rolelists, TRUE)||in_array("timesheet_category_create",$rolelists, TRUE)||in_array("timesheet_category_delete",$rolelists, TRUE)||in_array("timesheet_category_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("timesheet_category_all",$rolelists, TRUE))
										TimeSheet Category All,
									@endif
									@if(in_array("timesheet_category_read",$rolelists, TRUE))
										TimeSheet Category Read,
									@endif
									@if(in_array("timesheet_category_write",$rolelists, TRUE))
										TimeSheet Category Write,
									@endif
									@if(in_array("timesheet_category_create",$rolelists, TRUE))
										TimeSheet Category Create,
									@endif
									@if(in_array("timesheet_category_delete",$rolelists, TRUE))
										TimeSheet Category Delete,
									@endif
								</div>
								@endif

								<!-- Time Details
								@if(in_array("time_details_read",$rolelists, TRUE)||in_array("time_details_write",$rolelists, TRUE)||in_array("time_details_create",$rolelists, TRUE)||in_array("time_details_delete",$rolelists, TRUE)||in_array("time_details_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("time_details_all",$rolelists, TRUE))
										Task Details All,
									@endif  
									@if(in_array("time_details_read",$rolelists, TRUE))
										Task Details Read,
									@endif
									@if(in_array("time_details_write",$rolelists, TRUE))
										Task Details Write,
									@endif
									@if(in_array("time_details_create",$rolelists, TRUE))
										Task Details Create,
									@endif
									@if(in_array("time_details_delete",$rolelists, TRUE))
										Task Details Delete,
									@endif
								</div>
								@endif
								 -->
								<!-- Domain Management -->
								 <!-- Hosting -->
								 @if(in_array("host_read",$rolelists, TRUE)||in_array("host_write",$rolelists, TRUE)||in_array("host_create",$rolelists, TRUE)||in_array("host_delete",$rolelists, TRUE)||in_array("host_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("host_all",$rolelists, TRUE))
										Hosting Management All,
									@endif
									@if(in_array("host_read",$rolelists, TRUE))
										Hosting Management Read,
									@endif
									@if(in_array("host_write",$rolelists, TRUE))
										Hosting Management Write,
									@endif
									@if(in_array("host_create",$rolelists, TRUE))
										Hosting Management Create,
									@endif
									@if(in_array("host_delete",$rolelists, TRUE))
										Hosting Management Delete,
									@endif
								</div>
								@endif

								<!-- Domain List -->
								@if(in_array("domain_read",$rolelists, TRUE)||in_array("domain_write",$rolelists, TRUE)||in_array("domain_create",$rolelists, TRUE)||in_array("domain_delete",$rolelists, TRUE)||in_array("domain_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("domain_all",$rolelists, TRUE))
										Domain Management All,
									@endif
									@if(in_array("domain_read",$rolelists, TRUE))
										Domain Management Read,
									@endif
									@if(in_array("domain_write",$rolelists, TRUE))
										Domain Management Write,
									@endif
									@if(in_array("domain_create",$rolelists, TRUE))
										Domain Management Create,
									@endif
									@if(in_array("domain_delete",$rolelists, TRUE))
										Domain Management Delete,
									@endif
								</div>
								@endif

								<!-- SubDomain List -->
								@if(in_array("subdomain_read",$rolelists, TRUE)||in_array("subdomain_write",$rolelists, TRUE)||in_array("subdomain_create",$rolelists, TRUE)||in_array("subdomain_delete",$rolelists, TRUE)||in_array("subdomain_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("subdomain_all",$rolelists, TRUE))
										SubDomain Management All,
									@endif
									@if(in_array("subdomain_read",$rolelists, TRUE))
										SubDomain Management Read,
									@endif
									@if(in_array("subdomain_write",$rolelists, TRUE))
										SubDomain Management Write,
									@endif
									@if(in_array("subdomain_create",$rolelists, TRUE))
										SubDomain Management Create,
									@endif
									@if(in_array("subdomain_delete",$rolelists, TRUE))
										SubDomain Management Delete,
									@endif
								</div>
								@endif

								<!-- Domain Type List -->
								 <!-- Type  list page Folder Name-->
								@if(in_array("domain_type_read",$rolelists, TRUE)||in_array("domain_type_write",$rolelists, TRUE)||in_array("domain_type_create",$rolelists, TRUE)||in_array("domain_type_delete",$rolelists, TRUE)||in_array("domain_type_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("domain_type_all",$rolelists, TRUE))
										Domain Type Management All,
									@endif
									@if(in_array("domain_type_read",$rolelists, TRUE))
										Domain Type Management Read,
									@endif
									@if(in_array("domain_type_write",$rolelists, TRUE))
										Domain Type Management Write,
									@endif
									@if(in_array("domain_type_create",$rolelists, TRUE))
										Domain Type Management Create,
									@endif
									@if(in_array("domain_type_delete",$rolelists, TRUE))
										Domain Type Management Delete,
									@endif
								</div>
								@endif

								<!-- Tool Management -->
								<!-- Tool Type -->
								@if(in_array("tool_read",$rolelists, TRUE)||in_array("tool_write",$rolelists, TRUE)||in_array("tool_create",$rolelists, TRUE)||in_array("tool_delete",$rolelists, TRUE)||in_array("tool_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("tool_all",$rolelists, TRUE))
										Tool Management All,
									@endif
									@if(in_array("tool_read",$rolelists, TRUE))
										Tool Management Read,
									@endif
									@if(in_array("tool_write",$rolelists, TRUE))
										Tool Management Write,
									@endif
									@if(in_array("tool_create",$rolelists, TRUE))
										Tool Management Create,
									@endif
									@if(in_array("tool_delete",$rolelists, TRUE))
										Tool Management Delete,
									@endif
								</div>
								@endif

								<!-- Tool Credentials -->
								@if(in_array("toolc_read",$rolelists, TRUE)||in_array("toolc_write",$rolelists, TRUE)||in_array("toolc_create",$rolelists, TRUE)||in_array("toolc_delete",$rolelists, TRUE)||in_array("toolc_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("toolc_all",$rolelists, TRUE))
										Tool Credentials All,
									@endif
									@if(in_array("toolc_read",$rolelists, TRUE))
										Tool Credentials Read,
									@endif
									@if(in_array("toolc_write",$rolelists, TRUE))
										Tool Credentials Write,
									@endif
									@if(in_array("toolc_create",$rolelists, TRUE))
										Tool Credentials Create,
									@endif
									@if(in_array("toolc_delete",$rolelists, TRUE))
										Tool Credentials Delete,
									@endif
								</div>
								@endif
								
								

								<!-- Goal Task Folder name-->
								 <!-- GoalSheet -->
								@if(in_array("goalsheet_read",$rolelists, TRUE)||in_array("goalsheet_write",$rolelists, TRUE)||in_array("goalsheet_create",$rolelists, TRUE)||in_array("goalsheet_delete",$rolelists, TRUE)||in_array("goalsheet_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("goalsheet_all",$rolelists, TRUE))
										GoalSheet All,
									@endif
									@if(in_array("goalsheet_read",$rolelists, TRUE))
										GoalSheet Read,
									@endif
									@if(in_array("goalsheet_write",$rolelists, TRUE))
										GoalSheet Write,
									@endif
									@if(in_array("goalsheet_create",$rolelists, TRUE))
										GoalSheet Create, 
									@endif
									@if(in_array("goalsheet_delete",$rolelists, TRUE))
										GoalSheet Delete,
									@endif
								</div>
								@endif

							
								<!-- Goal Sheet Category -->
								@if(in_array("goalsheet_category_read",$rolelists, TRUE)||in_array("goalsheet_category_write",$rolelists, TRUE)||in_array("goalsheet_category_create",$rolelists, TRUE)||in_array("goalsheet_category_delete",$rolelists, TRUE)||in_array("goalsheet_category_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
									<span class="bullet bg-primary me-3"></span>
									@if(in_array("goalsheet_category_all",$rolelists, TRUE))
										GoalSheet Category All,
									@endif
									@if(in_array("goalsheet_category_read",$rolelists, TRUE))
										GoalSheet Category Read,
									@endif
									@if(in_array("goalsheet_category_write",$rolelists, TRUE))
										GoalSheet Category Write,
									@endif
									@if(in_array("goalsheet_category_create",$rolelists, TRUE))
										GoalSheet Category Create,
									@endif
									@if(in_array("goalsheet_category_delete",$rolelists, TRUE))
										GoalSheet Category Delete,
									@endif
								</div>
								@endif

								<!-- Social Media -->
								@if(in_array("sm_read",$rolelists, TRUE)||in_array("sm_write",$rolelists, TRUE)||in_array("sm_create",$rolelists, TRUE)||in_array("sm_delete",$rolelists, TRUE)||in_array("sm_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("sm_all",$rolelists, TRUE))
										Social Media All,
									@endif
									@if(in_array("sm_read",$rolelists, TRUE))
										Social Media Read,
									@endif
									@if(in_array("sm_write",$rolelists, TRUE))
										Social Media Write,
									@endif
									@if(in_array("sm_create",$rolelists, TRUE))
										Social Media Create,
									@endif
									@if(in_array("sm_delete",$rolelists, TRUE))
										Social Media Delete,
									@endif
								</div>
								@endif

								<!-- Heading Master -->
								<!-- Tool Domain Type -->
								@if(in_array("tool_domain_type_read",$rolelists, TRUE)||in_array("tool_domain_type_write",$rolelists, TRUE)||in_array("tool_domain_type_create",$rolelists, TRUE)||in_array("tool_domain_type_delete",$rolelists, TRUE)||in_array("tool_domain_type_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("tool_domain_type_all",$rolelists, TRUE))
									Tool Domain Type All,
									@endif
									@if(in_array("tool_domain_type_read",$rolelists, TRUE))
									Tool Domain Type Read,
									@endif
									@if(in_array("tool_domain_type_write",$rolelists, TRUE))
									Tool Domain Type Write,
									@endif
									@if(in_array("tool_domain_type_create",$rolelists, TRUE))
									Tool Domain Type Create,
									@endif
									@if(in_array("tool_domain_type_create",$rolelists, TRUE))
									Tool Domain Type Delete,
									@endif
								</div>
								@endif

								<!-- Knowledge Management -->
								 <!-- Training Videos -->
								@if(in_array("tvideo_read",$rolelists, TRUE)||in_array("tvideo_write",$rolelists, TRUE)||in_array("tvideo_create",$rolelists, TRUE)||in_array("tvideo_delete",$rolelists, TRUE)||in_array("tvideo_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("tvideo_all",$rolelists, TRUE))
									Training Video All,
									@endif
									@if(in_array("tvideo_read",$rolelists, TRUE))
									Training Video Read,
									@endif
									@if(in_array("tvideo_write",$rolelists, TRUE))
									Training Video Write,
									@endif
									@if(in_array("tvideo_create",$rolelists, TRUE))
									Training Video Create,
									@endif
									@if(in_array("tvideo_delete",$rolelists, TRUE))
									Training Video Delete,
									@endif
								</div>
								@endif

								<!-- Corporte Video -->

								@if(in_array("cvideo_read",$rolelists, TRUE)||in_array("cvideo_write",$rolelists, TRUE)||in_array("cvideo_create",$rolelists, TRUE)||in_array("cvideo_delete",$rolelists, TRUE)||in_array("cvideo_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("cvideo_all",$rolelists, TRUE))
									Corporate Video All,
									@endif
									@if(in_array("cvideo_read",$rolelists, TRUE))
									Corporate Video Read,
									@endif
									@if(in_array("cvideo_write",$rolelists, TRUE))
									Corporate Video Write,
									@endif
									@if(in_array("cvideo_create",$rolelists, TRUE))
									Corporate Video Create,
									@endif
									@if(in_array("cvideo_delete",$rolelists, TRUE))
									Corporate Video Delete,
									@endif
								</div>
								@endif

								<!-- Goal And Time Management -->

								<!-- @if(in_array("cvideo_read",$rolelists, TRUE)||in_array("cvideo_write",$rolelists, TRUE)||in_array("cvideo_create",$rolelists, TRUE)||in_array("cvideo_delete",$rolelists, TRUE)||in_array("cvideo_all",$rolelists, TRUE))
								<div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>
									@if(in_array("cvideo_all",$rolelists, TRUE))
									Corporate Video All,
									@endif
									@if(in_array("cvideo_read",$rolelists, TRUE))
									Corporate Video Read,
									@endif
									@if(in_array("cvideo_write",$rolelists, TRUE))
									Corporate Video Write,
									@endif
									@if(in_array("cvideo_create",$rolelists, TRUE))
									Corporate Video Create,
									@endif
									@if(in_array("cvideo_create",$rolelists, TRUE))
									Corporate Video Delete,
									@endif
								</div>
								@endif -->
							</div>
						</div> 
						<div class="card-footer flex-wrap pt-0">
							@if(in_array("role_management_all",$rolerawdata, TRUE) || in_array("role_management_write",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))             
							<div class="ro-ed-lt"> 
								<form method="POST" class="btn" action="{{route('edit.rolelist')}}">
									@csrf
									<input type="hidden" value="{{$rolelist->id}}" name="id">
									<button type="submit" class="btn btn-light btn-active-primary my-1 me-2" data-bs-target="#kt_modal_update_role" >Edit Role</button> 
								</form> 
							</div>
							@endif
							@if($rolelist->role_name!="Coe Admin" && $rolelist->role_name!="Admin")
							@if(in_array("role_management_all",$rolerawdata, TRUE) || in_array("role_management_delete",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="ro-ed-rt"> 
								<form method="POST" class="btn" action="{{route('delete.rolelist')}}">
									@csrf
									<input type="hidden" value="{{$rolelist->id}}" name="id">
									<button type="submit" class="btn btn-light btn-active-light-primary my-1" onclick="deleterole()">Delete Role</button>
								</form> 
							</div>
							@endif 
							@endif
						</div>
					</div>
				</div>
			@endforeach
			</div>
			<!--end::Row-->
			<!--begin::Modals-->
			<!--begin::Modal - Add role-->
			<div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true"> 	<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered mw-750px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header">
							<!--begin::Modal title-->
							<h2 class="fw-bolder">Add a Role</h2>
							<!--end::Modal title-->
							<!--begin::Close--> 
							<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
								<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
								</span>
							<!--end::Svg Icon-->
							</div>
							<!--end::Close-->
						</div>
						<!--end::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body scroll-y mx-lg-5 my-7">
							<!--begin::Form-->
							<form  class="form" action="{{route('store.rolelist')}}" method="POST">
							@csrf
								<!--begin::Scroll-->
								<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
									<!--begin::Input group-->
									<div class="fv-row mb-10">
										<!--begin::Label-->
										<label class="fs-5 fw-bolder form-label mb-2">
										<span class="required">Role name</span>
										</label>
										<!--end::Label-->
										<!--begin::Input-->
										<input class="form-control form-control-solid" placeholder="Enter a role name" name="role_name" required />
										<!--end::Input-->
									</div>
									<!--end::Input group-->
									<!--begin::Permissions-->
									<div class="fv-row">
									<!--begin::Label-->
										<label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
										<!--end::Label-->
										<!--begin::Table wrapper-->
										<div class="table-responsive">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5">
												<!--begin::Table body-->
											<tbody class="text-gray-600 fw-bold">
													<!--begin::Table row-->
												<tr>
													<td class="text-gray-800">Administrator Access
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allows a full access to the system"></i></td>
													<td>
														<!--begin::Checkbox-->
														<label class="form-check form-check-custom form-check-solid me-9">
															<input class="form-check-input" type="checkbox" value="kt_roles_select_all" id="kt_roles_select_all" name="kt_roles_select_all" />
															<span class="form-check-label" for="kt_roles_select_all">Select all</span>
														</label>
														<!--end::Checkbox-->
													</td>
												</tr>
									
								
												<tr>
													<td class="text-gray-800">Admin & Team Users</td>
													<td>
														<div class="d-flex justify-content-between w-100">
															<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
																<input class="form-check-input" type="checkbox" value="user_management_all" id="user_management_all" name="user_management_all" />
																<span class="form-check-label" for="user_management_all">All</span>
															</label>
															<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
																<input class="form-check-input" type="checkbox" value="user_management_read" name="user_management_read" />
																<span class="form-check-label">Read</span>
															</label>
															<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
																<input class="form-check-input" type="checkbox" value="user_management_write" name="user_management_write" />
																<span class="form-check-label">Write</span>
															</label>
															<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
																<input class="form-check-input" type="checkbox" value="user_management_create" name="user_management_create" />
																<span class="form-check-label">Create</span>
															</label>
															<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
																<input class="form-check-input" type="checkbox" value="user_management_delete" name="user_management_delete" />
																<span class="form-check-label">Delete</span>
															</label>
														</div>
													</td>
												</tr>

									<tr>
										<td class="text-gray-800">Access Control & Roles</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="role_management_all" id="role_management_all" name="role_management_all" />
													<span class="form-check-label" for="role_management_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="role_management_read" name="role_management_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="role_management_write" name="role_management_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="role_management_create" name="role_management_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="role_management_delete" name="role_management_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>
									<!-- Callcenter Management -->
									 <!-- Enquiry List -->

									<tr>
										<td class="text-gray-800">Enquiry List</td>
										<td>
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="enquiry_all" id="enquiry_all" name="enquiry_all" />
													<span class="form-check-label" for="enquiry_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="enquiry_read" name="enquiry_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="enquiry_write" name="enquiry_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="enquiry_create" name="enquiry_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="enquiry_delete" name="enquiry_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>
									<!-- FollowUp List -->
									<tr>
										<td class="text-gray-800">FollowUp List</td>
										<td>
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="followup_all" id="followup_all" name="followup_all" />
													<span class="form-check-label" for="followup_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="followup_read" name="followup_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="followup_write" name="followup_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="followup_create" name="followup_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="followup_delete" name="followup_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>


									<tr>
										<td class="text-gray-800">Apply Leave</td>
										<td>
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="leave_all" id="leave_all" name="leave_all" />
													<span class="form-check-label" for="leave_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="leave_read" name="leave_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="leave_write" name="leave_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="leave_create" name="leave_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="leave_delete" name="leave_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>


									<!-- Project Management -->

									<tr>
										<td class="text-gray-800">Services</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="service_all" id="service_all" name="service_all" />
													<span class="form-check-label" for="service_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="service_read" name="service_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="service_write" name="service_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="service_create" name="service_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="service_delete" name="service_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>

									<tr>
										<td class="text-gray-800">Projects</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="project_all" id="project_all" name="project_all" />
													<span class="form-check-label" for="project_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="project_read" name="project_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="project_write" name="project_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="project_create" name="project_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="project_delete" name="project_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>
									<!-- TimeSheet -->
									<tr>
										<td class="text-gray-800">Timesheet</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_all" id="timesheet_all" name="timesheet_all" />
													<span class="form-check-label" for="timesheet_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_read" name="timesheet_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_write" name="timesheet_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_create" name="timesheet_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_delete" name="timesheet_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>
									<!-- Time Sheet Category -->
									<tr>
										<td class="text-gray-800">TimeSheet Category</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_category_all" id="timesheet_category_all" name="timesheet_category_all" />
													<span class="form-check-label" for="timesheet_category_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_category_read" name="timesheet_category_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_category_write" name="timesheet_category_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_category_create" name="timesheet_category_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="timesheet_category_delete" name="timesheet_category_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>
		

									<!-- Time -->
									<!-- <tr>
										<td class="text-gray-800">Task Timesheet List</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="task_timesheet_all" id="task_timesheet_all" name="task_timesheet_all" />
													<span class="form-check-label" for="task_timesheet_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="task_timesheet_read" name="task_timesheet_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="task_timesheet_write" name="task_timesheet_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="task_timesheet_create" name="task_timesheet_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="task_timesheet_delete" name="task_timesheet_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr> -->

									<!-- Time Details -->
									<!-- <tr>
										<td class="text-gray-800">Time Details</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="time_details_all" id="time_details_all" name="time_details_all" />
													<span class="form-check-label" for="time_details_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="time_details_read" name="time_details_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="time_details_write" name="time_details_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="time_details_create" name="time_details_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="time_details_delete" name="time_details_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr> -->




									<!-- Domain Management -->
									<tr>
										<td class="text-gray-800">Hosting</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="host_all" id="host_all" name="host_all" />
													<span class="form-check-label" for="host_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="host_read" name="host_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="host_write" name="host_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="host_create" name="host_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="host_delete" name="host_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>

									<tr>
										<td class="text-gray-800">Domain</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domain_all" id="domain_all" name="domain_all" />
													<span class="form-check-label" for="domain_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domain_read" name="domain_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domain_write" name="domain_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domain_create" name="domain_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domain_delete" name="domain_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>

									<tr>
										<td class="text-gray-800">SubDomain</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="subdomain_all" id="subdomain_all" name="subdomain_all" />
													<span class="form-check-label" for="subdomain_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="subdomain_read" name="subdomain_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="subdomain_write" name="subdomain_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="subdomain_create" name="subdomain_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="subdomain_delete" name="subdomain_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>

									<tr>
										<td class="text-gray-800">Domain Type</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domaintype_all" id="domaintype_all" name="domaintype_all" />
													<span class="form-check-label" for="domaintype_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domaintype_read" name="domaintype_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domaintype_write" name="domaintype_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domaintype_create" name="domaintype_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="domaintype_delete" name="domaintype_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>

									<!-- Tools Management -->
									<tr>
										<td class="text-gray-800">Tools & Resources List</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_all" id="tool_all" name="tool_all" />
													<span class="form-check-label" for="tool_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_read" name="tool_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_write" name="tool_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_create" name="tool_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_delete" name="tool_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>


									<tr>
										<td class="text-gray-800">Tools & Login Credentials</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="toolc_all" id="toolc_all" name="toolc_all" />
													<span class="form-check-label" for="toolc_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="toolc_read" name="toolc_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="toolc_write" name="toolc_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="toolc_create" name="toolc_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="toolc_delete" name="toolc_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>
									<!-- Goal Task Folder Name-->
									<tr>
										<td class="text-gray-800">Goal Sheet</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_all" id="goalsheet_all" name="goalsheet_all" />
													<span class="form-check-label" for="goalsheet_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_read" name="goalsheet_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_write" name="goalsheet_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_create" name="goalsheet_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_delete" name="goalsheet_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>
	
									<tr>
										<td class="text-gray-800">GoalSheet Category</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_category_all" id="goalsheet_category_all" name="goalsheet_category_all" />
													<span class="form-check-label" for="goalsheet_category_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_category_read" name="goalsheet_category_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_category_write" name="goalsheet_category_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_category_create" name="goalsheet_category_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="goalsheet_category_delete" name="goalsheet_category_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>

									<!-- Social Media -->
									<tr>
										<td class="text-gray-800">Social Media</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="sm_all" id="sm_all" name="sm_all" />
													<span class="form-check-label" for="sm_all">All</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="sm_read" name="sm_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="sm_write" name="sm_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="sm_create" name="sm_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="sm_delete" name="sm_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>


									<!-- Heading Master -->
									<tr>
										<td class="text-gray-800">Tool Domain Type</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_all" id="tool_domain_type_all" name="tool_domain_type_all" />
													<span class="form-check-label" for="tool_domain_type_all">All</span>
												</label>
												<label class="form-check form-check-tool_domain_type form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_read" name="tool_domain_type_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-tool_domain_type form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_write" name="tool_domain_type_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-tool_domain_type form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_create" name="tool_domain_type_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-tool_domain_type form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_delete" name="tool_domain_type_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>

									<!-- Knowledge Management -->
									<tr>
										<td class="text-gray-800">Training Videos</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tvideo_all" id="tvideo_all" name="tvideo_all" />
													<span class="form-check-label" for="tvideo_all">All</span>
												</label>
												<label class="form-check form-check-tvideo form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tvideo_read" name="tvideo_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-tvideo form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tvideo_write" name="tvideo_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-tvideo form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tvideo_create" name="tvideo_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-tvideo form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tvideo_delete" name="tvideo_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>


									<!-- Corporate Video -->

									<tr>
										<td class="text-gray-800">Corporate Video</td>
										<td> 
											<div class="d-flex justify-content-between w-100">
												<label class="form-check form-check-sm form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_all" id="tool_domain_type_all" name="tool_domain_type_all" />
													<span class="form-check-label" for="tool_domain_type_all">All</span>
												</label>
												<label class="form-check form-check-tool_domain_type form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_read" name="tool_domain_type_read" />
													<span class="form-check-label">Read</span>
												</label>
												<label class="form-check form-check-tool_domain_type form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_write" name="tool_domain_type_write" />
													<span class="form-check-label">Write</span>
												</label>
												<label class="form-check form-check-tool_domain_type form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_create" name="tool_domain_type_create" />
													<span class="form-check-label">Create</span>
												</label>
												<label class="form-check form-check-tool_domain_type form-check-custom form-check-solid flex-grow-1 text-center">
													<input class="form-check-input" type="checkbox" value="tool_domain_type_delete" name="tool_domain_type_delete" />
													<span class="form-check-label">Delete</span>
												</label>
											</div>
										</td>
									</tr>	
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="text-center pt-15">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
						<button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit" name="addrolesubmit">
						<span class="indicator-label">Submit</span>
						<span class="indicator-progress">Please wait...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
						</button>
					</div>
				</form>
			</div>
			</div>
			</div>
			</div>
		</div>
	</div>
</div>
@endsection