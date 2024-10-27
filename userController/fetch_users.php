<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

$sql = "SELECT * FROM users WHERE user_id != $user_id AND user_type != 'Resident'";
$result = mysqli_query($con, $sql);

$users = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['user_id']} AND outgoing_msg_id = $user_id) 
              OR (incoming_msg_id = $user_id AND outgoing_msg_id = {$row['user_id']})
              ORDER BY msg_id DESC LIMIT 1"; 
    
    $query2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_assoc($query2);

    if (mysqli_num_rows($query2) > 0) {
        $last_message = $row2['msg'];
        if ($row2['incoming_msg_id'] == $user_id) {
            $last_message = 'You: ' . $last_message;
        }
    } else {
        $last_message = 'No message available';
    }

    $msg = (strlen($last_message) > 28) ? substr($last_message, 0, 28) . '...' : $last_message;

    $users[] = array(
        'user_id' => $row['user_id'],
        'user_firstname' => $row['user_firstname'],
        'user_lastname' => $row['user_lastname'],
        'last_message' => $msg,
        'user_type' => $row['user_type'],
    );
}

echo json_encode($users);
