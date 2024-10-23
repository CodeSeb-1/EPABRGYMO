<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');


if (isset($_POST['add_resident'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $insert = [
        'query' => "INSERT INTO 
                        masterlist (masterlist_first_name, masterlist_middle_name, masterlist_last_name, 
                                    masterlist_contact_num, masterlist_email, masterlist_birthdate, masterlist_address)
                    VALUES (?, ?, ?, ?, ?, ?, ?)",
        'bind' => 'sssssss',
        'value' => [$firstname, $middlename, $lastname, $contact, $email, $birthdate, $address]
    ];

    $result = insertData($insert);

    if ($result) {
        echo "<script>alert('Success'); window.location.href='../../secretary/secretary_resident_database.php';</script>";
    } else {
        echo "<script>alert('Error: Request could not be processed.'); window.location.href='../../secretary/secretary_resident_database.php';</script>";
    }
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
                <td>" . calculate_age($row['masterlist_birthdate']) . "</td>
                <td>{$row['masterlist_birthdate']}</td>
                <td>{$row['masterlist_contact_num']}</td>
                <td>{$row['masterlist_email']}</td>
                <td>{$row['masterlist_address']}</td>
            </tr>
        ";
    });
}

function calculate_age($birthdate) {
    $birthDate = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}
