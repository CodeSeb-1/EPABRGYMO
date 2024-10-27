<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

$sql = "SELECT * FROM users WHERE user_id != $user_id";
$result = mysqli_query($con, $sql);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Fetch the last message with the current user
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['user_id']} AND outgoing_msg_id = $user_id) 
              OR (incoming_msg_id = $user_id AND outgoing_msg_id = {$row['user_id']})
              ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_assoc($query2);

    // Count unread messages from this user
    $unread_count_sql = "SELECT COUNT(*) as unread_count FROM messages WHERE incoming_msg_id = {$row['user_id']} 
                         AND outgoing_msg_id = $user_id AND is_read = 0";
    $unread_count_result = mysqli_query($con, $unread_count_sql);
    $unread_data = mysqli_fetch_assoc($unread_count_result);
    $unread_count = $unread_data['unread_count'] ?? 0;

    $last_message = 'No message available';
    if ($row2) {
        $last_message = $row2['msg'];
        if ($row2['incoming_msg_id'] == $user_id) {
            $last_message = 'You: ' . $last_message;
        }
    }
    $msg = (strlen($last_message) > 28) ? substr($last_message, 0, 28) . '...' : $last_message;

    $users[] = array(
        'user_id' => $row['user_id'],
        'user_firstname' => $row['user_firstname'],
        'user_lastname' => $row['user_lastname'],
        'last_message' => $msg,
        'user_type' => $row['user_type'],
        'unread_count' => $unread_count, // Include unread count
    );
}

echo json_encode($users);
