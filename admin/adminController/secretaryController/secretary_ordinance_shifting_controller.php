<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$users = [
    'query' => "SELECT * FROM users WHERE user_type = 'Tanod'",
    'bind' => '',
    'value' => '',
];

function display_users()
{
    global $users;

    $users_id = displayAll($users, null, function ($row, $id) {
        return "<option value='{$row['user_firstname']} {$row['user_lastname']}'>{$row['user_firstname']} {$row['user_lastname']}</option>";
    });

    if (!$users_id) {
        echo '<option>No users available</option>';
    } else {
        echo $users_id;
    }
}