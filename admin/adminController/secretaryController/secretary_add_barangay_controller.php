<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$result = null;

// Check if editing is requested
if (isset($_GET['user_id'])) {
    $id = $_GET['user_id'];
    $user = [
        'query' => 'SELECT * FROM users WHERE user_id = ?',
        'bind' => 'i',
        'value' => [$id]
    ];
    $result = select($user, true);  // Fetch the user data
}

// Handle Add or Update User
if (isset($_POST['add']) || isset($_POST['edit'])) {
    $user_type = $_POST['user_type'];
    $id = $_POST['user_id'] ?? null;
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $address = trim($_POST['address']);

    // Check if email already exists
    if (!isset($_POST['edit'])) { // Only check if not editing
        $email_check = [
            'query' => 'SELECT COUNT(*) FROM users WHERE user_email = ?',
            'bind' => 's',
            'value' => [$email]
        ];
        $email_exists = select($email_check, true); // Assuming select returns a single value
        
        if ($email_exists['COUNT(*)'] > 0) {
            echo "<script>alert('Error: Email already exists. Please use a different email.'); window.location.href='../../secretary/secretary_add_barangay.php'; window.history.back();</script>";
            exit; // Stop further processing
        }
    }

    if (isset($_POST['edit'])) {
        // Update existing user
        $update = [
            'query' => "UPDATE users 
                        SET user_firstname = ?, user_middlename = ?, 
                            user_lastname = ?, user_phoneNo = ?, 
                            user_email = ?, user_birthdate = ?, 
                            user_address = ?, user_type = ?
                        WHERE user_id = ?",
            'bind' => 'ssssssssi',
            'value' => [$firstname, $middlename, $lastname, $contact, $email, $birthdate, $address, $user_type, $id]
        ];
        $result = updateData($update);
        if ($result) {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "User Updated Successfully";
            echo "<script>window.location.href='../../secretary/secretary_add_barangay.php'</script>";
        } else {
            echo "<script>alert('Error: Request could not be processed.'); window.location.href='../../secretary/secretary_add_barangay.php';</script>";
        }
    } else {
        // Add new user
        $insert = [
            'query' => "INSERT INTO 
                        users (user_firstname, user_middlename, user_lastname, 
                                user_phoneNo, user_email, user_birthdate, user_address, user_type, user_verification)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'bind' => 'sssssssss',
            'value' => [$firstname, $middlename, $lastname, $contact, $email, $birthdate, $address, $user_type, "Verified"]
        ];
        $result = insertData($insert, "BarangayOfficials");
        if ($result) {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "Added New User";
            echo "<script>window.location.href='../../secretary/secretary_add_barangay.php'</script>";
        } else {
            echo "<script>alert('Error: Request could not be processed.'); window.location.href='../../secretary/secretary_add_barangay.php';</script>";
        }
    }
}

function calculate_age($birthdate) {
    $birthDate = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}

$start = 0;
$rows_per_page = 15;
$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

$search = $_GET['search'] ?? '';
$search = $con->real_escape_string($search); // Sanitize the input

// Update the record SQL query to exclude users with user_type 'Resident'
$record_sql = "SELECT * FROM users WHERE user_type != 'Resident' AND CONCAT(user_firstname, ' ', user_middlename, ' ', user_lastname) LIKE ?";

$stmt = $con->prepare($record_sql);
$searchTerm = "%$search%"; // Prepare search term for wildcard search
$stmt->bind_param('s', $searchTerm);
$stmt->execute();

$records = $stmt->get_result();
$nr_of_rows = $records->num_rows;

// Pagination logic
$pages = ceil($nr_of_rows / $rows_per_page);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$page = max(1, min($page, $pages)); 

$start = ($page - 1) * $rows_per_page;

// Prepare user query with pagination, excluding 'Resident'
$user = [
    'query' => "SELECT * FROM users WHERE user_type != 'Resident' AND CONCAT(user_firstname, ' ', user_middlename, ' ', user_lastname) LIKE ? ORDER BY user_id DESC LIMIT ?, ?",
    'bind' => 'sii',
    'value' => [$searchTerm, $start, $rows_per_page],
];

function display_user() {
    global $user;
    
    // Prepare the statement
    $stmt = $GLOBALS['con']->prepare($user['query']);
    $stmt->bind_param($user['bind'], ...$user['value']);
    $stmt->execute();
    
    // Get the results
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        global $page;
        $birthdate = new DateTime($row['user_birthdate']);
        $formattedBirthdate = $birthdate->format('F j, Y');
        echo "
            <tr>
                <td>{$row['user_type']}</td>
                <td>{$row['user_firstname']} {$row['user_middlename']} {$row['user_lastname']}</td>
                <td>" . calculate_age($row['user_birthdate']) . "</td>
                <td>{$formattedBirthdate}</td>
                <td>{$row['user_phoneNo']}</td>
                <td>{$row['user_email']}</td>
                <td>{$row['user_address']}</td>
                <td><a href='../secretary/secretary_add_barangay.php?user_id={$row['user_id']}&page=$page'>Edit</a></td>
            </tr>
        ";
    }
}
