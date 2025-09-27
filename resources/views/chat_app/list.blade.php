@extends('admin.admin_master')
@section('admin')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="whatsapp-container">
    <div class="chat-app">
        <!-- Left Sidebar -->
        <div class="sidebar">
            <!-- Header -->
            <div class="sidebar-header">
                <div class="user-info">
                    <img src="/upload/admin-images/{{ auth()->user()->profile_image ?: 'default.jpg' }}" 
                         alt="Profile" 
                         class="profile-img"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiM2Njc3ODEiLz4KPHN2ZyB4PSIxMCIgeT0iMTAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Ik0yMCAyMXYtMmEyIDIgMCAwIDAtMi0yaC0xMmEyIDIgMCAwIDAtMiAydjIiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ii8+Cjwvc3ZnPgo8L3N2Zz4K'">
                    <div class="user-details">
                        <h6>{{ auth()->user()->name }}</h6>
                        <span class="status online">Online</span>
        </div>
                </div>
                <div class="sidebar-actions">
                    <button class="btn-icon" onclick="showNewChatModal()" title="New Chat">
                        <i class="fas fa-comment-medical"></i>
                    </button>
                    <button class="btn-icon" onclick="toggleSidebarMenu()" title="Menu">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
						</div> 

            <!-- Search -->
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search or start new chat" id="searchInput" onkeyup="searchChats()">
        </div>
						</div> 

            <!-- Chat List -->
            <div class="chat-list" id="chatList">
                        @foreach($users as $user)
                    <div class="chat-item" onclick="openChat({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->profile_image }}', {{ $user->status }})" data-userid="{{ $user->id }}">
                        <div class="chat-avatar">
                            <img src="/upload/admin-images/{{ $user->profile_image ?: 'default.jpg' }}" 
                                 alt="{{ $user->name }}" 
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDkiIGhlaWdodD0iNDkiIHZpZXdCb3g9IjAgMCA0OSA0OSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjQuNSIgY3k9IjI0LjUiIHI9IjI0LjUiIGZpbGw9IiM2Njc3ODEiLz4KPHN2ZyB4PSIxMiIgeT0iMTIiIHdpZHRoPSIyNSIgaGVpZ2h0PSIyNSIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Ik0yMCAyMXYtMmEyIDIgMCAwIDAtMi0yaC0xMmEyIDIgMCAwIDAtMiAydjIiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ii8+Cjwvc3ZnPgo8L3N2Zz4K'">
                            <div class="status-indicator {{ $user->status == 0 ? 'online' : 'offline' }}"></div>
                        </div>
                        <div class="chat-info">
                            <div class="chat-name">{{ $user->name }}</div>
                            <div class="chat-last-message" id="lastMessage_{{ $user->id }}">Click to start chatting</div>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-time" id="lastTime_{{ $user->id }}"></div>
                            <div class="unread-count" id="unread_{{ $user->id }}" style="display: none;">0</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

        <!-- Right Chat Area -->
        <div class="chat-area">
            <!-- Chat Header -->
            <div class="chat-header" id="chatHeader">
                <div class="chat-user-info">
                    <img src="/upload/admin-images/default.jpg" id="chatUserImage" class="chat-user-avatar" alt="User" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiM2Njc3ODEiLz4KPHN2ZyB4PSIxMCIgeT0iMTAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Ik0yMCAyMXYtMmEyIDIgMCAwIDAtMi0yaC0xMmEyIDIgMCAwIDAtMiAydjIiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ii8+Cjwvc3ZnPgo8L3N2Zz4K'">
                    <div class="chat-user-details">
                        <h6 id="chatUserName">WhatsApp</h6>
                        <span id="chatUserStatus" class="chat-status">Select a contact to start chatting</span>
