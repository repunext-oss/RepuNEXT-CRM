@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">View Task Timesheet</span>
						<span class="text-muted fw-semibold fs-7">
                            <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Task Timesheet
                        </span>
					</h3> 
				</div>
				<div class="form">
					<div class="card-body border-0 pt-0">
						<!-- Hidden ID -->
						<input type="text" name="id" value="{{ $repn->id }}" hidden>
						
						<!-- Goal Name -->
						<div class="row">
							<div class="col-lg-12 fv-row">
								<label class="col-lg-12 col-form-label time fw-bold fs-6">Goal Name</label>
								<select name="goalid_ref[]" id="goalid_ref" class="form-select mb-3 form-control" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" disabled>
									<?php $mems = explode(',', $repn->goalid_ref); ?> 	
									@foreach($serv as $servs)
										<option value="{{$servs->id}}" @if(in_array($servs->id, $mems)) selected @endif>
                                            {{$servs->g_taskname}}
                                        </option>
									@endforeach
								</select>
								<input type="hidden" name="goalid_ref" value="{{ $repn->goalid_ref }}">
							</div>
						</div>

						<!-- Start Time and End Time -->
						<div class="row">
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label time fw-bold fs-6">Start Time</label>
								<input type="time" name="starttime" id="starttime" value="{{ $repn->starttime }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" readonly>
							</div>
							<div class="col-lg-6 fv-row">
								<label class="col-lg-12 col-form-label time fw-bold fs-6">End Time</label>
								<input type="time" name="endtime" id="endtime" value="{{ $repn->endtime }}" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" readonly>
							</div>
						</div>
						<br>
					</div>

					<!-- Footer -->
					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<a href="{{route('list.time')}}" class="btn btn-light-success me-2">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
