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
                        <span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / callcenter / List</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-kt-initialized="1">
                        <!-- <a href="{{route('callcenter.add')}}" class="btn btn-sm btn-primary"  >Add</a> -->
                    </div>
                </div>
                <div class="card-body pt-5 pb-0">
                    <form method="post" action="{{ route('callcenter.update',['d'=>$d])}}" name="myform">
                        @csrf
                        @method('put')
                        <table id="PoTable" class="table border rounded gy-5 gs-7 dataTable no-footer" aria-describedby="kt_datatable_example_1_info">
                            <tbody>

                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Name</label>
                                        <input type="hidden" name="id" placeholder="enter name">

                                        <input type="text" class="form-control" name="Name" required placeholder="Enter Name" value="{{ $d->Name }}" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" >
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Mobile</label>
                                        <input type="number" class="form-control" name="Mobile" required placeholder="Enter Mobile.No" value="{{ $d->Mobile }}"><span id="numloc"></span>
                                    </div>
                                </div></br>


                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Enquiry Date</label>

                                        <input type="date" class="form-control" name="Enquiry_Date" required placeholder="Enter Enquiry Date" value="{{ $d->Enquiry_Date }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Email address</label>
                                        <input type="email" class="form-control" name="Email" required placeholder="Enter Email" value="{{ $d->Email }}">
                                    </div>
                                </div></br>




                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Company Name</label>

                                        <input type="text" class="form-control" name="Company_Name" required placeholder="Enter Company Name" value="{{ $d->Company_Name }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Follow up</label>
                                        <input type="text" class="form-control" name="FollowUp" required value="{{ $d->FollowUp }}">
                                    </div>
                                </div></br>


                                <div class="row">
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">FollowUp Date</label>
                                        <input type="date" class="form-control" name="followupdate" required placeholder="Enter Date" value="{{ $d->followupdate }}">

                                    </div>
                                    <div class="col-6">
                                        <label class="required fw-bold fs-6 mb-2">Service</label>
                                        <input type="text" class="form-control" name="Service" required placeholder="Enter Service" value="{{ $d->Service }}">
                                    </div>
                                </div></br>



                                <div class="row">
                                    <div class="col-6">

                                        <label class="required fw-bold fs-6 mb-2">Source</label>
                                        <input type="text" class="form-control" name="Source" required placeholder="Enter Source" value="{{ $d->Source}}">
                                    </div>
                                    <div class="col-6">
                                        <div class="col-1">
                                            <label class="required fw-bold fs-6 mb-2">Status</label>
                                        </div>
                                        <div class="col-md-4">

                                            <select class="custom-select my-1 mr-sm-2" name="Status" required>

                                                <option value="" selected disabled>Choose...</option>
                                                <option value="Hot" {{ $d->Status === 'Hot' ? 'selected' : '' }}>Hot</option>
                                                <option value="Warm" {{ $d->Status === 'Warm' ? 'selected' : '' }}>Warm</option>
                                                <option value="Cold" {{ $d->Status === 'Cold' ? 'selected' : '' }}>Cold</option>
                                                <option value="Dead" {{ $d->Status === 'Dead' ? 'selected' : '' }}>Dead</option>
                                            </select>
                                        </div></br>
                                    </div>
                                </div></br>




                                <div class="row">
                                    <div class="col-1">
                                        <input type="submit" value="Submit" name="submit" class="btn btn-primary" />
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('callcenter.callcenter') }}" class="btn btn-secondary">Cancel</a>
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


<script>  
function validate(){  
var num=document.myform.Mobile.value;  
if (isNaN(Mobile)){  
  document.getElementById("numloc").innerHTML="Enter Numeric value only";  
  return false;  
}else{  
  return true;  
  }  
}  
</script>


<!-- <script>
	$(document).ready( function () {
		$('#PoTable').DataTable(); 
	} );
</script> -->
@endsection