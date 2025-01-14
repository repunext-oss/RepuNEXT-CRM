@extends('admin.admin_master')
@section('admin')

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Edit</span>
                        <span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / websitecredentials / List</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-kt-initialized="1">
                        <!-- <a href="{{route('callcenter.add')}}" class="btn btn-sm btn-primary"  >Add</a> -->
                    </div>
                </div>
                <div class="card-body pt-5 pb-0">
                    <form method="post" action="{{ route('website.update',['d'=>$d])}}">
                        @csrf
                        @method('put')
                        <table id="PoTable" class="table border rounded gy-5 gs-7 dataTable no-footer" aria-describedby="kt_datatable_example_1_info">
                            <tbody>

                            <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Website</label>
                                        <input type="hidden" name="id" placeholder="enter name">

                                        <input type="text" class="form-control" name="Website" required placeholder="Enter Website" value="{{ $d->Website }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">URL</label>
                                        <input type="text" class="form-control" name="URL" required placeholder="Enter URL" value="{{ $d->URL }}">
                                    </div>
                                </div></br>


                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">User Name </label>
                                        <input type="text" class="form-control" name="User_Name" required placeholder="Enter User Name" value="{{ $d->User_Name }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Password</label>
                                        <input type="text" class="form-control" name="Password" required placeholder="Enter Password" value="{{ $d->Password }}">
                                    </div>
                                </div></br>




                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Completion Date</label>
                                        <input type="date" class="form-control" name="Completion_Date" required placeholder="Enter Completion_Date" value="{{ $d->Completion_Date }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Next Renewal Date</label>
                                        <input type="date" class="form-control" name="Next_Renewal_Date" required value="{{ $d->Next_Renewal_Date }}">
                                    </div>
                                </div></br>


                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Client Contact 1</label>
                                        <input type="text" class="form-control" name="Client_Contact1" required placeholder="Enter Client Contact Details" value="{{ $d->Client_Contact1 }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Client Contact 2</label>
                                        <input type="text" class="form-control" name="Client_Contact2" required placeholder="Enter Additional Details" value="{{ $d->Client_Contact2 }}">
                                    </div>
                                </div></br>


                                <div class="row">
                                    
                                    <div class="col-6">
                                        <div class="col-1">
                                            <label class="required fw-bold fs-6 mb-2">Month</label>
                                        </div>
                                        <div class="col-md-4">

                                            <select class="custom-select my-1 mr-sm-2" name="Month" required>
                                                <option value="" selected disabled>Choose...</option>
                                                <option value="January" {{ $d->Month ==='January' ? 'selected' :'' }}>January</option>
                                                <option value="February" {{ $d->Month ==='February' ? 'selected' :'' }}>February</option>
                                                <option value="March" {{ $d->Month ==='March' ? 'selected' :'' }}>March</option>
                                                <option value="April" {{ $d->Month ==='April' ? 'selected' :'' }}>April</option>
                                                <option value="May" {{ $d->Month ==='May' ? 'selected' :'' }}>May</option>
                                                <option value="June" {{ $d->Month ==='June' ? 'selected' :'' }}>June</option>
                                                <option value="July" {{ $d->Month ==='July' ? 'selected' :'' }}>July</option>
                                                <option value="August" {{ $d->Month ==='August' ? 'selected' :'' }}>August</option>
                                                <option value="September" {{ $d->Month ==='September' ? 'selected' :'' }}>September</option>
                                                <option value="October" {{ $d->Month ==='October' ? 'selected' :'' }}>October</option>
                                                <option value="November" {{ $d->Month ==='November' ? 'selected' :'' }}>November</option>
                                                <option value="December" {{ $d->Month ==='December' ? 'selected' :'' }}>December</option>
                                            </select>
                                        </div></br>
                                    </div>
                                </div></br>




                                <div class="row">
                                    <div class="col-1">
                                        <input type="submit" value="Submit" name="submit" class="btn btn-primary" />
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('website.main') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                                </br>
                            </tbody>
                        </table>
                        <!-- <div class="row">
                            <input type="submit" value="Submit" name="submit" class="btn btn-primary"/>
                            </div> -->
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>


<!-- <script>
	$(document).ready( function () {
		$('#PoTable').DataTable(); 
	} );
</script> -->
@endsection