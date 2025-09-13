@extends('admin.admin_master')
@section('admin')

<div class="container mt-4">
    <h2 class="mb-3">Group Chat Rooms</h2>

    <form action="{{ route('rooms.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Room name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Users</label>
            <select id="userSelect" name="users[]" class="form-control select2" multiple required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Select users to be added. You can remove them below.</small>
        </div>

        <!-- Selected User Display -->
        <!-- <div id="selectedUsers" class="mb-3"></div> -->

        <div class="input-group">
            <button type="submit" class="btn btn-primary">Create Room</button>
        </div>
    </form>

    <h4>Your Rooms</h4>
    <ul class="list-group">
        @forelse($rooms as $room)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('chat.show', $room->id) }}">{{ $room->name }}</a>
                
                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </li>
        @empty
            <li class="list-group-item text-muted">No rooms found.</li>
        @endforelse
    </ul>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href ="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        const $select = $('.select2');
        const $display = $('#selectedUsers');

        $select.select2({
            placeholder: "Select users",
            width: '100%'
        });

        function updateSelectedUsers() {
            const selectedOptions = $select.select2('data');
            $display.empty();

            selectedOptions.forEach(function (item) {
                const badge = $('<span class="badge bg-primary me-2 mb-2 p-2 rounded-pill">')
                    .text(item.text)
                    .append(
                        $('<button type="button" class="btn-close btn-close-white btn-sm ms-2" aria-label="Remove"></button>')
                            .on('click', function () {
                                const selected = $select.val().filter(id => id !== item.id);
                                $select.val(selected).trigger('change');
                            })
                    );
                $display.append(badge);
            });
        }
        $select.on('change', updateSelectedUsers);
        updateSelectedUsers();

    });
</script>

@endsection
