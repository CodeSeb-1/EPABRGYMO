<script>
    $(document).ready(function() {
        let selectedUserId = null; 
        const incoming_id = <?php echo $_SESSION['user_id']; ?>;
        let lastMessages = {};

        function fetchUsers() {
            const searchTerm = $('.search-bar').val().toLowerCase();

            $.ajax({
                url: '../fetch_users.php',
                method: 'GET',
                success: function(data) {
                    try {
                        const users = JSON.parse(data);
                        let userList = '';
                        users.forEach(user => {
                            const lastMessage = user.last_message ? user.last_message : "No messages yet";
                            const isUnread = user.unread_count > 0;
                            const userFullName = `${user.user_firstname} ${user.user_lastname}`;

                            if (userFullName.toLowerCase().includes(searchTerm)) {
                                userList += `<a href="#" class="user-link" data-id="${user.user_id}" data-name="${userFullName}">
                                                <li class="conversation-item ${isUnread ? 'bold' : ''}">
                                                    <img src="${user.user_profile}" 
                                                 alt="${user.user_firstname}";"/>
                                                    <div class='info'>
                                                        <span class="${isUnread ? 'bold' : ''}">${userFullName}</span>
                                                        <span>${user.user_type}</span>
                                                        <div class="last-message">${lastMessage}</div> 
                                                    </div>
                                                </li>
                                            </a>`;
                            }
                        });
                        $('.conversation-list').html(userList);
                    } catch (error) {
                        console.error("Error parsing JSON response from fetch_users:", error);
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
                        if (msg.separator) {
                            chatArea += `<div class="date-separator">${msg.separator}</div>`;
                        } else {
                            const messageClass = msg.outgoing_msg_id == outgoing_id ? 'sent' : 'received';
                            chatArea += `
                                <div class="message ${messageClass}">
                                    <div class="message-content">${msg.msg}</div>
                                    <div class="message-time">${msg.time}</div>
                                </div>`;
                        }
                    });
                    $('.chat-messages').html(chatArea);
                scrollToBottom(); // Scroll to the bottom after loading messages
            } catch (error) {
                console.error("Error parsing JSON response from fetch_messages:", error);
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
                            scrollToBottom(); // Scroll to the bottom after sending a message
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

        function scrollToBottom() {
            $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
        }

        $(document).on('click', '.user-link', function(e) {
            e.preventDefault();
            const outgoing_id = $(this).data('id');
            const user_name = $(this).data('name');
            loadChat(outgoing_id, user_name);
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

        $('.search-bar').on('input', fetchUsers); // Update user list on search

        fetchUsers();
    });
</script>
