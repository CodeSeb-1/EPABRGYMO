<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$start = 0;
$rows_per_page = 10;
$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

$record_sql = "SELECT r.*, u.user_firstname, u.user_middlename, u.user_lastname, u.user_email
                FROM reports r
                INNER JOIN users u ON r.user_id = u.user_id";

if ($filterStatus) {
    $record_sql .= " WHERE report_status = '$filterStatus'";
}

// Get total number of records
$records = $con->query($record_sql);
$nr_of_rows = $records->num_rows;

$pages = ceil($nr_of_rows / $rows_per_page);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$page = max(1, min($page, $pages)); 

$start = ($page - 1) * $rows_per_page;

$request = [
    'query' => "SELECT r.*, u.user_firstname, u.user_middlename, u.user_lastname, u.user_email
                FROM reports r
                INNER JOIN users u ON r.user_id = u.user_id",
    'bind' => '',
    'value' => []
];


function display_reports()
{
    global $request, $filterStatus, $start, $rows_per_page, $con;

    if ($filterStatus) {
        $request['query'] .= " WHERE report_status = ?";
        $request['bind'] .= 's';
        $request['value'][] = $filterStatus;
    }

    // Add pagination to the query
    $request['query'] .= " ORDER BY report_id DESC LIMIT ?, ?";
    $request['bind'] .= 'ii';
    $request['value'][] = $start;
    $request['value'][] = $rows_per_page;

    displayAll($request, null, function ($row, $id) {
        global $filterStatus, $page;

        $fullname = $row['user_firstname'] . " " . $row['user_lastname'];
        
        $formatted_date = date("F j, Y, g:i A", strtotime($row['report_date']));
        $statusClass = match ($row['report_date']) {
            'Pending' => 'status-pending',
            'Approved' => 'status-approved',
            'Declined' => 'status-declined',
            default => ''
        };

        echo "
            <tr data-doc-req-id='{$row['report_id']}'>
                <td>{$row['report_id']}</td>
                <td>{$fullname}</td>
                <td>{$row['report_type']}</td>
                <td>{$row['report_content']}</td>
                <td>{$row['report_purok']}</td>
                <td>{$formatted_date}</td>
                <td><span class='$statusClass'>{$row['report_status']}</span></td>
                <td><a href='secretary_reports.php?page=$page&status=$filterStatus&report_id={$row['report_id']}' id='view'>View</a></td>
            </tr>";
    });
}


if (
    $_SERVER["REQUEST_METHOD"] == "POST" && (
        isset($_POST['in_progress']) ||
        isset($_POST['decline']) ||
        isset($_POST['on_hold']) ||
        isset($_POST['resolved']) ||
        isset($_POST['closed']) ||
        isset($_POST['cancelled'])
    )
) {
    $report_id = $_POST['report_id'];
    $user_id = $_POST['user_id']; // Assuming you have user_id from the POST data
    $notificationLink = "http://localhost/EPABRGYMO/view_report.php?page=1&status=&report_id=$report_id";

    if (isset($_POST['in_progress'])) {
        $update = [
            'query' => "UPDATE reports SET report_status = ?, reason = null WHERE report_id = ?",
            'bind' => 'si',
            'value' => ["In Progress", $report_id]
        ];

        // Notification for In Progress
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Report Update", "Your report is now In Progress", $notificationLink]
        ];

    } elseif (isset($_POST['on_hold'])) {
        $hold_reason = $_POST['hold_reason'];

        $update = [
            'query' => "UPDATE reports SET report_status = ?, reason = ? WHERE report_id = ?",
            'bind' => 'ssi',
            'value' => ["On Hold", $hold_reason, $report_id]
        ];

        // Notification for On Hold
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Report Update", "Your report is on hold", $notificationLink]
        ];

    } elseif (isset($_POST['resolved'])) {
        $resolution_notes = $_POST['resolution_notes'];

        $update = [
            'query' => "UPDATE reports SET report_status = ?, reason = ? WHERE report_id = ?",
            'bind' => 'ssi',
            'value' => ["Resolved", $resolution_notes, $report_id]
        ];

        // Notification for Resolved
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Report Update", "Your report has been resolved", $notificationLink]
        ];

    } elseif (isset($_POST['closed'])) {
        $update = [
            'query' => "UPDATE reports SET report_status = ? WHERE report_id = ?",
            'bind' => 'si',
            'value' => ["Closed", $report_id]
        ];

        // Notification for Closed
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Report Update", "Your report has been closed", $notificationLink]
        ];

    } elseif (isset($_POST['cancelled'])) {
        $cancellation_reason = ($_POST['cancellation_reason'] === "others") ? $_POST['other_cancellation_reason'] : $_POST['cancellation_reason'];

        $update = [
            'query' => "UPDATE reports SET report_status = ?, reason = ? WHERE report_id = ?",
            'bind' => 'ssi',
            'value' => ["Cancelled", $cancellation_reason, $report_id]
        ];

        // Notification for Cancelled
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Report Update", "Your report has been cancelled", $notificationLink]
        ];

    } elseif (isset($_POST['decline'])) {
        $decline_reason = ($_POST['decline_reason'] === "others") ? $_POST['other_decline_reason'] : $_POST['decline_reason'];

        $update = [
            'query' => "UPDATE reports SET report_status = ?, reason = ? WHERE report_id = ?",
            'bind' => 'ssi',
            'value' => ["Declined", $decline_reason, $report_id]
        ];

        // Notification for Declined
        $insertNotification = [
            "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
            "bind" => "isss",
            "value" => [$user_id, "Report Update", "Your report was declined", $notificationLink]
        ];
    }

    // Execute the update and insert notification
    updateData($update);
    insertData($insertNotification);
    location("../../secretary/secretary_reports.php");
}








