<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$start = 0;
$rows_per_page = 10;
$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

$record_sql = "SELECT dr.*, dt.doc_name 
                        FROM document_request dr
                        INNER JOIN document_type dt 
                        ON dr.doc_type_id = dt.doc_type_id";

if ($filterStatus) {
    $record_sql .= " WHERE dr.request_status = '$filterStatus'";
}

// Get total number of records
$records = $con->query($record_sql);
$nr_of_rows = $records->num_rows;

$pages = ceil($nr_of_rows / $rows_per_page);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$page = max(1, min($page, $pages)); 

$start = ($page - 1) * $rows_per_page;

$request = [
    'query'=> "SELECT dr.*, dt.doc_name 
               FROM document_request dr
               INNER JOIN document_type dt 
               ON dr.doc_type_id = dt.doc_type_id",
    'bind'=> '',
    'value'=> []
];



function display_request()
{
    global $request, $filterStatus, $start, $rows_per_page, $con;

    if ($filterStatus) {
        $request['query'] .= " WHERE dr.request_status = ?";
        $request['bind'] .= 's';
        $request['value'][] = $filterStatus;
    }

    // Add pagination to the query
    $request['query'] .= " ORDER BY dr.doc_req_id DESC LIMIT ?, ?";
    $request['bind'] .= 'ii';
    $request['value'][] = $start;
    $request['value'][] = $rows_per_page;

    displayAll($request, null, function ($row, $id) {
        global $filterStatus, $page;
        
        $formatted_date = date("F j, Y, g:i A", strtotime($row['request_date']));
        $statusClass = match ($row['request_status']) {
            'Pending' => 'status-pending',
            'Approved' => 'status-approved',
            'Declined' => 'status-declined',
            default => ''
        };

        echo "
            <tr data-doc-req-id='{$row['doc_req_id']}'>
                <td>{$row['doc_req_id']}</td>
                <td>{$row['request_name']}</td>
                <td>{$row['doc_name']}</td>
                <td>{$row['request_purpose']}</td>
                <td>{$formatted_date}</td>
                <td><span class='$statusClass'>{$row['request_status']}</span></td>
                <td><a href='secretary_document_request.php?page=$page&status=$filterStatus&doc_req_id={$row['doc_req_id']}' id='view'>View</a></td>
            </tr>";
    });
}

//eto ung sa modal
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['accept']) || isset($_POST['decline']) || isset($_POST['claim']) || isset($_POST['claimed']))) {
    $doc_req_id = $_POST['doc_req_id'];
    $user_id = $_POST['user_id'];
    $notificationLink = "view_request.php?page=1&status=&doc_req_id=$doc_req_id";

    if (isset($_POST['accept'])) {
        $update = [
            'query' => "UPDATE document_request SET request_status = ?
                        WHERE doc_req_id = ?",
            'bind' => 'si',
            'value' => ["Approved", $doc_req_id]
        ];

        // Notification data for Approved
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Request Update Status", "Your Request has been approved", $notificationLink]
        ];

    } else if (isset($_POST['decline'])) {
        $decline_reason = ($_POST['decline_reason'] === "others") ? $_POST['other_decline_reason'] : $_POST['decline_reason'];

        $update = [
            'query' => "UPDATE document_request SET request_status = ?, Reason = ?
                        WHERE doc_req_id = ?",
            'bind' => 'ssi',
            'value' => ["Declined", $decline_reason, $doc_req_id]
        ];

        // Notification data for Declined
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Request Update Status", "Request was Declined", $notificationLink]
        ];

    } else if (isset($_POST["claim"])) {
        $expiration_date = $_POST['expire_date'];

        $update = [
            'query' => "UPDATE document_request SET request_status = ?, issued_date = NOW(), expiration_date = ?
                        WHERE doc_req_id = ?",
            'bind' => 'ssi',
            'value' => ["Ready To Claim", $expiration_date, $doc_req_id]
        ];

        // Notification data for Ready To Claim
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Request Update Status", "Your document is ready to claim", $notificationLink]
        ];

    } else if (isset($_POST['claimed'])) {
        $update = [
            'query' => "UPDATE document_request SET request_status = ?
                        WHERE doc_req_id = ?",
            'bind' => 'si',
            'value' => ["Claimed", $doc_req_id]
        ];

        // Notification data for Claimed
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Request Update Status", "Your document has been claimed", $notificationLink]
        ];

    } 
    // Execute update and notification insertion
    updateData($update);
    insertData($insertNotification);
    location("../../secretary/secretary_document_request.php");
}

