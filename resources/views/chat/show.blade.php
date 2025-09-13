@extends('admin.admin_master')
@section('admin')

<div class="container mt-4">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h2>Room: {{ $room->name }}</h2>
    <div class="mb-3">
        <h5>Users in this Room:</h5>
        <div class="d-flex flex-wrap">
            @foreach($room-> users as $user)
                <div class="badge bg-info text-dark me-2 mb-2 p-2 d-flex align-items-center">
                    {{ $user->name }}
                    @if($user->id !== auth()->id())
                        <form action="{{ route('rooms.removeUser', $room->id) }}" method="POST" class="ms-2">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-sm btn-danger ms-1 py-0 px-2" title="Remove User">&times;</button>
                        </form>
                    @else
                        <span class="ms-2 badge bg-secondary">You</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="chat-box mb-4" style="height: 400px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px;">
        @foreach($messages as $message)
            @if(!$message->is_deleted)
                <div id="message-{{ $message->id }}" 
                    style="display: flex; justify-content: {{ $message->user_id === auth()->id() ? 'flex-end' : 'flex-start' }}; margin-bottom: 8px; align-items: center;">
                    <div style="
                        max-width: 60%;
                        padding: 8px 12px;
                        border-radius: 15px;
                        background-color: {{ $message->user_id === auth()->id() ? '#0d6efd' : '#e9ecef' }};
                        color: {{ $message->user_id === auth()->id() ? 'white' : 'black' }};
                    ">
                        <strong>{{ $message->user->name }}</strong><br>
                        {{ $message->message }}
                        {{ $message->attachment }}

                    </div>
                    @if($message->user_id === auth()->id())
                        <button onclick="deleteMessage({{ $message->id }})" 
                                style="background: transparent; border: none; color: red; cursor: pointer; margin-left: 8px;" 
                                title="Delete message">&times;</button>
                    @endif
                </div>
            @endif
        @endforeach
</div>

<form action="{{ route('chat.sends', $room->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="room_id" value="{{ $room->id }}">
        <div class="input-group">
            <label for="attachment" class="file-icon me-3 d-flex align-items-center" style="cursor: pointer;">
                <i class="bi bi-paperclip me-2" style="font-size: 18px; color: grey;"></i>
            </label>
            <input type="file" name="attachment" id="attachment" class="d-none" accept=".jpg,.jpeg,.png,.gif,.pdf,.docx,.mp4">
            <input type="text" name="message" class="form-control" placeholder="Type your message" >
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
</form>

<a href="{{ route('rooms.index') }}" class="btn btn-secondary mt-3">Back to Rooms</a>
</div>

<script>
function deleteMessage(id) {
    fetch(`/message/destroy/${id}`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('message-' + id)?.remove();
        } else {
            alert('Failed to delete');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>

@endsection
