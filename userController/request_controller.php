<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

if (isset($_POST['request'])) {

    $select_document = $_POST['documentId'];
    $select_purpose = ($_POST['purpose'] === 'others') ? $_POST['other_Purpose'] : $_POST['purpose'];

    if ($_POST['requestor'] === "me") {
        $originalUser = $_POST['originalUser'];
        $originalAddress = $_POST['addressOption'];

        $insert_original = [
            'query' => "INSERT INTO document_request (user_id, doc_type_id, request_name, request_purpose, request_address, request_age)
                        VALUES (?,?,?,?,?,?)",
            'bind' => 'iisssi',
            'value' => [$_SESSION['user_id'], $select_document, $originalUser, $select_purpose, $_SESSION['user_address'], $_SESSION['user_age']]
        ];

        $result = insertData($insert_original);

        if ($result) {
            echo "<script>alert('Success'); window.location.href='../request.php';</script>";
        } else {
            echo "<script>alert('Error: Request could not be processed.'); window.location.href='../request.php';</script>";
        }

    } else { // pag other 

        $requestor_name = $_POST['otherName'];
        $requestor_bday = $_POST['otherBirthday'];
        $requestor_age = calculateAge($requestor_bday);


        $address = ($_POST['addressOption'] === "sameAsMe") ? $_SESSION['user_address'] : $_POST['otherAddress'];

        $insert_requestor = [
            'query' => "INSERT INTO document_request (user_id, doc_type_id, request_name, request_purpose, request_address, request_age)
                        VALUES (?,?,?,?,?,?)",
            'bind' => 'iissss',
            'value' => [$_SESSION['user_id'], $select_document, $requestor_name, $select_purpose, $address, $requestor_age]
        ];

        $result = insertData($insert_requestor);
    }
    echo "<script>alert('Completed'); window.location.href='../request.php'</script>";
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

$start = 0;
$rows_per_page = 4;

$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

$query = "SELECT dr.*, dt.doc_name 
          FROM document_request dr
          JOIN document_type dt ON dr.doc_type_id = dt.doc_type_id
          WHERE dr.user_id = {$_SESSION['user_id']}";

if ($filterStatus) {
    $query .= " AND dr.request_status = '{$filterStatus}'";
}

$records = $con->query($query);
$nr_of_rows = $records->num_rows;

$pages = ceil($nr_of_rows / $rows_per_page);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $pages));

$start = ($page - 1) * $rows_per_page;

$query .= " ORDER BY dr.request_status DESC LIMIT $start, $rows_per_page";

$display_request = [
    'query' => $query,
    'bind' => '', 
    'value' => []
];

function display_request() {
    global $display_request;

    // Display the results using your existing displayAll logic
    displayAll($display_request, null, function ($row, $id) {
        echo "
            <tr>
                <td>{$row['request_name']}</td>
                <td>{$row['request_age']}</td>
                <td>{$row['request_address']}</td>
                <td>{$row['doc_name']}</td>
                <td>{$row['request_purpose']}</td>
                <td>{$row['request_status']}</td>
                <td>";
        
        // Show the cancel link only if the status is 'Pending'
        if ($row['request_status'] === 'Pending') {
            echo "<a href='cancel_request.php?id={$row['doc_req_id']}' onclick='return confirm(\"Are you sure you want to cancel this request?\")'>Cancel</a>";
        }

        echo "</td>
            </tr>";
    });
}




