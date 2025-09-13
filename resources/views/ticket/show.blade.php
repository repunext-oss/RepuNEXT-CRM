@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View </span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Project / Service</span>
					</h3> 
				</div>
				<div class="card-body border-0 pt-0"> 
				<form action="{{ route('update.ticket') }}" method="post" class="form" enctype="multipart/form-data"> 
					@csrf

					<input type="hidden" name="id" value="{{ $ticket->id }}">

					<div class="row">
						<div class="col-lg-12 fv-row">
							<label for="ticket_subject" class="col-form-label fw-bold fs-6">Subject</label>
							<input type="text" name="ticket_subject" id="ticket_subject" 
								value="{{ old('ticket_subject', $ticket->ticket_subject) }}" 
								placeholder="Enter a Subject" 
								class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" disabled/>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 fv-row">
							<label for="product" class="col-form-label fw-bold fs-6">Product</label>
							<select name="product" id="product" 
									class="form-select form-select-lg form-select-solid mb-3 mb-lg-0" 
									data-placeholder="Select a Product" disabled>
								<option value="" disabled>Select a Product</option>
								@foreach($gc as $gcs)
									<option value="{{ $gcs->id }}" {{ $gcs->id == $ticket->product ? 'selected' : '' }}>
										{{ $gcs->gc_name }}
									</option>
								@endforeach
							</select>
						</div>

						<div class="col-lg-4 fv-row">
							<label for="ticket_prority" class="col-form-label fw-bold fs-6">Priority</label>
							<input type="text" name="ticket_prority" id="ticket_prority" 
								value="{{ old('ticket_prority', $ticket->ticket_prority) }}" 
								placeholder="Ticket priority" 
								class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" disabled />
						</div> 

						<div class="col-lg-4 fv-row">
							<label for="ticket_status" class="col-form-label fw-bold fs-6">Status</label>
							<div class="position-relative">
								<select name="ticket_status" id="ticket_status"
										class="form-select form-select-lg form-select-solid mb-3 mb-lg-0 bg-gray-100 border border-gray-300 text-gray-800 py-3 px-4 pe-10 rounded-xl focus:outline-none focus:bg-white focus:border-blue-400" disabled>
									<option value="0" {{ $ticket->ticket_status == 0 ? 'selected' : '' }}>Open</option>
									<option value="1" {{ $ticket->ticket_status == 1 ? 'selected' : '' }}>Pending</option>
									<option value="2" {{ $ticket->ticket_status == 2 ? 'selected' : '' }}>Resolved</option>
									<option value="3" {{ $ticket->ticket_status == 3 ? 'selected' : '' }}>Closed</option>
								</select>
								<div class="position-absolute top-50 end-0 translate-middle-y pe-3 pointer-events-none text-gray-600">
									<svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
										<path d="M7 7l3-3 3 3m0 6l-3 3-3-3" />
									</svg>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12 fv-row">
							<label for="ticket_description" class="col-form-label fw-bold fs-6">Description</label>
							<textarea name="ticket_description" id="ticket_description" 
									placeholder="Enter a ticket description" 
									class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" disabled 
									rows="4">{{ old('ticket_description', $ticket->ticket_description) }}</textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12 fv-row mb-4">
							<label for="attachments" class="col-form-label fw-bold fs-6">Attachments</label>
							<div class="input-group">
								<input type="file" class="form-control form-control-lg border-primary-subtle shadow-sm" 
									id="attachments" name="attachments" disabled>
							</div>
							<div class="form-text">Accepted formats: PDF, JPG, PNG, DOCX. Max size: 5MB.</div>

							@if($ticket->attachments)
								<div class="mt-2">
									<strong>Current File:</strong> 
									<a href="{{ asset('upload/tickets/' . $ticket->attachments) }}" target="_blank">
										{{ $ticket->attachments }}
									</a>
								</div>
							@endif
						</div>
					</div>

					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<a href="{{ route('list.ticket') }}" class="btn btn-light-success me-2">Back</a>
						<button type="submit" class="btn btn-primary">Save Changes</button>
					</div>
				</form>
				</div>
		</div>
	</div>
</div>
@endsection  
