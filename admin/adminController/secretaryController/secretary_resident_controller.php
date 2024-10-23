<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');


if(isset($_POST['add_resident'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $address = $_POST['address'];
}

$resident = [
    'query' => 'SELECT * FROM masterlist',
    'bind'=> '',
    'value'=> [],
];


function display_resident() {
    global $resident;
    displayAll($resident, null, function ($row, $id) {
        echo "
            <tr>
                <td>{$row['masterlist_first_name']} {$row['masterlist_middle_name']} {$row['masterlist_last_name']}</td>
            </tr>

        ";
    });
}