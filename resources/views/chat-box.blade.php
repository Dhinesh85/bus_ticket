<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Main Chat Container -->
                <div class="chat-container flex h-[80vh]">
                    
                    <!-- Left Sidebar: User List -->
                    <div class="chat-sidebar w-1/3 border-r border-gray-300 dark:border-gray-700 flex flex-col" style="margin-right: 15px;">
                        <!-- Search Bar -->
                        <div class="search-container p-3 border-b border-gray-300 dark:border-gray-700">
                            <div class="relative">
                                <input type="text" id="user-search" placeholder="Search users..." 
                                       class="w-full py-2 px-4 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3" style="top: 10px;right: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User List -->
                        <div class="user-list-container flex-1 overflow-y-auto">
                            <ul id="user-list" class="list-group" style="margin-top: 15px;">
                                @foreach($users as $user)
                                <li class="user-item p-3 border-b border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" data-id="{{ $user->id }}" style="white-space: nowrap;">
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . ($user->profile_image ?? 'default.png')) }}" 
                                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                                            <span class="status-indicator absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="flex justify-between items-center">
                                                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $user->name }}</h3>
                                                <div class="flex items-center">
                                                    @if($user->unread_count > 0)
                                                        <span class="bg-green-500 text-white text-xs font-medium px-2 py-0.5 rounded-full mr-2">
                                                            {{ $user->unread_count }}
                                                        </span>
                                                    @endif
                                                    <!-- <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $user->last_message_time ? $user->last_message_time->format('g:i A') : '' }}
                                                    </span> -->
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ $user->last_message_preview }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Right: Chat Area -->
                    <div class="chat-main w-2/3 flex flex-col mobile-view" style="width: 100%;">
                        <!-- Chat Header -->
                        <div id="chat-header" class="chat-header p-3 border-b border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 flex items-center">
                            <div class="user-avatar">
                                <img id="chat-user-avatar" src="{{ asset('storage/default.png') }}" 
                                     class="w-10 h-10 rounded-full object-cover">
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 id="chat-user-name" class="text-md font-semibold text-gray-800 dark:text-gray-200">Select a user</h3>
                                <p id="chat-user-status" class="text-xs text-gray-500 dark:text-gray-400">Not connected</p>
                            </div>
                           
                        </div>
                        
                        <!-- Chat Messages -->
                        <div id="chat-box" class="chat-messages flex-1 p-4 overflow-y-auto bg-[url('/images/chat-bg.png')] bg-repeat bg-contain">
                            <div class="flex justify-center items-center h-full text-gray-500 dark:text-gray-400">
                                <p>Select a user to start chatting</p>
                            </div>
                        </div>
                        
                        <!-- Chat Input -->
                        <form id="chat-form" class="chat-input p-3 border-t border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                            @csrf
                            <input type="hidden" id="receiver_id">
                            <div class="flex items-center mobile-text">
                                <button type="button" id="emoji-button" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                                <button type="button" id="attachment-button" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </button>
                                <div class="flex-1 mx-2">
                                    <input type="text" id="message" placeholder="Type a message" 
                                           class="w-full py-2 px-4 rounded-full bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500" autocomplete="off">
                                </div>
                                <button type="submit" class="text-white bg-green-500 hover:bg-green-600 rounded-full p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                        
                        <!-- Hidden file upload form -->
                        <form id="attachment-form" style="display: none;">
                            @csrf
                            <input type="file" id="file-input" name="file">
                            <input type="hidden" id="attachment-receiver-id" name="receiver_id">
                        </form>
                        
                        <!-- Emoji Picker Container -->
                        <div id="emoji-picker" class="absolute bottom-16 left-4 hidden bg-white dark:bg-gray-800 shadow-lg rounded-lg p-2 z-10" style="margin-top: 25%;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let chatInterval;
        let selectedUser = null;

        function fetchMessages() {
            let receiver_id = $('#receiver_id').val();
            if (!receiver_id) return;

            $.post('/chat/fetch', {
                _token: '{{ csrf_token() }}',
                receiver_id: receiver_id
            }, function(data) {
                $('#chat-box').html('');
                
                if (data.length === 0) {
                    $('#chat-box').html('<div class="flex justify-center items-center h-full text-gray-500 dark:text-gray-400"><p>No messages yet. Start the conversation!</p></div>');
                    return;
                }

                data.forEach(msg => {
                    const isMe = msg.sender_id == {{ auth()->id() }};
                    const messageClass = isMe ? 'bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 ml-auto' : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200';
                    const messageAlignment = isMe ? 'justify-end' : 'justify-start';
                    const messageTime = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    
                    let messageContent = msg.message;
                    
                    // Check if message contains attachment information
                    if (msg.attachment) {
                        const fileName = msg.message.replace('Sent an attachment: ', '');
                        messageContent = `
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <a href="{{ asset('storage') }}/${msg.attachment}" target="_blank" class="underline">${fileName}</a>
                            </div>
                        `;
                    }
                    
                    $('#chat-box').append(`
                        <div class="flex ${messageAlignment} mb-4">
                            <div class="max-w-[70%] rounded-lg px-4 py-2 ${messageClass} shadow">
                                <p>${messageContent}</p>
                                <div class="text-xs text-gray-500 dark:text-gray-400 text-right mt-1">${messageTime}</div>
                            </div>
                        </div>
                    `);
                });
                
                // Scroll to bottom
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            });
        }

        function startChatPolling() {
            if (chatInterval) clearInterval(chatInterval);
            chatInterval = setInterval(fetchMessages, 3000);
        }

        function updateChatHeader(user) {
            $('#chat-user-name').text(user.name);
            $('#chat-user-status').text('Online');
            $('#chat-user-avatar').attr('src', "{{ asset('storage/') }}/" + (user.profile_image || 'default.png'));
        }
        
        function updateUserListTimes() {
            $('.user-item').each(function() {
                const userId = $(this).data('id');
                const userItem = $(this);
                
                $.post('/chat/last-message', {
                    _token: '{{ csrf_token() }}',
                    user_id: userId
                }, function(data) {
                    if (data) {
                        userItem.find('.text-gray-500.text-xs').text(data.time);
                        userItem.find('.text-gray-600.text-xs').text(data.preview || 'No messages yet');
                    }
                });
            });
        }
        
        // Simple emoji picker
        const emojis = [
            '😀', '😁', '😂', '🤣', '😃', '😄', '😅', '😆', '😉', '😊', 
            '😋', '😎', '😍', '😘', '🥰', '😗', '😙', '😚', '🙂', '🤔',
            '👍', '👎', '❤️', '👏', '🙏', '🎉', '🎂', '🎁', '👋', '👌'
        ];
        
        function loadEmojiPicker() {
            const emojiPicker = $('#emoji-picker');
            emojiPicker.empty();
            
            emojis.forEach(emoji => {
                const emojiButton = $(`<button class="emoji-btn p-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">${emoji}</button>`);
                emojiPicker.append(emojiButton);
                
                emojiButton.on('click', function() {
                    const currentMessage = $('#message').val();
                    $('#message').val(currentMessage + emoji);
                    $('#emoji-picker').hide();
                });
            });
        }

        $(document).ready(function() {
            // Load emoji picker
            loadEmojiPicker();
            
            // Initialize update of user list times
            updateUserListTimes();
            setInterval(updateUserListTimes, 30000); // Update every 30 seconds
            
            // User search functionality
            $('#user-search').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                
                $('.user-item').each(function() {
                    const username = $(this).find('h3').text().toLowerCase();
                    if (username.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // User selection
            $(document).on('click', '.user-item', function () {
                $('.user-item').removeClass('bg-gray-200 dark:bg-gray-600');
                $(this).addClass('bg-gray-200 dark:bg-gray-600');

                let userId = $(this).data('id');
                let userName = $(this).find('h3').text();
                let userAvatar = $(this).find('img').attr('src');
                
                selectedUser = {
                    id: userId,
                    name: userName,
                    profile_image: userAvatar.replace("{{ asset('storage/') }}/", '')
                };

                $('#receiver_id').val(userId);
                $('#attachment-receiver-id').val(userId);
                updateChatHeader(selectedUser);
                
                $('#chat-box').html('<div class="flex justify-center items-center h-full"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-500"></div></div>');
                fetchMessages();
                startChatPolling();
            });
            
            // Emoji button functionality
            $('#emoji-button').on('click', function() {
                $('#emoji-picker').toggle();
            });
            
            // Hide emoji picker when clicking elsewhere
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#emoji-picker, #emoji-button').length) {
                    $('#emoji-picker').hide();
                }
            });
            
            // Attachment button functionality
            $('#attachment-button').on('click', function() {
                if (!$('#receiver_id').val()) {
                    alert('Please select a user first');
                    return;
                }
                
                $('#file-input').trigger('click');
            });
            
            // Handle file selection
            $('#file-input').on('change', function() {
                if (this.files && this.files[0]) {
                    const formData = new FormData($('#attachment-form')[0]);
                    
                    $.ajax({
                        url: '/chat/upload-attachment',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function() {
                            fetchMessages();
                            updateUserListTimes();
                            $('#file-input').val(''); // Clear the file input
                        },
                        error: function() {
                            alert('Failed to upload file. Please try again.');
                            $('#file-input').val(''); // Clear the file input
                        }
                    });
                }
            });

            // Send message
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                let msg = $('#message').val().trim();
                let receiver_id = $('#receiver_id').val();

                if (!receiver_id || !msg) return;

                // Optimistically add message to chat
                const messageTime = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                $('#chat-box').append(`
                    <div class="flex justify-end mb-4">
                       <div class="max-w-[70%] rounded-lg px-4 py-2 bg-green-800 text-white ml-auto shadow" style="color: white;">
                            <p>${msg}</p>
                            <div class="text-xs text-gray-400 text-right mt-1">${messageTime}</div>
                        </div>
                    </div>
                `);
                
                // Scroll to bottom
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                
                // Clear input
                $('#message').val('');

                // Send message to server
                $.post('/chat/send', {
                    _token: '{{ csrf_token() }}',
                    receiver_id: receiver_id,
                    message: msg
                }, function() {
                    // Message sent successfully
                    fetchMessages();
                    updateUserListTimes(); // Update user list with new message info
                }).fail(function() {
                    // Handle error
                    alert('Failed to send message. Please try again.');
                });
            });
        });
    </script>

    <style>
        /* WhatsApp-like styling */
        .chat-container {
            height: calc(100vh - 100px);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }
        
        .user-item.active {
            background-color: rgba(37, 99, 235, 0.1);
        }
        
        /* Message bubble tails (optional) */
        .message-bubble::before {
            content: "";
            position: absolute;
            top: 0;
            width: 12px;
            height: 12px;
            transform: rotate(45deg);
        }
        
        .message-bubble.outgoing::before {
            right: -5px;
            background-color: #dcf8c6;
        }
        
        .message-bubble.incoming::before {
            left: -5px;
            background-color: white;
        }
        
        /* Emoji picker styling */
        #emoji-picker {
            max-width: 250px;
        }
        
        .emoji-btn {
            font-size: 20px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 5px;
            border-radius: 4px;
            transition: background 0.2s;
        }
        
        .emoji-btn:hover {
            background-color: rgba(156, 163, 175, 0.3);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #emoji-picker {
                width: 80%;
                max-width: 300px;
            }
            .mobile-text{
                font-size: 14px;
            }
            .mobile-view{
                max-width: 100%;
            }
            
            .emoji-btn {
                font-size: 18px;
                padding: 8px;
            }
            
            /* Increase touch targets on mobile */
            .user-item {
                padding: 12px;
            }
            
            button {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
</x-app-layout>