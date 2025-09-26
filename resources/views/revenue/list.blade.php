@extends('admin.admin_master')
@section('admin')
<?php $rolerawdata = session('userRoles', []); ?>
<style>
    .st-drop { border:1px solid #b9b9b9 !important; }
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Revenue & Expense Ledger</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </span>
                    </h3>

                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('revenue.create') }}">
                            <button type="button" class="btn btn-primary">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                              transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                              fill="currentColor" />
                                    </svg>
                                </span>
                                Add
                            </button>
                        </a>
                    </div>
                </div>

                <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
                    <div class="card-title">
                       
                        <div id="kt_ecommerce_report_views_export" class="d-none"></div>
                    </div>

                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                        {{-- Date Range Filter (GET) --}}
                        <form id="filterForm" method="GET" class="d-flex align-items-center gap-2">
                            <input id="created_range"
                                   class="form-control form-control-solid w-250px st-drop"
                                   placeholder="Filter by Created Date" autocomplete="off" />

                            <input type="hidden" name="start_date" id="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date"   id="end_date"   value="{{ request('end_date') }}">

                            <button type="submit" class="btn btn-primary">Apply</button>

                            @if(request()->filled('start_date') || request()->filled('end_date'))
                                <a href="{{ url()->current() }}" class="btn btn-light">Reset</a>
                            @endif>
                            <div class="btn-group ms-2">
                                <button type="button" class="btn btn-light st-drop" data-quick-range="today">Today</button>
                                <button type="button" class="btn btn-light st-drop" data-quick-range="last7">Last 7 days</button>
                                <button type="button" class="btn btn-light st-drop" data-quick-range="thisMonth">This month</button>
                                <button type="button" class="btn btn-light st-drop" data-quick-range="all">All time</button>
                            </div>
                        </form>

                        {{-- Export Menu (kept as-is; wire to export routes if you have them) --}}
                        <button type="button" class="btn btn-light-primary st-drop" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                                          transform="rotate(90 12.75 4.25)" fill="currentColor" />
                                    <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                          fill="currentColor" />
                                    <path opacity="0.3"
                                          d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                          fill="currentColor" />
                                </svg>
                            </span>
                            Export Report
                        </button>
                        @php
                            $qs = http_build_query(request()->only('start_date','end_date'));
                        @endphp
                        <div id="kt_ecommerce_report_views_export" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4 " data-kt-menu="true">
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

                {{-- Active range banner --}}
                @if(request('start_date') && request('end_date'))
                    <div class="px-6">
                        <div class="alert alert-info p-2">
                            Showing: {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }}
                            to {{ \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') }}
                        </div>
                    </div>
                @endif

                <div class="card-body pt-0">
                @php
                        $totalRevenue = $totalRevenue ?? 0;
                        $totalExpense = $totalExpense ?? 0;
                        $net          = $totalRevenue - $totalExpense;
                        $isProfit     = $net >= 0;
                    @endphp

                    <div class="row g-6 mb-8">
                        <!-- Revenue -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="fs-6 text-muted mb-1">Total Revenue</div>
                                        <div class="fs-2hx fw-bolder text-success">
                                            ${{ number_format($totalRevenue, 2) }}
                                        </div>
                                        @if(request('start_date') && request('end_date'))
                                            <div class="badge badge-light-success mt-2">
                                                {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }}
                                                – {{ \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="symbol symbol-50px">
                                        <span class="symbol-label bg-light-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="text-success" viewBox="0 0 24 24">
                                                <path d="M3 17h2.586l3.95-3.95 3 3L20 9.586V12h2V6h-6v2h2.586l-5.514 5.514-3-3L3 14.586V17z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expenses -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="fs-6 text-muted mb-1">Total Expenses</div>
                                        <div class="fs-2hx fw-bolder text-danger">
                                            ${{ number_format($totalExpense, 2) }}
                                        </div>
                                        @if(request('start_date') && request('end_date'))
                                            <div class="badge badge-light-danger mt-2">
                                                {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }}
                                                – {{ \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="symbol symbol-50px">
                                        <span class="symbol-label bg-light-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="text-danger" viewBox="0 0 24 24">
                                                <path d="M21 7h-2.586l-3.95 3.95-3-3L4 14.414V12H2v6h6v-2H5.414l5.514-5.514 3 3L21 9.414V7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Net Income -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="fs-6 text-muted mb-1">Net {{ $isProfit ? 'Income' : 'Loss' }}</div>
                                        <div class="fs-2hx fw-bolder {{ $isProfit ? 'text-primary' : 'text-danger' }}">
                                            ${{ number_format($net, 2) }}
                                        </div>
                                        <span class="badge {{ $isProfit ? 'badge-light-primary' : 'badge-light-danger' }} mt-2">
                                            <span class="svg-icon svg-icon-5 me-1">
                                                @if($isProfit)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5l6 6H6l6-6z"/></svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 19l-6-6h12l-6 6z"/></svg>
                                                @endif
                                            </span>
                                            {{ $isProfit ? 'Profit' : 'Loss' }}
                                        </span>
                                    </div>
                                    <div class="symbol symbol-50px">
                                        <span class="symbol-label {{ $isProfit ? 'bg-light-primary' : 'bg-light-danger' }}">
                                            @if($isProfit)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="text-primary" viewBox="0 0 24 24">
                                                    <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.59 5.58L20 12l-8-8-8 8z"/>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="text-danger" viewBox="0 0 24 24">
                                                    <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.59-5.58L4 12l8 8 8-8z"/>
                                                </svg>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <h1 class="mt-6 mb-4">Revenue</h1>
                    <table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" id="revenue_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted bg-light">
                                <th class="w-10px pe-2"></th>
                                <th>#</th>
                                <th class="min-w-125px sorting">Category</th>
                                <th class="min-w-125px sorting">Subcategory</th>
                                <th class="min-w-125px sorting">Amount</th>
                                <th class="min-w-125px sorting">CreatedDate</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @php $j = 0; @endphp
                            @forelse($revenues as $revenue)
                                <tr>
                                    <td></td>
                                    <td>{{ $j += 1 }}</td>
                                    <td>{{ $revenue->category }}</td>
                                    <td>{{ $revenue->subcategory }}</td>
                                    <td>${{ number_format($revenue->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($revenue->created_at)->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No revenue found for the selected range.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-body pt-0">
                    <h1 class="mt-6 mb-4">Expense</h1>
                    <table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" id="expense_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted bg-light">
                                <th class="w-10px pe-2"></th>
                                <th>#</th>
                                <th class="min-w-125px sorting">Category</th>
                                <th class="min-w-125px sorting">Subcategory</th>
                                <th class="min-w-125px sorting">Amount</th>
                                <th class="min-w-125px sorting">CreatedDate</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @php $j = 0; @endphp
                            @forelse($expenses as $expense)
                                <tr>
                                    <td></td>
                                    <td>{{ $j += 1 }}</td>
                                    <td>{{ $expense->category }}</td>
                                    <td>{{ $expense->subcategory }}</td>
                                    <td>${{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No expenses found for the selected range.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Keep your existing JS if needed (deleteConfirmation/Check). Removed here for clarity. --}}

{{-- Flatpickr: include once (skip if globally loaded) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
(function() {
    const form = document.getElementById('filterForm');
    const startInput = document.getElementById('start_date');
    const endInput   = document.getElementById('end_date');

    const fp = flatpickr("#created_range", {
        mode: "range",
        dateFormat: "Y-m-d",   // values sent to backend (ISO)
        altInput: true,
        altFormat: "d-m-Y",    // what users see
        defaultDate: [
            "{{ request('start_date') }}",
            "{{ request('end_date') }}"
        ].filter(Boolean),
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const [start, end] = selectedDates;
                startInput.value = instance.formatDate(start, "Y-m-d");
                endInput.value   = instance.formatDate(end,   "Y-m-d");
            }
        }
    });

    function setRangeAndSubmit(start, end) {
        fp.setDate([start, end], true); // true triggers onChange to fill hidden inputs
        form.submit();
    }

    document.querySelectorAll('[data-quick-range]').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.dataset.quickRange;
            const now = new Date();
            let start, end;

            if (type === 'today') {
                start = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                end   = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                return setRangeAndSubmit(start, end);
            }
            if (type === 'last7') {
                end   = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                start = new Date(end);
                start.setDate(start.getDate() - 6); // inclusive 7 days
                return setRangeAndSubmit(start, end);
            }
            if (type === 'thisMonth') {
                start = new Date(now.getFullYear(), now.getMonth(), 1);
                end   = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                return setRangeAndSubmit(start, end);
            }
            if (type === 'all') {
                startInput.value = "";
                endInput.value   = "";
                form.submit();
            }
        });
    });
})();
</script>


<script>  
	function deleteConfirmation(id)
 	{
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false
			}, function (isConfirm) {
			if (!isConfirm) return;    
			let token = "{{ csrf_token() }}";
			let _url = `/project/service/destroy/${id}`;
			$.ajax({
				type: 'POST',  
				url: _url,
				data: {_token: token},  
				success: function () {
					swal("Done!", "It was succesfully deleted!", "success");
					location.reload();  
				},
				error: function (xhr, ajaxOptions, thrownError) {
					swal("Error deleting!", "Please try again", "error");
				}
			}); 
		});  
    }
	function Check(value,id) {  
		if(value.checked){ var statusval=0; }else{ var statusval=1; }  
		let token = "{{ csrf_token() }}";
			let _url = `/project/service/status`; 
			$.ajax({
				type: 'POST',  
				url: _url,
				data: {_token: token, id:id, statusval: statusval},  
				success: function () {
					Swal.fire({icon: 'success',title: 'The status has been switched',showConfirmButton: false,timer: 1500}); 
				},
				error: function (xhr, ajaxOptions, thrownError) {
					swal("Error Status!", "Please try again", "error");
				}
			}); 
    }; 
</script>
@endsection