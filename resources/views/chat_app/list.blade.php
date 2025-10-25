@extends('admin.admin_master')
@section('admin')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('backend/assets/css/chat-app.css') }}">

<div class="container-fluid p-0 h-100" style="overflow-x: hidden; overflow-y: auto; background: linear-gradient(135deg, #e0e7ff 0%, #f3e8ff 100%); position: relative;">
    <div class="row g-0 h-100" style="overflow: visible; position: relative; z-index: 1;">
        <!-- Left Sidebar -->
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 shadow-lg" style="border: none; border-radius: 0;">
            <!-- Header -->
            <div class="card-header text-white d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 1.25rem;">
                <div class="d-flex align-items-center">
                    <img src="/upload/admin-images/{{ auth()->user()->profile_image ?: 'default.jpg' }}" 
                         alt="Profile" 
                         class="rounded-circle me-3 border border-light shadow-sm"
                         width="45"
                         height="45"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiM2Njc3ODEiLz4KPHN2ZyB4PSIxMCIgeT0iMTAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Ik0yMCAyMXYtMmEyIDIgMCAwIDAtMi0yaC0xMmEyIDIgMCAwIDAtMiAydjIiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ii8+Cjwvc3ZnPgo8L3N2Zz4K'">
                    <div>
                        <h6 class="mb-0 text-white fw-bold">{{ auth()->user()->name }}</h6>
                        <small class="text-light opacity-75">Online</small>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-light rounded-circle" type="button" data-bs-toggle="dropdown" style="width: 36px; height: 36px; border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="showNewChatModal()"><i class="fas fa-plus me-2"></i>New Chat</a></li>
                        <li><a class="dropdown-item" href="#" onclick="showSettings()"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div> 

            <!-- Search -->
            <div class="p-3" style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                <div class="input-group" style="border-radius: 25px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <span class="input-group-text bg-white border-0" style="border-radius: 25px 0 0 25px;"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control border-0" placeholder="Search or start new chat" id="searchInput" onkeyup="searchChats()" style="background: white; border-radius: 0;">
                    <button class="btn btn-outline-secondary border-0" type="button" onclick="clearSearch()" style="border-radius: 0 25px 25px 0; background: white;">
                        <i class="fas fa-times text-muted"></i>
                    </button>
                </div>
            </div> 

            <!-- Chat List -->
            <div class="card-body p-0" id="chatList" style="height: calc(100vh - 200px); overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch;">
                @if(count($users) > 0)
                @foreach($users as $user)
                    <div class="border-bottom" onclick="openChat({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->profile_image }}', {{ $user->status }})" data-userid="{{ $user->id }}" style="border: none !important; margin: 2px 8px; border-radius: 12px; transition: all 0.3s ease; cursor: pointer;">
                        <div class="d-flex align-items-center p-3 hover-bg" style="border-radius: 12px; transition: all 0.3s ease;">
                            <div class="position-relative me-3">
                                <img src="/upload/admin-images/{{ $user->profile_image ?: 'default.jpg' }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle border border-light shadow-sm" 
                                     width="50" 
                                     height="50"
                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDUiIGhlaWdodD0iNDUiIHZpZXdCb3g9IjAgMCA0NSA0NSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjIuNSIgY3k9IjIyLjUiIHI9IjIyLjUiIGZpbGw9IiM2Njc3ODEiLz4KPHN2ZyB4PSIxMSIgeT0iMTEiIHdpZHRoPSIyMyIgaGVpZ2h0PSIyMyIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Ik0yMCAyMXYtMmEyIDIgMCAwIDAtMi0yaC0xMmEyIDIgMCAwIDAtMiAydjIiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ii8+Cjwvc3ZnPgo8L3N2Zz4K'">
                                <span class="position-absolute bottom-0 end-0 badge rounded-pill {{ $user->status == 0 ? 'bg-success' : 'bg-secondary' }}" style="width: 12px; height: 12px; padding: 0; border: 2px solid white;"></span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.95rem; letter-spacing: 0.3px;">{{ $user->name }}</h6>
                                    <small class="text-muted" id="lastTime_{{ $user->id }}" style="font-size: 0.7rem; font-weight: 500;">Now</small>
                                </div>
                                <p class="mb-0 text-muted small" id="lastMessage_{{ $user->id }}" style="font-size: 0.85rem; line-height: 1.4; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Click to start chatting</p>
                            </div>
                            <div class="ms-2">
                                <span class="badge bg-primary rounded-pill d-none" id="unread_{{ $user->id }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4); font-size: 0.7rem; min-width: 20px; padding: 0.25rem 0.5rem;">0</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                    <div class="text-center p-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No contacts available</h6>
                        <p class="text-muted small">Start a new conversation</p>
                    </div>
                @endif
            </div>
            </div>
        </div>

        <!-- Right Chat Area -->
        <div class="col-md-8 col-lg-9" style="overflow: visible;">
            <div class="card h-100 shadow-lg" style="overflow: visible; border: none; border-radius: 0;">
            <!-- Chat Header -->
            <div class="card-header bg-white border-bottom" id="chatHeader" style="border: none; padding: 1.25rem; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary me-2 mobile-chat-toggle d-md-none" onclick="toggleChatSidebar()" title="Toggle Chat List">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="position-relative me-3">
                            <img src="/upload/admin-images/default.jpg" id="chatUserImage" class="rounded-circle border border-light shadow-sm" width="50" height="50" alt="User" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDUiIGhlaWdodD0iNDUiIHZpZXdCb3g9IjAgMCA0NSA0NSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjIuNSIgY3k9IjIyLjUiIHI9IjIyLjUiIGZpbGw9IiM2Njc3ODEiLz4KPHN2ZyB4PSIxMSIgeT0iMTEiIHdpZHRoPSIyMyIgaGVpZ2h0PSIyMyIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Ik0yMCAyMXYtMmEyIDIgMCAwIDAtMi0yaC0xMmEyIDIgMCAwIDAtMiAydjIiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ii8+Cjwvc3ZnPgo8L3N2Zz4K'">
                            <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-secondary" id="chatUserStatusIndicator" style="width: 14px; height: 14px; padding: 0; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark" id="chatUserName">Repu Chat</h6>
                            <small class="text-muted" id="chatUserStatus">Select a contact to start chatting</small>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-secondary rounded-circle" onclick="toggleSearchMessages()" title="Search Messages" style="width: 36px; height: 36px; border: 1px solid #e9ecef;">
                            <i class="fas fa-search"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button" data-bs-toggle="dropdown" title="More Options" style="width: 36px; height: 36px; border: 1px solid #e9ecef;">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="viewContactInfo()"><i class="fas fa-user me-2"></i>View Contact</a></li>
                                <li><a class="dropdown-item" href="#" onclick="clearChat()"><i class="fas fa-trash me-2"></i>Clear Chat</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Content Area -->
            <div class="card-body p-0 d-flex flex-column" style="height: calc(100vh - 80px); overflow: hidden; position: relative;">
                
                <!-- Welcome Screen -->
                <div class="w-100 d-flex align-items-center justify-content-center flex-grow-1" id="welcomeScreen" style="display: flex; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="text-center p-4">
                        <div class="mb-4">
                            <div class="d-inline-block p-4 rounded-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);">
                                <i class="fas fa-comments fa-3x text-white"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold text-dark mb-3">Welcome to Repu Chat</h3>
                        <p class="text-muted mb-4 fs-5">Send and receive messages instantly. Select a contact from the sidebar to start chatting.</p>
                        <div class="row g-3 justify-content-center">
                            <div class="col-auto">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    <small>Secure & Private</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-bolt me-2"></i>
                                    <small>Instant Delivery</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-mobile-alt me-2"></i>
                                    <small>Cross Platform</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Search Overlay -->
                <div class="message-search-overlay position-absolute w-100 h-100" id="messageSearchOverlay" style="display: none; top: 0; left: 0; background: white; z-index: 20;">
                    <div class="search-header p-3 border-bottom">
                        <button class="btn btn-sm btn-outline-secondary me-2" onclick="closeMessageSearch()" title="Close Search">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div class="d-flex">
                            <input type="text" id="messageSearchInput" placeholder="Search messages..." autocomplete="off" class="form-control">
                            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="clearMessageSearch()" title="Clear">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="search-results p-3" id="searchResults" style="height: calc(100% - 70px); overflow-y: auto;">
                        <div class="no-results text-center" style="display: none;">
                            <i class="fas fa-search fa-2x text-muted mb-3"></i>
                            <p class="text-muted">No messages found</p>
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="d-flex flex-column flex-grow-1" id="messagesContainer" style="display: none;">
                    <!-- Messages Display Area -->
                    <div class="messages p-3 flex-grow-1" id="chatMessages" style="overflow-y: auto; overflow-x: hidden; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%);">
                        <!-- Messages will be loaded here -->
                    </div>
                
                    <!-- Typing Indicator -->
                    <div class="typing-indicator p-3 border-top" id="typingIndicator" style="display: none;">
                        <div class="d-flex align-items-center">
                            <div class="typing-dots me-2">
                                <span class="badge bg-secondary rounded-circle" style="width: 6px; height: 6px; animation: typing 1.4s infinite ease-in-out;"></span>
                                <span class="badge bg-secondary rounded-circle" style="width: 6px; height: 6px; animation: typing 1.4s infinite ease-in-out 0.2s;"></span>
                                <span class="badge bg-secondary rounded-circle" style="width: 6px; height: 6px; animation: typing 1.4s infinite ease-in-out 0.4s;"></span>
                            </div>
                            <small class="text-muted">typing...</small>
                        </div>
                    </div>
                </div>

                <!-- Simple Message Input Bar -->
                <div id="messageInputContainer" style="position: fixed; bottom: 0; left: 0; right: 0; background: white; border-top: 1px solid #ddd; padding: 15px; z-index: 1000; box-shadow: 0 -2px 10px rgba(0,0,0,0.1);">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-secondary" onclick="document.getElementById('fileInput').click()" style="border-radius: 50%; width: 40px; height: 40px; padding: 0;" title="Attach File">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <input type="file" id="fileInput" class="d-none" accept="*/*" onchange="handleFileSelect(this)">
                        <input type="text" id="messageInput" class="form-control" placeholder="Type a message..." disabled style="border-radius: 25px; padding: 12px 20px; border: 1px solid #ddd;" onkeypress="if(event.key==='Enter') sendMessage()">
                        <button class="btn btn-primary" onclick="sendMessage()" style="border-radius: 50%; width: 45px; height: 45px; padding: 0;" title="Send Message">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
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

// Helper function to escape HTML and prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Helper function to format date headers
function formatDateHeader(dateString) {
    const date = new Date(dateString);
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);
    
    if (date.toDateString() === today.toDateString()) {
        return 'Today';
    } else if(date.toDateString() === yesterday.toDateString()) {
        return 'Yesterday';
    } else{
        return date.toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
    }
}

// Helper function to format time
function formatTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: true 
    });
}

// Force hide welcome screen and show messages
function forceShowChatArea() {
    const welcomeScreen = document.getElementById('welcomeScreen');
    const messagesContainer = document.getElementById('messagesContainer');
    const messageInputContainer = document.getElementById('messageInputContainer');
    
    if (welcomeScreen) {
        welcomeScreen.classList.add('hidden');
        welcomeScreen.style.display = 'none';
        welcomeScreen.style.visibility = 'hidden';
        welcomeScreen.style.opacity = '0';
        welcomeScreen.style.pointerEvents = 'none';
        welcomeScreen.style.zIndex = '-1';
    }   
    
    if (messagesContainer) {
        messagesContainer.style.display = 'flex';
        messagesContainer.style.visibility = 'visible';
        messagesContainer.style.opacity = '1';
        messagesContainer.style.zIndex = '1';
    }
    
    if (messageInputContainer) {
        messageInputContainer.style.display = 'block';
        messageInputContainer.style.visibility = 'visible';
        messageInputContainer.style.flexShrink = '0';
    }
}

// Reset chat to welcome screen (when no user selected)
function resetToWelcomeScreen() {
    // Reset selected user
    selectedUserId = null;
    selectedUserName = '';
    selectedUserImage = '';
    selectedUserStatus = 0;
    
    // Clear any active chat selection
    document.querySelectorAll('.border-bottom').forEach(item => {
        item.classList.remove('active', 'bg-primary', 'text-white');
    });
    
    // Show welcome screen and hide messages
    const welcomeScreen = document.getElementById('welcomeScreen');
    const messagesContainer = document.getElementById('messagesContainer');
    const messageInputContainer = document.getElementById('messageInputContainer');
    
    welcomeScreen.classList.remove('hidden');
    welcomeScreen.style.display = 'flex';
    messagesContainer.style.display = 'none';
    // Keep input container visible
    messageInputContainer.style.display = 'block';
    messageInputContainer.style.flexShrink = '0';
    
    // Clear any intervals
    if (chatInterval) {
        clearInterval(chatInterval);
        chatInterval = null;
    }
}

// Function to close current chat and return to welcome screen
function closeCurrentChat() {
    if (selectedUserId) {
        resetToWelcomeScreen();
        showToast('Chat closed', 'info');
    }
}

// Image viewer function
function openImageViewer(imageSrc) {
    // Create image viewer modal
    const modal = document.createElement('div');
    modal.className = 'image-viewer-modal';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    `;
    
    const img = document.createElement('img');
    img.src = imageSrc;
    img.style.cssText = `
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 8px;
    `;
    
    modal.appendChild(img);
    document.body.appendChild(modal);
    
    // Close on click
    modal.addEventListener('click', () => {
        document.body.removeChild(modal);
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.body.contains(modal)) {
            document.body.removeChild(modal);
        }
    });
}

// Voice message playback function
function playVoiceMessage(filename) {
    const audio = document.getElementById(`voice-${filename}`);
    const button = event.target.closest('button');
    const icon = button.querySelector('i');
    
    if (!audio) {
        showToast('Audio file not found', 'error');
        return;
    }
    
    // Stop all other voice messages
    document.querySelectorAll('audio').forEach(a => {
        if (a !== audio && !a.paused) {
            a.pause();
            a.currentTime = 0;
            const otherButton = document.querySelector(`button[onclick*="${a.id.replace('voice-', '')}"]`);
            if (otherButton) {
                const otherIcon = otherButton.querySelector('i');
                otherIcon.className = 'fas fa-play';
            }
        }
    });
    
    if (audio.paused) {
        audio.play().then(() => {
            icon.className = 'fas fa-pause';
            showToast('Playing voice message...', 'info');
        }).catch(err => {
            showToast('Could not play audio', 'error');
        });
        
        audio.addEventListener('ended', () => {
            icon.className = 'fas fa-play';
        });
    } else {
        audio.pause();
        audio.currentTime = 0;
        icon.className = 'fas fa-play';
    }
}

function openChat(userId, userName, userImage, userStatus) {
    selectedUserId = userId;
    selectedUserName = userName;
    selectedUserImage = userImage;
    selectedUserStatus = userStatus;
    
    // Update chat selection with smooth transition
    document.querySelectorAll('.border-bottom').forEach(item => {
        item.classList.remove('active', 'bg-primary', 'text-white');
    });
    const selectedChatItem = document.querySelector(`[data-userid="${userId}"]`);
    if (selectedChatItem) {
        selectedChatItem.classList.add('active', 'bg-primary', 'text-white');
    }
    
    document.getElementById('chatUserImage').src = '/upload/admin-images/' + (userImage || 'default.jpg');
    document.getElementById('chatUserImage').onerror = function() {
        this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDUiIGhlaWdodD0iNDUiIHZpZXdCb3g9IjAgMCA0NSA0NSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjIuNSIgY3k9IjIyLjUiIHI9IjIyLjUiIGZpbGw9IiM2Njc3ODEiLz4KPHN2ZyB4PSIxMSIgeT0iMTEiIHdpZHRoPSIyMyIgaGVpZ2h0PSIyMyIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Ik0yMCAyMXYtMmEyIDIgMCAwIDAtMi0yaC0xMmEyIDIgMCAwIDAtMiAydjIiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0Ii8+Cjwvc3ZnPgo8L3N2Zz4K';
    };
    
    document.getElementById('chatUserName').textContent = userName;
    document.getElementById('chatUserStatus').innerHTML = `
        <i class="fas fa-circle text-${userStatus == 0 ? 'success' : 'secondary'} me-1" style="font-size: 0.6rem;"></i>
        ${userStatus == 0 ? 'Online' : 'Last seen recently'}
    `;
    
    forceShowChatArea();
    clearEmptyState();
    showChatLoadingState();
    
    lastTimestamp = null;
    lastRenderedDate = null;
    renderedMessageIds.clear();
    
    fetchMessagesWithLoading(true);

    if (chatInterval) clearInterval(chatInterval);
    chatInterval = setInterval(() => {
        if (isAtBottom && selectedUserId) {
            fetchMessages();
        }
    }, 500); 
}

function showChatLoadingState() {
    const welcomeScreen = document.getElementById('welcomeScreen');
    const messagesContainer = document.getElementById('messagesContainer');
    const messageInputContainer = document.getElementById('messageInputContainer');
    
    welcomeScreen.classList.add('hidden');
    welcomeScreen.style.display = 'none';
    messagesContainer.style.display = 'flex';
    messageInputContainer.style.display = 'block';
    messageInputContainer.style.flexShrink = '0';
    
    document.getElementById('chatMessages').innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
            <div class="text-center">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="text-muted">Loading messages...</div>
            </div>
        </div>
    `;
    
    // Disable message input temporarily
    document.getElementById('messageInput').disabled = true;
    document.getElementById('messageInput').placeholder = 'Loading...';
}

// Show empty chat state
function showEmptyChatState() {
    document.getElementById('chatMessages').innerHTML = `
        <div class="d-flex flex-column justify-content-center align-items-center text-center" style="height: 400px; padding: 2rem;">
            <div class="mb-4">
                <div class="empty-chat-icon">
                    <i class="fas fa-comments fa-4x text-primary mb-3"></i>
                </div>
            </div>
            <h4 class="text-dark mb-3 fw-bold">No messages yet</h4>
            <p class="text-muted mb-4 fs-5">Start the conversation with <span class="text-primary fw-bold">${selectedUserName}</span></p>
            <div class="empty-chat-card">
                <div class="d-flex align-items-center text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Send your first message to begin chatting</small>
                </div>
            </div>
        </div>
    `;
}

// Clear empty state when messages exist
function clearEmptyState() {
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        // Remove empty state elements
        const emptyStateElements = chatMessages.querySelectorAll('.empty-chat-icon, .empty-chat-card');
        emptyStateElements.forEach(element => element.remove());
        
        // Remove empty state text
        const emptyStateText = chatMessages.querySelector('h4');
        if (emptyStateText && emptyStateText.textContent.includes('No messages yet')) {
            emptyStateText.remove();
        }
        
        const emptyStateDesc = chatMessages.querySelector('p');
        if (emptyStateDesc && emptyStateDesc.textContent.includes('Start the conversation')) {
            emptyStateDesc.remove();
        }
        
        // Remove empty state info card
        const emptyStateInfo = chatMessages.querySelector('.empty-chat-card');
        if (emptyStateInfo) {
            emptyStateInfo.remove();
        }
    }
}

// Enhanced message fetching with loading states and error handling
function fetchMessagesWithLoading(initial = false) {
    if (!selectedUserId) {
        return;    
    }

    $.ajax({
        url: "{{ route('chat.fetch') }}",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            receiver_id: selectedUserId,
            incoming_id: selectedUserId,
            last_time: lastTimestamp,
            initial: initial ? 1 : 0
        },
        success: function(response) {
            hideChatLoadingState();
            
            if (Array.isArray(response) && response.length > 0) {
                displayMessages(response, initial);
                // Clear any empty state when messages exist
                clearEmptyState();
            } else {
                if (initial) {
                    showEmptyChatState();
                }
            }
            
            // Enable message input
            const messageInput = document.getElementById('messageInput');
            if (messageInput) {
                messageInput.disabled = false;
                messageInput.placeholder = `Message ${selectedUserName}...`;
            }
        },
        error: function(xhr, status, error) {
            hideChatLoadingState();
            showChatErrorState(xhr, error);
        }
    });
}

// Hide loading state
function hideChatLoadingState() {
    // Remove any loading spinners
    const loadingSpinner = document.querySelector('.spinner-border');
    if (loadingSpinner) {
        loadingSpinner.closest('.d-flex').remove();
    }
}

// Show error state
function showChatErrorState(xhr, error) {
    let errorMessage = 'Failed to load messages';
    let errorDetails = '';
    
    if (xhr.status === 401) {
        errorMessage = 'Authentication required';
        errorDetails = 'Please log in again to continue chatting';
    } else if (xhr.status === 403) {
        errorMessage = 'Access denied';
        errorDetails = 'You do not have permission to view this chat';
    } else if (xhr.status === 404) {
        errorMessage = 'Chat not found';
        errorDetails = 'This conversation may have been deleted';
    } else if (xhr.status >= 500) {
        errorMessage = 'Server error';
        errorDetails = 'Please try again in a few moments';
    }
    
    document.getElementById('chatMessages').innerHTML = `
        <div class="d-flex flex-column justify-content-center align-items-center text-center" style="height: 300px; padding: 2rem;">
            <div class="mb-4">
                <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
            </div>
            <h5 class="text-danger mb-2">${errorMessage}</h5>
            <p class="text-muted mb-4">${errorDetails}</p>
            <button class="btn btn-outline-primary" onclick="fetchMessagesWithLoading(true)">
                <i class="fas fa-redo me-2"></i>Try Again
            </button>
        </div>
    `;
    
    // Disable message input on error
    document.getElementById('messageInput').disabled = true;
    document.getElementById('messageInput').placeholder = 'Error loading chat';
}

// Enhanced message display function
function displayMessages(messages, isInitial = false) {
    const chatBox = document.getElementById('chatMessages');
    if (!chatBox) {
        return;
    }
    
    forceShowChatArea();
    
    if (isInitial) {
        chatBox.innerHTML = '';
        lastRenderedDate = null;
        renderedMessageIds.clear();
        // Clear any existing empty state
        clearEmptyState();
    }
    
    let hasNewMessages = false;
    let messagesHTML = '';
    
    messages.forEach((msg, index) => {
        if (renderedMessageIds.has(msg.id)) {
            return;
        }
        
        hasNewMessages = true;
        renderedMessageIds.add(msg.id);
        
        // Store message for search functionality
        allMessages.push(msg);
        
        const messageDate = new Date(msg.created_at);
        const messageDateString = messageDate.toDateString();
        
        // Add date separator if new day
        if (lastRenderedDate !== messageDateString) {
            const dateLabel = formatDateHeader(msg.created_at);
            messagesHTML += `<div class="date-separator"><span>${dateLabel}</span></div>`;
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
                messageContent += `<div class="message-image mt-2">
                    <img src="/uploads/chat/${msg.attach}" alt="Image" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-width: 250px; cursor: pointer; border-radius: 12px;"
                         onclick="openImageViewer('/uploads/chat/${msg.attach}')">
                </div>`;
            } else if (['webm', 'mp3', 'wav', 'ogg', 'm4a'].includes(fileType)) {
                messageContent += `<div class="voice-message mt-2">
                    <div class="voice-player d-flex align-items-center bg-light rounded p-2">
                        <button class="btn btn-sm btn-outline-primary me-2" onclick="playVoiceMessage('${msg.attach}')">
                            <i class="fas fa-play"></i>
                        </button>
                        <div class="voice-info flex-grow-1">
                            <div class="voice-waveform d-flex align-items-center">
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                            </div>
                            <small class="text-muted">Voice Message</small>
                        </div>
                        <audio id="voice-${msg.attach}" preload="metadata">
                            <source src="/uploads/chat/${msg.attach}" type="audio/webm">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>`;
            } else {
                messageContent += `<div class="message-file mt-2">
                    <a href="/uploads/chat/${msg.attach}" download class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-file me-2"></i>${msg.attach}
                    </a>
                </div>`;
            }
        }
        
        // Build message HTML with improved Bootstrap styling
        messagesHTML += `
            <div class="message ${messageClass} mb-3" data-message-id="${msg.id}">
                <div class="message-bubble shadow-sm">
                    ${messageContent}
                    <div class="message-time mt-2">
                        <small class="text-muted">${messageTime}</small>
                    </div>
                </div>
            </div>
        `;
    });
    
    if (hasNewMessages) {
        chatBox.innerHTML += messagesHTML;
        
        // Force show chat area again after adding messages
        setTimeout(() => {
            forceShowChatArea();
            scrollToBottom();    
            
            // Force a repaint to ensure messages are visible
            chatBox.style.display = 'none';
            chatBox.offsetHeight; // Trigger reflow
            chatBox.style.display = 'block';
        }, 50);
    }
}

function fetchMessages(initial = false) {
    if (!selectedUserId) return;

    $.ajax({
        url: "{{ route('chat.fetch') }}",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            receiver_id: selectedUserId,
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
    const messageInput = document.getElementById('messageInput');
    
    if (messageInputContainer && messageInput) {
        console.log('Simple text bar initialized successfully');
        console.log('Message input container position:', messageInputContainer.getBoundingClientRect());
    } else {
        console.error('Message input elements not found!');
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
    const chatItems = document.querySelectorAll('.border-bottom');
    
    chatItems.forEach(item => {
        const userName = item.querySelector('h6').textContent.toLowerCase();
        const lastMessage = item.querySelector('p').textContent.toLowerCase();
        
        if (userName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function clearSearch() {
    document.getElementById('searchInput').value = '';
    const chatItems = document.querySelectorAll('.border-bottom');
    chatItems.forEach(item => {
        item.style.display = 'block';
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
        console.log('File selected:', selectedFile.name);
    }
}

function removeFile() {
    selectedFile = null;
    console.log('File removed');
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
    if (!selectedUserId) {
        showToast('Please select a user to send voice message to.', 'warning');
        return;
    }

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        showToast('Voice recording is not supported in this browser', 'error');
        return;
    }
    
    // Show recording modal
    const recordingModal = document.getElementById('voiceRecordingModal');
    if (recordingModal) {
        recordingModal.style.display = 'flex';
    }
    
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            mediaRecorder = new MediaRecorder(stream, {
                mimeType: 'audio/webm;codecs=opus'
            });
            recordedChunks = [];
            
            mediaRecorder.ondataavailable = event => {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };
            
            mediaRecorder.onstop = () => {
                if (recordedChunks.length > 0) {
                    const audioBlob = new Blob(recordedChunks, { type: 'audio/webm' });
                    sendVoiceMessage(audioBlob);
                } else {
                    showToast('No audio recorded. Please try again.', 'warning');
                }
                stream.getTracks().forEach(track => track.stop());
            };
            
            mediaRecorder.onerror = (event) => {
                showToast('Recording error occurred. Please try again.', 'error');
                isRecording = false;
                if (recordingModal) {
                    recordingModal.style.display = 'none';
                }
            };
            
            mediaRecorder.start(1000); // Record in 1-second chunks
            isRecording = true;
            
            // Update button appearance
            const voiceButton = document.querySelector('[onclick="toggleVoiceRecording()"]');
            voiceButton.classList.add('btn-danger');
            voiceButton.classList.remove('btn-outline-secondary');
            
        })
        .catch(err => {
            showToast('Could not access microphone. Please check permissions.', 'error');
            isRecording = false;
            if (recordingModal) {
                recordingModal.style.display = 'none';
            }
        });
}

function stopVoiceRecording() {
    if (mediaRecorder && isRecording) {
        mediaRecorder.stop();
        isRecording = false;
        
        // Hide recording modal
        const recordingModal = document.getElementById('voiceRecordingModal');
        if (recordingModal) {
            recordingModal.style.display = 'none';
        }
        
        // Reset button appearance
        const voiceButton = document.querySelector('[onclick="toggleVoiceRecording()"]');
        voiceButton.classList.remove('btn-danger');
        voiceButton.classList.add('btn-outline-secondary');
    }
}

function sendVoiceMessage(audioBlob) {
    if (!selectedUserId) {
        showToast('Please select a user to send voice message to.', 'warning');
        return;
    }

    if (!audioBlob || audioBlob.size === 0) {
        showToast('No audio recorded. Please try again.', 'warning');
        return;
    }

    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('receiver_id', selectedUserId);
    formData.append('voice_message', audioBlob, 'voice_message.webm');
    
    // Show sending state
    const voiceButton = document.querySelector('[onclick="toggleVoiceRecording()"]');
    const originalContent = voiceButton.innerHTML;
    voiceButton.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Sending...</span></div>';
    voiceButton.disabled = true;
    
    $.ajax({
        url: "{{ route('chat.send') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                // Clear empty state since we now have a message
                clearEmptyState();
                
                showToast('Voice message sent successfully!', 'success');
                // Fetch new messages immediately
                fetchMessagesWithLoading(false);
            } else {
                showToast('Failed to send voice message: ' + (response.error || 'Unknown error'), 'error');
            }
            
            // Reset button
            voiceButton.innerHTML = originalContent;
            voiceButton.disabled = false;
        },
        error: function(xhr, status, error) {
            let errorMessage = 'Failed to send voice message. Please try again.';
            
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else if (xhr.status === 422) {
                errorMessage = 'Validation error. Please check your input.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again.';
            } else if (xhr.status === 413) {
                errorMessage = 'Voice message too large. Please record a shorter message.';
            }
            
            showToast(errorMessage, 'error');
            
            // Reset button
            voiceButton.innerHTML = originalContent;
            voiceButton.disabled = false;
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
        showToast('Please select a user to chat with.', 'warning');
        return;
    }

    const messageInput = document.getElementById('messageInput');
    if (!messageInput || messageInput.disabled) {
        showToast('Please select a user to chat with.', 'warning');
        return;
    }
    
    const message = messageInput.value.trim();
    
    if (!message && !selectedFile) {
        showToast('Please enter a message or choose a file.', 'warning');
        return;
    }

    // Show sending state
    const sendButton = document.querySelector('#messageInputContainer button');
    if (sendButton) {
        showSendingState(sendButton);
    }

    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('receiver_id', selectedUserId);
    
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
                
                // Clear empty state since we now have a message
                clearEmptyState();
                
                // Show success feedback
                showToast('Message sent successfully!', 'success');
                
                // Fetch new messages with enhanced function
                fetchMessagesWithLoading(false);
            } else {
                showToast('Failed to send message: ' + (response.error || 'Unknown error'), 'error');
            }
            const sendButton = document.querySelector('#messageInputContainer button');
            if (sendButton) {
                resetSendingState(sendButton);
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to send message. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            } else if (xhr.status === 422) {
                errorMessage = 'Validation error. Please check your input.';
            } else if (xhr.status === 401) {
                errorMessage = 'Please log in again to send messages.';
            } else if (xhr.status >= 500) {
                errorMessage = 'Server error. Please try again in a few moments.';
            }
            showToast(errorMessage, 'error');
            const sendButton = document.querySelector('#messageInputContainer button');
            if (sendButton) {
                resetSendingState(sendButton);
            }
        }
    });
}

// Show sending state
function showSendingState(sendButton) {
    sendButton.disabled = true;
    sendButton.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"><span class="visually-hidden">Sending...</span></div>Sending...';
    sendButton.classList.add('disabled');
}

// Reset sending state
function resetSendingState(sendButton) {
    sendButton.disabled = false;
    sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
    sendButton.classList.remove('disabled');
}

// Toast notification function
function showToast(message, type = 'info') {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());
    
    const toastClass = {
        'success': 'bg-success',
        'error': 'bg-danger',
        'warning': 'bg-warning',
        'info': 'bg-info'
    }[type] || 'bg-info';
    
    const toast = document.createElement('div');
    toast.className = `toast-notification ${toastClass} text-white p-3 rounded shadow`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        min-width: 300px;
        animation: slideInRight 0.3s ease-out;
    `;
    
    toast.innerHTML = `
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                <span>${message}</span>
            </div>
            <button class="btn btn-sm btn-outline-light ms-3" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
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

// Initialize the chat application
document.addEventListener('DOMContentLoaded', function() {
    // Ensure welcome screen is shown by default
    resetToWelcomeScreen();
});

</script>

<!-- Link to External Chat App Stylesheet -->
<link rel="stylesheet" href="{{ asset('backend/assets/css/chat-app.css') }}">

<style>
/* All styles moved to external stylesheet: backend/assets/css/chat-app.css */
/* Additional compatibility styles can be added here if needed */

