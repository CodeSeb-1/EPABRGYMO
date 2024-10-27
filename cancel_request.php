<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
$request_id = $_GET['id'];
$update_status = [
    'query' => "UPDATE document_request 
                SET request_status = 'Canceled' 
                WHERE doc_req_id = ?",
    'bind' => 'i',
    'value' => [$request_id]
];
$result = updateData($update_status);

if ($result) {
    echo "<script>alert('Success'); window.location.href='view_request.php';</script>";
} else {
    echo "<script>alert('Error: Request could not be processed.'); window.location.href='view_request.php';</script>";
}
?>