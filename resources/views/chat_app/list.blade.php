@extends('admin.admin_master')
@section('admin')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Chat</h3>
            <span class="text-muted small">
                <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Chat
            </span>
        </div>
        <div class="card-body p-0">
            <div class="d-flex" style="height: 85vh;">
                <!-- Sidebar -->
                <div class="sidebar p-3 bg-light" style="width: 30%; border-right: 1px solid #e3e3e3; overflow-y: auto;" >
                        <div class="d-flex align-items-center position-relative my-1"> 
                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                        </svg>
                                    </span> 
                                    <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Report" />
						</div> 

                    <div class="user-list">
                        @foreach($users as $user)
                            <div class="user d-flex align-items-center p-2 rounded mb-2 cursor-pointer hover-bg-light" onclick="openChat({{ $user->id }}, '{{ $user->name }}', '{{ $user->profile_image }}')" data-userid="{{ $user->id }}">
                                <img src="/upload/admin-images/{{ $user->profile_image }}" alt="User" class="rounded-circle" width="50" height="50">
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <p class="mb-0 text-muted small {{ $user->status == 0 ? 'text-success' : 'text-danger' }}">
                                        ● {{ $user->status == 0 ? 'Active' : 'Inactive' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="chat-area flex-fill d-flex flex-column">
                    <div class="chat-header p-3 bg-light border-bottom d-flex align-items-center">
                        <img src="" id="chatUserImage" class="rounded-circle" width="50" height="50" alt="User">
                        <div class="ms-3">
                            <h4 id="chatUserName" class="mb-0">Select a user</h4>
                            <span class="status text-muted small">● Online</span>
                        </div>
                    </div>
                    <div class="chat-messages p-3 flex-fill" id="chatMessages" style="background-color: #f7f7f7; overflow-y: auto;">
                        <p class="text-muted">No messages yet. Select a user to start chatting.</p>                                                                          
                    </div>
                    <div class="chat-input p-3 border-top bg-light d-flex align-items-center rounded-3 shadow-sm">
                        <label for="attachment" class="file-icon me-3 d-flex align-items-center" style="cursor: pointer;">
                            <i class="bi bi-paperclip me-2" style="font-size: 18px; color: grey;"></i>
                        </label>
                        <input type="file" id="attachment" class="d-none" accept=".jpg,.jpeg,.png,.gif,.pdf,.docx,.mp4" />
                        <textarea class="form-control me-3 border-0 rounded-3" id="messageInput" rows="1" placeholder="Type a message..." style="resize: none; box-shadow: none;"></textarea>
                        <!-- Display the file name if a file is selected -->
                        <div id="fileNameDisplay" style="margin-left: 10px; color: #555;"></div>
                        <button class="btn btn-primary rounded-3 px-4 py-2" onclick="sendMessage()" style="font-size: 14px;">Send</button>
                    </div>
                </div>8
            </div>
        </div>
    </div>
</div>

<script>
let authId = @json(Auth::id());
let selectedUserId = null;
let lastTimestamp = null;
let lastRenderedDate = null;
let renderedMessageIds = new Set();
let chatInterval = null;
let isScrolling = false; // Track if the user is scrolling
let isAtBottom = true; // Track if the user is at the bottom of the chat


function openChat(userId, userName, userImage) {
    selectedUserId = userId;
    lastTimestamp = null;
    lastRenderedDate = null;
    renderedMessageIds.clear();
    document.getElementById('chatUserName').textContent = userName;
    document.getElementById('chatUserImage').src = '/upload/admin-images/' + userImage;
    document.getElementById('chatMessages').innerHTML = '';
    
    fetchMessages(true);

    if (chatInterval) clearInterval(chatInterval);

    // Start the auto-refresh for messages when at the bottom
    chatInterval = setInterval(() => {
        if (isAtBottom) {
            fetchMessages();
        }
    }, 3000); // Refresh every 3 seconds
}

function fetchMessages(initial = false) {
    if (!selectedUserId) return;

    $.ajax({
        url: "{{ route('chat.fetch') }}",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            incoming_id: selectedUserId,
            last_time: lastTimestamp,
            initial: initial ? 1 : 0
        },
        success: function (response) {
            const chatBox = document.getElementById('chatMessages');

            if (Array.isArray(response) && response.length > 0) {
                response.forEach(msg => {
                    if (renderedMessageIds.has(msg.id)) return;

                    const messageDate = new Date(msg.created_at);
                    const messageDateString = messageDate.toDateString();

                    if (lastRenderedDate !== messageDateString) {
                        const dateLabel = formatDateHeader(msg.created_at);
                        chatBox.innerHTML += `<div class="text-center text-muted my-2"><small><strong>${dateLabel}</strong></small></div>`;
                        lastRenderedDate = messageDateString;
                    }

                    let messageClass = (msg.outgoing_msg_id == authId) ? 'sent' : 'received';
                    let messageContent = msg.msg ? `<p>${msg.msg}</p>` : '';

                    if (msg.attach) {
                        let fileType = msg.attach.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                            messageContent += `<img src="/uploads/chat/${msg.attach}" style="max-width: 300px;">`;
                        } else {
                            messageContent += `<a href="/uploads/chat/${msg.attach}" target="_blank">Download File</a>`;
                        }
                    }

                    const deleteButton = messageClass === 'sent' ? `
                        <button class="delete-btn" data-message-id="${msg.id}" style="border: none; background: none; color: red; cursor: pointer;">
                            <i class="fas fa-trash"></i> <!-- Font Awesome Trash Icon -->
                        </button>
                    ` : '';


                    chatBox.innerHTML += `
                        <div class="message ${messageClass}" style="margin-left: ${messageClass === 'sent' ? 'auto' : '0'}; margin-right: ${messageClass === 'received' ? 'auto' : '0'};">
                            <div class="message-header d-flex align-items-center mb-2">
                                <img src="/upload/admin-images/${msg.outgoing_user.profile_image}" alt="${msg.outgoing_user.name}" class="profile-image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
                                <strong class="text-muted" style="font-size: 14px;">${msg.outgoing_user.name}</strong>${deleteButton}
                            </div>

                            <div class="message-content" style="background-color: ${messageClass === 'sent' ? '#87CEFA' : '#E6E6FA'}; color: ${messageClass === 'sent' ? '#000' : '#000'}; padding: 1rem; border-radius: 10px; font-weight: 400;">
                                <div>${messageContent}</div>
                            </div>

                            <div class="text-muted small text-end" style="margin-top: 5px;">${formatTime(msg.created_at)}</div>
                        </div>
                    `;

                    const deleteButtons = chatBox.querySelectorAll('.delete-btn');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const messageId = button.getAttribute('data-message-id');
                            deleteMessage(messageId);
                        });
                    });

                    lastTimestamp = msg.created_at;
                    renderedMessageIds.add(msg.id);
                });

                chatBox.scrollTop = chatBox.scrollHeight;
                isAtBottom = chatBox.scrollHeight - chatBox.scrollTop === chatBox.clientHeight; // Check if the user is at the bottom
                
               
            }
        }
    });
}
document.getElementById('attachment').addEventListener('change', function() {
                    const fileName = this.files.length ? this.files[0].name : '';
                    document.getElementById('fileNameDisplay').textContent = fileName ? `${fileName}` : '';
                });
