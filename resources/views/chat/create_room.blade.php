@extends('admin.admin_master')
@section('admin')
<div class="container mt-4">
    <h2>Create New Chat Room</h2>

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Room Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter room name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Users to Add</label>
            <select name="users[]" class="form-control" multiple required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold Ctrl (Cmd) to select multiple users.</small>
        </div>

        <button type="submit" class="btn btn-primary">Create Room</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
