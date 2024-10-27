<script>
        $(document).ready(function() {
            let selectedUserId = null; 
            const incoming_id = <?php echo $_SESSION['user_id']; ?>;

            let hasNewMessage = false;
            let messageFetchInterval;

            let lastMessages = {};

            function fetchUsers() {
                $.ajax({
                    url: '../fetch_users.php',
                    method: 'GET',
                    success: function(data) {
                        try {
                            const users = JSON.parse(data);
                            let userList = '';
                            users.forEach(user => {
                                const lastMessage = user.last_message ? user.last_message : "No messages yet";
                                if (lastMessages[user.user_id] !== lastMessage) {
                                    lastMessages[user.user_id] = lastMessage;
                                }

                                userList += `<a href="#" class="user-link" data-id="${user.user_id}" data-name="${user.user_firstname} ${user.user_lastname}">
                                                <li class="conversation-item">
                                                    <img src="https://via.placeholder.com/40" alt="${user.user_firstname}"/>
                                                    <div class='info'>
                                                        <span>${user.user_firstname} ${user.user_lastname}</span>
                                                        <div class="last-message">${lastMessage}</div> 
                                                    </div>
                                                </li>
                                              </a>`;
                            });
                            $('.conversation-list').html(userList);
                        } catch (error) {
                            console.error("Error parsing JSON response from fetch_users:", error);
                            console.error("Response data:", data);
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX error fetching users:", xhr);
                    }
                });
            }

            setInterval(fetchUsers, 3000);

            function loadChat(outgoing_id, user_name) {
                $('.chat-username').text(user_name);
                selectedUserId = outgoing_id;

                $.ajax({
                    url: '../fetch_messages.php',
                    method: 'POST',
                    data: { incoming_id, outgoing_id },
                    success: function(data) {
                        try {
                            const messages = JSON.parse(data);
                            let chatArea = '';
                            messages.forEach(msg => {
                                if (msg.outgoing_msg_id == incoming_id) {
                                    chatArea += `<div class="message received">
                                                    <div class="message-content">${msg.msg}</div>
                                                    <div class="message-time">${msg.time}</div>
                                                </div>`;
                                } else {
                                    chatArea += `<div class="message sent">
                                                    <div class="message-content">${msg.msg}</div>
                                                    <div class="message-time">${msg.time}</div>
                                                </div>`;
                                }
                            });
                            $('.chat-messages').html(chatArea);
                        } catch (error) {
                            console.error("Error parsing JSON response from fetch_messages:", error);
                            console.error("Response data:", data);
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX error loading chat:", xhr);
                    }
                });
            }

            function sendMessage() {
                const message = $('#messageInput').val(); 
                const outgoing_id = selectedUserId;

                if (outgoing_id && message.trim() !== '') {
                    $.ajax({
                        url: '../send_message.php',
                        method: 'POST',
                        data: { incoming_id, outgoing_id, message },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#messageInput').val(''); 
                                loadChat(outgoing_id, $('.chat-username').text()); 
                            } else {
                                alert('Failed to send message. Please try again.');
                            }
                        },
                        error: function(xhr) {
                            console.error("AJAX error sending message:", xhr);
                        }
                    });
                } else {
                    alert('Please select a user and enter a message.'); 
                }
            }

            $(document).on('click', '.user-link', function(e) {
                e.preventDefault();
                const outgoing_id = $(this).data('id');
                const user_name = $(this).data('name');
                loadChat(outgoing_id, user_name); 
                startMessageFetching(outgoing_id); 
            });

            $('#sendMessage').click(function() {
                sendMessage(); 
            });

            $('#messageInput').on('keypress', function(e) {
                if (e.which === 13) { 
                    e.preventDefault();
                    sendMessage(); 
                }
            });

            fetchUsers();

            function startMessageFetching(outgoing_id) {
                clearInterval(messageFetchInterval); 
                messageFetchInterval = setInterval(function() {
                    loadChat(outgoing_id, $('.chat-username').text());
                }, 3000);
            }
        });
    </script>