/* Prevent page scroll - only messages area should scroll */
body {
    overflow: hidden !important;
}

.admin-content-wrapper {
    overflow: hidden !important;
}

.container-fluid {
    overflow: hidden !important;
}

.card-body {
    overflow: hidden !important;
}

/* All remaining styles are in the external stylesheet */



.voice-wave .wave:nth-child(1) { animation-delay: 0s; }
.voice-wave .wave:nth-child(2) { animation-delay: 0.1s; }
.voice-wave .wave:nth-child(3) { animation-delay: 0.2s; }

@keyframes voiceWave {
    0%, 100% { height: 20px; }
    50% { height: 40px; }
}

/* Responsive improvements */
@media (max-width: 768px) {
    .toast-notification {
        right: 10px;
        left: 10px;
        min-width: auto;
    }
    
    .message-bubble {
        max-width: 85%;
    }
    
    #messagesContainer {
        height: calc(100vh - 100px) !important;
    }
}
</style>

<style>
/* Legacy inline styles - to be cleaned up */
.placeholder-remove {
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
    color: #8696a0;
    font-size: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 12px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(60, 65, 80, 0.9) 0%, rgba(45, 50, 65, 0.8) 100%);
    border: 1px solid rgba(138, 43, 226, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
}

.emoji-btn:hover {
    background: linear-gradient(135deg, #8a2be2 0%, #6a1b9a 100%);
    color: #ffffff;
    transform: scale(1.1) translateY(-2px);
    box-shadow: 0 6px 20px rgba(138, 43, 226, 0.4);
    border-color: transparent;
}

.emoji-btn:active {
    transform: scale(0.95) translateY(0);
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
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 18px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.attach-btn, .voice-btn {
    background: linear-gradient(135deg, rgba(60, 65, 80, 0.9) 0%, rgba(45, 50, 65, 0.8) 100%);
    color: #8696a0;
    border: 1px solid rgba(138, 43, 226, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.attach-btn:hover, .voice-btn:hover {
    background: linear-gradient(135deg, #8a2be2 0%, #6a1b9a 100%);
    color: #ffffff;
    transform: scale(1.1) translateY(-2px);
    box-shadow: 0 6px 20px rgba(138, 43, 226, 0.4);
    border-color: transparent;
}

.attach-btn:active, .voice-btn:active {
    transform: scale(0.95) translateY(0);
}

.send-btn {
    background: linear-gradient(135deg, #8a2be2 0%, #6a1b9a 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(138, 43, 226, 0.4);
}

.send-btn:hover {
    background: linear-gradient(135deg, #9932cc 0%, #8a2be2 100%);
    transform: scale(1.05) translateY(-2px);
    box-shadow: 0 6px 20px rgba(138, 43, 226, 0.5);
}

.send-btn:active {
    transform: scale(0.95) translateY(0);
}

/* Emoji Picker */
.emoji-picker {
    position: absolute;
    bottom: 80px;
    left: 16px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 20px;
    max-width: 320px;
    z-index: 1000;
    border: 1px solid rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.emoji-grid {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 6px;
    max-height: 240px;
    overflow-y: auto;
    padding: 8px;
}

.emoji-item {
    padding: 12px 8px;
    border-radius: 12px;
    cursor: pointer;
    font-size: 22px;
    text-align: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    background: transparent;
}

.emoji-item:hover {
    background: linear-gradient(135deg, #00a884 0%, #008f73 100%);
    transform: scale(1.15);
    box-shadow: 0 4px 12px rgba(0, 168, 132, 0.3);
}

.emoji-item:active {
    transform: scale(0.95);
}

/* Attachment Menu */
.attachment-menu {
    position: absolute;
    bottom: 80px;
    left: 16px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 12px 0;
    min-width: 220px;
    z-index: 1000;
    border: 1px solid rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.attachment-option {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 12px;
    margin: 4px 12px;
    position: relative;
}

.attachment-option:hover {
    background: linear-gradient(135deg, #00a884 0%, #008f73 100%);
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(0, 168, 132, 0.3);
}

.attachment-option:hover i {
    color: #ffffff;
    transform: scale(1.1);
}

.attachment-option:hover span {
    color: #ffffff;
    font-weight: 500;
}

.attachment-option i {
    width: 24px;
    color: #00a884;
    font-size: 18px;
    transition: all 0.3s ease;
}

.attachment-option span {
    font-size: 15px;
    color: #111b21;
    font-weight: 400;
    transition: all 0.3s ease;
}

/* File Preview Card */
.file-preview-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid rgba(0, 168, 132, 0.1);
    border-radius: 16px;
    padding: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.file-preview-card:hover {
    box-shadow: 0 6px 20px rgba(0, 168, 132, 0.15);
    transform: translateY(-2px);
}

.file-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #00a884 0%, #008f73 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    color: white;
    font-size: 18px;
}

.file-info {
    flex: 1;
}

.file-name {
    display: block;
    font-weight: 500;
    color: #111b21;
    font-size: 14px;
    margin-bottom: 2px;
}

.file-size {
    font-size: 12px;
    color: #54656f;
}

.remove-file-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.remove-file-btn:hover {
    background: #dc3545;
    border-color: #dc3545;
    color: white;
    transform: scale(1.1);
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
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        height: 60px;
        min-height: 60px;
        display: block;
        width: 100%;
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
        border-radius: 20px;
        padding: 16px;
    }
    
    .emoji-grid {
        grid-template-columns: repeat(6, 1fr);
        gap: 8px;
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

/* Bootstrap enhancements for chat */
.hover-bg:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.border-bottom:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.4;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

/* Improved message styling */
.message {
    margin-bottom: 1.2rem;
    animation: messageSlideIn 0.3s ease-out;
    display: flex;
    align-items: flex-end;
}

.message.sent {
    justify-content: flex-end;
}

.message.received {
    justify-content: flex-start;
}

.message-bubble {
    max-width: 75%;
    padding: 0.875rem 1.125rem;
    border-radius: 20px;
    word-wrap: break-word;
    position: relative;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.message-bubble:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.message.sent .message-bubble {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border-bottom-right-radius: 6px;
}

.message.received .message-bubble {
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
    color: #2c3e50;
    border: 1px solid #e3f2fd;
    border-bottom-left-radius: 6px;
}

.message-text {
    line-height: 1.4;
    font-size: 0.95rem;
}

.message-time {
    font-size: 0.75rem;
    opacity: 0.8;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
}

.message.sent .message-time {
    color: rgba(255, 255, 255, 0.8);
    justify-content: flex-end;
}

.message.received .message-time {
    color: #6c757d;
    justify-content: flex-start;
}


@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.date-separator {
    text-align: center;
    margin: 1.5rem 0;
    font-size: 0.8rem;
    color: #6c757d;
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
    background: linear-gradient(to right, transparent, #dee2e6, transparent);
    z-index: 1;
}

.date-separator span {
    background: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    border: 1px solid #dee2e6;
    position: relative;
    z-index: 2;
}

/* Toast animations */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

/* Enhanced chat styling */
.active {
    background-color: #007bff !important;
    color: white !important;
}

.active .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

.active .badge {
    background-color: rgba(255, 255, 255, 0.2) !important;
}

/* Loading states */
.disabled {
    opacity: 0.6;
    cursor: not-allowed !important;
}

/* Message animations */
.message {
    animation: messageSlideIn 0.3s ease-out;
}

@keyframes messageSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced input styling */
#messageInput {
    background: linear-gradient(135deg, rgba(60, 65, 80, 0.9) 0%, rgba(45, 50, 65, 0.8) 100%);
    border: 1px solid rgba(138, 43, 226, 0.3);
    color: #e9edef;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

#messageInput:focus {
    border-color: #8a2be2;
    box-shadow: 0 0 0 0.2rem rgba(138, 43, 226, 0.25);
    background: linear-gradient(135deg, rgba(70, 75, 90, 0.9) 0%, rgba(55, 60, 75, 0.8) 100%);
}

#messageInput::placeholder {
    color: #8696a0;
}

/* Professional hover effects */
.btn:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.border-bottom:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transition: background-color 0.2s ease;
}

/* Chat layout improvements */
#messagesContainer {
    position: relative;
}

#welcomeScreen {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10;
    transition: opacity 0.3s ease;
}

#welcomeScreen.hidden {
    display: none !important;
    opacity: 0;
    pointer-events: none;
}

#messageInputContainer {
    position: fixed !important;
    bottom: 0 !important;
    left: 0 !important;
    right: 0 !important;
    background: white !important;
    border-top: 1px solid #ddd !important;
    padding: 15px !important;
    z-index: 1000 !important;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1) !important;
}

#messageInputContainer .btn {
    transition: all 0.3s ease !important;
}

#messageInputContainer .btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
}

#messageInput:disabled {
    background-color: #f8f9fa !important;
    cursor: not-allowed !important;
}

#messageInput:focus {
    border-color: #007bff !important;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
}

#messageInput {
    display: block !important;
    visibility: visible !important;
    min-height: 40px;
    background-color: white !important;
    border: 1px solid #ced4da !important;
}

