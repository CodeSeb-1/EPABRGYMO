<?php
include '../calendar.php';
include_once("../adminController/secretaryController/secretary_resident_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css????">
    <link rel="stylesheet" href="../../assets/pagination.css">
    <link rel="stylesheet" href="../../assets/chat.css?">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include_once '../header.php'; ?>
    <div class="main-container">
        <?php include_once 'sidebar.php'; sidebar('chat'); ?>
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
    </div>
    <?php include_once '../chat.php'; ?>
</body>
</html>
