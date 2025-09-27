<div id="kt_aside" class="aside bg-dark" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
	<div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto py-8" id="kt_aside_logo">
		<a href=""> <img alt="Logo" src="{{asset('backend/assets/media/logos/repunextlogo.png')}}" class="h-60px" /> </a>
	</div>
	<?php 	if(!Auth::check()){ header("Refresh:0; url=".URL::to('admin/login')."");exit;}
	$role_data = DB::table('roles')->where('role_name',Auth::user()->role)->get();  
			foreach($role_data  as $roledata){$roledataval=explode(",",$roledata->role);}
			session(['userRoles' => $roledataval]); $rolerawdata = session('userRoles');?>
	<div class="aside-nav d-flex flex-column align-lg-center flex-column-fluid w-100 pt-5 pt-lg-0" id="kt_aside_nav">
		<div class="hover-scroll-overlay-y my-2 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
			<div id="kt_aside_menu" class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6" data-kt-menu="true">
				<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
					<span class="menu-link menu-center">
						<span class="menu-icon me-0">
							<i class="fonticon-house fs-1"></i>
						</span>
					</span>
					<div class="menu-sub menu-sub-dropdown py-4 w-200px w-lg-225px">
						<div class="menu-item">
							<a class="menu-link " href="{{ route('dashboard') }}">
								<span class="menu-bullet">
								</span>
								<span class="menu-title">Dashboard</span> </a>
						</div>
					</div>
				</div>
				<!-- Call Center Management -->
				@if(in_array("enquiry_all",$rolerawdata, TRUE) || in_array("enquiry_read",$rolerawdata, TRUE) ||
				in_array("enquiry_write",$rolerawdata, TRUE) || in_array("enquiry_create",$rolerawdata, TRUE) || in_array("enquiry_delete",$rolerawdata, TRUE) || 
				in_array("followup_all",$rolerawdata, TRUE) || in_array("followup_read",$rolerawdata, TRUE) ||
				in_array("followup_write",$rolerawdata, TRUE) || in_array("followup_create",$rolerawdata, TRUE) || in_array("followup_delete",$rolerawdata, TRUE) || 
				in_array("kt_roles_select_all",$rolerawdata, TRUE))
				<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
					<span class="menu-link menu-center">
						<span class="menu-icon me-0">
							<i class="bi bi-telephone-forward fs-1"></i>
						</span>
					</span>
					<div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px" style="">
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Call Center Managment</span>
							</div>
						</div>
						@if(in_array("enquiry_all",$rolerawdata, TRUE) || in_array("enquiry_read",$rolerawdata, TRUE) ||
						in_array("enquiry_write",$rolerawdata, TRUE) || in_array("enquiry_create",$rolerawdata, TRUE) || in_array("enquiry_delete",$rolerawdata, TRUE) || 
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.support')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Client Enquiry List</span>
								</a>
							</div> 
						</div>
						@endif
						@if(in_array("followup_all",$rolerawdata, TRUE) || in_array("followup_read",$rolerawdata, TRUE) ||
						in_array("followup_write",$rolerawdata, TRUE) || in_array("followup_create",$rolerawdata, TRUE) || in_array("followup_delete",$rolerawdata, TRUE) || 
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.followup')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Lead Follow-up List</span>
								</a>
							</div> 
						</div>
						@endif
					</div>
				</div>
				@endif



				<!-- Man Icon -->
				@if(in_array("leave_all",$rolerawdata, TRUE) || in_array("leave_read",$rolerawdata, TRUE) || in_array("leave_write",$rolerawdata, TRUE) || in_array("leave_create",$rolerawdata, TRUE) || in_array("leave_delete",$rolerawdata, TRUE) ||
				in_array("goalsheet_category_all",$rolerawdata, TRUE) || in_array("goalsheet_category_read",$rolerawdata, TRUE) || in_array("goalsheet_category_write",$rolerawdata, TRUE) || in_array("goalsheet_category_create",$rolerawdata, TRUE) || in_array("goalsheet_category_delete",$rolerawdata, TRUE) ||
				in_array("goalsheet_all",$rolerawdata, TRUE) || in_array("goalsheet_read",$rolerawdata, TRUE) || in_array("goalsheet_write",$rolerawdata, TRUE) || in_array("goalsheet_create",$rolerawdata, TRUE) || in_array("goalsheet_delete",$rolerawdata, TRUE) ||		
				in_array("timesheet_category_all",$rolerawdata, TRUE) || in_array("timesheet_category_read",$rolerawdata, TRUE) || in_array("timesheet_category_write",$rolerawdata, TRUE) || in_array("timesheet_category_create",$rolerawdata, TRUE) || in_array("timesheet_category_delete",$rolerawdata, TRUE)||
				in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_read",$rolerawdata, TRUE) || in_array("timesheet_write",$rolerawdata, TRUE) || in_array("timesheet_create",$rolerawdata, TRUE) || in_array("timesheet_all_delete",$rolerawdata, TRUE)||
				in_array("tvideo_all",$rolerawdata, TRUE) || in_array("tvideo_read",$rolerawdata, TRUE) || in_array("tvideo_write",$rolerawdata, TRUE) || in_array("tvideo_create",$rolerawdata, TRUE) || in_array("tvideo_delete",$rolerawdata, TRUE)||
				in_array("cvideo_all",$rolerawdata, TRUE) || in_array("cvideo_read",$rolerawdata, TRUE) || in_array("cvideo_write",$rolerawdata, TRUE) || in_array("cvideo_create",$rolerawdata, TRUE) || in_array("cvideo_delete",$rolerawdata, TRUE)||
				in_array("kt_roles_select_all",$rolerawdata, TRUE))
				<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
					<span class="menu-link menu-center">
						<span class="menu-icon me-0">
							<i class="bi bi-person-lines-fill fs-1"></i> <!-- Person with Lines (Text) -->
						</span>
					</span>
					<div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px" style="">
						@if(in_array("leave_all",$rolerawdata, TRUE) || in_array("leave_read",$rolerawdata, TRUE) ||in_array("leave_write",$rolerawdata, TRUE) || in_array("leave_create",$rolerawdata, TRUE) || in_array("leave_delete",$rolerawdata, TRUE) ||in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Leave Managment</span>
							</div>
						</div>
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.leave')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Apply Leave</span>
								</a>
							</div> 
						</div>
						@endif
						@if(in_array("goalsheet_category_all",$rolerawdata, TRUE) || in_array("goalsheet_category_read",$rolerawdata, TRUE) ||
						in_array("goalsheet_category_write",$rolerawdata, TRUE) || in_array("goalsheet_category_create",$rolerawdata, TRUE) || in_array("goalsheet_category_delete",$rolerawdata, TRUE) ||
						in_array("goalsheet_all",$rolerawdata, TRUE) || in_array("goalsheet_read",$rolerawdata, TRUE) ||
						in_array("goalsheet_write",$rolerawdata, TRUE) || in_array("goalsheet_create",$rolerawdata, TRUE) || in_array("goalsheet_delete",$rolerawdata, TRUE) ||
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
						
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Goal Task Managment</span>
							</div>
						</div>
						
						@if(in_array("goalsheet_all",$rolerawdata, TRUE) || in_array("goalsheet_read",$rolerawdata, TRUE) ||
						in_array("goalsheet_write",$rolerawdata, TRUE) || in_array("goalsheet_create",$rolerawdata, TRUE) || in_array("goalsheet_delete",$rolerawdata, TRUE) ||
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.gtask')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Goal Sheet List</span>
								</a>
							</div> 
						@endif
						@endif
						
						
						@if(in_array("timesheet_category_all",$rolerawdata, TRUE) || in_array("timesheet_category_read",$rolerawdata, TRUE) || in_array("timesheet_category_delete",$rolerawdata, TRUE) ||
						in_array("timesheet_category_write",$rolerawdata, TRUE) || in_array("timesheet_category_create",$rolerawdata, TRUE)||
						in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_read",$rolerawdata, TRUE) || in_array("timesheet_delete",$rolerawdata, TRUE) ||
						in_array("timesheet_write",$rolerawdata, TRUE) || in_array("timesheet_create",$rolerawdata, TRUE)||
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Time Managment</span>
							</div>
						</div> 
						@if(in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_read",$rolerawdata, TRUE) || in_array("timesheet_delete",$rolerawdata, TRUE) ||
						in_array("timesheet_write",$rolerawdata, TRUE) || in_array("timesheet_create",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.ttimecat')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Time Sheet List</span>
								</a>
							</div>
						@endif
						@endif
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Chat Managment</span>
							</div>
						</div>
						<div class="menu-item">
							<a class="menu-link" href="{{route('list.chatapp')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span> 		
								<span class="menu-title">Repu Chat</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link" href="{{route('rooms.index')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span> 		
								<span class="menu-title">Group Chat </span>
							</a>
						</div>
						<!-- Knowledge Management -->
						@if(in_array("tvideo_all",$rolerawdata, TRUE) || in_array("tvideo_read",$rolerawdata, TRUE) || in_array("tvideo_delete",$rolerawdata, TRUE) ||
						in_array("tvideo_write",$rolerawdata, TRUE) || in_array("tvideo_create",$rolerawdata, TRUE) ||
						in_array("cvideo_all",$rolerawdata, TRUE) || in_array("cvideo_read",$rolerawdata, TRUE) ||
						in_array("cvideo_write",$rolerawdata, TRUE) || in_array("cvideo_create",$rolerawdata, TRUE) || in_array("cvideo_delete",$rolerawdata, TRUE)||
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Knowledge Managment</span>
							</div>
						</div>
				 
						@if(in_array("tvideo_all",$rolerawdata, TRUE) || in_array("tvideo_read",$rolerawdata, TRUE) || in_array("tvideo_delete",$rolerawdata, TRUE) ||
						in_array("tvideo_write",$rolerawdata, TRUE) || in_array("tvideo_create",$rolerawdata, TRUE) || in_array("tvideo_delete",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.tvideos')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span> 		
									<span class="menu-title">Training Videos List</span>
								</a>
							</div>
						@endif 
						@if(in_array("cvideo_all",$rolerawdata, TRUE) || in_array("cvideo_read",$rolerawdata, TRUE) ||
						in_array("cvideo_write",$rolerawdata, TRUE) || in_array("cvideo_create",$rolerawdata, TRUE) || in_array("cvideo_delete",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE)) 
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.cvideo')}}"> 
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Corporate Videos List</span>
								</a>
							</div>
						@endif
						@endif
					</div>
				</div>
				@endif


			

				
				<!-- Project Management -->
				@if(in_array("project_all",$rolerawdata, TRUE) || in_array("project_read",$rolerawdata, TRUE) || in_array("project_delete",$rolerawdata, TRUE) || in_array("project_write",$rolerawdata, TRUE) || in_array("project_create",$rolerawdata, TRUE) ||
				in_array("service_all",$rolerawdata, TRUE) || in_array("service_read",$rolerawdata, TRUE) || in_array("service_delete",$rolerawdata, TRUE) || in_array("service_write",$rolerawdata, TRUE) || in_array("service_create",$rolerawdata, TRUE)||
				in_array("kt_roles_select_all",$rolerawdata, TRUE))
				<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
					<span class="menu-link menu-center">
						<span class="menu-icon me-0">
							<i class="bi bi-subtract fs-1"></i>
						</span>
					</span>
					<div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px" style="">
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Project Managment</span>
							</div>
						</div>
						@if(in_array("project_all",$rolerawdata, TRUE) || in_array("project_read",$rolerawdata, TRUE) || in_array("project_delete",$rolerawdata, TRUE) ||
						in_array("project_write",$rolerawdata, TRUE) || in_array("project_create",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.pdetail')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span> 		
									<span class="menu-title">Projects List</span>
								</a>
							</div>
						@endif

						@if(in_array("service_all",$rolerawdata, TRUE) || in_array("service_read",$rolerawdata, TRUE) || in_array("service_delete",$rolerawdata, TRUE) ||
						in_array("service_write",$rolerawdata, TRUE) || in_array("service_create",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.pservice')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Services List</span>
								</a>
							</div>
						@endif
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.salesorder')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Sale List</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link" href="{{route('booking.index')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Studio Booking</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link" href="{{route('availability.index')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Person Availability</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link" href="{{route('revenue-expense.index')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Revenue & Expense</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link" href="{{route('jira-tasks.board')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Repunext Board</span>
								</a>
							</div>
							<div class="menu-item">
								<a class="menu-link" href="{{route('jira-tasks.backlog')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Backlog</span>
								</a>
							</div>
							
					</div>
				</div>
				@endif
			 
				@if(in_array("tool_all",$rolerawdata, TRUE) || in_array("tool_read",$rolerawdata, TRUE) || in_array("tool_delete",$rolerawdata, TRUE) || in_array("tool_write",$rolerawdata, TRUE) || in_array("tool_create",$rolerawdata, TRUE)||
				in_array("toolc_all",$rolerawdata, TRUE) || in_array("toolc_read",$rolerawdata, TRUE)|| in_array("toolc_delete",$rolerawdata, TRUE) || in_array("toolc_write",$rolerawdata, TRUE) || in_array("toolc_create",$rolerawdata, TRUE)||
				in_array("sm_all",$rolerawdata, TRUE) || in_array("sm_read",$rolerawdata, TRUE) || in_array("sm_write",$rolerawdata, TRUE) || in_array("sm_create",$rolerawdata, TRUE) || in_array("sm_delete",$rolerawdata, TRUE) ||
				in_array("kt_roles_select_all",$rolerawdata, TRUE)) 
				<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
					<span class="menu-link menu-center">
						<span class="menu-icon me-0">
							<i class="bi bi-tools fs-1"></i>
						</span>
					</span>
					<div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px" style="">
						@if(in_array("toolc_all",$rolerawdata, TRUE) || in_array("toolc_read",$rolerawdata, TRUE)|| in_array("toolc_delete",$rolerawdata, TRUE)||
						in_array("toolc_write",$rolerawdata, TRUE) || in_array("toolc_create",$rolerawdata, TRUE)||
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<div class="menu-content">
									<span class="menu-section fs-5 fw-bolder ps-1 py-1">AI Managment</span>
								</div>
							</div>
								<div class="menu-item">
									<a class="menu-link" href="{{route('aichat.index')}}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">Repunext AI</span>
									</a>
								</div>
							<div class="menu-item">
								<div class="menu-content">
									<span class="menu-section fs-5 fw-bolder ps-1 py-1">Tools Managment</span>
								</div>
							</div>  
							@if(in_array("toolc_all",$rolerawdata, TRUE) || in_array("toolc_read",$rolerawdata, TRUE)|| in_array("toolc_delete",$rolerawdata, TRUE)||
							in_array("toolc_write",$rolerawdata, TRUE) || in_array("toolc_create",$rolerawdata, TRUE)||
							in_array("kt_roles_select_all",$rolerawdata, TRUE)) 
								<div class="menu-item">
									<a class="menu-link" href="{{route('list.toolcred')}}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">Tools & Login Credentials</span>
									</a>
								</div>
							@endif 
						@endif 
							@if(in_array("sm_all",$rolerawdata, TRUE) || in_array("sm_read",$rolerawdata, TRUE) || in_array("sm_delete",$rolerawdata, TRUE) ||
							in_array("sm_write",$rolerawdata, TRUE) || in_array("sm_create",$rolerawdata, TRUE)||
							in_array("kt_roles_select_all",$rolerawdata, TRUE)) 
							<div class="menu-item">
								<div class="menu-content">
									<span class="menu-section fs-5 fw-bolder ps-1 py-1">Social Media Managment</span>
								</div>
							</div>
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.smedia')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Social Media List</span>
								</a>
							</div>
							@endif
							<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Domain Managment</span>
							</div>
						</div>  
						@if(in_array("domain_all",$rolerawdata, TRUE) || in_array("domain_read",$rolerawdata, TRUE) || in_array("domain_delete",$rolerawdata, TRUE) ||
						in_array("domain_write",$rolerawdata, TRUE) || in_array("domain_create",$rolerawdata, TRUE) ||in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.ddetail')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Domain List</span>
								</a>
							</div>
						@endif 
						@if(in_array("subdomain_all",$rolerawdata, TRUE) || in_array("subdomain_read",$rolerawdata, TRUE) || in_array("subdomain_delete",$rolerawdata, TRUE) ||
						in_array("subdomain_write",$rolerawdata, TRUE) || in_array("subdomain_create",$rolerawdata, TRUE) ||in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.sddetail')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">SubDomain List</span>
								</a>
							</div>
						@endif 
						@if(in_array("host_all",$rolerawdata, TRUE) || in_array("host_read",$rolerawdata, TRUE) || in_array("host_delete",$rolerawdata, TRUE) ||
						in_array("host_write",$rolerawdata, TRUE) || in_array("host_create",$rolerawdata, TRUE) ||	in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.hdetail')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span> 		
									<span class="menu-title">Hosting List</span>
								</a>
							</div>
						@endif
					</div>
				</div>
				@endif 

				@if(in_array("tool_all",$rolerawdata, TRUE) || in_array("tool_read",$rolerawdata, TRUE) || in_array("tool_delete",$rolerawdata, TRUE) || in_array("tool_write",$rolerawdata, TRUE) || in_array("tool_create",$rolerawdata, TRUE)||
				in_array("goalsheet_category_all",$rolerawdata, TRUE) || in_array("goalsheet_category_read",$rolerawdata, TRUE) || in_array("goalsheet_category_write",$rolerawdata, TRUE) || in_array("goalsheet_category_create",$rolerawdata, TRUE) || in_array("goalsheet_category_delete",$rolerawdata, TRUE) ||
				in_array("timesheet_category_all",$rolerawdata, TRUE) || in_array("timesheet_category_read",$rolerawdata, TRUE) || in_array("timesheet_category_delete",$rolerawdata, TRUE) || in_array("timesheet_category_write",$rolerawdata, TRUE) || in_array("timesheet_category_create",$rolerawdata, TRUE)||
				in_array("domain_type_all",$rolerawdata, TRUE) || in_array("domain_type_read",$rolerawdata, TRUE) || in_array("domain_type_delete",$rolerawdata, TRUE) || in_array("domain_type_write",$rolerawdata, TRUE) || in_array("domain_type_create",$rolerawdata, TRUE) || 	
				in_array("kt_roles_select_all",$rolerawdata, TRUE)) 
				<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
					<span class="menu-link menu-center">
						<span class="menu-icon me-0">
						<i class="bi bi-diagram-3 fs-2x"></i> 
						</span>
					</span>
					<div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px" style=""> 
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Master Managment</span>
							</div>
						</div> 
						@if(in_array("tool_all",$rolerawdata, TRUE) || in_array("tool_read",$rolerawdata, TRUE) || in_array("tool_delete",$rolerawdata, TRUE) ||
						in_array("tool_write",$rolerawdata, TRUE) || in_array("tool_create",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<div class="menu-item">
							<a class="menu-link" href="{{route('list.tooltime')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span> 		
								<span class="menu-title">Tools Type List </span>
							</a>
						</div>
						@endif 
						@if(in_array("goalsheet_category_all",$rolerawdata, TRUE) || in_array("goalsheet_category_read",$rolerawdata, TRUE) ||
						in_array("goalsheet_category_write",$rolerawdata, TRUE) || in_array("goalsheet_category_create",$rolerawdata, TRUE) || in_array("goalsheet_category_delete",$rolerawdata, TRUE) ||
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.gscategory')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">GoalSheet Category List</span>
								</a>
							</div> 
						@endif 
						@if(in_array("timesheet_category_all",$rolerawdata, TRUE) || in_array("timesheet_category_read",$rolerawdata, TRUE) || in_array("timesheet_category_delete",$rolerawdata, TRUE) ||
						in_array("timesheet_category_write",$rolerawdata, TRUE) || in_array("timesheet_category_create",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.timecat')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Timesheet Category List</span>
								</a>
							</div>  
						@endif
						@if(in_array("domain_type_all",$rolerawdata, TRUE) || in_array("domain_type_read",$rolerawdata, TRUE) || in_array("domain_type_delete",$rolerawdata, TRUE) ||
						in_array("domain_type_write",$rolerawdata, TRUE) || in_array("domain_type_create",$rolerawdata, TRUE) ||
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.ttime')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Domain Types List</span>
								</a>
							</div>
						@endif
							 
					</div>
				</div>
				@endif 

				<!-- User Management And Role Management -->
				@if(in_array("user_management_all",$rolerawdata, TRUE) || in_array("user_management_read",$rolerawdata, TRUE) || in_array("user_management_write",$rolerawdata, TRUE) || in_array("user_management_create",$rolerawdata, TRUE)|| in_array("user_management_delete",$rolerawdata, TRUE)||
				in_array("role_management_all",$rolerawdata, TRUE) || in_array("role_management_read",$rolerawdata, TRUE) || in_array("role_management_delete",$rolerawdata, TRUE) || in_array("role_management_write",$rolerawdata, TRUE) ||in_array("role_management_create",$rolerawdata, TRUE) ||
				in_array("kt_roles_select_all",$rolerawdata, TRUE))
				<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2">
					<span class="menu-link menu-center">
						<span class="menu-icon me-0">
							<i class="bi bi-file-lock-fill fs-1"></i>
						</span>
					</span>
					<div class="menu-sub menu-sub-dropdown menu-sub-indention px-2 py-4 w-250px" style="">
					@if(in_array("user_management_all",$rolerawdata, TRUE) || in_array("user_management_read",$rolerawdata, TRUE) || in_array("user_management_delete",$rolerawdata, TRUE) ||
					in_array("user_management_write",$rolerawdata, TRUE) || in_array("user_management_create",$rolerawdata, TRUE)||	in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">User Managment</span>
							</div>
						</div>
						
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.user')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Admin & Team Users</span>
								</a>
							</div>
						@endif
						@if(in_array("role_management_all",$rolerawdata, TRUE) || in_array("role_management_read",$rolerawdata, TRUE) || in_array("role_management_delete",$rolerawdata, TRUE) ||
						in_array("role_management_write",$rolerawdata, TRUE) ||in_array("role_management_create",$rolerawdata, TRUE) ||
						in_array("kt_roles_select_all",$rolerawdata, TRUE))
						<div class="menu-item">
							<div class="menu-content">
								<span class="menu-section fs-5 fw-bolder ps-1 py-1">Role Managment</span>
							</div>
						</div>
							<div class="menu-item">
								<a class="menu-link" href="{{route('list.role')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Access Control & Roles</span>
								</a>
							</div>
						@endif
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
