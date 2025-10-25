@extends('admin.admin_master')
@section('admin')

<style>
.chat-container {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.chat-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 20px 30px;
    margin-bottom: 20px;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    color: white;
}

.chat-main {
    display: flex;
    gap: 20px;
    height: calc(100vh - 180px);
    max-height: 800px;
}

.chat-sidebar {
    width: 320px;
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.chat-area {
    flex: 1;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.chat-messages {
    flex: 1;
    padding: 24px;
    overflow-y: auto;
    background: #fafbfc;
}

.message {
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.message.own {
    flex-direction: row-reverse;
}

.message-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 14px;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.message-content {
    max-width: 70%;
    background: white;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.message.own .message-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}

.message-sender {
    font-weight: 600;
    font-size: 13px;
    color: #667eea;
}

.message.own .message-sender {
    color: rgba(255, 255, 255, 0.9);
}

.message-time {
    font-size: 11px;
    opacity: 0.7;
    color: #6c757d;
}

.message.own .message-time {
    color: rgba(255, 255, 255, 0.8);
}

.message-text {
    margin: 0;
    word-wrap: break-word;
    line-height: 1.4;
    font-size: 14px;
}

.message-actions {
    position: absolute;
    top: -8px;
    right: -8px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.message:hover .message-actions {
    opacity: 1;
}

.chat-input {
    padding: 20px 24px;
    border-top: 1px solid #e9ecef;
    background: white;
}

.input-group {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f8f9fa;
    border-radius: 25px;
    padding: 8px 8px 8px 20px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.input-group:focus-within {
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.message-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    padding: 8px 0;
    font-size: 14px;
    color: #495057;
}

.message-input::placeholder {
    color: #adb5bd;
}

.attachment-btn, .send-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 16px;
}

.attachment-btn {
    background: #6c757d;
    color: white;
}

.attachment-btn:hover {
    background: #5a6268;
    transform: scale(1.05);
}

.send-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.send-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.send-btn:disabled {
    background: #adb5bd;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.member-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    margin-bottom: 8px;
    transition: background 0.3s ease;
}

.member-item:hover {
    background: #f8f9fa;
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
}

.member-info {
    flex: 1;
}

.member-name {
    font-weight: 600;
    font-size: 14px;
    margin: 0;
    color: #2c3e50;
}

.member-role {
    font-size: 12px;
    color: #6c757d;
    margin: 0;
}

.room-info {
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.room-title {
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 4px;
}

.room-description {
    color: #6c757d;
    font-size: 14px;
    margin: 0 0 12px 0;
}

.room-meta {
    display: flex;
    align-items: center;
    gap: 12px;
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
}

.attachment-preview {
    margin-bottom: 12px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 12px;
    display: none;
    border: 1px solid #e9ecef;
}

.attachment-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.attachment-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #667eea;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

.attachment-name {
    flex: 1;
    font-size: 14px;
    color: #495057;
    font-weight: 500;
}

.remove-attachment {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.3s ease;
}

.remove-attachment:hover {
    background: #c82333;
    transform: scale(1.1);
}

.typing-indicator {
    padding: 12px 24px;
    color: #6c757d;
    font-style: italic;
    font-size: 13px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state h4 {
    margin-bottom: 8px;
    color: #495057;
}

.empty-state p {
    margin: 0;
    font-size: 14px;
}

/* Scrollbar Styling */
.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Members List Container */
.members-list-container {
    max-height: 300px;
    overflow-y: auto;
    padding-right: 8px;
    margin-bottom: 16px;
}

.members-list-container::-webkit-scrollbar {
    width: 6px;
}

.members-list-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.members-list-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.members-list-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .chat-main {
        flex-direction: column;
        height: auto;
    }
    
    .chat-sidebar {
        width: 100%;
        margin-bottom: 20px;
    }
    
    .chat-area {
        min-height: 500px;
    }
}
</style>

<div class="chat-container">
    <div class="container-fluid">
        <!-- Header -->
        <div class="chat-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-comments me-2"></i>
                        {{ $room->name }}
                    </h2>
                    @if($room->description)
                        <p class="mb-0 opacity-90">{{ $room->description }}</p>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('rooms.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to Rooms
                    </a>
                    <button class="btn btn-outline-light" onclick="checkForNewMessages()" title="Refresh Messages">
                        <i class="fas fa-sync-alt me-2"></i>Refresh
                    </button>
                    <button class="btn btn-outline-light" onclick="showAddMembersModal()">
                        <i class="fas fa-user-plus me-2"></i>Add Members
                    </button>
                </div>
            </div>
        </div>

        <div class="chat-main">
            <!-- Sidebar -->
            <div class="chat-sidebar">
                <div class="room-info">
                    <h5 class="room-title">{{ $room->name }}</h5>
                    @if($room->description)
                        <p class="room-description">{{ $room->description }}</p>
                    @endif
                    <div class="room-meta">
                        <span class="room-badge">{{ $room->room_type ?? 'general' }}</span>
                        <span class="room-members">{{ $room->users->count() }} members</span>
                    </div>
                </div>

                <h6 class="mb-3" style="color: #2c3e50; font-weight: 600;">Members</h6>
                
                <!-- Scrollable Members List -->
                <div class="members-list-container">
                    @foreach($room->users as $user)
                        <div class="member-item">
                            <div class="member-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="member-info">
                                <p class="member-name">{{ $user->name }}</p>
                                <p class="member-role">
                                    @if($user->id == $room->created_by)
                                        Room Creator
                                    @elseif($user->id == auth()->id())
                                        You
                                    @else
                                        Member
                                    @endif
                                </p>
                            </div>
                            @if($user->id !== auth()->id() && $room->created_by == auth()->id())
                                <form action="{{ route('rooms.removeUser', $room->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Remove {{ $user->name }} from this room?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
             
    </div>

            <!-- Chat Area -->
            <div class="chat-area">
                <!-- Messages -->
                <div class="chat-messages" id="chatMessages">
                    @if($messages->count() > 0)
        @foreach($messages as $message)
            @if(!$message->is_deleted)
                                <div class="message {{ $message->user_id === auth()->id() ? 'own' : '' }}" id="message-{{ $message->id }}">
                                    <div class="message-avatar">
                                        {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                    </div>
                                    <div class="message-content">
                                        <div class="message-header">
                                            <span class="message-sender">{{ $message->user->name }}</span>
                                            <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                                        </div>
                                        @if($message->message)
                                            <p class="message-text">{{ $message->message }}</p>
                                        @endif
                                        @if($message->hasAttachment())
                                            <div class="mt-2">
                                                <a href="{{ $message->attachment_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-paperclip me-1"></i>
                        {{ $message->attachment }}
                                                </a>
                    </div>
                                        @endif
                                        <div class="message-actions">
                    @if($message->user_id === auth()->id())
                        <button onclick="deleteMessage({{ $message->id }})" 
                                                        class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <h4>No messages yet</h4>
                            <p>Start the conversation by sending a message</p>
                        </div>
                    @endif
                </div>

                <!-- Typing Indicator -->
                <div class="typing-indicator" id="typingIndicator" style="display: none;">
                    <span id="typingText"></span>
</div>

                <!-- Input Area -->
                <div class="chat-input">
                    <form id="messageForm">
    @csrf
    <input type="hidden" name="room_id" value="{{ $room->id }}">
                        
                        <!-- Attachment Preview -->
                        <div class="attachment-preview" id="attachmentPreview">
                            <div class="attachment-item">
                                <div class="attachment-icon">
                                    <i class="fas fa-file"></i>
                                </div>
                                <span class="attachment-name" id="attachmentName"></span>
                                <button type="button" class="remove-attachment" onclick="removeAttachment()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

        <div class="input-group">
                            <input type="file" name="attachment" id="attachment" class="d-none" 
                                   accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.mp4,.avi,.mov">
                            <button type="button" class="attachment-btn" onclick="document.getElementById('attachment').click()">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="text" name="message" id="messageInput" class="message-input" 
                                   placeholder="Type your message..." autocomplete="off">
                            <button type="submit" class="send-btn" id="sendBtn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Members Modal -->
<div class="modal fade" id="addMembersModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Members to {{ $room->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('rooms.addUsers', $room->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Users</label>
                        <select name="users[]" class="form-control select2" multiple required>
                            @foreach($users as $user)
                                @if(!$room->users->contains($user->id))
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Members</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let lastMessageId = {{ $messages->last() ? $messages->last()->id : 0 }};
let typingTimer;
let isTyping = false;
let isSending = false;

$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select users...",
        width: '100%'
    });

    // Fix existing message alignments
    fixExistingMessageAlignments();

    // Auto-scroll to bottom
    scrollToBottom();

    // Message form submission - PREVENT DUPLICATE SUBMISSIONS
    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        if (!isSending) {
            sendMessage();
        }
    });

    // Enter key to send message
    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            if (!isSending) {
                sendMessage();
            }
        }
    });

    // File attachment handling
    $('#attachment').on('change', function() {
        const file = this.files[0];
        if (file) {
            $('#attachmentName').text(file.name);
            $('#attachmentPreview').show();
        }
    });

    // Auto-refresh messages every 2 seconds for better real-time experience
    setInterval(function() {
        if (!isSending) {
            checkForNewMessages();
        }
    }, 2000);
});

