@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card pt-4">
                <div class="card-header pt-6">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Add</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / LeaveManagement
                        </span>
                    </h3>
                </div>
                <div class="card-body border-0 pt-0">
                    <form action="{{ route('store.leaveManagement') }}" method="post" class="form" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                        <input type="hidden" class="form-control mb-3" value="{{ session('username') ?? 'Not Available' }}" readonly>

                        <div class="row">
                           <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Employee Name</label>
                                <select name="user_id" id="user_id" required 
                                    class="form-select form-select-lg form-select-solid mb-3 mb-lg-0">
                                    <option value="">Select Employee</option>
                                    @foreach ($user as $users)
                                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Start Date</label>
                                <input type="date" name="startdate" id="startdate" required 
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>

                           
                        </div>

                        <!-- <div class="row">
                            <div class="col-lg-12 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Credit Leave (Days)</label>
                                <input type="number" name="credit_leave" id="credit_leave" step="0.5" min="0.5" max="5" 
                                    placeholder="Enter Leave in Days (e.g., 1, 1.5, 2)" required 
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div> -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="col-form-label required fw-bold fs-6">Credit Leave (Days)</label>
                                <select name="credit_leave" id="credit_leave" required class="form-control form-control-lg">
                                    <option value="" disabled selected>Select an Option</option>
                                    <option value="8">1 day</option>
                                    <option value="16">2 days</option>
                                    <option value="24">3 days</option>
                                    <option value="32">4 days</option>
                                    <option value="56">1 Week</option>
                                    <option value="112">2 Weeks</option>
                                    <option value="168">3 Weeks</option>
                                    <option value="224">4 Weeks</option>
                                    <option value="248">1 Month</option>
                                </select>
                            </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('add.leaveManagement') }}" class="btn btn-light-success me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