// if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['accept']) || isset($_POST['decline']) || isset($_POST['claim']) || isset($_POST['claimed']))) {
//     $doc_req_id = $_POST['doc_req_id'];

//     if (isset($_POST['accept'])) {
//         $update = [
//             'query' => "UPDATE document_request SET request_status = ?
//                         WHERE doc_req_id = ?",
//             'bind' => 'si',
//             'value' => ["Approved", $doc_req_id]
//         ];
      

//     } else if (isset($_POST['decline'])) {
//         $update = [
//             'query' => "UPDATE document_request SET request_status = ?
//                         WHERE doc_req_id = ?",
//             'bind' => 'si',
//             'value' => ["Declined", $doc_req_id]
//         ];
      
//     } else if (isset($_POST["claim"])) { 
//         $expiration_date = $_POST['expire_date'];
//         $update = [
//             'query' => "UPDATE document_request 
//                 SET request_status = ?, issued_date = NOW(), expiration_date = ? 
//                 WHERE doc_req_id = ?",
//             'bind' => 'ssi',
//             'value' => ["Ready To Claim", $expiration_date, $doc_req_id]
//         ];

//     } else if (isset($_POST['claimed'])) {
//         $update = [
//             'query' => "UPDATE document_request SET request_status = ?
//                         WHERE doc_req_id = ?",
//             'bind' => 'si',
//             'value' => ["Claimed", $doc_req_id]
//         ];

//     }   
//     updateData($update);
//     location("../../secretary/secretary_document_request.php");
// }

//eto ung sa modal
$requestDetails = null;
if (isset($_GET['report_id'])) {
    $report_id = $_GET['report_id'];

    $data = [
        'query' => "SELECT 
                    r.*, 
                    CONCAT(u.user_firstname, ' ', u.user_middlename, ' ', u.user_lastname) AS full_name, 
                    u.user_email
                FROM 
                    reports r
                INNER JOIN 
                    users u 
                ON 
                    r.user_id = u.user_id
                WHERE 
                    r.report_id = ?",
        'bind' => 'i',
        'value' => [$report_id]
    ];
    

    $requestDetails = select($data, true);
    if (!$requestDetails) {
        echo "<script> alert('No results found for doc_req_id: $report_id');</script>";
    }
}

//pang format lang
$requestDate = $requestDetails['request_date'] ?? '';
$dateTime = new DateTime($requestDate);
$formattedDate = $dateTime->format('F j, Y g:i A');

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