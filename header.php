<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');?>
<!-- <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" /> -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,280,0,0" />
<link rel="stylesheet" href="assets/notification.css????">
<?php


// Handle marking notification as read
if (isset($_GET['view_notification_id'])) {
    $notification_id = $_GET['view_notification_id'];
    markNotificationAsRead($notification_id);
}

function nav($active)
{
    $user_id = $_SESSION['user_id'];
    $notifications = getAllNotifications($user_id);
    $unread_notification_count = count(array_filter($notifications, function ($n) {
        return !$n['is_read']; }));
     $unread_chat_count = getUnreadChatCount($user_id);  // Get unread chat count

    // echo "Unread Chat: $unread_chat_count";
    $img_path = file_exists($img = $_SERVER['DOCUMENT_ROOT'] . "/EPABRGYMO/dataImages/Resident.{$_SESSION['user_id']}.jpg")
        ? "/EPABRGYMO/dataImages/Resident.{$_SESSION['user_id']}.jpg"
        : "assets/profile.jpg";

    echo '
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="assets/LOGO.png" alt="Logo">
                </div>
                <ul class="menu">
                    <li><a href="index.php" class="' . ($active == "home" ? "active" : "") . '">Home</a></li>
                    <li><a href="request.php" class="' . ($active == "request" ? "active" : "") . '">Request</a></li>
                    <li><a href="report.php" class="' . ($active == "reports" ? "active" : "") . '">Reports</a></li>
                </ul>
                <div class="user-info">
                    <div class="notifications">
                        <a href="chat.php">
                            <span class="material-symbols-outlined chat" style="color:#fff; cursor: pointer;">chat</span>
                            ' . ($unread_chat_count > 0 ? '<span class="notif-count">' . $unread_chat_count . '</span>' : '') . '
                        </a>
                    </div>
                    <div class="notifications">
                        <span class="material-symbols-outlined notif" style="color:#fff; cursor: pointer;" onclick="toggleNotifications()">notifications</span>
                        ' . ($unread_notification_count > 0 ? '<span class="notif-count">' . $unread_notification_count . '</span>' : '') . '
                        <div id="notificationsDropdown" class="notifications-dropdown">
                            <div class="notifications-header">
                                <span class="notifications-title">Notifications</span>
                                <a href="?mark_all_read=true" style="background: none; color: #007bff; cursor: pointer; text-decoration: none;">Mark all as read</a>
                            </div>
                            <div id="notificationsList">';
                            if (empty($notifications)) {
                                echo '<div class="no-notifications">No notifications available.</div>';
                            } else {
                                foreach ($notifications as $notification) {
                                    $status = $notification['is_read'] ? 'Read' : 'Unread';
                                    $link = htmlspecialchars($notification['link']);
                                    $separator = (strpos($link, '?') !== false) ? '&' : '?';
                                    $fullLink = $link . $separator . "notification_id=" . $notification['id'];

                                    echo '
                                    <a href="' . $fullLink . '&view_notification_id=' . $notification['id'] . '">
                                        <div class="notification-item ' . ($notification['is_read'] ? '' : 'unread') . '" data-id="' . $notification['id'] . '">
                                            <div class="notification-content">
                                                <strong>' . htmlspecialchars($notification['type']) . '</strong><br>
                                                <p>' . htmlspecialchars($notification['message']) . '</p>
                                            </div>
                                            <div class="notification-meta">
                                                <span>' . $status . '</span>
                                                <span>' . $notification['created_at'] . '</span>
                                            </div>
                                        </div>
                                    </a>';
                                }
                            }
                            echo '</div>
                        </div>
                    </div>
                    <a href="profile.php" id="profile_pic">
                        <img src="' . $img_path . '" alt="profile">
                    </a>
                </div>
            </nav>
        </div>
    </header>';
}

?>

<script>
function toggleNotifications() {
    var dropdown = document.getElementById("notificationsDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}
</script>