#messageInput:disabled {
    background-color: #f8f9fa !important;
    opacity: 0.8 !important;
    cursor: not-allowed;
}

.d-flex.align-items-end {
    display: flex !important;
    align-items: flex-end !important;
    gap: 0.5rem;
}

#messageInputContainer .btn {
    display: inline-flex !important;
    opacity: 1 !important;
    visibility: visible !important;
    min-width: 42px !important;
    min-height: 42px !important;
    border-radius: 50% !important;
}

#messageInputContainer .btn i {
    font-size: 16px !important;
}

#messageInputContainer .d-flex.align-items-end {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
}

/* Messages scroll area */
#chatMessages {
    overflow-y: auto !important;
    overflow-x: hidden !important;
    max-height: 100%;
    height: 100%;
    -webkit-overflow-scrolling: touch;
}

#messagesContainer {
    overflow: hidden !important;
}

/* Chat list scrolling */
#chatList {
    overflow-y: auto !important;
    overflow-x: hidden !important;
    -webkit-overflow-scrolling: touch;
}

#chatList::-webkit-scrollbar {
    width: 6px;
}

#chatList::-webkit-scrollbar-track {
    background: transparent;
}

#chatList::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

        #chatList::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Enhanced Hover Effects */
        .border-bottom:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }

        /* Button Hover Effects */
        .emoji-btn:hover, .attach-btn:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3) !important;
        }

        #sendButton:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6) !important;
        }

        /* Input Focus Effects */
        #messageInput:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
            outline: none !important;
        }

        /* Status Indicator Animation */
        .badge.bg-success {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }    
        }

        /* Smooth Transitions */
        * {
            transition: all 0.3s ease;
        }

        /* Enhanced Card Shadows */
        .card {
            box-shadow: 0 8px 32px rgba(0,0,0,0.1) !important;
        }

        /* Improved Typography */
        h6, .fw-bold {
            font-weight: 600 !important;
        }

        /* Better Spacing */
        .p-3 {
            padding: 1.25rem !important;
        }