`                    </div>
                        </div>
                <div class="chat-actions">
                    <button class="btn-icon" onclick="toggleSearchMessages()" title="Search Messages">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn-icon" onclick="toggleChatMenu()" title="Menu">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    </div>
                    </div>

            <!-- Welcome Screen -->
            <div class="welcome-screen" id="welcomeScreen">
                <div class="welcome-content">
                    <div class="whatsapp-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h4>WhatsApp Web</h4>
                    <p>Send and receive messages without keeping your phone online.<br>
                    Use WhatsApp on up to 4 linked devices and 1 phone at the same time.</p>
            </div>
            </div>

            <!-- Message Search Overlay -->
            <div class="message-search-overlay" id="messageSearchOverlay" style="display: none;">
                <div class="search-header">
                    <button class="btn-icon" onclick="closeMessageSearch()" title="Close Search">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="search-input-wrapper">
                        <input type="text" id="messageSearchInput" placeholder="Search messages..." autocomplete="off">
                        <button class="btn-icon" onclick="clearMessageSearch()" title="Clear">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="search-results" id="searchResults">
                    <div class="no-results" style="display: none;">
                        <i class="fas fa-search"></i>
                        <p>No messages found</p>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="messages-container" id="messagesContainer" style="display: none;">
                <div class="messages" id="chatMessages">
                    <!-- Messages will be loaded here -->
                </div>
                
                <!-- Typing Indicator -->
                <div class="typing-indicator" id="typingIndicator" style="display: none;">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <span class="typing-text">typing...</span>
                </div>
            </div>

            <!-- Message Input -->
            <div class="message-input-container" id="messageInputContainer">
                <div class="input-wrapper">
                    <button class="btn-icon emoji-btn" onclick="toggleEmojiPicker()" title="Emoji">
                        <i class="far fa-smile"></i>
                    </button>
                    
                    <div class="input-area">
                        <div class="reply-preview" id="replyPreview" style="display: none;">
                            <div class="reply-content">
                                <div class="reply-info">
                                    <span class="reply-name"></span>
                                    <span class="reply-text"></span>
                                </div>
                                <button class="btn-icon" onclick="cancelReply()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="file-preview" id="filePreview" style="display: none;">
                            <div class="file-info">
                                <i class="fas fa-file"></i>
                                <span id="fileName"></span>
                                <button class="btn-icon" onclick="removeFile()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="input-row">
                            <button class="btn-icon attach-btn" onclick="showAttachmentMenu()" title="Attach">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            
                            <div class="message-input-wrapper">
                                <textarea id="messageInput" placeholder="Type a message" rows="1" onkeyup="handleTyping()" onkeydown="handleTypingStart()" oninput="autoResize()" disabled></textarea>
                            </div>
                            
                            <button class="btn-icon voice-btn" onclick="toggleVoiceRecording()" title="Voice Message">
                                <i class="fas fa-microphone"></i>
                            </button>
                            
                            <button class="btn-icon send-btn" onclick="sendMessage()" title="Send">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden file inputs -->
                <input type="file" id="imageInput" class="d-none" accept="image/*" onchange="handleFileSelect(this)">
                <input type="file" id="documentInput" class="d-none" accept=".pdf,.doc,.docx,.txt,.xlsx,.pptx" onchange="handleFileSelect(this)">
                <input type="file" id="videoInput" class="d-none" accept="video/*" onchange="handleFileSelect(this)">
            </div>
        </div>
    </div>
</div>

<!-- Emoji Picker -->
<div class="emoji-picker" id="emojiPicker" style="display: none;">
    <div class="emoji-grid" id="emojiGrid">
        <!-- Emojis will be loaded here -->
    </div>
</div>

<!-- Attachment Menu -->
<div class="attachment-menu" id="attachmentMenu" style="display: none;">
    <div class="attachment-option" onclick="selectFile('imageInput')">
        <i class="fas fa-image"></i>
        <span>Photo & Video</span>
    </div>
    <div class="attachment-option" onclick="selectFile('documentInput')">
        <i class="fas fa-file-alt"></i>
        <span>Document</span>
    </div>
    <div class="attachment-option" onclick="startVoiceRecording()">
        <i class="fas fa-microphone"></i>
        <span>Voice Message</span>
    </div>
</div>

<!-- Voice Recording Modal -->
<div class="voice-recording-modal" id="voiceRecordingModal" style="display: none;">
    <div class="voice-recording-content">
        <div class="voice-wave">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
        <p>Recording...</p>
        <button class="btn btn-danger" onclick="stopVoiceRecording()">
            <i class="fas fa-stop"></i> Stop
        </button>
    </div>
</div>

<!-- Forward Message Modal -->
<div id="forwardModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-share"></i> Forward Message</h3>
            <button class="close-btn" onclick="closeForwardModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="forward-preview">
                <div class="forward-message-preview">
                    <span class="forward-label">Forwarding:</span>
                    <div class="forward-message-content" id="forwardMessageContent"></div>
                </div>
            </div>
            <div class="forward-to-section">
                <h4>Forward to:</h4>
                <div class="forward-user-list" id="forwardUserList">
                    <!-- Users will be populated here -->
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeForwardModal()">Cancel</button>
            <button class="btn btn-primary" id="confirmForwardBtn" onclick="confirmForward()" disabled>Forward</button>
        </div>
    </div>
</div>

<script>
let authId = @json(Auth::id());
let selectedUserId = null;
let selectedUserName = '';
let selectedUserImage = '';
let selectedUserStatus = 0;
let lastTimestamp = null;
let lastRenderedDate = null;
let renderedMessageIds = new Set();
let chatInterval = null;
let isScrolling = false;
let isAtBottom = true;
let typingTimer = null;
let isTyping = false;
let replyToMessageData = null;
let selectedFile = null;
let isRecording = false;
let mediaRecorder = null;
let recordedChunks = [];
let emojiPickerVisible = false;
let forwardMessageData = null;
let selectedForwardUsers = new Set();
let attachmentMenuVisible = false;
let allMessages = [];
let searchResults = [];


function openChat(userId, userName, userImage, userStatus) {
    selectedUserId = userId;
    selectedUserName = userName;
    selectedUserImage = userImage;
    selectedUserStatus = userStatus;
    
    // Update chat selection
    document.querySelectorAll('.chat-item').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelector(`[data-userid="${userId}"]`).classList.add('active');
    
    // Update chat header
    document.getElementById('chatUserImage').src = '/upload/admin-images/' + (userImage || 'default.jpg');
    document.getElementById('chatUserImage').onerror = function() {
        this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiM2Njc3ODEiLz4KPHN2ZyB4PSIxMCIgeT0iMTAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Ik0yMCAyMXYtMmEyIDIgMCAwIDAtMi0yaC0xMmEyIDIgMCAwIDAtMiAydjIiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ii8+Cjwvc3ZnPgo8L3N2Zz4K';
    };
    document.getElementById('chatUserName').textContent = userName;
    document.getElementById('chatUserStatus').textContent = userStatus == 0 ? 'Online' : 'Last seen recently';
    
    // Show chat area and hide welcome screen
    document.getElementById('welcomeScreen').style.display = 'none';
    document.getElementById('messagesContainer').style.display = 'flex';
    
    // Add active class for mobile responsiveness
    document.querySelector('.chat-area').classList.add('active');
    
    // Ensure header and input are always visible
    document.getElementById('chatHeader').style.display = 'flex';
    document.getElementById('messageInputContainer').style.display = 'block';
    
    // Force message input container to be visible
    const messageInputContainer = document.getElementById('messageInputContainer');
    messageInputContainer.style.setProperty('display', 'block', 'important');
    messageInputContainer.style.setProperty('visibility', 'visible', 'important');
    messageInputContainer.style.setProperty('opacity', '1', 'important');
    
    // Enable message input
    document.getElementById('messageInput').disabled = false;
    document.getElementById('messageInput').placeholder = 'Type a message';
    
    // Debug: Log message input container visibility
    console.log('Message Input Container:', {
        display: messageInputContainer.style.display,
        visibility: messageInputContainer.style.visibility,
        opacity: messageInputContainer.style.opacity,
        computedStyle: window.getComputedStyle(messageInputContainer).display
    });
    
    // Reset message state
    lastTimestamp = null;
    lastRenderedDate = null;
    renderedMessageIds.clear();
    document.getElementById('chatMessages').innerHTML = '';
    
    // Fetch messages
    fetchMessages(true);

    // Start auto-refresh
    if (chatInterval) clearInterval(chatInterval);
    chatInterval = setInterval(() => {
        if (isAtBottom) {
            fetchMessages();
        }
    }, 1000);
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
            let hasNewMessages = false;

            if (Array.isArray(response) && response.length > 0) {
                response.forEach(msg => {
                    if (renderedMessageIds.has(msg.id)) return;
                    
                    hasNewMessages = true;
                    
                    // Store message for search functionality
                    allMessages.push(msg);

                    const messageDate = new Date(msg.created_at);
                    const messageDateString = messageDate.toDateString();

                    // Add date separator if new day
                    if (lastRenderedDate !== messageDateString) {
                        const dateLabel = formatDateHeader(msg.created_at);
                        chatBox.innerHTML += `<div class="date-separator">${dateLabel}</div>`;
                        lastRenderedDate = messageDateString;
                    }

                    const messageClass = (msg.outgoing_msg_id == authId) ? 'sent' : 'received';
                    const messageTime = formatTime(msg.created_at);
                    
                    let messageContent = '';
                    
                    // Message text
                    if (msg.msg) {
                        messageContent = `<div class="message-text">${escapeHtml(msg.msg)}</div>`;
                    }
                    
                    // File attachment
                    if (msg.attach) {
                        const fileType = msg.attach.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                            messageContent += `<div class="message-image"><img src="/uploads/chat/${msg.attach}" alt="Image" onclick="openImageViewer('/uploads/chat/${msg.attach}')"></div>`;
                        } else {
                            messageContent += `<div class="message-file"><a href="/uploads/chat/${msg.attach}" download><i class="fas fa-file"></i> ${msg.attach}</a></div>`;
                        }
                    }

                    // Message status for sent messages
                    let statusIcon = '';
                    if (messageClass === 'sent') {
                        statusIcon = '<div class="message-status"><i class="fas fa-check-double"></i></div>';
                    }

                    // Build message HTML
                    const messageHtml = `
                        <div class="message ${messageClass}" data-message-id="${msg.id}">
                            <div class="message-bubble">
                                ${messageContent}
                                <div class="message-time">
                                    ${messageTime}
                                    ${statusIcon}
                            </div>
                                <div class="message-actions">
                                    <button onclick="replyToMessage(${msg.id}, '${escapeHtml(msg.msg)}')" title="Reply">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button onclick="forwardMessage(${msg.id}, '${escapeHtml(msg.msg || '')}')" title="Forward">
                                        <i class="fas fa-share"></i>
                                    </button>
                                    ${messageClass === 'sent' ? `
                                        <button onclick="deleteMessage(${msg.id})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    ` : ''}
                            </div>
                            </div>
                        </div>
                    `;

                    chatBox.innerHTML += messageHtml;
                    lastTimestamp = msg.created_at;
                    renderedMessageIds.add(msg.id);
                });

                // Auto-scroll if at bottom or initial load
                if (isAtBottom || initial) {
                    scrollToBottom();
                }
                
                isAtBottom = chatBox.scrollHeight - chatBox.scrollTop === chatBox.clientHeight;
                
                // Update last message in chat list
                if (hasNewMessages && response.length > 0) {
                    const lastMsg = response[response.length - 1];
                    updateChatListLastMessage(lastMsg);
                }
            }
        },
        error: function(xhr) {
            console.error('Error fetching messages:', xhr.responseText);
        }
    });
}
// Scroll event listener
document.getElementById('chatMessages').addEventListener('scroll', function() {
    const chatBox = document.getElementById('chatMessages');
    isAtBottom = chatBox.scrollHeight - chatBox.scrollTop === chatBox.clientHeight;

    if (!isAtBottom) {
        if (chatInterval) clearInterval(chatInterval);
        isScrolling = true;
    } else if (isAtBottom && isScrolling) {
        isScrolling = false;
        chatInterval = setInterval(() => {
            fetchMessages();
        }, 1000);
    }
});

// Initialize emoji picker and ensure functions are available
document.addEventListener('DOMContentLoaded', function() {
    initializeEmojiPicker();
    
    // Ensure message input container is visible on page load
    const messageInputContainer = document.getElementById('messageInputContainer');
    if (messageInputContainer) {
        messageInputContainer.style.display = 'block';
        messageInputContainer.style.visibility = 'visible';
        messageInputContainer.style.opacity = '1';
        console.log('Message input container initialized as visible');
    }
    
    // Make sure openChat function is globally available
    window.openChat = openChat;
    window.sendMessage = sendMessage;
    window.deleteMessage = deleteMessage;
    window.searchChats = searchChats;
    window.toggleEmojiPicker = toggleEmojiPicker;
    window.showAttachmentMenu = showAttachmentMenu;
    window.selectFile = selectFile;
    window.handleFileSelect = handleFileSelect;
    window.removeFile = removeFile;
    window.toggleVoiceRecording = toggleVoiceRecording;
    window.startVoiceRecording = startVoiceRecording;
    window.stopVoiceRecording = stopVoiceRecording;
    window.replyToMessage = replyToMessage;
    window.cancelReply = cancelReply;
    window.autoResize = autoResize;
    window.handleTyping = handleTyping;
    window.handleTypingStart = handleTypingStart;
    window.forwardMessage = forwardMessage;
    window.closeForwardModal = closeForwardModal;
    window.confirmForward = confirmForward;
    window.toggleForwardUser = toggleForwardUser;
    window.toggleSearchMessages = toggleSearchMessages;
    window.closeMessageSearch = closeMessageSearch;
    window.clearMessageSearch = clearMessageSearch;
    window.searchMessages = searchMessages;
    window.scrollToMessage = scrollToMessage;
    
    // Add event listener for message search
    const messageSearchInput = document.getElementById('messageSearchInput');
    if (messageSearchInput) {
        messageSearchInput.addEventListener('input', searchMessages);
    }
    
    // Initialize search overlay
    const searchOverlay = document.getElementById('messageSearchOverlay');
    if (searchOverlay) {
        searchOverlay.style.display = 'none';
        console.log('Search overlay initialized');
    }
});

// Utility functions
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function scrollToBottom() {
    const chatBox = document.getElementById('chatMessages');
    chatBox.scrollTop = chatBox.scrollHeight;
    isAtBottom = true;
}

function updateChatListLastMessage(message) {
    const lastMessageEl = document.getElementById(`lastMessage_${selectedUserId}`);
    const lastTimeEl = document.getElementById(`lastTime_${selectedUserId}`);
    
    if (lastMessageEl) {
        if (message.attach) {
            const fileType = message.attach.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                lastMessageEl.textContent = '📷 Photo';
            } else {
                lastMessageEl.textContent = '📎 ' + message.attach;
            }
        } else {
            lastMessageEl.textContent = message.msg || 'Message';
        }
    }
    
    if (lastTimeEl) {
        lastTimeEl.textContent = formatTime(message.created_at);
    }
}

// Search functionality
function searchChats() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const chatItems = document.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
        const userName = item.querySelector('.chat-name').textContent.toLowerCase();
        const lastMessage = item.querySelector('.chat-last-message').textContent.toLowerCase();
        
        if (userName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// Emoji picker functionality
function initializeEmojiPicker() {
    const emojis = [
        '😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇',
        '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚',
        '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩',
        '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣',
        '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬',
        '🤯', '😳', '🥵', '🥶', '😱', '😨', '😰', '😥', '😓', '🤗',
        '🤔', '🤭', '🤫', '🤥', '😶', '😐', '😑', '😬', '🙄', '😯',
        '😦', '😧', '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐',
        '🥴', '🤢', '🤮', '🤧', '😷', '🤒', '🤕', '🤑', '🤠', '😈',
        '👿', '👹', '👺', '🤡', '💩', '👻', '💀', '☠️', '👽', '👾',
        '🤖', '🎃', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿',
        '😾', '👶', '👧', '🧒', '👦', '👩', '🧑', '👨', '👱‍♀️', '👱',
        '👱‍♂️', '🧔', '👵', '🧓', '👴', '👲', '👳‍♀️', '👳', '👳‍♂️', '🧕',
        '👮‍♀️', '👮', '👮‍♂️', '👷‍♀️', '👷', '👷‍♂️', '💂‍♀️', '💂', '💂‍♂️', '🕵️‍♀️',
        '🕵️', '🕵️‍♂️', '👩‍⚕️', '👨‍⚕️', '👩‍🌾', '👨‍🌾', '👩‍🍳', '👨‍🍳', '👩‍🎓', '👨‍🎓',
        '👩‍🎤', '👨‍🎤', '👩‍🏫', '👨‍🏫', '👩‍🏭', '👨‍🏭', '👩‍💻', '👨‍💻', '👩‍💼', '👨‍💼'
    ];
    
    const emojiGrid = document.getElementById('emojiGrid');
    emojis.forEach(emoji => {
        const emojiItem = document.createElement('div');
        emojiItem.className = 'emoji-item';
        emojiItem.textContent = emoji;
        emojiItem.onclick = () => insertEmoji(emoji);
        emojiGrid.appendChild(emojiItem);
    });
}

function toggleEmojiPicker() {
    emojiPickerVisible = !emojiPickerVisible;
    document.getElementById('emojiPicker').style.display = emojiPickerVisible ? 'block' : 'none';
}

function insertEmoji(emoji) {
    const messageInput = document.getElementById('messageInput');
    const cursorPos = messageInput.selectionStart;
    const textBefore = messageInput.value.substring(0, cursorPos);
    const textAfter = messageInput.value.substring(cursorPos);
    
    messageInput.value = textBefore + emoji + textAfter;
    messageInput.focus();
    messageInput.setSelectionRange(cursorPos + emoji.length, cursorPos + emoji.length);
    
    toggleEmojiPicker();
}

// Attachment functionality
function showAttachmentMenu() {
    attachmentMenuVisible = !attachmentMenuVisible;
    document.getElementById('attachmentMenu').style.display = attachmentMenuVisible ? 'block' : 'none';
}

function selectFile(inputId) {
    document.getElementById(inputId).click();
    attachmentMenuVisible = false;
    document.getElementById('attachmentMenu').style.display = 'none';
}

function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        selectedFile = input.files[0];
        document.getElementById('fileName').textContent = selectedFile.name;
        document.getElementById('filePreview').style.display = 'block';
    }
}

function removeFile() {
    selectedFile = null;
    document.getElementById('filePreview').style.display = 'none';
    // Clear all file inputs
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.value = '';
    });
}

// Voice recording functionality
function toggleVoiceRecording() {
    if (isRecording) {
        stopVoiceRecording();
    } else {
        startVoiceRecording();
    }
}

function startVoiceRecording() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('Voice recording is not supported in this browser');
        return;
    }
    
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            mediaRecorder = new MediaRecorder(stream);
            recordedChunks = [];
            
            mediaRecorder.ondataavailable = event => {
                recordedChunks.push(event.data);
            };
            
            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(recordedChunks, { type: 'audio/webm' });
                sendVoiceMessage(audioBlob);
                stream.getTracks().forEach(track => track.stop());
            };
            
            mediaRecorder.start();
            isRecording = true;
            document.getElementById('voiceRecordingModal').style.display = 'flex';
        })
        .catch(err => {
            console.error('Error accessing microphone:', err);
            alert('Could not access microphone');
        });
}

function stopVoiceRecording() {
    if (mediaRecorder && isRecording) {
        mediaRecorder.stop();
        isRecording = false;
        document.getElementById('voiceRecordingModal').style.display = 'none';
    }
}

function sendVoiceMessage(audioBlob) {
    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('incoming_id', selectedUserId);
    formData.append('voice_message', audioBlob, 'voice_message.webm');
    
    $.ajax({
        url: "{{ route('chat.send') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                fetchMessages();
            }
        }
    });
}

// Message actions
function replyToMessage(messageId, messageText) {
    replyToMessageData = { id: messageId, text: messageText };
    document.querySelector('.reply-name').textContent = 'Reply to message';
    document.querySelector('.reply-text').textContent = messageText;
    document.getElementById('replyPreview').style.display = 'block';
}

function cancelReply() {
    replyToMessageData = null;
    document.getElementById('replyPreview').style.display = 'none';
}

// Forward message functionality
function forwardMessage(messageId, messageText) {
    console.log('Forward message called:', messageId, messageText);
    
    forwardMessageData = { id: messageId, text: messageText };
    document.getElementById('forwardMessageContent').textContent = messageText;
    
    // Populate user list for forwarding
    populateForwardUserList();
    
    // Show modal
    document.getElementById('forwardModal').style.display = 'flex';
    
    console.log('Forward modal should be visible now');
}

function populateForwardUserList() {
    const userList = document.getElementById('forwardUserList');
    userList.innerHTML = '';
    
    console.log('Populating forward user list...');
    console.log('Auth ID:', authId);
    console.log('Selected User ID:', selectedUserId);
    
    // Get all users except current user and selected user
    const chatItems = document.querySelectorAll('.chat-item');
    let userCount = 0;
    
    chatItems.forEach(item => {
        const userId = item.getAttribute('data-userid');
        console.log('Processing user ID:', userId);
        
        if (userId && userId != authId && userId != selectedUserId) {
            const userName = item.querySelector('.chat-name').textContent;
            const userImage = item.querySelector('.chat-avatar img').src;
            
            console.log('Adding user to forward list:', userName, 'ID:', userId);
            
            const userElement = document.createElement('div');
            userElement.className = 'forward-user-item';
            userElement.innerHTML = `
                <div class="user-info">
                    <img src="${userImage}" alt="${userName}" class="user-avatar">
                    <span class="user-name">${userName}</span>
                </div>
                <input type="checkbox" class="forward-checkbox" data-user-id="${userId}" onchange="toggleForwardUser('${userId}')">
            `;
            
            userList.appendChild(userElement);
            userCount++;
        }
    });
    
    console.log(`Added ${userCount} users to forward list`);
    
    // Reset selected users
    selectedForwardUsers.clear();
    document.getElementById('confirmForwardBtn').disabled = true;
}

function toggleForwardUser(userId) {
    const checkbox = document.querySelector(`input[data-user-id="${userId}"]`);
    const userIdStr = String(userId);
    
    if (checkbox.checked) {
        selectedForwardUsers.add(userIdStr);
    } else {
        selectedForwardUsers.delete(userIdStr);
    }
    
    // Enable/disable forward button
    const forwardBtn = document.getElementById('confirmForwardBtn');
    forwardBtn.disabled = selectedForwardUsers.size === 0;
    
    console.log('Selected users:', Array.from(selectedForwardUsers));
}

function confirmForward() {
    if (selectedForwardUsers.size === 0 || !forwardMessageData) {
        alert('Please select at least one user to forward the message to.');
        return;
    }
    
    console.log('Forwarding message to users:', Array.from(selectedForwardUsers));
    
    let successCount = 0;
    let errorCount = 0;
    let totalRequests = selectedForwardUsers.size;
    let completedRequests = 0;
    
    // Forward message to selected users
    selectedForwardUsers.forEach(userId => {
        $.ajax({
            url: "{{ route('chat.send') }}",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                incoming_id: userId,
                message: `Forwarded: ${forwardMessageData.text}`
            },
            success: function(response) {
                completedRequests++;
                if (response.success) {
                    successCount++;
                    console.log(`Message forwarded to user ${userId} successfully`);
                } else {
                    errorCount++;
                    console.error('Failed to forward message to user', userId, ':', response.error);
                }
                
                // Check if all requests are completed
                if (completedRequests === totalRequests) {
                    closeForwardModal();
                    if (successCount > 0) {
                        alert(`Message forwarded to ${successCount} user(s)${errorCount > 0 ? ` (${errorCount} failed)` : ''}`);
                    } else {
                        alert('Failed to forward message to any users. Please try again.');
                    }
                }
            },
            error: function(xhr) {
                completedRequests++;
                errorCount++;
                console.error('Error forwarding message to user', userId, ':', xhr);
                
                // Check if all requests are completed
                if (completedRequests === totalRequests) {
                    closeForwardModal();
                    if (successCount > 0) {
                        alert(`Message forwarded to ${successCount} user(s) (${errorCount} failed)`);
                    } else {
                        alert('Failed to forward message to any users. Please try again.');
                    }
                }
            }
        });
    });
}

function closeForwardModal() {
    document.getElementById('forwardModal').style.display = 'none';
    forwardMessageData = null;
    selectedForwardUsers.clear();
    document.getElementById('confirmForwardBtn').disabled = true;
}

// Message search functionality
function toggleSearchMessages() {
    try {
        const overlay = document.getElementById('messageSearchOverlay');
        const chatArea = document.querySelector('.chat-area');
        const searchInput = document.getElementById('messageSearchInput');
        
        if (!overlay || !chatArea || !searchInput) {
            console.error('Search elements not found');
            return;
        }
        
        if (overlay.style.display === 'none' || overlay.style.display === '') {
            overlay.style.display = 'flex';
            chatArea.style.display = 'none';
            searchInput.focus();
            console.log('Search overlay opened');
        } else {
            overlay.style.display = 'none';
            chatArea.style.display = 'flex';
            console.log('Search overlay closed');
        }
    } catch (error) {
        console.error('Error in toggleSearchMessages:', error);
    }
}

function closeMessageSearch() {
    try {
        const overlay = document.getElementById('messageSearchOverlay');
        const chatArea = document.querySelector('.chat-area');
        const searchInput = document.getElementById('messageSearchInput');
        
        if (overlay) overlay.style.display = 'none';
        if (chatArea) chatArea.style.display = 'flex';
        if (searchInput) searchInput.value = '';
        
        clearMessageSearch();
        console.log('Search closed');
    } catch (error) {
        console.error('Error in closeMessageSearch:', error);
    }
}

function clearMessageSearch() {
    try {
        const searchInput = document.getElementById('messageSearchInput');
        const searchResults = document.getElementById('searchResults');
        const noResults = document.querySelector('.no-results');
        
        if (searchInput) searchInput.value = '';
        if (searchResults) searchResults.innerHTML = '';
        if (noResults) noResults.style.display = 'none';
    } catch (error) {
        console.error('Error in clearMessageSearch:', error);
    }
}

function searchMessages() {
    try {
        const searchInput = document.getElementById('messageSearchInput');
        const searchResults = document.getElementById('searchResults');
        const noResults = document.querySelector('.no-results');
        
        if (!searchInput || !searchResults || !noResults) {
            console.error('Search elements not found');
            return;
        }
        
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        console.log('Searching for:', searchTerm);
        console.log('Total messages:', allMessages.length);
        
        if (searchTerm.length < 2) {
            searchResults.innerHTML = '';
            noResults.style.display = 'none';
            return;
        }
        
        // Search through all messages
        const filteredMessages = allMessages.filter(msg => 
            msg.msg && msg.msg.toLowerCase().includes(searchTerm)
        );
        
        console.log('Filtered messages:', filteredMessages.length);
        
        if (filteredMessages.length === 0) {
            searchResults.innerHTML = '';
            noResults.style.display = 'flex';
            return;
        }
    
    noResults.style.display = 'none';
    
    // Group messages by date
    const groupedMessages = {};
    filteredMessages.forEach(msg => {
        const date = new Date(msg.created_at).toDateString();
        if (!groupedMessages[date]) {
            groupedMessages[date] = [];
        }
        groupedMessages[date].push(msg);
    });
    
    // Render search results
    let searchHtml = '';
    Object.keys(groupedMessages).sort((a, b) => new Date(b) - new Date(a)).forEach(date => {
        const messages = groupedMessages[date];
        const dateHeader = formatDateHeader(messages[0].created_at);
        
        searchHtml += `
            <div class="search-date-header">
                <span>${dateHeader}</span>
            </div>
        `;
        
        messages.forEach(msg => {
            const messageTime = new Date(msg.created_at).toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
            
            const messageClass = msg.outgoing_msg_id == authId ? 'sent' : 'received';
            const highlightedText = msg.msg.replace(
                new RegExp(`(${searchTerm})`, 'gi'),
                '<mark>$1</mark>'
            );
            
            searchHtml += `
                <div class="search-result-item" onclick="scrollToMessage(${msg.id})">
                    <div class="search-message ${messageClass}">
                        <div class="search-message-content">${highlightedText}</div>
                        <div class="search-message-time">${messageTime}</div>
                    </div>
                </div>
            `;
        });
    });
    
    searchResults.innerHTML = searchHtml;
    } catch (error) {
        console.error('Error in searchMessages:', error);
    }
}

function scrollToMessage(messageId) {
    // Close search overlay
    closeMessageSearch();
    
    // Find and scroll to the message
    const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
    if (messageElement) {
        messageElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        // Add highlight effect
        messageElement.classList.add('message-highlight');
        setTimeout(() => {
            messageElement.classList.remove('message-highlight');
        }, 2000);
    }
}

// Auto-resize textarea
function autoResize() {
    const textarea = document.getElementById('messageInput');
    textarea.style.height = 'auto';
    textarea.style.height = Math.min(textarea.scrollHeight, 100) + 'px';
}
function sendMessage() {
    if (!selectedUserId) {
        alert('Select a user to chat with.');
        return;
    }

    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    
    if (!message && !selectedFile) {
        alert('Enter a message or choose a file.');
        return;
    }

    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('incoming_id', selectedUserId);
    
    if (message) {
    formData.append('message', message);
    }
    
    if (selectedFile) {
        formData.append('attachment', selectedFile);
    }

    $.ajax({
        url: "{{ route('chat.send') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                // Clear inputs
                messageInput.value = '';
                messageInput.style.height = 'auto';
                removeFile();
                cancelReply();
                
                // Stop typing indicator
                if (isTyping) {
                    isTyping = false;
                    sendTypingStatus(false);
                }
                
                // Fetch new messages
            fetchMessages();
            } else {
                alert('Failed to send message: ' + (response.error || 'Unknown error'));
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to send message. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else if (xhr.status === 422) {
                errorMessage = 'Validation error. Please check your input.';
            }
            alert(errorMessage);
        }
    });
}

// Message deletion
function deleteMessage(messageId) {
    if (!confirm('Are you sure you want to delete this message?')) {
        return;
    }

    $.ajax({
        url: "{{ route('chat.delete') }}",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            message_id: messageId
        },
        success: function (response) {
            if (response.success) {
                const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
                if (messageElement) {
                    messageElement.remove();
                }
            } else {
                alert('Failed to delete the message: ' + (response.error || 'Unknown error'));
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to delete message. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            }
            alert(errorMessage);
        }
    });
}

// Utility functions
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

// Typing indicator functions
function handleTypingStart() {
    if (!selectedUserId) return;
    
    if (!isTyping) {
        isTyping = true;
        sendTypingStatus(true);
    }
}

function handleTyping() {
    if (!selectedUserId) return;
    
    if (typingTimer) {
        clearTimeout(typingTimer);
    }
    
    typingTimer = setTimeout(() => {
        if (isTyping) {
            isTyping = false;
            sendTypingStatus(false);
        }
    }, 2000);
}

function sendTypingStatus(typing) {
    $.ajax({
        url: typing ? "{{ route('chat.typing') }}" : "{{ route('chat.stopped_typing') }}",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            incoming_id: selectedUserId
        },
        success: function(response) {
            console.log('Typing status sent:', typing);
        },
        error: function(xhr) {
            console.error('Error sending typing status:', xhr.responseText);
        }
    });
}

// Additional WhatsApp-like functions
function showNewChatModal() {
    alert('New chat functionality would be implemented here');
}

function toggleSidebarMenu() {
    alert('Sidebar menu functionality would be implemented here');
}


function toggleChatMenu() {
    alert('Chat menu functionality would be implemented here');
}

function openImageViewer(imageSrc) {
    // Open image in full screen
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        cursor: pointer;
    `;
    
    const img = document.createElement('img');
    img.src = imageSrc;
    img.style.cssText = `
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    `;
    
    modal.appendChild(img);
    document.body.appendChild(modal);
    
    modal.onclick = () => {
        document.body.removeChild(modal);
    };
}

