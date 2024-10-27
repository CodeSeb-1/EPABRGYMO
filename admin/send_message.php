<?php
header('Content-Type: application/json');
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$incoming_id = $_POST['incoming_id']; // Sender
$outgoing_id = $_POST['outgoing_id']; // Recipient
$message = $_POST['message'];

$query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, is_read) VALUES ($incoming_id, $outgoing_id, '$message', 0)";
if ($con->query($query)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
