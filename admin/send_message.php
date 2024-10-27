<?php
header('Content-Type: application/json'); // Add this line
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$incoming_id = $_POST['incoming_id']; // Logged-in user
$outgoing_id = $_POST['outgoing_id']; // Recipient
$message = $_POST['message'];

$query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES ($incoming_id, $outgoing_id, '$message')";
if ($con->query($query)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