function sendMessage() {
    if (isSending) return; // Prevent duplicate submissions
    
    const messageText = $('#messageInput').val().trim();
    const attachment = $('#attachment')[0].files[0];
    
    if (!messageText && !attachment) {
        alert('Please enter a message or select a file to send.');
        return; // Don't send empty messages
    }
    
    isSending = true;
    $('#sendBtn').prop('disabled', true);
    $('#sendBtn i').removeClass('fa-paper-plane').addClass('fa-spinner fa-spin');
    
    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('room_id', roomId);
    formData.append('message', messageText);
    if (attachment) {
        formData.append('attachment', attachment);
    }
    
    $.ajax({
        url: `/chat/${roomId}/send`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#messageInput').val('');
                $('#attachment').val('');
                $('#attachmentPreview').hide();
                appendMessage(response.message);
                scrollToBottom();
            }
        },
        error: function(xhr) {
            console.error('Error sending message:', xhr.responseText);
            let errorMessage = 'Failed to send message. Please try again.';
            
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else if (xhr.status === 422) {
                errorMessage = 'Validation error. Please check your input.';
            } else if (xhr.status === 403) {
                errorMessage = 'You are not authorized to send messages in this room.';
            } else if (xhr.status === 404) {
                errorMessage = 'Room not found.';
            }
            
            alert(errorMessage);
        },
        complete: function() {
            isSending = false;
            $('#sendBtn').prop('disabled', false);
            $('#sendBtn i').removeClass('fa-spinner fa-spin').addClass('fa-paper-plane');
        }
    });
}

