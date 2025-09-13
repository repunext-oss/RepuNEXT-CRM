@extends('admin.admin_master')
@section('admin')
<div class="container mt-4">

  {{-- 🔹 Filter Form --}}
  <form method="GET" class="mb-3 d-flex gap-2">
    <label class="fw-bold mt-1">Filter:</label>
    <select name="user_id" class="form-select form-select-sm" style="max-width:200px">
      <option value="">-- All Users --</option>
      @foreach($users as $u)
        <option value="{{ $u->id }}" {{ request('user_id')==$u->id ? 'selected':'' }}>
          {{ $u->name }}
        </option>
      @endforeach
    </select>
    <select name="year" class="form-select form-select-sm" style="max-width:120px">
      @for($y=now()->year-2;$y<=now()->year+1;$y++)
        <option value="{{ $y }}" {{ $y==$year?'selected':'' }}>{{ $y }}</option>
      @endfor
    </select>
    <button class="btn btn-primary btn-sm">Filter</button>
  </form>

  {{-- 🔹 Balance Leave Table --}}
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white text-center">
      <h5 class="mb-0">Balance Leave – Latest CL / SL</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Year</th>
              <th>Month</th>
              <th>CL (days)</th>
              <th>SL (days)</th>
              <th>Total Balance (days)</th>
            </tr>
          </thead>
          <tbody>
            @forelse($balanceLeaves as $i => $row)
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->user_name }}</td>
                <td>{{ $row->year }}</td>
                <td>{{ \Carbon\Carbon::create()->month($row->month)->format('F') }}</td>
                <td>{{ number_format($row->casual_leave / 8, 1) }}</td>
                <td>{{ number_format($row->sick_leave / 8, 1) }}</td>
                <td class="fw-bold text-success">{{ number_format($row->balance_leave, 1) }}</td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-muted">No records found</td></tr>
            @endforelse
          </tbody>
          {{-- 🔹 Summary Row --}}
          @if(count($balanceLeaves))
          <tfoot>
            <tr class="table-secondary fw-bold">
              <td colspan="4">TOTAL</td>
              <td>{{ number_format($balanceLeaves->sum('casual_leave')/8, 1) }}</td>
              <td>{{ number_format($balanceLeaves->sum('sick_leave')/8, 1) }}</td>
              <td>{{ number_format($balanceLeaves->sum('balance_leave'), 1) }}</td>
            </tr>
          </tfoot>
          @endif
        </table>
      </div>
    </div>
  </div>

  {{-- 🔹 Taken Leave Table --}}
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white text-center">
      <h5 class="mb-0">Taken Leave – Monthly ({{ $year }})</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Year</th>
              <th>Month</th>
              <th>Total Taken Leave (days)</th>
              <th>Loss of Pay (days)</th>
            </tr>
          </thead>
          <tbody>
            @forelse($takenLeaves as $i => $row)
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->user_name }}</td>
                <td>{{ $row->year }}</td>
                <td>{{ \Carbon\Carbon::create()->month($row->month)->format('F') }}</td>
                <td>{{ number_format($row->taken_leave, 1) }}</td>
                <td class="{{ $row->lop > 0 ? 'text-danger fw-bold' : '' }}">
                  {{ number_format($row->lop, 1) }}
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-muted">No records found</td></tr>
            @endforelse
          </tbody>
          {{-- 🔹 Summary Row --}}
          @if(count($takenLeaves))
          <tfoot>
            <tr class="table-secondary fw-bold">
              <td colspan="4">TOTAL</td>
              <td>{{ number_format($takenLeaves->sum('taken_leave'), 1) }}</td>
              <td>{{ number_format($takenLeaves->sum('lop'), 1) }}</td>
            </tr>
          </tfoot>
          @endif
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
