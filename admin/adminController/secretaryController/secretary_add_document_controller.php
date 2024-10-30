<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

if (isset($_POST['add_document'])) {//add document

    $document = $_POST['document_type'];
    $purpose = $_POST['document_purpose'];

    $data = [
        "query" => "INSERT INTO document_type (doc_name, doc_purpose)
                    VALUES (?,?,?)",
        "bind" => "ss",
        "value" => [$document, $purpose]
    ];

    $results = insertData($data);
    if($results) {
        $_SESSION['modal_btn'] = true;
        $_SESSION['message_modal'] = "New Document Added";
        echo "<script>window.location.href='../../secretary/secretary_add_document.php#documents'</script>";
    }

} else if (isset($_POST['update_document'])) {

    $doc_id = $_SESSION['doc_type_id'];
    $document_type = $_POST['document_type'];
    $document_purpose = $_POST['document_purpose'];
    $has_payment = $_POST['has_payment'];

    $data = [
        "query" => "UPDATE document_type SET doc_name = ?, doc_purpose = ? WHERE doc_type_id = ?",
        "bind" => "ssi",
        "value" => [$document_type, $document_purpose, $doc_id]
    ];

    $results = updateData($data);
    if($results) {
        $_SESSION['modal_btn'] = true;
        $_SESSION['message_modal'] = "Document Updated";
        echo "<script>window.location.href='../../secretary/secretary_add_document.php#documents'</script>";
    }

} else if (isset($_POST['remove_document'])) {

    $doc_id = $_SESSION['doc_type_id'];

    $data = [
        "query" => "DELETE FROM document_type WHERE doc_type_id = ?",
        "bind" => "i",
        "value" => [$doc_id]
    ];

    deleteData($data);
    $_SESSION['modal_btn'] = true;
    $_SESSION['message_modal'] = "Deleted Document Successpoley";
     echo "<script>window.location.href='../../secretary/secretary_add_document.php#documents'</script>";

}

$start_1 = 0;
$rows_per_page_1 = 10;
$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

// Get total number of records
$record_sql = "SELECT * FROM document_type ORDER BY doc_type_id DESC";
$records = $con->query($record_sql);
$nr_of_rows_1 = $records->num_rows;

// Calculate total pages
$pages_1 = ceil($nr_of_rows_1 / $rows_per_page_1);

// Determine current page number
$page_1 = isset($_GET['page_1']) ? (int)$_GET['page_1'] : 1; 
$page_1 = max(1, min($page_1, $pages_1)); 

// Calculate the starting row for the query
$start_1 = ($page_1 - 1) * $rows_per_page_1;

$display_documents = [
    "query" => "SELECT * FROM document_type ORDER BY doc_type_id DESC LIMIT $start_1, $rows_per_page_1",
    "bind" => "",
    "value" => []
];

function display_documents()
{
    global $display_documents;

    displayAll($display_documents, null, function ($row, $id) {
        echo "
            <tr>
               <td>{$row['doc_name']}</td>
               <td>{$row['doc_purpose']}</td>
               <td>{$row['created_at']}</td>
                <td><a href='secretary_add_document.php?doc_type_id={$row['doc_type_id']}' id='view'>View</a></td>
            </tr>";
    });

//     <td>
//     <a href='../secretary/secretary_document_request.php?id={$row['doc_type_id']}#documents'><span class='material-symbols-outlined edit'>edit_square</span></a>
//     <a href='?delete_id={$row['doc_type_id']}#documents'><span class='material-symbols-outlined delete'>delete</span></a>
// </td>
}

$requestDetails = null;
if (isset($_GET['doc_type_id'])) {
    $doc_type_id = $_GET['doc_type_id'];

    $data = [
        'query' => "SELECT * FROM document_type WHERE doc_type_id = ?;
                    ",
        'bind' => 'i',
        'value' => [$doc_type_id]
    ];

    $requestDetails = select($data, true);
    if (!$requestDetails) {
        echo "<script> alert('No results found for doc_req_id: $doc_type_id');</script>";
    }
}
$issuedDate = isset($requestDetails['created_at']) ? new DateTime($requestDetails['created_at']) : '';
$formattedIssuedDate = $issuedDate ? $issuedDate->format('F j, Y') : ''; // Example format: October 30, 2024