// Close menus when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.emoji-picker') && !event.target.closest('.emoji-btn')) {
        emojiPickerVisible = false;
        document.getElementById('emojiPicker').style.display = 'none';
    }
    
    if (!event.target.closest('.attachment-menu') && !event.target.closest('.attach-btn')) {
        attachmentMenuVisible = false;
        document.getElementById('attachmentMenu').style.display = 'none';
    }
});

</script>



<style>
/* Modern WhatsApp-like Chat App Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    height: 100%;
    overflow: hidden;
    position: fixed;
    width: 100%;
}

#app {
    height: 100vh;
    overflow: hidden;
    position: fixed;
    width: 100%;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    height: 100vh;
    overflow: hidden;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
}

.whatsapp-container {
    height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0;
    box-sizing: border-box;
    overflow: hidden;
    position: relative;
}

.chat-app {
    width: 100%;
    height: 100vh;
    max-width: 1200px;
    background: #fff;
    border-radius: 0;
    box-shadow: none;
    display: flex;
    overflow: hidden;
    backdrop-filter: blur(10px);
    border: none;
    box-sizing: border-box;
}

/* Sidebar Styles */
.sidebar {
    width: 400px;
    min-width: 350px;
    max-width: 450px;
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    border-right: 1px solid rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
    position: relative;
    height: 100%;
    overflow: hidden;
}

