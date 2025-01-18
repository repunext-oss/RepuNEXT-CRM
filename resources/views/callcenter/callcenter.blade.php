@extends('admin.admin_master')
@section('admin')
<?php $rolerawdata = session('userRoles', []); ?>
<style>
    .st-drop {
        border: 1px solid #b9b9b9 !important;
    }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Call Center List</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Call Center / List
                        </span>
                    </h3>
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('callcenter.add') }}">
                            <button type="button" class="btn btn-primary">
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-plus"></i>
                                </span>
                                Add
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" class="form-control form-control-solid w-250px ps-14" placeholder="Search Report">
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <button type="button" class="btn btn-light-primary st-drop" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-file-export"></i>
                            </span>
                            Export Report
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="copy">Copy to clipboard</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="excel">Export as Excel</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="csv">Export as CSV</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="pdf">Export as PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
                
				<div class="card-body pt-0"> 
					<table class="table border align-middle rounded  dataTable table-row-dashed fs-6 gy-5" id="kt_ecommerce_report_views_table">
						<thead> 
						<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted bg-light">
              
                                <th >S.No</th>
                                <th class="min-w-125px">Name / Mobile / Email</th>
                                <th class="min-w-125px">Enquiry Date / Follow-Up Date</th>
                                <th class="min-w-115px">Company Name</th>
                                <th class="min-w-115px">Follow-Up</th>
                                <th class="min-w-115px">Source</th>
                                <th class="min-w-115px">Service</th>
                                <th class="min-w-115px">Status</th>
                                <th class="min-w-120px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($callcenter as $d)
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td>{{ $d->Name }}<br>{{ $d->Mobile }}<br>{{ $d->Email }}</td>
                                <td>{{ $d->Enquiry_Date }} / {{ $d->followupdate }}</td>
                                <td>{{ $d->Company_Name }}</td>
                                <td>{{ $d->FollowUp }}</td>
                                <td>{{ $d->Source }}</td>
                                <td>{{ $d->Service }}</td>
                                <td>{{ $d->Status }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('callcenter.view', $d->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('callcenter.edit', $d->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button onclick="deleteConfirmation({{ $d->id }})" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
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


@endsection