/* Empty chat state styling */
.empty-chat-icon {
    animation: pulse 2s infinite;
}

.empty-chat-card {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: 1px solid #dee2e6;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

/* Voice message styling */
.voice-message {
    max-width: 300px;
}

.voice-player {
    background: linear-gradient(135deg, #f8f9fa, #ffffff) !important;
    border: 1px solid #e3f2fd;
    transition: all 0.2s ease;
}

.voice-player:hover {
    background: linear-gradient(135deg, #e3f2fd, #f8f9fa) !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.voice-waveform {
    gap: 2px;
    margin-bottom: 4px;
}

.wave-bar {
    width: 3px;
    height: 12px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 2px;
    animation: wave 1.5s ease-in-out infinite;
}

.wave-bar:nth-child(1) { animation-delay: 0s; }
.wave-bar:nth-child(2) { animation-delay: 0.1s; }
.wave-bar:nth-child(3) { animation-delay: 0.2s; }
.wave-bar:nth-child(4) { animation-delay: 0.3s; }
.wave-bar:nth-child(5) { animation-delay: 0.4s; }

@keyframes wave {
    0%, 100% { height: 12px; }
    50% { height: 20px; }
}

/* Voice recording modal improvements */
.voice-recording-modal {
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
}

.voice-wave {
    display: flex;
    gap: 4px;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.voice-wave .wave {
    width: 4px;
    height: 20px;
    background: linear-gradient(135deg, #dc3545, #c82333);
    border-radius: 2px;
    animation: voiceWave 1s ease-in-out infinite;
}

.voice-wave .wave:nth-child(1) { animation-delay: 0s; }
.voice-wave .wave:nth-child(2) { animation-delay: 0.1s; }
.voice-wave .wave:nth-child(3) { animation-delay: 0.2s; }

@keyframes voiceWave {
    0%, 100% { height: 20px; }
    50% { height: 40px; }
}

/* Responsive improvements */
@media (max-width: 768px) {
    .toast-notification {
        right: 10px;
        left: 10px;
        min-width: auto;
    }
    
    .message-bubble {
        max-width: 85%;
    }
    
    #messagesContainer {
        height: calc(100vh - 100px) !important;
    }
}
</style>

@endsection
