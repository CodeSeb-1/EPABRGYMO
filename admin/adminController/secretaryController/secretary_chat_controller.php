<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');


$query = "SELECT * FROM users";
$result = $con->query($query);

$users = array();
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
echo json_encode($users);