.sidebar::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 1px;
    height: 100%;
    background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.1) 50%, transparent 100%);
}

.sidebar-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    position: relative;
    flex-shrink: 0;
}

.sidebar-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.1) 50%, transparent 100%);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}

.profile-img:hover {
    transform: scale(1.05);
}

.user-details h6 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111b21;
    letter-spacing: -0.01em;
}

.status {
    font-size: 12px;
    color: #667781;
    font-weight: 500;
}

.status.online {
    color: #00a884;
    position: relative;
}

.status.online::before {
    content: '';
    position: absolute;
    left: -8px;
    top: 50%;
    transform: translateY(-50%);
    width: 6px;
    height: 6px;
    background: #00a884;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; transform: translateY(-50%) scale(1); }
    50% { opacity: 0.5; transform: translateY(-50%) scale(1.2); }
    100% { opacity: 1; transform: translateY(-50%) scale(1); }
}

.sidebar-actions {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 40px;
    height: 40px;
    border: none;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #54656f;
    font-size: 18px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-icon:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    color: #2c3e50;
}

/* Search Container */
.search-container {
    padding: 12px 16px;
    background: transparent;
    flex-shrink: 0;
}

.search-box {
    position: relative;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 25px;
    display: flex;
    align-items: center;
    padding: 12px 16px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.search-box:focus-within {
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    border-color: rgba(0, 168, 132, 0.3);
}

.search-box i {
    color: #667781;
    margin-right: 12px;
    font-size: 16px;
}

.search-box input {
    border: none;
    background: none;
    outline: none;
    flex: 1;
    font-size: 14px;
    color: #111b21;
    font-weight: 400;
}

.search-box input::placeholder {
    color: #667781;
    font-weight: 400;
}

/* Chat List */
.chat-list {
    flex: 1;
    overflow-y: auto;
    min-height: 0;
}

.chat-item {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    cursor: pointer;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
}

.chat-item:hover {
    background: linear-gradient(90deg, rgba(0, 168, 132, 0.05) 0%, rgba(255, 255, 255, 0.8) 100%);
    transform: translateX(4px);
}

.chat-item.active {
    background: linear-gradient(90deg, rgba(0, 168, 132, 0.1) 0%, rgba(255, 255, 255, 0.9) 100%);
    border-left: 3px solid #00a884;
    box-shadow: 0 2px 8px rgba(0, 168, 132, 0.1);
}

.chat-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, #00a884 0%, #008f73 100%);
}