function appendMessage(message) {
    const currentUserId = {{ auth()->id() }};
    const isOwnMessage = message.user_id === currentUserId;
    const messageClass = isOwnMessage ? 'own' : '';
    const messageTime = new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'});
    
    const messageHtml = `
        <div class="message ${messageClass}" id="message-${message.id}">
            <div class="message-avatar">
                ${message.user.name.charAt(0).toUpperCase()}
            </div>
            <div class="message-content">
                <div class="message-header">
                    <span class="message-sender">${message.user.name}</span>
                    <span class="message-time">${messageTime}</span>
                </div>
                ${message.message ? `<p class="message-text">${message.message}</p>` : ''}
                ${message.attachment ? `
                    <div class="mt-2">
                        <a href="/uploads/chat/${message.attachment}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-paperclip me-1"></i>
                            ${message.attachment}
                        </a>
                    </div>
                ` : ''}
                ${isOwnMessage ? `
                    <div class="message-actions">
                        <button onclick="deleteMessage(${message.id})" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                ` : ''}
            </div>
        </div>
    `;
    
    // Remove empty state if it exists
    $('.empty-state').remove();
    
    $('#chatMessages').append(messageHtml);
    lastMessageId = message.id;
    
    // Debug logging
    console.log('Message from user ID:', message.user_id, 'Current user ID:', currentUserId, 'Is own message:', isOwnMessage);
}

function checkForNewMessages() {
    $.ajax({
        url: `/rooms/${roomId}/messages/${lastMessageId}`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.messages && response.messages.length > 0) {
                console.log('New messages received:', response.messages.length);
                response.messages.forEach(function(message) {
                    appendMessage(message);
                });
                scrollToBottom();
            }
        },
        error: function(xhr) {
            console.error('Error checking for new messages:', xhr.responseText);
        }
    });
}

function deleteMessage(messageId) {
    if (confirm('Are you sure you want to delete this message?')) {
        $.ajax({
            url: `/message/destroy/${messageId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $(`#message-${messageId}`).fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            },
            error: function(xhr) {
                console.error('Error deleting message:', xhr.responseText);
            }
        });
    }
}

function removeAttachment() {
    $('#attachment').val('');
    $('#attachmentPreview').hide();
}

function showAddMembersModal() {
    $('#addMembersModal').modal('show');
}

function scrollToBottom() {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function fixExistingMessageAlignments() {
    const currentUserId = {{ auth()->id() }};
    $('.message').each(function() {
        const messageElement = $(this);
        const messageId = messageElement.attr('id');
        
        // Extract user ID from the message element (we'll need to get this from the data)
        // For now, let's check if the message has the 'own' class and fix it
        const hasOwnClass = messageElement.hasClass('own');
        
        // Get the sender name to determine if it's the current user
        const senderName = messageElement.find('.message-sender').text().trim();
        const currentUserName = '{{ auth()->user()->name }}';
        
        // Remove existing own class
        messageElement.removeClass('own');
        
        // Add own class only if it's the current user's message
        if (senderName === currentUserName) {
            messageElement.addClass('own');
        }
        
        console.log('Fixed message alignment for:', senderName, 'Is own:', senderName === currentUserName);
    });
}

// Get room ID from URL
const roomId = {{ $room->id }};

// Initialize lastMessageId properly
if (lastMessageId === 0 && $('.message').length > 0) {
    const lastMessage = $('.message').last();
    const messageId = lastMessage.attr('id');
    if (messageId) {
        lastMessageId = parseInt(messageId.replace('message-', ''));
    }
}

console.log('Initial lastMessageId:', lastMessageId);
console.log('Room ID:', roomId);
</script>

@endsection