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
        @if(!$message->message && !$message->hasAttachment())
            <p class="message-text text-muted"><em>Empty message</em></p>
        @endif
        @if($message->user_id === auth()->id())
            <div class="message-actions">
                <button onclick="deleteMessage({{ $message->id }})" 
                        class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        @endif
    </div>
</div>