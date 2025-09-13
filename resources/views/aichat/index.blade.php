@extends('admin.admin_master')
@section('admin')
 
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <div class="container-xxl" id="kt_content_container">  
      <div class="card " id="kt_chat_messenger"> 
        <div class="card-header min-h-55px px-5" id="kt_chat_messenger_header"> 
          <div class="card-title w-100 m-0"> 
            <div class="d-flex justify-content-center flex-column me-3 ">
              <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">AI Chat</a>
              <div class="mb-0 lh-1">
                  <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                  <span class="fs-7 fw-semibold text-muted">Active</span>
              </div> 
            </div>
          </div>
        </div>
        <div class="card-body border rounded p-4" id="kt_chat_messenger_body">
          <div id="chat-scroll-container" class="scroll-y me-n5 pe-5 h-100 " style="min-height: 200px;max-height: 250px;overflow-y: auto;">

              @forelse($messages as $msg) 
                <div class="d-flex justify-content-end mb-2"> 
                    <div class="d-flex flex-column align-items-end"> 
                        <div class="d-flex align-items-center mb-2"> 
                                <div class="me-3"> 
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ">{{Auth::user()->name}}</a>  
                                    <br><span class="text-muted fs-7 mb-1">{{ $msg->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="symbol  symbol-35px symbol-circle "><img alt="Pic" src="{{(!empty(Auth::user()->profile_image))? url('upload/admin-images/'.Auth::user()->profile_image):url('upload/default.jpg');}}"></div>               
                        </div> 
                        <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-500px text-end" data-kt-element="message-text">
                        {{ $msg->user_message }} </div> 
                    </div> 
                </div> 
                <div class="d-flex justify-content-start mb-2"> 
                    <div class="d-flex flex-column align-items-start"> 
                        <div class="d-flex align-items-center mb-2">
                            <div class="symbol  symbol-35px symbol-circle "><img alt="Pic" src="{{asset('backend/assets/media/logos/logo.png')}}"></div>
                            <div class="ms-3">
                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Repunext Bot 🤖</a>
                                <br><span class="text-muted fs-7 mb-1">{{ $msg->created_at->format('Y-m-d H:i') }}</span>
                            </div> 
                        </div>  
                        <div class="position-relative"> 
                          <div class="position-absolute top-0 end-0 p-2">
                            <span  class="copy-text px-2 py-1 border border-gray-400 bg-light text-dark rounded" 
                                style="cursor: pointer; font-size: 0.875rem;"  onclick="copyToClipboard(this)" ><i class="bi bi-clipboard"></i> Copy
                            </span>
                          </div> 
                          <div class="chatgpt-response p-8 fs-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-700px text-start" data-kt-element="message-text">
                              {!! nl2br(e($msg->chatgpt_response)) !!}
                          </div>
                        </div>
                    </div> 
                </div> 
              @empty
                  <div class="alert alert-info">No chat messages yet.</div>
              @endforelse
          </div> 
        </div>  
        <div class="card-footer pt-2" id="kt_chat_messenger_footer"> 
          <form  id="myForm" method="POST" action="{{ route('aichat.send') }}">
          @csrf 
              <textarea class="form-control  mb-2" name="message" rows="1" placeholder="Type a message"></textarea>  
            <div class="d-flex flex-stack"> 
                <div class="d-flex align-items-center fw-bold">
                    Response Type
                </div> 
                <div class="w-100 px-3"> 
                    <select name="categoryname" class="col-lg-6 col-form-label form-select" required>
                        <option value="short" selected>Short (max 90 words)</option>
                        <option value="medium">Medium (max 200 words)</option>
                        <option value="long" >Long (max 500 words)</option>
                        <option value="summary">Summary (max 1200 Words)</option>
                        <option value="article">Article (max 2400 words)</option>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit" id="submitBtn" data-kt-element="send">Send</button> 
            </div> 
          </form>
        </div> 
      </div>
    </div>
  </div>
</div> 
<script> 
  function copyToClipboard(textElement) {
    const responseBox = textElement.closest('.position-relative').querySelector('.chatgpt-response');
    const text = responseBox.innerText; 
    navigator.clipboard.writeText(text).then(() => {
        textElement.textContent = ' Copied';
        textElement.classList.remove('bi-clipboard');
        textElement.classList.add('bi-clipboard-check');
        setTimeout(() => { textElement.textContent = ' Copy'; 
          textElement.classList.remove('bi-clipboard-check');
          textElement.classList.add('bi-clipboard');}, 1500);
    });
  }
  document.getElementById('myForm').addEventListener('submit', function (e) {
      const submitBtn = document.getElementById('submitBtn');
      submitBtn.disabled = true;
      submitBtn.innerText = 'Submitting...';
  }); 
  document.addEventListener("DOMContentLoaded", function () {
      const chatContainer = document.getElementById("chat-scroll-container");
      if (chatContainer) {
          chatContainer.scrollTop = chatContainer.scrollHeight;
      }
  });
</script>
@endsection 