document.getElementById('chatMessages').addEventListener('scroll', function() {
    const chatBox = document.getElementById('chatMessages');
    isAtBottom = chatBox.scrollHeight - chatBox.scrollTop === chatBox.clientHeight; // Check if the user is at the bottom

    if (!isAtBottom) {
        // Stop auto-refresh if the user is scrolling up
        if (chatInterval) clearInterval(chatInterval);
        isScrolling = true;
    } else if (isAtBottom && isScrolling) {
        // Restart auto-refresh when the user is at the bottom again
        isScrolling = false;
        chatInterval = setInterval(() => {
            fetchMessages();
        }, 3000); // Refresh every 3 seconds
    }
});
function sendMessage() {
    if (!selectedUserId) return alert('Select a user to chat with.');

    let message = $('#messageInput').val();
    let file = $('#attachment')[0].files[0];
    if (!message.trim() && !file) return alert('Enter a message or choose a file.');

    let formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('incoming_id', selectedUserId);
    formData.append('message', message);
    if (file) formData.append('attachment', file);

    $.ajax({
        url: "{{ route('chat.send') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function() {
            $('#messageInput').val('');
            $('#attachment').val('');
            document.getElementById('fileNameDisplay').textContent = '';
            fetchMessages();
        }
    });
}

// Function to handle the deletion of a message
function deleteMessage(messageId) {
    $.ajax({
        url: "{{ route('chat.delete') }}",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            message_id: messageId
        },
        success: function (response) {
            if (response.success) {
                // Remove the message from the UI
                const messageElement = document.querySelector(`.message .delete-btn[data-message-id="${messageId}"]`).closest('.message');
                if (messageElement) {
                    messageElement.remove();
                }
            } else {
                alert('Failed to delete the message.');
            }
        }
    });
}
function formatDateHeader(dateString) {
    const today = new Date();
    const msgDate = new Date(dateString);
    const yesterday = new Date();
    yesterday.setDate(today.getDate() - 1);

    if (msgDate.toDateString() === today.toDateString()) return 'Today';
    else if (msgDate.toDateString() === yesterday.toDateString()) return 'Yesterday';
    else {
        return msgDate.toLocaleDateString('en-US', {
            day: 'numeric', month: 'short', year: 'numeric'
        });
    }
}
function formatTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
}

</script>



<style>
.message {
    display: flex;
    flex-direction: column;
    max-width: 70%;
    margin: 10px 0;
}

.sent {
    margin-left: auto;
}

.received {
    margin-right: auto;
}

.message-content {
    border-radius: 10px;
    padding: 10px;
}

#chatMessages {
    display: flex;
    flex-direction: column;
    padding: 20px;
    max-height: 400px;
    overflow-y: auto;
    transition: opacity 0.5s ease-in-out; 
}
</style>



@endsection
