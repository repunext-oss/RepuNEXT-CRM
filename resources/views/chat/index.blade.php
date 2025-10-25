@extends('admin.admin_master')
@section('admin')

<style>
.rooms-container {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.rooms-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    color: white;
}

.rooms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 24px;
    margin-bottom: 30px;
}

.room-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.room-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
}

.room-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.room-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.room-title {
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 4px 0;
}

.room-description {
    color: #6c757d;
    font-size: 14px;
    margin: 0;
    line-height: 1.4;
}

.room-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.room-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.room-members {
    color: #6c757d;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.room-members i {
    font-size: 12px;
}

.room-last-message {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 16px;
    border-left: 3px solid #667eea;
}

.last-message-text {
    font-size: 14px;
    color: #495057;
    margin: 0 0 4px 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.last-message-time {
    font-size: 12px;
    color: #6c757d;
    margin: 0;
}

.room-members-list {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
}

.member-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 12px;
    box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3);
    border: 2px solid white;
}

.member-avatar:not(:first-child) {
    margin-left: -8px;
}

.more-members {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 12px;
    border: 2px solid white;
}

.room-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.join-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.join-btn:hover {
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.room-options {
    display: flex;
    gap: 8px;
}

.option-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
}

.edit-btn {
    background: #17a2b8;
    color: white;
}

.edit-btn:hover {
    background: #138496;
    transform: scale(1.1);
}

.delete-btn {
    background: #dc3545;
    color: white;
}

.delete-btn:hover {
    background: #c82333;
    transform: scale(1.1);
}

.create-room-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    padding: 16px 32px;
    border-radius: 16px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 20px rgba(40, 167, 69, 0.3);
    margin-bottom: 30px;
}

.create-room-btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(40, 167, 69, 0.4);
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.empty-state i {
    font-size: 64px;
    color: #6c757d;
    margin-bottom: 24px;
    opacity: 0.5;
}

.empty-state h3 {
    color: #2c3e50;
    margin-bottom: 12px;
    font-weight: 600;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 24px;
    font-size: 16px;
}

/* Modal Styling */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px 16px 0 0;
    border-bottom: none;
    padding: 24px 30px;
}

.modal-title {
    font-weight: 600;
    margin: 0;
}

.btn-close {
    filter: brightness(0) invert(1);
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 20px 30px;
    border-radius: 0 0 16px 16px;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .rooms-grid {
        grid-template-columns: 1fr;
    }
    
    .rooms-header {
        padding: 20px;
    }
    
    .room-card {
        padding: 20px;
    }
}
</style>

<div class="rooms-container">
    <div class="container-fluid">
        <!-- Header -->
        <div class="rooms-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">
                        <i class="fas fa-comments me-3"></i>
                        Team Chat Rooms
                    </h1>
                    <p class="mb-0 opacity-90">Connect and collaborate with your team members</p>
                </div>
                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#createRoomModal">
                    <i class="fas fa-plus me-2"></i>Create Room
                </button>
            </div>
        </div>

      
        <!-- Rooms Grid -->
        @if($rooms->count() > 0)
            <div class="rooms-grid">
                @foreach($rooms as $room)
                    <div class="room-card" onclick="window.location.href='{{ route('chat.show', $room->id) }}'">
                        <div class="room-header">
                            <div>
                                <h5 class="room-title">{{ $room->name }}</h5>
                                @if($room->description)
                                    <p class="room-description">{{ $room->description }}</p>
                                @endif
                            </div>
                            <div class="room-options">
                                @if($room->created_by == auth()->id())
                                  
                                    <button class="option-btn delete-btn" onclick="event.stopPropagation(); deleteRoom({{ $room->id }})" title="Delete Room">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="room-meta">
                            <span class="room-badge">{{ $room->room_type ?? 'general' }}</span>
                            <span class="room-members">
                                <i class="fas fa-users"></i>
                                {{ $room->users->count() }} members
                            </span>
                        </div>

                        @if($room->latestMessage)
                            <div class="room-last-message">
                                <p class="last-message-text">{{ $room->latestMessage->message }}</p>
                                <p class="last-message-time">
                                    {{ $room->latestMessage->created_at->diffForHumans() }}
                                </p>
                            </div>
                        @endif

                        <div class="room-members-list">
                            @foreach($room->users->take(4) as $user)
                                <div class="member-avatar" title="{{ $user->name }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endforeach
                            @if($room->users->count() > 4)
                                <div class="more-members" title="+{{ $room->users->count() - 4 }} more">
                                    +{{ $room->users->count() - 4 }}
                                </div>
                            @endif
                        </div>

                        <div class="room-actions">
                            <a href="{{ route('chat.show', $room->id) }}" class="join-btn">
                                <i class="fas fa-comments"></i>
                                Join Chat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-comments"></i>
                <h3>No chat rooms yet</h3>
                <p>Create your first chat room to start collaborating with your team</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoomModal">
                    <i class="fas fa-plus me-2"></i>Create Room
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Create Room Modal -->
<div class="modal fade" id="createRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Create New Chat Room
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Room Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter room name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter room description (optional)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Room Type</label>
                        <select name="room_type" class="form-select" required>
                            <option value="general">General</option>
                            <option value="project">Project</option>
                            <option value="department">Department</option>
                            <option value="announcement">Announcement</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Members</label>
                        <select name="users[]" class="form-control select2" multiple>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <div class="form-text">Select team members to add to this room</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select team members...",
        allowClear: true,
        width: '100%'
    });
});

function editRoom(roomId) {
    // Implement edit room functionality
    alert('Edit room functionality will be implemented');
}

function deleteRoom(roomId) {
    if (confirm('Are you sure you want to delete this room? This action cannot be undone.')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/rooms/destroy/${roomId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection