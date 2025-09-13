@extends('admin.admin_master')
@section('admin')
<style>
    .custom-input-size {
        width: 100%; /* or a fixed width, e.g., 400px */
        height: 70px; /* Adjust as needed */
    }
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card" style="background-color: #E1EBEE">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Add</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / GoalTask
                        </span>
                    </h3>
                </div>

                <div class="card-body border-0 pt-0">
                    <form action="{{ route('store.gtask') }}" method="post" class="form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Task Name</label>
                                <input type="text" name="g_taskname" id="g_taskname" placeholder="Goal Task Name" required class="form-control form-control-lg form-control mb-3 mb-lg-0" />
                            </div>

                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Category</label>
                                <select name="g_category[]" id="g_category" required class="form-control form-control-lg form-control mb-3 mb-lg-0" data-placeholder="Select a Category">
                                    <option value="" disabled selected>Select a Category</option>
                                    @foreach($gc as $gcs)
                                        <option value="{{ $gcs->id }}">{{ $gcs->gc_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="g_assignedby" value="{{ $loginUserId }}">
                        </div>

                        <div class="row">
                            <div class="col-lg-12 fv-row">
                            <label class="col-lg-12 col-form-label fw-bold fs-6">Goal Description</label> 
                                <textarea name="g_description" id="g_description"
                                    placeholder="Goal Description"
                                    class="form-control form-control-lg mb-3 mb-lg-0"
                                    style="height: 100px; max-height: 300px; width: 100%; resize: vertical;"></textarea>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Deadline</label>
                                <input type="date" name="g_deadline" id="g_deadline" placeholder="Goal Deadline" required class="form-control form-control-lg form-control mb-3 mb-lg-0" />
                            </div>

                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Select time to complete task</label>
                                <select type="text" name="timer" id="timer" required class="form-control form-control-lg form-control mb-3 mb-lg-0" data-placeholder="Select an option">
                                    <option value="" disabled selected>Select an Option</option>
                                    <option value="5">5 minutes</option>
                                    <option value="10">10 minutes</option>
                                    <option value="20">20 minutes</option>
                                    <option value="30">30 minutes</option>
                                    <option value="60">1 hour</option>
                                    <option value="120">2 hours</option>
                                    <option value="180">3 hours</option>
                                    <option value="240">4 hours</option>
                                    <option value="300">5 hours</option>
                                    <option value="360">6 hours</option>
                                    <option value="420">7 hours</option>
                                    <option value="480">8 hours</option>
                                    <option value="720">12 hours</option>
                                    <option value="960">16 hours</option>
                                    <option value="1200">20 hours</option>
                                    <option value="1440">24 hours</option>
                                    <option value="1680">28 hours</option>
                                    <option value="1920">32 hours</option>
                                    <option value="2160">36 hours</option>
                                    <option value="2400">40 hours</option>
                                </select>
                            </div>

                            <div class="col-lg-4 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Priority</label>
                                <select name="g_priority" id="g_priority" required class="form-control form-control-lg form-control mb-3 mb-lg-0" data-placeholder="Select an option">
                                    <option value="" disabled selected>Select an Option</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Assigned</label>
                                <select name="g_assigned[]" id="g_assigned" class="form-select mb-3 form-control select2" data-placeholder="Select an option" multiple="multiple">
                                    @php
                                        $selectedValues = old('g_assigned', isset($selectedData) ? explode(",", $selectedData->g_assigned ?? '') : []);
                                    @endphp

                                    @foreach($repn as $repns)
                                        <option value="{{ $repns->id }}" 
                                            @if(in_array($repns->id, $selectedValues)) selected @endif>
                                            {{ $repns->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 fv-row">
                                <label class="col-lg-12 col-form-label required fw-bold fs-6">Goal Status</label>
                                <select name="g_status" id="g_status" required class="form-control form-control-lg form-control mb-3 mb-lg-0" data-placeholder="Select a status">
                                    <option value="" disabled selected>Select a Status</option>
                                    <option value="New">New</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{route('list.gtask')}}" class="btn btn-light-success me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    $('#g_assigned').select2({
        placeholder: "Select an option",
        allowClear: true
    });
});
</script>
@endsection
