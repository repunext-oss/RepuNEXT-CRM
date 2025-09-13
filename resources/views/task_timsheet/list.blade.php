@extends('admin.admin_master')
@section('admin')

<?php $rolerawdata = session('userRoles', []); ?>

<style>.st-drop { border: 1px solid #b9b9b9 !important; } 
svg {
    vertical-align: middle;
    margin-right: 5px;
}
.card-body1 {
            width: 1100px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            border-radius: 8px; */
            box-shadow: 0px 4px 25px rgba(0, 0, 0, 0.1);
            padding: 10px;
    
        }

#taskTimeChart {
    width:400px !important; 
    height: 400px !important;
    margin-left: 50px;
}
.hidden {
    display: none;
}

</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card " style="background-color: #E1EBEE"> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">
                        TimeSheet <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <circle cx="12" cy="16" r="4"></circle>
                            <path d="M12 14v2l1.5 1.5"></path>
                        </svg>
                    </span>

    				<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / TimeSheet</span>
					</h3>
					
					<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
						@if(in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_create",$rolerawdata, TRUE)|| in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<a href="{{ route('add.ttimecat') }}"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" >
								<span class="svg-icon svg-icon-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
										<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
									</svg>
								</span>Add</button>
							</a>
						@endif
					</div>
				</div>
                <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0 d-flex justify-content-between">
    
                <div class="calendar-container d-flex align-items-center">
                    <button id="calendar-button" class="btn btn-dark border d-flex align-items-center px-3" style="background-color: rgb(3, 31, 58);">
                        <i class="fa fa-calendar-alt me-2"></i> 
                        <span id="selected-date">Select date range</span>
                    </button>
                    <input type="hidden" id="start-date" />
                    <input type="hidden" id="end-date" />

                    <button id="refreshButton" class="btn btn-primary ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 1 0-.908.417A6 6 0 1 0 8 2v1z"/>
                            <path d="M8 1a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 1z"/>
                        </svg>
                    </button>

                </div>
                                  
                <div class="d-flex align-items-center">
                    <input type="text" id="searchBox" class="form-control" placeholder="Search Report" style="max-width: 250px;">
                </div>

            </div>

                <div class="card-body pt-0">

                    <table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" >
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted" style="background-color: #002244;">
                                <th class="w-10px pe-2"></th>
                                <th>#</th>
                                <th class="min-w-115px sorting">Username</th>
                                <th class="min-w-115px sorting">TaskTime Date</th>
                                <th class="min-w-125px sorting">TaskTime Category</th>
                                <th class="min-w-125px sorting" >TaskTime Name</th>
                                <th class="min-w-125px sorting" >Task Duration</th>
                                <th class="min-w-110px sorting">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <?php $j = 0; ?>
                            @foreach($repn as $repns)
                            @if( in_array("kt_roles_select_all", $rolerawdata, TRUE) || in_array("timesheet_all", $rolerawdata, TRUE) || (Auth::user()->id) == ($repns->tc_name))
                                <tr class="task-row" data-task-date="{{ $repns->tt_date }}">
                                    <td></td>
                                    <td>{{ ++$j }}</td>
                                    <td>
                                        @php
                                            $member = explode(",", $repns->tc_name);
                                        @endphp
                                        @foreach($user as $users)
                                            @if(in_array($users->id, $member))
                                                {{ $users->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    
                                    <td>{{ $repns->tt_date }}</td>
                                    <td>
                                        @php
                                            $member = explode(",", $repns->tt_cat);
                                        @endphp
                                        @foreach($serv as $servs)
                                            @if(in_array($servs->id, $member))
                                                {{ $servs->tc_name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="#" class="tt-name" data-desc="{{ $repns->tt_desc }}">
                                            {{ $repns->tt_name }}
                                        </a>
                                        <div class="tt-desc mt-2" style="display: none;">
                                            <strong>Comment:</strong> {{ $repns->tt_desc }}
                                        </div>
                                    </td>
                                    <td><strong>{{ $repns->tt_starttime }} to {{ $repns->tt_endtime }}</strong></td>

                                    <td>
                                        @if(in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_read",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
                                        <a href="{{route('view.ttimecat', $repns->id)}}" class="btn btn-sm align-self-center" style="text-transform: none; background-color: #002244; color:white;">
                                            <i class="fa fa-eye" aria-hidden="true"></i> view
                                        </a>

                                        @endif
                                        @if(in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_write",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
                                            <a href="{{route('edit.ttimecat', $repns->id)}}" class="btn btn-sm btn-info align-self-center" style="text-transform: none;">
                                                <i class="fa fa-edit" aria-hidden="true"></i>edit
                                            </a>
                                        @endif
                                        @if(in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_delete",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
                                            <a href="#" onclick="deleteConfirmation({{ $repns->id }})" data-id="{{ $repns->id }}" class="btn btn-sm crop-delete btn-danger align-self-center" style="text-transform: none;">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{$repn->links() }}
                </div> 
            </div>
            <div class="card mt-5">
				<div class="card-body1">
                <div class="row mb-4">
						<div class="col-12" >
							<h3>TIME SPENT REPORT</h3>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-12" style="margin-right:50px" >
                        <canvas id="taskTimeChart" ></canvas>
						</div>
					</div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <p class="total-time" id="totalTimeSpent">Total Time Spent: 00:00</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let searchBox = document.getElementById("searchBox");
    let startDateInput = document.getElementById("start-date");
    let endDateInput = document.getElementById("end-date");

    if (searchBox) {
        searchBox.addEventListener("keyup", function () {
            let searchValue = searchBox.value.toLowerCase();
            let filteredData = {};
            let selectedStartDate = startDateInput.value;
            let selectedEndDate = endDateInput.value;

            document.querySelectorAll(".task-row").forEach(row => {
                let text = row.textContent.toLowerCase();
                let taskDate = row.getAttribute("data-task-date");

                // Check if the task falls within the selected date range
                let isWithinDateRange = (!selectedStartDate || taskDate >= selectedStartDate) &&
                                        (!selectedEndDate || taskDate <= selectedEndDate);

                let isVisible = text.includes(searchValue) && isWithinDateRange;
                row.style.display = isVisible ? "" : "none";

                if (isVisible) {
                    let category = row.querySelector("td:nth-child(5)").textContent.trim(); // Category column
                    let timeSpent = row.querySelector("td:nth-child(7)").textContent.match(/\d+:\d+/);
                    
                    if (timeSpent) {
                        let [hours, minutes] = timeSpent[0].split(":").map(Number);
                        let totalMinutes = hours * 60 + minutes;
                        filteredData[category] = (filteredData[category] || 0) + totalMinutes;
                    }
                }
            });

            updatePieChart(filteredData);
        });
    }
});


    document.addEventListener("DOMContentLoaded", function () {
        let refreshButton = document.getElementById("refreshButton");

        if (refreshButton) {
            refreshButton.addEventListener("click", function () {
                location.reload(); 
            });
        }
    });


    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".tt-name").forEach(ttName => {
        ttName.addEventListener("click", function (e) {
            e.preventDefault();
            let descDiv = this.nextElementSibling;
            if (descDiv) {
                descDiv.style.display = (descDiv.style.display === "none" || descDiv.style.display === "") ? "block" : "none";
            } 
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const calendarButton = document.getElementById("calendar-button");
    const selectedDateDisplay = document.getElementById("selected-date");
    const startDateInput = document.getElementById("start-date");
    const endDateInput = document.getElementById("end-date");

    let pieChart;

    function calculateTimeSpent(startTime, endTime) {
        let start = new Date(`1970-01-01T${startTime}`);
        let end = new Date(`1970-01-01T${endTime}`);
        let diffInMinutes = Math.abs((end - start) / (1000 * 60));

        let hours = Math.floor(diffInMinutes / 60);
        let minutes = Math.floor(diffInMinutes % 60);

        return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
    }
    
    window.updatePieChart = function (taskData) {
        const ctx = document.getElementById("taskTimeChart").getContext("2d");

        if (window.pieChart) {
            window.pieChart.destroy();
        }

        let labels = Object.keys(taskData);
        let dataValues = Object.values(taskData);
        let totalMinutes = dataValues.reduce((acc, val) => acc + val, 0) || 0; // Prevent NaN

        // Update Total Time Display
        document.getElementById("totalTimeSpent").textContent = 
            `Total Time Spent: ${formatTotalTime(totalMinutes)}`;

        window.pieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: labels,
                datasets: [{
                    label: "Time Spent (HH:MM)",
                    data: dataValues,
                    backgroundColor: [
                        "#00416A", "#8DA399", "#7CB9E8", "#00308F", "#72A0C1", "#F0F8FF", "#6CB4EE", "#002D62", "#007FFF", "#5072A7",
                        "#5F9EA0", "#00008B", "#00CED1", "#00BFFF", "#008E97", "#007791", "#6F00FF", "#2c3968", "#6082B6", "#4C516D"
                    ],
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true,
                cutout: "70%",
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                let index = tooltipItem.dataIndex;
                                let category = labels[index];
                                let minutes = dataValues[index];
                                return `${category}: ${formatTotalTime(minutes)}`;
                            }
                        }
                    },
                    legend: {
                        position: "right"
                    }
                }
            }
        });
    };

    window.formatTotalTime = function (totalMinutes) {
        let hours = Math.floor(totalMinutes / 60);
        let minutes = totalMinutes % 60;
        return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
    };

    function fetchFilteredData(startDate, endDate) {
        console.log("Fetching data for range:", startDate, "to", endDate);

        $.ajax({
            url: "/ttimecat/list",
            type: "GET",
            data: { startDate: startDate, endDate: endDate },
            dataType: "json",
            success: function (response) {
                let tableBody = document.querySelector(".dataTable tbody");
                tableBody.innerHTML = "";
                let categoryMap = {};
                let userMap = {};
                let categoryTimeSpent = {};

                if (response.user) {
                    response.user.forEach(user => {
                        userMap[user.id] = user.name;
                    });
                } else {
                    console.warn("User data is missing in the response.");
                }

                if (response.serv) {
                    response.serv.forEach(service => {
                        categoryMap[service.id] = service.tc_name;
                    });
                } else {
                    console.warn("Service data is missing in the response.");
                }

                if (!response.repn || response.repn.length === 0) {
                    tableBody.innerHTML = "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
                    updatePieChart({});
                    return;
                }

                response.repn.forEach((task, index) => {
                    let userName = userMap[task.tc_name] || "Unknown User";
                    let categoryName = categoryMap[task.tt_cat] || "Unknown Category";
                    let startTime = task.tt_starttime;
                    let endTime = task.tt_endtime;
                    let remove="";
                    let edit="";
                    let view="";

                    let rows = `
                        <a href="#" class="tt-name">
                            ${task.tt_name}
                        </a>
                        <div class="tt-desc mt-2 hidden">
                            <strong>Comment:</strong> ${task.tt_desc || "No Comments"}
                        </div>`;

                    @if(in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_read",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
                    view= ` <a href="/ttimecat/view/${task.id}" class="btn btn-sm align-self-center" style="text-transform: none; background-color: #002244; color:white;">
                                    <i class="fa fa-eye" aria-hidden="true"></i> view
                                </a>`;
                    @endif 

                    @if(in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_write",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
                    edit =` <a href="/ttimecat/edit/${task.id}" class="btn btn-sm btn-info align-self-center" style="text-transform: none;">
                                    <i class="fa fa-edit" aria-hidden="true"></i>edit
                                </a>`;
                    @endif
                    @if(in_array("timesheet_all",$rolerawdata, TRUE) || in_array("timesheet_delete",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
                     remove = `
                            <a href="#" onclick="deleteConfirmation('${task.id}')" class="btn btn-sm btn-danger align-self-center" style="text-transform: none;">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        `;
                    @endif

                    let start = new Date(`1970-01-01T${startTime}`);
                    let end = new Date(`1970-01-01T${endTime}`);
                    let timeSpentMinutes = Math.abs((end - start) / (1000 * 60));

                    
                    categoryTimeSpent[categoryName] = (categoryTimeSpent[categoryName] || 0) + timeSpentMinutes;

                    let row = `
                        <tr class="task-row" data-task-date="${task.tt_date}">
                            <td></td>
                            <td>${index + 1}</td>
                            <td>${userName}</td>
                            <td>${task.tt_date}</td>    
                            <td>${categoryName}</td>
                            <td>${rows}</td>
                            <td><strong>${startTime} to ${endTime} (${calculateTimeSpent(startTime, endTime)})</strong></td>
                            <td>${view}${edit}${remove}</td>
                        </tr>`;
                    tableBody.insertAdjacentHTML("beforeend", row);
                });

                updatePieChart(categoryTimeSpent);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching filtered data:", error);
                alert("Failed to load data. Please try again.");
            }
        });
    }       
    
    let today = new Date().toISOString().split('T')[0];
    fetchFilteredData(today, today);

    if (calendarButton) {
        const datePicker = flatpickr(calendarButton, {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: false,
            altFormat: "D, M j, Y",
            allowInput: false,
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const formattedStart = instance.formatDate(selectedDates[0], "Y-m-d");
                    const formattedEnd = instance.formatDate(selectedDates[1], "Y-m-d");
                    selectedDateDisplay.textContent = `${formattedStart} - ${formattedEnd}`;
                    startDateInput.value = formattedStart;
                    endDateInput.value = formattedEnd;
                    fetchFilteredData(formattedStart, formattedEnd);
                }
            }
        });

        calendarButton.addEventListener("click", function () {
            datePicker.open();
        });
    }
});


    document.addEventListener("DOMContentLoaded", function () {
        document.body.addEventListener("click", function (event) {
            if (event.target.classList.contains("tt-name")) {
                event.preventDefault();
                toggleDescription(event.target);
            }
        });
    });

    function toggleDescription(element) {
        let descriptionDiv = element.nextElementSibling;

        document.querySelectorAll(".tt-desc").forEach(desc => {
            if (desc !== descriptionDiv) {
                desc.classList.add("hidden");
            }
        });

        if (descriptionDiv && descriptionDiv.classList.contains("tt-desc")) {
            descriptionDiv.classList.toggle("hidden");
        }
    }

    window.toggleDescription = toggleDescription;



function deleteConfirmation(id) {
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
        let _url = '/ttimecat/destroy/' + id;

        $.ajax({
            type: 'POST',  
            url: _url,
            data: {_token: token},  
            success: function () {
                swal("Done!", "It was successfully deleted!", "success");
                location.reload();  
            },
            error: function () {
                swal("Error deleting!", "Please try again", "error");
            }
        }); 
    });  
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".tt-name").forEach(ttName => {
        ttName.addEventListener("click", (e) => {
            e.preventDefault();
            const descDiv = ttName.nextElementSibling;
            descDiv.style.display = descDiv.style.display === "none" ? "block" : "none";
        });
    });
});
</script>

@endsection
