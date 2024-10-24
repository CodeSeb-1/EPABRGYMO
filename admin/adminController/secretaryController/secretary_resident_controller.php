<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');


$result = null;

// Check if editing is requested
if (isset($_GET['masterlist_id'])) {
    $id = $_GET['masterlist_id'];
    $resident = [
        'query' => 'SELECT * FROM masterlist WHERE masterlist_id = ?',
        'bind' => 'i',
        'value' => [$id]
    ];
    $result = select($resident,true);  // Fetch the resident data
}

// Handle Add or Update Resident
if (isset($_POST['add_resident']) || isset($_POST['edit_resident'])) {
    $id = $_POST['resident_id'] ?? null;
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (isset($_POST['edit_resident'])) {
        // Update existing resident
        $update = [
            'query' => "UPDATE masterlist 
                        SET masterlist_first_name = ?, masterlist_middle_name = ?, 
                            masterlist_last_name = ?, masterlist_contact_num = ?, 
                            masterlist_email = ?, masterlist_birthdate = ?, 
                            masterlist_address = ? 
                        WHERE masterlist_id = ?",
            'bind' => 'sssssssi',
            'value' => [$firstname, $middlename, $lastname, $contact, $email, $birthdate, $address, $id]
        ];
        $result = updateData($update);
    } else {
        // Add new resident
        $insert = [
            'query' => "INSERT INTO 
                        masterlist (masterlist_first_name, masterlist_middle_name, masterlist_last_name, 
                                    masterlist_contact_num, masterlist_email, masterlist_birthdate, masterlist_address)
                        VALUES (?, ?, ?, ?, ?, ?, ?)",
            'bind' => 'sssssss',
            'value' => [$firstname, $middlename, $lastname, $contact, $email, $birthdate, $address]
        ];
        $result = insertData($insert);
    }

    if ($result) {
        echo "<script>alert('Success'); window.location.href='../../secretary/secretary_resident_database.php';</script>";
    } else {
        echo "<script>alert('Error: Request could not be processed.'); window.location.href='../../secretary/secretary_resident_database.php';</script>";
    }
}





$start = 0;
$rows_per_page = 15;
$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

$record_sql = "SELECT * FROM masterlist";

$records = $con->query($record_sql);
$nr_of_rows = $records->num_rows;

$pages = ceil($nr_of_rows / $rows_per_page);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$page = max(1, min($page, $pages)); 

$start = ($page - 1) * $rows_per_page;

$resident = [
    'query' => "SELECT * FROM masterlist LIMIT ?, ?",
    'bind' => 'ii',
    'value' => [$start, $rows_per_page],
];

function display_resident() {
    global $resident;
    displayAll($resident, null, function ($row, $id) {
        global $page;

        echo "
            <tr>
                <td>{$row['masterlist_first_name']} {$row['masterlist_middle_name']} {$row['masterlist_last_name']}</td>
                <td>" . calculate_age($row['masterlist_birthdate']) . "</td>
                <td>{$row['masterlist_birthdate']}</td>
                <td>{$row['masterlist_contact_num']}</td>
                <td>{$row['masterlist_email']}</td>
                <td>{$row['masterlist_address']}</td>
                <td><a href='../secretary/secretary_resident_database.php?masterlist_id={$row['masterlist_id']}&page=$page'>Edit</a></td>
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