// if (isset($_POST['add_document'])) {//add document
//     $document = $_POST['document_type'];
//     $purpose = $_POST['document_purpose'];
//     $payment = $_POST['has_payment'];

//     $data = [
//         "query" => "INSERT INTO document_type (doc_name, doc_purpose, has_payment)
//                     VALUES (?,?,?)",
//         "bind" => "sss",
//         "value" => [$document, $purpose, $payment]
//     ];

//     $results = insertData($data);
//     if($results) {
//         $_SESSION['modal_btn'] = true;
//         $_SESSION['message_modal'] = "New Document Added";
//         echo "<script>window.location.href='../../secretary/secretary_document_request.php#documents'</script>";
//     }
// } else if (isset($_POST['update_document'])) {
//     $doc_id = $_POST['doc_type_id'];
//     $document_type = $_POST['document_type'];
//     $document_purpose = $_POST['document_purpose'];
//     $has_payment = $_POST['has_payment'];

//     $data = [
//         "query" => "UPDATE document_type SET doc_name = ?, doc_purpose = ?, has_payment = ? WHERE doc_type_id = ?",
//         "bind" => "sssi",
//         "value" => [$document_type, $document_purpose, $has_payment, $doc_id]
//     ];

//     $results = updateData($data);
//     if($results) {
//         $_SESSION['modal_btn'] = true;
//         $_SESSION['message_modal'] = "Document Updated";
//         echo "<script>window.location.href='../../secretary/secretary_document_request.php#documents'</script>";
//     }
// }

// $start_1 = 0;
// $rows_per_page_1 = 10;
// $selectedStatus = $_GET['status'] ?? 'All';
// $filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

// // Get total number of records
// $record_sql = "SELECT * FROM document_type ORDER BY doc_type_id DESC";
// $records = $con->query($record_sql);
// $nr_of_rows_1 = $records->num_rows;

// // Calculate total pages
// $pages_1 = ceil($nr_of_rows_1 / $rows_per_page_1);

// // Determine current page number
// $page_1 = isset($_GET['page_1']) ? (int)$_GET['page_1'] : 1; 
// $page_1 = max(1, min($page_1, $pages_1)); 

// // Calculate the starting row for the query
// $start_1 = ($page_1 - 1) * $rows_per_page_1;

// $display_documents = [
//     "query" => "SELECT * FROM document_type ORDER BY doc_type_id DESC LIMIT $start_1, $rows_per_page_1",
//     "bind" => "",
//     "value" => []
// ];

// function display_documents()
// {
//     global $display_documents;

//     displayAll($display_documents, null, function ($row, $id) {
//         echo "
//             <tr>
//                <td>{$row['doc_name']}</td>
//                <td>{$row['doc_purpose']}</td>
//                <td>{$row['has_payment']}</td>
//                <td>{$row['created_at']}</td>
//                 <td><a href='secretary_document_request.php?id={$row['doc_type_id']}' id='view'>View</a></td>
//             </tr>";
//     });

// //     <td>
// //     <a href='../secretary/secretary_document_request.php?id={$row['doc_type_id']}#documents'><span class='material-symbols-outlined edit'>edit_square</span></a>
// //     <a href='?delete_id={$row['doc_type_id']}#documents'><span class='material-symbols-outlined delete'>delete</span></a>
// // </td>
// }

// if (isset($_GET['delete_id'])) {
//     $delete_id = $_GET['delete_id'];
//     echo "
//     <div class='modal'>
//         <p>Are you sure you want to delete this document?</p>
//         <a href='?confirm_delete={$delete_id}#documents'>Yes</a>
//         <a href='secretary_document_request.php#documents'>No</a>
//     </div>";
// }

// // Execute deletion if confirmed
// if (isset($_GET['confirm_delete'])) {
//     $doc_id = $_GET['confirm_delete'];
    
//     // Define the delete query
//     $data = [
//         "query" => "DELETE FROM document_type WHERE doc_type_id = ?",
//         "bind" => "i",
//         "value" => [$doc_id]
//     ];

//      deleteData($data);
    
//         $_SESSION['modal_btn'] = true;
//         $_SESSION['message_modal'] = "Document Deleted Successfully";
//         echo "<script>window.location.href='secretary_document_request.php#documents'</script>";
    
// }

// $document = null;
// if (isset($_GET['id'])) {
//     $data = [
//         "query" => "SELECT * FROM document_type WHERE doc_type_id = ?",
//         "bind" => "i",
//         "value" => [$_GET['id']]
//     ];

//     $results = select($data, true);
//     if ($results) {
//         $document = $results;
//     }
// }
