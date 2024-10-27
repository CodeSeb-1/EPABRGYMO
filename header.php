<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

if (isset($_GET['notification_id'])) {
    $notification_id = $_GET['notification_id'];
    markAsRead($notification_id); // Mark the notification as read
}
function nav($active)
{
    $user_id = $_SESSION["user_id"]; // Assuming user ID is stored in the session
    $unread_count = getUnreadCount($user_id);
    echo '
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="assets/LOGO.png" alt="Logo">
                </div>
                <ul class="menu">
                    <li><a href="index.php" class="' . ($active == "home" ? "active" : "") . '">Home</a></li>
                    <li><a href="request.php" class="' . ($active == "request" ? "active" : "") . '">Request</a></li>
                    <li><a href="chat.php" class="' . ($active == "chat" ? "active" : "") . '">Chat</a></li>
                    <li><a href="report.php" class="' . ($active == "reports" ? "active" : "") . '">Reports</a></li>
                </ul>
                <div class="notifications">
                        <a href="notifications.php">
                            <span class="material-symbols-outlined">notifications</span>
                            ' . ($unread_count > 0 ? '<span class="notif-count">' . $unread_count . '</span>' : '') . '
                        </a>
                    </div>
                <div class="user-info">
                
                    <img src="assets/image.png" alt="">
                    <a href="profile.php" class="'.($active == "profile" ? "active" : "").'"><span>' . $_SESSION["user_fullname"] . '</span></a>
                </div>
            </nav>
        </div>
    </header>
    ';
}