.chat-avatar {
    position: relative;
    margin-right: 12px;
}

.chat-avatar img {
    width: 49px;
    height: 49px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}

.chat-item:hover .chat-avatar img {
    transform: scale(1.05);
}

.status-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.status-indicator.online {
    background: linear-gradient(135deg, #00a884 0%, #008f73 100%);
    animation: pulse 2s infinite;
}

.status-indicator.offline {
    background: linear-gradient(135deg, #667781 0%, #54656f 100%);
}

.chat-info {
    flex: 1;
    min-width: 0;
}

.chat-name {
    font-size: 16px;
    font-weight: 500;
    color: #111b21;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat-last-message {
    font-size: 14px;
    color: #667781;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.chat-time {
    font-size: 12px;
    color: #667781;
}

.unread-count {
    background-color: #00a884;
    color: white;
    font-size: 12px;
    font-weight: 600;
    min-width: 20px;
    height: 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 6px;
}

/* Chat Area */
.chat-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: linear-gradient(135deg, #efeae2 0%, #f7f3f0 100%);
    position: relative;
    height: 100%;
    min-height: 0;
    overflow: hidden;
    max-height: 100vh;
}

/* Ensure chat area is visible on desktop by default */
@media (min-width: 769px) {
    .whatsapp-container {
    padding: 10px;
}

    .chat-app {
        height: calc(100vh - 20px);
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 8px 25px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .sidebar {
        width: 400px;
        min-width: 350px;
        max-width: 450px;
    }
    
    .chat-area {
        display: flex !important;
    }
    
    .message-input-container {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 1000 !important;
        height: 60px !important;
        min-height: 60px !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 100% !important;
    }
}

.chat-area::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="0.5" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="0.3" fill="%23ffffff" opacity="0.05"/><circle cx="50" cy="10" r="0.4" fill="%23ffffff" opacity="0.08"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.chat-header {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 242, 245, 0.9) 100%);
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    backdrop-filter: blur(10px);
    position: relative;
    z-index: 10;
    min-height: 50px;
    flex-shrink: 0;
}

.chat-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.1) 50%, transparent 100%);
}

