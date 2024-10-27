<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$incoming_id = $_POST['incoming_id']; // Logged-in user (recipient)
$outgoing_id = $_POST['outgoing_id']; // User they are chatting with

$query = "SELECT * FROM messages WHERE (incoming_msg_id = $incoming_id AND outgoing_msg_id = $outgoing_id) 
          OR (incoming_msg_id = $outgoing_id AND outgoing_msg_id = $incoming_id)";
$result = $con->query($query);

$messages = array();
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'outgoing_msg_id' => $row['outgoing_msg_id'],
        'msg' => $row['msg'],
        'time' => date('h:i A', strtotime($row['date'])),
    ];
}

// Only mark messages as read where the logged-in user is the recipient
$update_query = "UPDATE messages SET is_read = 1 WHERE incoming_msg_id = $outgoing_id AND outgoing_msg_id = $incoming_id AND is_read = 0";
$con->query($update_query);

echo json_encode($messages);
