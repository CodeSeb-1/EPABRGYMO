<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
$user_id = $_SESSION['user_id'];

if (isset($_POST['report'])) {
    $report_type = $_POST['report_type'];
    $report_content = $_POST['description'];
    $report_name = $_POST['person'];
    $report_purok = ($_POST['purokOption'] === "sameAsMe") ? $_SESSION['user_purok'] : $_POST['otherPurok'];

    $insert_report = [
        'query' => "INSERT INTO reports (user_id, report_type, report_content, report_name, report_purok) 
                    VALUES (?, ?, ?, ?, ?)",
        'bind' => 'isssi',
        'value' => [$user_id, $report_type, $report_content, $report_name, $report_purok]
    ];

    $result = insertData($insert_report);

    if ($result) {
        $_SESSION['modal_btn'] = true;
        header("Location: ../report.php");
        exit;
    }
}

$start = 0;
$rows_per_page = 15;
$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max(1, $page); // Ensure the page number is at least 1

// Query request for fetching reports with pagination
$request = [
    'query' => "SELECT r.*, u.user_firstname, u.user_middlename, u.user_lastname, u.user_email 
                FROM reports r
                INNER JOIN users u ON r.user_id = u.user_id 
                WHERE r.user_id = ?" .
        ($filterStatus ? " AND r.report_status = ?" : "") .
        " ORDER BY r.report_id DESC LIMIT ?, ?",
    'bind' => $filterStatus ? 'ssii' : 'sii',
    'value' => $filterStatus
        ? [$user_id, $filterStatus, $start, $rows_per_page]
        : [$user_id, $start, $rows_per_page]
];

// Get the total number of reports for pagination
$totalReports = select([
    'query' => "SELECT COUNT(*) AS total FROM reports WHERE user_id = ?" .
        ($filterStatus ? " AND report_status = ?" : ""),
    'bind' => $filterStatus ? 'ss' : 's',
    'value' => $filterStatus ? [$user_id, $filterStatus] : [$user_id]
], true)['total'];

$pages = ceil($totalReports / $rows_per_page);
$page = min($page, $pages); // Ensure the page number doesn't exceed total pages
$start = ($page - 1) * $rows_per_page; // Recalculate starting point

// Render the report table rows
function display_reports()
{
    global $request;
    $renderRow = function ($row, $id) {
        $action = $row['report_status'] === 'Pending'
            ? "<a href='view_report.php?report_id={$row['report_id']}&page={$id}&status={$row['report_status']}'>Cancel</a>"
            : "<a href='view_report.php?page={$id}&status={$row['report_status']}&report_id='view'>View</a>";

        return "
            <tr>
                <td>{$row['report_id']}</td>
                <td>{$row['report_type']}</td>
                <td>{$row['report_content']}</td>
                <td>{$row['report_purok']}</td>
                <td>{$row['report_date']}</td>
                <td>{$row['report_status']}</td>
                <td>$action</td>
            </tr>";
    };

    echo displayAll($request, $_GET['page'] ?? 1, $renderRow);
}

?>