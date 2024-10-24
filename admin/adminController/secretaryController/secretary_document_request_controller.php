<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$start = 0;
$rows_per_page = 10;

// Get total number of records
$records = $con->query("SELECT dr.*, dt.doc_name 
                        FROM document_request dr
                        INNER JOIN document_type dt 
                        ON dr.doc_type_id = dt.doc_type_id");
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

$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

function display_request() {
    global $request, $filterStatus, $start, $rows_per_page, $con;

    if ($filterStatus) {
        $request['query'] .= " WHERE dr.request_status = ?";
        $request['bind'] .= 's';  
        $request['value'][] = $filterStatus;
    }

    $request['query'] .= " ORDER BY dr.doc_req_id DESC LIMIT ?, ?";
    $request['bind'] .= 'ii';  
    $request['value'][] = $start;
    $request['value'][] = $rows_per_page;

    displayAll($request, null, function($row, $id) {
        $formatted_date = date("F j, Y, g:i A", strtotime($row['request_date']));
        $statusClass = '';
        if ($row['request_status'] === 'Pending') {
            $statusClass = 'status-pending';
        } elseif ($row['request_status'] === 'Approved') {
            $statusClass = 'status-approved';
        } elseif ($row['request_status'] === 'Declined') {
            $statusClass = 'status-declined';
        }

        echo "
            <tr data-doc-req-id='{$row['doc_req_id']}'>
                <td>{$row['doc_req_id']}</td>
                <td>{$row['request_name']}</td>
                <td>{$row['doc_name']}</td>
                <td>{$row['request_purpose']}</td>
                <td>{$formatted_date}</td>
                <td><span class='$statusClass'>{$row['request_status']}</span></td>
                <td><a href='?doc_req_id={$row['doc_req_id']}' id='view'>View</a></td>
            </tr>";
    });
}




if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['accept']) || isset($_POST['decline']) || isset($_POST['claim']) )) {
    $doc_req_id = $_POST['doc_req_id'];

    if (isset($_POST['accept'])) {
        $update = [
            'query' => "UPDATE document_request SET request_status = ?
                        WHERE doc_req_id = ?",
            'bind' => 'si',
            'value' => ["Approved", $doc_req_id]
        ];
      

    } else if (isset($_POST['decline'])) {
        $update = [
            'query' => "UPDATE document_request SET request_status = ?
                        WHERE doc_req_id = ?",
            'bind' => 'si',
            'value' => ["Declined", $doc_req_id]
        ];
      
    } else if (isset($_POST["claim"])) { 
        $update = [
            'query' => "UPDATE document_request SET request_status = ?
                        WHERE doc_req_id = ?",
            'bind' => 'si',
            'value' => ["Ready To Claim", $doc_req_id]
        ];
    }   
    updateData($update);
    location("../../secretary/secretary_document_request.php");
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