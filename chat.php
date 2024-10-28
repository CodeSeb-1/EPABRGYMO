<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link rel="stylesheet" href="assets/style1.css????">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        

    </style>
</head>
<body>
    <?php 
        include_once("header.php");
        nav("chat");
    ?>
    <div class="chat-container">
            <div class="sidebar">
                <input type="text" class="search-bar" placeholder="Search...">
                <ul class="conversation-list"></ul>
            </div>
            <div class="chat-area">
                <div class="chat-header">
                    <h2 class="chat-username">Select a user</h2>
                </div>
                <div class="chat-messages"></div>
                <div class="chat-input">
                    <input type="text" placeholder="Your message..." id="messageInput">
                    <button id="sendMessage">Send</button>
                </div>
            </div>
        </div>
    <!-- <script src="navbar.js"></script> -->
    <?php include_once("userController/chat_controller.php") ?>
</body>
</html>