.chat-user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chat-user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.chat-user-details h6 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111b21;
}

.chat-status {
    font-size: 13px;
    color: #667781;
}

.chat-actions {
    display: flex;
    gap: 8px;
}

/* Welcome Screen */
.welcome-screen {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #efeae2;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="%23000" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
}

.welcome-content {
    text-align: center;
    max-width: 400px;
}

.whatsapp-icon {
    font-size: 64px;
    color: #00a884;
    margin-bottom: 24px;
}

.welcome-content h4 {
    color: #3b4a54;
    margin-bottom: 16px;
    font-weight: 300;
}

.welcome-content p {
    color: #667781;
    line-height: 1.5;
}

/* Messages Container */
.messages-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: transparent;
    position: relative;
    min-height: 0;
    overflow: hidden;
    height: 0;
    max-height: calc(100vh - 180px);
    margin-bottom: 0;
}

.messages {
    flex: 1;
    padding: 16px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 8px;
    position: relative;
    z-index: 1;
    min-height: 0;
    max-height: calc(100vh - 220px);
    padding-bottom: 100px;
    margin-bottom: 0;
}

/* Message Styles */
.message {
    display: flex;
    margin-bottom: 8px;
    animation: messageSlideIn 0.3s ease-out;
}

.message.sent {
    justify-content: flex-end;
}

.message.received {
    justify-content: flex-start;
}

.message-bubble {
    max-width: 65%;
    padding: 12px 16px;
    border-radius: 20px;
    position: relative;
    word-wrap: break-word;
    backdrop-filter: blur(10px);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.message-bubble:hover {
    transform: translateY(-1px);
}

.message.sent .message-bubble {
    background: linear-gradient(135deg, #d9fdd3 0%, #c8f7c5 100%);
    border-bottom-right-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.message.received .message-bubble {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.95) 100%);
    border-bottom-left-radius: 6px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.5);
}

.message-text {
    font-size: 14px;
    line-height: 1.4;
    color: #111b21;
    margin-bottom: 4px;
}

.message-time {
    font-size: 11px;
    color: #667781;
    text-align: right;
    margin-top: 4px;
}

.message.sent .message-time {
    color: #53bdeb;
}

.message-status {
    display: inline-flex;
    margin-left: 4px;
}

.message-status i {
    font-size: 10px;
    color: #53bdeb;
}

.message-status.read i {
    color: #4fc3f7;
}

