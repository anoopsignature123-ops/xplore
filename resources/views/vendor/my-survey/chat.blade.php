@extends('vendor.includes.layout')
@section('title', $page_title)
@section('content')
@push('styles')
<style>
    body {
        overflow: hidden !important;
    }
    .chat-container {
        height: calc(100vh - 166px);
        display: flex;
        flex-direction: column;
        background-color: #f0f2f5;
        border-radius: 10px;
        overflow: hidden;
    }
    .chat-header {
        background: #075e54;
        color: white;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .chat-header h5 {
        margin: 0;
        font-weight: 600;
    }
    .chat-header small {
        opacity: 0.8;
    }
    .chat-body {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
    }
    .chat-message {
        max-width: 65%;
        padding: 10px 15px;
        border-radius: 8px;
        position: relative;
        font-size: 0.95rem;
        word-wrap: break-word;
    }
    .message-sent {
        align-self: flex-end;
        background-color: #dcf8c6;
        border-top-right-radius: 0;
    }
    .message-received {
        align-self: flex-start;
        background-color: #ffffff;
        border-top-left-radius: 0;
    }
    .message-time {
        font-size: 0.7rem;
        color: #888;
        display: block;
        text-align: right;
        margin-top: 5px;
    }
    .chat-footer {
        background: #f0f0f0;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .chat-footer input[type="text"] {
        flex: 1;
        border: none;
        padding: 12px 20px;
        border-radius: 24px;
        outline: none;
    }
    .chat-footer .btn {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .attachment-preview {
        max-width: 200px;
        border-radius: 8px;
        margin-top: 5px;
    }
    .attachment-pdf {
        background: #eee;
        padding: 10px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #333;
        margin-top: 5px;
    }
    #file-upload {
        display: none;
    }
</style>
@endpush

<div class="page-body">
   <!-- <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('vendor.index') }}"> <i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('vendor.my-survey.list') }}">My Surveys</a></li>
                  <li class="breadcrumb-item">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div> -->
   
   <div class="container-fluid mt-3">
      <div class="row"> 
         <div class="col-sm-12">
            <div class="card shadow-lg border-0 rounded-3">
               <div class="card-body p-0">
                   
                    <div class="chat-container">
                        <!-- Chat Header -->
                        <div class="chat-header d-flex justify-content-between align-items-center w-100">
                            <div class="d-flex align-items-center gap-3">
                                @php
                                    $customerName = $survey->customer->name ?? 'Customer';
                                    $fallbackImg = 'https://ui-avatars.com/api/?name=' . urlencode($customerName) . '&background=random';
                                    $customerImg = $survey->customer->profile_image 
                                        ? asset($survey->customer->profile_image) 
                                        : $fallbackImg;
                                @endphp
                                <img src="{{ $customerImg }}" alt="{{ $customerName }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #fff;">
                                <div>
                                    <h5>{{ $customerName }}</h5>
                                    <small>{{ $survey->survey_name }} ({{ \Carbon\Carbon::parse($survey->survey_date)->format('d M Y') }})</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if(strtolower($survey->status) !== 'completed')
                                    <button class="btn btn-sm text-dark fw-bold" style="background-color: #ffc107;" onclick="markAsComplete()">
                                        <i class="fa-solid fa-check"></i> Mark as Complete
                                    </button>
                                @endif
                                <a href="{{ route('vendor.my-survey.list') }}" class="text-white btn btn-sm" style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Chat Body -->
                        <div class="chat-body" id="chatBody">
                            <!-- Messages will be loaded here via JS -->
                            <div class="text-center w-100 mt-4 text-muted"><i class="fa-solid fa-spinner fa-spin"></i> Loading messages...</div>
                        </div>

                        <!-- Chat Footer -->
                        @if(strtolower($survey->status) === 'completed')
                            <div class="chat-footer justify-content-center bg-white text-muted py-3 border-top">
                                <strong><i class="fa-solid fa-info-circle me-1"></i> Survey is completed. You cannot send more messages.</strong>
                            </div>
                        @else
                            <form id="chatForm" class="chat-footer">
                                <input type="file" id="file-upload" accept="image/*,.pdf" onchange="handleFileSelect(this)">
                                <button type="button" class="btn btn-secondary" onclick="document.getElementById('file-upload').click();">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>
                                
                                <div id="file-preview-container" class="d-none bg-white p-2 rounded shadow-sm d-flex align-items-center gap-2">
                                    <span id="file-name-preview" class="text-truncate" style="max-width: 150px; font-size:12px;"></span>
                                    <button type="button" class="btn btn-sm btn-danger p-1" style="width:25px; height:25px;" onclick="clearFile()"><i class="fa-solid fa-times"></i></button>
                                </div>

                                <input type="text" id="chatInput" placeholder="Type a message..." autocomplete="off">
                                <button type="submit" class="btn btn-primary" id="btnSend">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </form>
                        @endif
                    </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
