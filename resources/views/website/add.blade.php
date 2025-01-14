@extends('admin.admin_master')
@section('admin')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Website Credentials List</span>
                        <span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / websitecredentials / List</span>
                    </h3>

                </div>
                <div class="card-body pt-5 pb-0">
                    <form method="post" action="{{ route('website.store')}}">
                        @csrf
                        <!-- @method('post') -->
                        <table id="PoTable" class="table border rounded gy-5 gs-7 dataTable no-footer" aria-describedby="kt_datatable_example_1_info">
                            <tbody>
                                <!-- <div class="row">
                                            <div class="col-1">
                                                <label>Name</label>
                                                </div>
                                                <div class="col-md-4">
                                                <input type="hidden" name="id" placeholder="enter name" >
                                                <input type="text" class="form-control" name="Name"  placeholder="Enter Name">
                                                </div>
                                    </div></br> -->


                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Website</label>
                                        <input type="hidden" name="id" placeholder="enter name">

                                        <input type="text" class="form-control" name="Website" required placeholder="Enter Website">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">URL</label>
                                        <input type="text" class="form-control" name="URL" required placeholder="Enter URL">
                                    </div>
                                </div></br>


                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">User Name </label>
                                        <input type="text" class="form-control" name="User_Name" required placeholder="Enter User Name">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Password</label>
                                        <input type="text" class="form-control" name="Password" required placeholder="Enter Password">
                                    </div>
                                </div></br>




                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Completion Date</label>
                                        <input type="date" class="form-control" name="Completion_Date" required placeholder="Enter Completion_Date">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Next Renewal Date</label>
                                        <input type="date" class="form-control" name="Next_Renewal_Date" required>
                                    </div>
                                </div></br>





                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Client Contact 1</label>
                                        <input type="text" class="form-control" name="Client_Contact1" required placeholder="Enter Client Contact Details">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Client Contact 2</label>
                                        <input type="text" class="form-control" name="Client_Contact2" placeholder="Enter Additional Details">
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
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </select>
                                        </div></br>
                                    </div>
                                </div></br>



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