/* Typing Indicator */
.typing-indicator {
    padding: 0 20px 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.typing-dots {
    display: flex;
    gap: 4px;
    background: #fff;
    padding: 8px 16px;
    border-radius: 18px;
    box-shadow: 0 1px 0.5px rgba(0, 0, 0, 0.13);
}

.typing-dots span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #667781;
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dots span:nth-child(1) { animation-delay: -0.32s; }
.typing-dots span:nth-child(2) { animation-delay: -0.16s; }

.typing-text {
    font-size: 12px;
    color: #667781;
    font-style: italic;
}

@keyframes typing {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}

/* Message Input */
.message-input-container {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 242, 245, 0.9) 100%);
    padding: 12px 16px;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
    backdrop-filter: blur(10px);
    position: fixed !important;
    bottom: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 1000 !important;
    min-height: 60px;
    height: 60px;
    flex-shrink: 0;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    width: 100% !important;
    box-sizing: border-box;
}

.message-input-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.1) 50%, transparent 100%);
}

/* Ensure input bar is always visible */
.chat-area {
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
}

/* Ensure proper bottom spacing */
.chat-area::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: transparent;
    pointer-events: none;
    z-index: 99;
}

.input-wrapper {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 25px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    padding: 12px 16px;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    min-height: 50px;
    height: 50px;
    width: 100%;
    box-sizing: border-box;
    position: relative;
}

.input-wrapper:focus-within {
    border-color: rgba(0, 168, 132, 0.3);
    box-shadow: 0 4px 16px rgba(0, 168, 132, 0.1);
    background: rgba(255, 255, 255, 1);
}

.emoji-btn {
    color: #54656f;
    font-size: 20px;
    transition: all 0.3s ease;
    padding: 8px;
    border-radius: 50%;
}

.emoji-btn:hover {
    background: rgba(0, 168, 132, 0.1);
    color: #00a884;
    transform: scale(1.1);
}

.input-area {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.reply-preview, .file-preview {
    background: linear-gradient(135deg, rgba(0, 168, 132, 0.1) 0%, rgba(0, 168, 132, 0.05) 100%);
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 8px;
    border-left: 4px solid #00a884;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 8px rgba(0, 168, 132, 0.1);
}

.reply-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.reply-name {
    font-size: 12px;
    font-weight: 600;
    color: #00a884;
}

.reply-text {
    font-size: 12px;
    color: #667781;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.file-info i {
    color: #54656f;
}

.input-row {
    display: flex;
    align-items: flex-end;
    gap: 8px;
}

.message-input-wrapper {
    flex: 1;
    min-height: 20px;
}

.message-input-wrapper textarea {
    width: 100%;
    border: none;
    outline: none;
    resize: none;
    font-size: 14px;
    line-height: 20px;
    max-height: 100px;
    background: transparent;
    color: #111b21;
}

.message-input-wrapper textarea::placeholder {
    color: #667781;
}

.message-input-wrapper textarea:disabled {
    background: rgba(255, 255, 255, 0.5);
    color: #999;
    cursor: not-allowed;
}

.message-input-wrapper textarea:disabled::placeholder {
    color: #999;
}

.attach-btn, .voice-btn, .send-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s ease;
    position: relative;
}

.attach-btn, .voice-btn {
    background: rgba(255, 255, 255, 0.8);
    color: #54656f;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.attach-btn:hover, .voice-btn:hover {
    background: rgba(0, 168, 132, 0.1);
    color: #00a884;
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0, 168, 132, 0.2);
}

.send-btn {
    background: linear-gradient(135deg, #00a884 0%, #008f73 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(0, 168, 132, 0.3);
}

.send-btn:hover {
    background: linear-gradient(135deg, #008f73 0%, #007a65 100%);
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 168, 132, 0.4);
}

.send-btn:active {
    transform: scale(0.95);
}

/* Emoji Picker */
.emoji-picker {
    position: absolute;
    bottom: 80px;
    left: 16px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    padding: 16px;
    max-width: 300px;
    z-index: 1000;
}

.emoji-grid {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 8px;
    max-height: 200px;
    overflow-y: auto;
}

.emoji-item {
    padding: 8px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 20px;
    text-align: center;
    transition: background-color 0.2s;
}

.emoji-item:hover {
    background-color: #f0f2f5;
}

/* Attachment Menu */
.attachment-menu {
    position: absolute;
    bottom: 80px;
    left: 16px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    padding: 8px 0;
    min-width: 200px;
    z-index: 1000;
}

.attachment-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.attachment-option:hover {
    background-color: #f0f2f5;
}

.attachment-option i {
    width: 20px;
    color: #54656f;
}

.attachment-option span {
    font-size: 14px;
    color: #111b21;
}

/* Voice Recording Modal */
.voice-recording-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}

.voice-recording-content {
    background: #fff;
    padding: 32px;
    border-radius: 8px;
    text-align: center;
    min-width: 300px;
}

.voice-wave {
    display: flex;
    justify-content: center;
    gap: 4px;
    margin-bottom: 16px;
}

.wave {
    width: 4px;
    height: 20px;
    background: #00a884;
    border-radius: 2px;
    animation: wave 1s infinite ease-in-out;
}

.wave:nth-child(1) { animation-delay: 0s; }
.wave:nth-child(2) { animation-delay: 0.2s; }
.wave:nth-child(3) { animation-delay: 0.4s; }

@keyframes wave {
    0%, 100% { height: 20px; }
    50% { height: 40px; }
}

/* Forward Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    backdrop-filter: blur(5px);
}

.modal-content {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.95) 100%);
    border-radius: 20px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, rgba(0, 168, 132, 0.1) 0%, rgba(0, 168, 132, 0.05) 100%);
}

.modal-header h3 {
    margin: 0;
    color: #111b21;
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.modal-header h3 i {
    color: #00a884;
}

.close-btn {
    background: none;
    border: none;
    font-size: 24px;
    color: #667781;
    cursor: pointer;
    padding: 4px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.close-btn:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #111b21;
}

.modal-body {
    padding: 24px;
    max-height: 60vh;
    overflow-y: auto;
}

.forward-preview {
    margin-bottom: 24px;
}

.forward-message-preview {
    background: linear-gradient(135deg, rgba(0, 168, 132, 0.1) 0%, rgba(0, 168, 132, 0.05) 100%);
    padding: 16px;
    border-radius: 12px;
    border-left: 4px solid #00a884;
    backdrop-filter: blur(10px);
}

.forward-label {
    font-size: 12px;
    color: #00a884;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    display: block;
}

.forward-message-content {
    color: #111b21;
    font-size: 14px;
    line-height: 1.4;
    max-height: 60px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.forward-to-section h4 {
    margin: 0 0 16px 0;
    color: #111b21;
    font-size: 16px;
    font-weight: 600;
}

.forward-user-list {
    max-height: 200px;
    overflow-y: auto;
}

.forward-user-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
    border: 1px solid transparent;
}

.forward-user-item:hover {
    background: rgba(0, 168, 132, 0.05);
    border-color: rgba(0, 168, 132, 0.2);
}

.forward-user-item .user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.forward-user-item .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.forward-user-item .user-name {
    color: #111b21;
    font-size: 14px;
    font-weight: 500;
}

.forward-checkbox {
    width: 20px;
    height: 20px;
    accent-color: #00a884;
    cursor: pointer;
}

.modal-footer {
    padding: 20px 24px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    background: rgba(255, 255, 255, 0.5);
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary {
    background: rgba(0, 0, 0, 0.1);
    color: #667781;
}

.btn-secondary:hover {
    background: rgba(0, 0, 0, 0.2);
    color: #111b21;
}

.btn-primary {
    background: linear-gradient(135deg, #00a884 0%, #008f73 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(0, 168, 132, 0.3);
}

.btn-primary:hover:not(:disabled) {
    background: linear-gradient(135deg, #008f73 0%, #007a65 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 168, 132, 0.4);
}

.btn-primary:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* Message Search Overlay Styles */
.message-search-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #efeae2 0%, #f7f3f0 100%);
    display: flex;
    flex-direction: column;
    z-index: 2000;
    width: 100%;
    height: 100vh;
}

