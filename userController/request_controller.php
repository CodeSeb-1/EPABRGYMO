<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

if (isset($_POST['request'])) {

    $select_document = $_POST['documentId'];
    $select_purpose = ($_POST['purpose'] === 'Others') ? $_POST['other_Purpose'] : $_POST['purpose'];


    //PAG ME LANG
    if ($_POST['requestor'] === "me") {
        $originalUser = $_POST['originalUser'];
        $originalAddress = $_POST['addressOption'];

        $insert_original = [
            'query' => "INSERT INTO document_request (user_id, doc_type_id, request_name, request_purpose, request_address, request_age, relationship)
                        VALUES (?,?,?,?,?,?,?)",
            'bind' => 'iisssis',
            'value' => [$_SESSION['user_id'], $select_document, $originalUser, $select_purpose, $_SESSION['user_address'], $_SESSION['user_age'], "Me"]
        ];

        $result = insertData($insert_original);

    } else { // PAG IBA 

        $relationship = $_POST['relationship'];
        $requestor_name = $_POST['otherName'];
        $requestor_bday = $_POST['otherBirthday'];
        $requestor_age = calculateAge($requestor_bday);

        $address = ($_POST['addressOption'] === "sameAsMe") ? $_SESSION['user_address'] : $_POST['otherAddress'];

        $insert_requestor = [
            'query' => "INSERT INTO document_request (user_id, doc_type_id, request_name, request_purpose, request_address, request_age, relationship)
                        VALUES (?,?,?,?,?,?,?)",
            'bind' => 'iisssss',
            'value' => [$_SESSION['user_id'], $select_document, $requestor_name, $select_purpose, $address, $requestor_age, $relationship]
        ];

        $result = insertData($insert_requestor);
    }

    if ($result) {
        $_SESSION['modal_btn'] = true;
        header("Location: ../request.php");
        exit;
    }
}

function calculateAge($birthday)
{
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age; //
}

$show_documents = [
    'query' => 'SELECT * FROM document_type',
    'bind' => '',
    'value' => '',
];

function display_document()
{
    global $show_documents;

    $documents = displayAll($show_documents, null, function ($row, $id) {
        return '<option value="' . $row['doc_type_id'] . '">' . $row['doc_name'] . '</option>';
    });

    if (!$documents) {
        echo '<option>No documents available</option>';
    } else {
        echo $documents;
    }
}

if (isset($_POST['documentId'])) {
    $docId = $_POST['documentId'];

    $data = [
        'query' => 'SELECT doc_purpose FROM document_type WHERE doc_type_id = ?',
        'bind' => 'i',
        'value' => [$docId]
    ];

    $result = select($data, true);

    if ($result) {
        $purposes = explode(',', $result['doc_purpose']);
        $purposes[] = 'Others'; // Ensure "others" is included
        echo json_encode($purposes);
    } else {
        echo json_encode([]); // Send empty array if nothing is found
    }
    exit; // Ensure script stops after handling the AJAX request
}

$start = 0;
$rows_per_page = 15;

$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

$query = "SELECT dr.*, dt.doc_name 
          FROM document_request dr
          JOIN document_type dt ON dr.doc_type_id = dt.doc_type_id
          WHERE dr.user_id = {$_SESSION['user_id']}
          AND (dr.expiration_date IS NULL OR CURDATE() <= dr.expiration_date)";

if ($filterStatus) {
    $query .= " AND dr.request_status = '{$filterStatus}'";
}

$records = $con->query($query);
$nr_of_rows = $records->num_rows;

$pages = ceil($nr_of_rows / $rows_per_page);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $pages));

$start = ($page - 1) * $rows_per_page;

$query .= " ORDER BY dr.doc_req_id DESC LIMIT $start, $rows_per_page";

$display_request = [
    'query' => $query,
    'bind' => '', 
    'value' => []
];

function display_request() {
    global $display_request;

    // Display the results using your existing displayAll logic
    displayAll($display_request, null, function ($row, $id) {
        global $page, $filterStatus;

        $statusClass = match ($row['request_status']) {
            'Pending' => 'status-pending',
            'Approved' => 'status-approved',
            'Declined' => 'status-declined',
            default => ''
        };
        echo "
            <tr>
                <td>{$row['request_name']}</td>
                <td>{$row['request_age']}</td>
                <td>{$row['request_address']}</td>
                <td>{$row['doc_name']}</td>
                <td>{$row['request_purpose']}</td>
                <td><span class='$statusClass'>{$row['request_status']}</span></td>";
        
        // Show the cancel link only if the status is 'Pending'
        if ($row['request_status'] === 'Pending') {
             echo "<td><a href='view_request.php?doc_req_id={$row['doc_req_id']}&page={$page}&status={$filterStatus}'>Cancel</a></td>";
        } else {
            echo "<td><a href='view_request.php?page={$page}&status={$filterStatus}&doc_req_id={$row['doc_req_id']}' id='view'>View</a></td>";
        }
        echo"</tr>";
    });
}


$requestDetails = null;
if (isset($_GET['doc_req_id'])) {
    $docReqId = $_GET['doc_req_id'];

    $data = [
        'query' => "SELECT 
                        dr.*, dt.doc_name 
                    FROM 
                        document_request dr
                    INNER JOIN 
                        document_type dt 
                    ON 
                        dr.doc_type_id = dt.doc_type_id
                    WHERE 
                        dr.doc_req_id = ?;
                    ",
        'bind' => 'i',
        'value' => [$docReqId]
    ];

    $requestDetails = select($data, true);
    if (!$requestDetails) {
        echo "<script> alert('No results found for doc_req_id: $docReqId');</script>";
    }
}

//pang format lang
$issuedDate = $requestDetails['issued_date'] ?? '';
$expirationDate = $requestDetails['expiration_date'] ?? '';
$requestDate = $requestDetails['request_date'] ?? '';
$dateTime = new DateTime($requestDate);
$formattedDate = $dateTime->format('F j, Y g:i A');
$formattedIssuedDate = $issuedDate ? (new DateTime($issuedDate))->format('F j, Y') : 'N/A';
$formattedExpirationDate = $expirationDate ? (new DateTime($expirationDate))->format('F j, Y') : 'N/A';

$duration = $formattedIssuedDate." - ". $formattedExpirationDate;

//para lang sa kulay
$requestStatus = $requestDetails['request_status'] ?? '';
$statusClass = '';
if ($requestStatus === 'Pending') {
    $statusClass = 'status-pending';
} elseif ($requestStatus === 'Approved') {
    $statusClass = 'status-approved';
} elseif ($requestStatus === 'Declined') {
    $statusClass = 'status-declined';
}

//pag nag cancel ng document
if(isset($_POST['cancel'])) {
    $reason = $_POST['reason'];
    $request_id = $_POST['doc_req_id'];

    $update_status = [
        'query' => "UPDATE document_request 
                    SET request_status = 'Canceled', reason = ?
                    WHERE doc_req_id = ?",
        'bind' => 'si',
        'value' => [$reason, $request_id]
    ];
    $result = updateData($update_status);

    //modal na mag pop up pag sucess na
    if ($result) {
        unset($_POST['cancel']);
        $_SESSION['modal_btn'] = true;
        header("Location: ../view_request.php");
        exit;
    }
}