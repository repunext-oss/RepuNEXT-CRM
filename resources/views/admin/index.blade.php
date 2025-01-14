@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Toolbar-->
	<div class="toolbar" id="kt_toolbar">
		<!--begin::Container-->
		<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
			
				<div id="kt_content_container" class="container-xxl">
					<div class="card">
						<div class="card-body">
							<div class="col-md-12">
								@if(Auth::user()->role=="Admin")
									<h1>Admin</h1>
									<p>Content creation is the ultimate inbound marketing practice. When you create content, you’re providing free and useful information to your audience, attracting potential customers to your website, and retaining existing customers through quality engagement.</p>

									<p>You’re also generating some major value for your company, as these content marketing stats show:</p>

										<p>Almost 40% of marketers say content marketing is an essential part of their marketing strategy. 81% say their company sees content as a business strategy.
			B2B marketers have data that says content marketing is a successful tool for nurturing leads (60%), generating revenue (51%), and building an audience of subscribers (47%).
			And 10% of marketers who blog say it generates the biggest return on investment.</p>
			<p>Content equals business growth. So, let’s get started with the types of content you can create and then review your content strategy.</p>
								@endif
								@if(Auth::user()->role=="Superadmin")
								<h1>Super Admin</h1>
								<p>A Super Administrator is a user who has complete access to all objects, folders, role templates, and groups in the system. A deployment can have one or more Super Administrators. A Super Administrator can create users, groups, and other super administrators.</p>

								@endif
</div>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
@endsection

