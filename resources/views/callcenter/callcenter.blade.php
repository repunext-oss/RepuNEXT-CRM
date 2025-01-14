@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-xxl">
			<div class="card">
				<div class="card-header border-0 pt-6">   
					<h3 class="card-title align-items-start flex-column">           
						<a href="/list/">            
							<span class="card-label fw-bold fs-3 mb-1"> Call Center
							</span>
						</a>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / callcenter
							 </span>
					</h3>  
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
							<a href="{{ route('callcenter.add') }}"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" >
								<span class="svg-icon svg-icon-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
										<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
									</svg>
								</span>Add</button> </a>
						</div>
					</div>        
				</div>  
				<div class="card-body border-top pt-0"></br>
				<table id="PoTable" class="table border rounded gy-5 gs-7 dataTable no-footer" aria-describedby="kt_datatable_example_1_info">
						<thead>
							<tr class="fw-bold text-muted bg-light">
								<th>S.No</th>
								<th>Name / Mobile / Email</th>    
								<th>Enquiry Date</th> 
								<th>Company Name</th>
								<th>Follow Up</th>
								<th>Follow up Date</th>
								<th>Source</th>
								<th>Service</th>
								<th>Status</th>
								<th>Action</th>
								<!-- <th style="text-align:right;">Actions</th> -->
							</tr>
						</thead>
						<tbody> 
							@foreach($callcenter as $d)
							<tr>
								<td>{{$d->id}}</td>
								<td>{{$d->Name}} <br>{{$d->Mobile}} <br>{{$d->Email}} </td>
								<td>{{$d->Enquiry_Date}}</td>
								<td>{{$d->Company_Name}}</td>
								<td>{{$d->FollowUp}}</td>
								<td>{{$d->followupdate}}</td>
								<td>{{$d->Source}}</td>
								<td>{{$d->Service}}</td>
								<td>{{$d->Status}}</td>
								<td><a href="{{ route('callcenter.edit',['d' => $d]) }}" class="btn btn-danger">Edit</a>
              
                					
								</td>    
							</tr>
							@endforeach
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready( function () {   
            $('#emailTable').DataTable({ 
				dom: 'frtip',   
			} ); 
		});
	function onlyNumberKey(evt) {
		  var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		  if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
			  return false;
		  return true;
	  }
	  function onlyAlphaKey(evt) {
		  var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		  if (ASCIICode > 31 && (ASCIICode < 65 || ASCIICode > 90) && (ASCIICode < 97 || ASCIICode > 122))
			  return false;
		  return true;
	  }
	$(document).ready( function () {
		$('#PoTable').DataTable(); 
	} );
	
</script>
@endsection


