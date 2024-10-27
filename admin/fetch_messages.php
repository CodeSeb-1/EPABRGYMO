<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$incoming_id = $_POST['incoming_id']; // Logged-in user
$outgoing_id = $_POST['outgoing_id']; // User they are chatting with

$query = "SELECT * FROM messages WHERE (incoming_msg_id = $incoming_id AND outgoing_msg_id = $outgoing_id) 
          OR (incoming_msg_id = $outgoing_id AND outgoing_msg_id = $incoming_id)";
$result = $con->query($query);

$messages = array();
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'outgoing_msg_id' => $row['outgoing_msg_id'],
        'msg' => $row['msg'],
        'time' => date('h:i A', strtotime($row['date'])), // Format time
    ];
}

echo json_encode($messages);
