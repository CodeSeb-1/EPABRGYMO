<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$incoming_id = $_POST['incoming_id'];
$outgoing_id = $_POST['outgoing_id'];

$query = "SELECT * FROM messages WHERE (incoming_msg_id = $incoming_id AND outgoing_msg_id = $outgoing_id) 
          OR (incoming_msg_id = $outgoing_id AND outgoing_msg_id = $incoming_id) ORDER BY date ASC";
$result = $con->query($query);

$messages = array();
$previousDate = null; // Track the date of the previous message

while ($row = $result->fetch_assoc()) {
    $timestamp = strtotime($row['date']);
    $currentDate = date('Y-m-d', $timestamp); // Get the date part only

    // Add a date separator if the current message is from a different date
    if ($previousDate !== $currentDate) {
        $separator = getDateSeparator($timestamp);
        $messages[] = ['separator' => $separator];
    }

    // Add the message
    $messages[] = [
        'outgoing_msg_id' => $row['outgoing_msg_id'],
        'msg' => $row['msg'],
        'time' => date('h:i A', $timestamp)
    ];

    $previousDate = $currentDate; // Update the previousDate tracker
}

$update_query = "UPDATE messages SET is_read = 1 WHERE incoming_msg_id = $outgoing_id AND outgoing_msg_id = $incoming_id AND is_read = 0";
$con->query($update_query);

echo json_encode($messages);

/**
 * Returns a formatted date separator based on how old the message is.
 */
function getDateSeparator($timestamp)
{
    $currentYear = date('Y');
    $messageYear = date('Y', $timestamp);

    if ($currentYear !== $messageYear) {
        return date('M d, Y', $timestamp); // Different year: Full date with year
    } elseif (time() - $timestamp < 86400) {
        return 'Today'; // Same day
    } elseif (time() - $timestamp < 2 * 86400) {
        return 'Yesterday'; // Previous day
    } elseif (time() - $timestamp < 7 * 86400) {
        return date('l', $timestamp); // Same week: Day of the week
    } else {
        return date('M d', $timestamp); // Same year but not same week: Month and day
    }
}
?>