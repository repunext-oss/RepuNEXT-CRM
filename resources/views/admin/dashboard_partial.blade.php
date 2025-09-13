<div id="dashboard-content">
    <div class="card-body">
        @if($userId && $users->where('id', $userId)->first())
            <h5 class="mt-4">Timesheet Entries for {{ $users->where('id', $userId)->first()->name }}</h5>
        @endif

        @php
            $groupedTime = $time->groupBy('tt_date');
            $totalMinutes = 0;
        @endphp

        <table class="table professional-table">
            <thead>
            <tr style="background-color: #002244;">

                    <th></th>
                    <th style="color: #ffffff; font-weight: bold;">#</th>
                    <th style="color: #ffffff; font-weight: bold;">Date</th>
                    <th style="color: #ffffff; font-weight: bold;">Total Tasks</th>
                    <th style="color: #ffffff; font-weight: bold;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groupedTime as $date => $entries)
                    <tr class="date-row">
                        <td></td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $date }}</td>
                        <td>{{ count($entries) }} tasks</td>
                        <td>
                            <button class="btn btn-sm btn-primary toggle-date" data-date="{{ \Illuminate\Support\Str::slug($date) }}">View Tasks</button>
                        </td>
                    </tr>

                    <tr class="sub-table-row" id="tasks-{{ \Illuminate\Support\Str::slug($date) }}" style="display: none;">
                        <td colspan="5" style="padding: 0 !important;">
                            <table class="table table-bordered table-sm mb-0 w-100">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>#</th>
                                        <th>TASK</th>
                                        <th>CATEGORIES</th>
                                        <th>TIME SPENT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entries as $subEntry)
                                        @php
                                            $start = \Carbon\Carbon::parse($subEntry->tt_starttime);
                                            $end = \Carbon\Carbon::parse($subEntry->tt_endtime);
                                            $diffInMinutes = $start->diffInMinutes($end);
                                            $totalMinutes += $diffInMinutes;
                                            $diff = $start->diff($end)->format('%H:%I:%S');
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="toggle-desc fw-semibold text-primary" data-id="{{ $subEntry->id }}">
                                                    {{ $subEntry->tt_name }}
                                                </a>
                                                <div class="task-desc mt-1 text-muted small" id="desc-{{ $subEntry->id }}" style="display: none;">
                                                    {{ $subEntry->tt_desc }}
                                                </div>
                                            </td>
                                            <td>
                                                @php $member = explode(",", $subEntry->tt_cat); @endphp
                                                @foreach($serv as $servs)
                                                    @if(in_array($servs->id, $member))
                                                        <span class="badge bg-light text-dark me-1">{{ $servs->tc_name }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $subEntry->tt_starttime }} - {{ $subEntry->tt_endtime }} ({{ $diff }})</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No Timesheet Entries Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($userId)
            @php
                $hours = floor($totalMinutes / 60);
                $minutes = $totalMinutes % 60;
            @endphp

            <div class="mt-3 fw-bold">
                Total Time Spent: {{ $hours }} Hours {{ $minutes }} Minutes
            </div>

            @if($userId && count($categoryData) > 0)
                <h5 class="mt-5">Time Spent Per Category (in Minutes)</h5>
                <canvas id="categoryChart"
                        height="140"
                        data-labels='@json(array_keys($categoryData))'
                        data-values='@json(array_values($categoryData))'></canvas>
            @endif
        @endif
    </div>
</div>