.search-header {
    padding: 16px 20px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 242, 245, 0.9) 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 12px;
    backdrop-filter: blur(10px);
}

.search-input-wrapper {
    flex: 1;
    position: relative;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 25px;
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.search-input-wrapper input {
    flex: 1;
    border: none;
    background: none;
    outline: none;
    font-size: 14px;
    color: #111b21;
    font-weight: 400;
}

.search-input-wrapper input::placeholder {
    color: #667781;
    font-weight: 400;
}

.search-results {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    max-height: calc(100vh - 120px);
}

.search-date-header {
    text-align: center;
    margin: 20px 0 16px 0;
    position: relative;
}

.search-date-header span {
    background: rgba(0, 168, 132, 0.1);
    color: #00a884;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.search-result-item {
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    border-radius: 12px;
    padding: 8px;
}

.search-result-item:hover {
    background: rgba(0, 168, 132, 0.05);
}

.search-message {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.search-message.sent {
    align-items: flex-end;
}

.search-message.received {
    align-items: flex-start;
}

.search-message-content {
    background: rgba(255, 255, 255, 0.8);
    padding: 8px 12px;
    border-radius: 12px;
    max-width: 70%;
    font-size: 14px;
    line-height: 1.4;
    color: #111b21;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.search-message.sent .search-message-content {
    background: linear-gradient(135deg, rgba(217, 253, 211, 0.8) 0%, rgba(200, 247, 197, 0.8) 100%);
    border-color: rgba(255, 255, 255, 0.3);
}

.search-message-time {
    font-size: 11px;
    color: #667781;
    margin-top: 2px;
}

.no-results {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
    color: #667781;
}

.no-results i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.no-results p {
    font-size: 16px;
    font-weight: 500;
}

/* Message highlight effect */
.message-highlight {
    animation: messageHighlight 2s ease-in-out;
}

@keyframes messageHighlight {
    0% { background-color: rgba(255, 235, 59, 0.3); }
    50% { background-color: rgba(255, 235, 59, 0.6); }
    100% { background-color: transparent; }
}

/* Search highlight */
mark {
    background: linear-gradient(135deg, #fff59d 0%, #ffeb3b 100%);
    color: #333;
    padding: 2px 4px;
    border-radius: 4px;
    font-weight: 600;
}

/* Animations */
@keyframes messageSlideIn {
    from {
        transform: translateY(10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive Design */

/* Scrollbar Styles */
.messages::-webkit-scrollbar,
.chat-list::-webkit-scrollbar,
.emoji-grid::-webkit-scrollbar {
    width: 6px;
}

.messages::-webkit-scrollbar-track,
.chat-list::-webkit-scrollbar-track,
.emoji-grid::-webkit-scrollbar-track {
    background: transparent;
}

.messages::-webkit-scrollbar-thumb,
.chat-list::-webkit-scrollbar-thumb,
.emoji-grid::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

.messages::-webkit-scrollbar-thumb:hover,
.chat-list::-webkit-scrollbar-thumb:hover,
.emoji-grid::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.3);
}

.d-none {
    display: none !important;
}

/* Additional WhatsApp-style features */
.date-separator {
    text-align: center;
    margin: 20px 0;
    color: #667781;
    font-size: 12px;
    font-weight: 500;
    position: relative;
}

.date-separator::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e9edef;
    z-index: 1;
}

.date-separator::after {
    content: attr(data-date);
    background: #efeae2;
    padding: 0 16px;
    position: relative;
    z-index: 2;
}

.message-actions {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #fff;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    display: none;
    gap: 4px;
    padding: 4px;
}

.message:hover .message-actions {
    display: flex;
}

.message-actions button {
    width: 28px;
    height: 28px;
    border: none;
    background: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #54656f;
    transition: background-color 0.2s;
}

.message-actions button:hover {
    background-color: #f0f2f5;
}

.message-image img {
    max-width: 200px;
    max-height: 200px;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s;
}

.message-image img:hover {
    transform: scale(1.05);
}

.message-file {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    margin-top: 4px;
}

.message-file a {
    color: inherit;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.message-file i {
    color: #00a884;
}

/* Mobile responsiveness improvements */
@media (max-width: 768px) {
    .whatsapp-container {
        height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        padding: 0;
        overflow: hidden;
    }
    
    .chat-app {
        width: 100%;
        height: 100vh;
        border-radius: 0;
        box-shadow: none;
        border: none;
    }
    
    .sidebar {
        width: 100%;
        position: absolute;
        z-index: 10;
        transition: transform 0.3s ease;
        height: 100vh;
        overflow: hidden;
    }
    
    .sidebar.hidden {
        transform: translateX(-100%);
    }
    
    .chat-area {
        display: none !important;
    }
    
    .chat-area.active {
        display: flex !important;
        width: 100%;
        height: 100vh;
        max-height: 100vh;
        overflow: hidden;
    }
    
    .messages-container {
        max-height: calc(100vh - 180px);
    overflow-y: auto;
        margin-bottom: 0;
    }
    
    .messages {
        max-height: calc(100vh - 220px);
        padding-bottom: 80px;
    }
    
    .message-input-container {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 1000 !important;
        height: 60px !important;
        min-height: 60px !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 100% !important;
    }
    
    .message-bubble {
        max-width: 85%;
        padding: 10px 14px;
    }
    
    .chat-item {
        padding: 12px 16px;
    }
    
    .sidebar-header {
        padding: 12px 16px;
    }
    
    .search-container {
        padding: 12px 16px;
    }
    
    .message-input-container {
        padding: 12px 16px;
    }
    
    .emoji-picker {
        bottom: 100px;
        left: 10px;
        right: 10px;
        max-width: none;
        border-radius: 15px;
    }
    
    .attachment-menu {
        bottom: 100px;
        left: 10px;
        right: 10px;
        min-width: auto;
        border-radius: 15px;
    }
    
    .btn-icon {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }
    
    .attach-btn, .voice-btn, .send-btn {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
}

/* Tablet Responsive */
@media (max-width: 1024px) and (min-width: 769px) {
    .sidebar {
        width: 40%;
    }
    
    .chat-item {
        padding: 14px 18px;
    }
    
    .message-bubble {
        max-width: 70%;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .chat-app {
        background: #111b21;
        color: #e9edef;
    }
    
    .sidebar {
        background: #2a2f32;
        border-right-color: #3b4a54;
    }
    
    .sidebar-header {
        background: #2a2f32;
        border-bottom-color: #3b4a54;
    }
    
    .chat-area {
        background: #0b141a;
    }
    
    .chat-header {
        background: #2a2f32;
        border-bottom-color: #3b4a54;
    }
    
    .messages-container {
        background: #0b141a;
    }
    
    .message-input-container {
        background: #2a2f32;
        border-top-color: #3b4a54;
    }
    
    .input-wrapper {
        background: #2a2f32;
        border-color: #3b4a54;
    }
}
</style>



@endsection