@push('scripts')
<script>
    const surveyId = "{{ $survey->id }}";
    const chatBody = document.getElementById('chatBody');
    let selectedFile = null;
    let currentPage = 1;
    let lastPage = 1;
    let isFetching = false;

    function markAsComplete() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to mark this survey as completed!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, mark it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('vendor.my-survey.chat.complete', $survey->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if(res.status) {
                            Swal.fire(
                                'Completed!',
                                res.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to update status.');
                    }
                });
            }
        });
    }

    function handleFileSelect(input) {
        if(input.files && input.files[0]) {
            selectedFile = input.files[0];
            document.getElementById('file-name-preview').innerText = selectedFile.name;
            document.getElementById('file-preview-container').classList.remove('d-none');
        }
    }

    function clearFile() {
        selectedFile = null;
        document.getElementById('file-upload').value = '';
        document.getElementById('file-preview-container').classList.add('d-none');
    }

    function renderMessage(msg, prepend = false) {
        const isMe = msg.is_me;
        const msgClass = isMe ? 'message-sent' : 'message-received';
        
        let attachmentHtml = '';
        if(msg.attachment_url) {
            if(msg.attachment_type === 'image') {
                attachmentHtml = `<a href="${msg.attachment_url}" target="_blank"><img src="${msg.attachment_url}" class="attachment-preview"></a>`;
            } else {
                attachmentHtml = `<a href="${msg.attachment_url}" target="_blank" class="attachment-pdf"><i class="fa-solid fa-file-pdf text-danger"></i> View Document</a>`;
            }
        }

        const textHtml = msg.message ? `<div>${msg.message}</div>` : '';

        const html = `
            <div class="chat-message ${msgClass}">
                ${attachmentHtml}
                ${textHtml}
                <span class="message-time">${msg.created_at}</span>
            </div>
        `;
        
        if (prepend) {
            chatBody.insertAdjacentHTML('afterbegin', html);
        } else {
            chatBody.insertAdjacentHTML('beforeend', html);
        }
    }

    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function fetchHistory(page = 1) {
        if (isFetching) return;
        isFetching = true;
        
        if (page === 1) {
            chatBody.innerHTML = '<div class="text-center w-100 mt-4 text-muted"><i class="fa-solid fa-spinner fa-spin"></i> Loading messages...</div>';
        } else {
            // Add a small loading indicator at top
            $('#chatBody').prepend('<div id="loadMoreSpinner" class="text-center w-100 py-2"><i class="fa-solid fa-spinner fa-spin"></i></div>');
        }

        $.ajax({
            url: "{{ route('vendor.my-survey.chat.history', $survey->id) }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                page_no: page,
                per_page_record: 10
            },
            success: function(res) {
                if (page === 1) chatBody.innerHTML = '';
                else $('#loadMoreSpinner').remove();

                if(res.data.length === 0 && page === 1) {
                    chatBody.innerHTML = '<div class="text-center w-100 mt-4 text-muted">No messages yet. Start the conversation!</div>';
                } else if (res.data.length > 0) {
                    currentPage = res.current_page;
                    lastPage = res.last_page;
                    
                    // The API returns newest first (DESC), so we reverse the array to render chronologically
                    let reversedData = res.data.reverse();

                    // If loading page 1, append them. If page > 1, prepend them.
                    if (page === 1) {
                        reversedData.forEach(msg => renderMessage(msg, false));
                        scrollToBottom();
                    } else {
                        // Save current scroll height to restore scroll position after prepending
                        let oldScrollHeight = chatBody.scrollHeight;
                        
                        // We must prepend in reverse-reverse order (so last item in reversedData gets prepended last)
                        // Actually, if we prepend, we should iterate from end of array to start, 
                        // so that the oldest message stays at the top.
                        for (let i = reversedData.length - 1; i >= 0; i--) {
                            renderMessage(reversedData[i], true);
                        }
                        
                        chatBody.scrollTop = chatBody.scrollHeight - oldScrollHeight;
                    }
                }
            },
            complete: function() {
                isFetching = false;
            }
        });
    }

    // Infinite Scroll Implementation
    chatBody.addEventListener('scroll', function() {
        if (chatBody.scrollTop === 0 && currentPage < lastPage && !isFetching) {
            fetchHistory(currentPage + 1);
        }
    });

    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        const message = $('#chatInput').val().trim();
        
        if(!message && !selectedFile) return;

        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        if(message) formData.append('message', message);
        if(selectedFile) formData.append('file', selectedFile);

        $('#btnSend').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');
        $('#chatInput').prop('disabled', true);

        $.ajax({
            url: "{{ route('vendor.my-survey.chat.send', $survey->id) }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if(res.status) {
                    if(chatBody.innerHTML.includes('No messages yet')) chatBody.innerHTML = '';
                    renderMessage(res.data, false);
                    scrollToBottom();
                    $('#chatInput').val('');
                    clearFile();
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) { toastr.error(value[0]); });
                } else {
                    toastr.error('Failed to send message');
                }
            },
            complete: function() {
                $('#btnSend').prop('disabled', false).html('<i class="fa-solid fa-paper-plane"></i>');
                $('#chatInput').prop('disabled', false).focus();
            }
        });
    });

    $(document).ready(function() {
        fetchHistory(1);
    });
</script>

<!-- Include Pusher and Laravel Echo from CDN -->
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Setup Axios for Private Channel Authentication
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

    // Initialize Echo with Reverb Configuration
    window.Pusher = Pusher;
    
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: '{{ env('REVERB_APP_KEY') }}',
        wsHost: window.location.hostname,
        wsPort: {{ env('REVERB_PORT', 8081) }},
        wssPort: {{ env('REVERB_PORT', 8081) }},
        forceTLS: false,
        enabledTransports: ['ws', 'wss'],
    });

    // Listen to the Private Channel
    window.Echo.private('survey.chat.' + surveyId)
        .listen('.message.sent', (e) => {
            // Only render if the message is NOT from the vendor
            // (If the vendor sent it, it's already rendered via AJAX success)
            if(e.sender_type !== 'vendor') {
                if(chatBody.innerHTML.includes('No messages yet')) chatBody.innerHTML = '';
                e.is_me = false; // It's from customer, so it's not 'me' for the vendor
                renderMessage(e);
                scrollToBottom();
            }
        });
</script>
@endpush
 