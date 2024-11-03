<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/calendar.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$start = 0;
$rows_per_page = 10;
$selectedStatus = $_GET['status'] ?? 'All';
$filterStatus = $selectedStatus !== 'All' ? $selectedStatus : null;

$record_sql = "SELECT * FROM events";

if ($filterStatus) {
    $record_sql .= " WHERE event_user_position = '$filterStatus'";
}

$records = $con->query($record_sql);
$nr_of_rows = $records->num_rows;

$pages = ceil($nr_of_rows / $rows_per_page);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$page = max(1, min($page, $pages)); 

$start = ($page - 1) * $rows_per_page;

function display_events() {
    global $events, $colors, $filterStatus, $start, $rows_per_page;

    $colors = [
        "Tanod" => "#ce5151",
        "Health Workers" => "#51ce57",
        "Kagawad" => "#518fce",
        "BrgyCaptain" => "#a45eb4"
    ];

    $events['query'] = "SELECT * FROM events";
    $events['bind'] = '';
    $events['value'] = []; 

    if ($filterStatus) {
        $events['query'] .= " WHERE event_user_position = ?";
        $events['bind'] .= 's'; // Bind type for string
        $events['value'][] = $filterStatus;
    }

    $events['query'] .= " ORDER BY event_id DESC LIMIT ?, ?";
    $events['bind'] .= 'ii'; // Bind types for integers
    $events['value'][] = $start;
    $events['value'][] = $rows_per_page;

    displayAll($events, null, function ($row, $id) use ($colors) {
        global $page, $filterStatus;

        $start = new DateTime($row['event_start']);
        $end = new DateTime($row['event_end']);

        $start_date = $start->format('F j, Y'); 
        $end_date = $end->format('F j, Y'); 
        
        // Get the user type and corresponding color
        $user_type = $row['event_user_position'];
        $line_color = isset($colors[$user_type]) ? $colors[$user_type] : 'gray';


        echo "
            <tr>
                <td><p style='background: $line_color'>.</p></td>
                <td>{$row['event_user_position']}</td>
                <td>{$row['event_name']}</td>
                <td>{$row['event_address']}</td>
                <td>{$start_date}</td>
                <td>{$end_date}</td>
                <td>
                    <a href='secretary_calendar.php?page=$page&status=$filterStatus&event_id_tag={$row['event_id']}' id='view'>View</a>
                </td>
            </tr>
        ";
    });
}


$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

$calendar = new Calendar($selectedYear . '-' . $selectedMonth . '-01', false);

$data = [
    'query' => "
        SELECT event_id, event_name, event_user_position, event_start, event_end, event_description, event_address 
        FROM events 
        WHERE (
            MONTH(event_start) = ? 
            OR MONTH(event_end) = ?
            OR (
                event_start <= LAST_DAY(?) AND event_end >= ?
            )
        ) AND YEAR(event_start) = ?",
    'bind' => 'iiiis',
    'value' => [
        $selectedMonth, 
        $selectedMonth, 
        $selectedYear . '-' . $selectedMonth . '-01',
        $selectedYear . '-' . $selectedMonth . '-01',
        $selectedYear
    ]
];


$results = select($data); 

$colors = [
    "Tanod" => "red",
    "Health Workers" => "green",
    "Kagawad" => "blue",
    "BrgyCaptain" => "purple"
];


if ($results && is_array($results)) {
    foreach ($results as $result) {
        $startDate = new DateTime($result['event_start']);
        $endDate = new DateTime($result['event_end']);
        $duration = $endDate->diff($startDate)->days + 1;

        $userPosition = $result['event_user_position'];
        $currentColor = $colors[$userPosition] ?? "black";

        $calendar->add_event(
            $result['event_id'],
            $result['event_name'],
            $result['event_start'], 
            $duration,
            $currentColor, // Use the current color
            $result['event_description'], 
            $result['event_address'] 
        );
    }
} else {
    error_log("No events found or an error occurred: " . print_r($results, true));
}


//DISPLAY MODAL WITH VALUES

$requestDetails = null;

if (isset($_GET['event_id_tag'])) {
    $event_id = $_GET['event_id_tag'];

    $data = [
        'query' => "SELECT * FROM events 
                    WHERE event_id = ?;
                    ",
        'bind' => 'i',
        'value' => [$event_id]
    ];

    $requestDetails = select($data, true);
    if (!$requestDetails) {
        echo "<script> alert('No results found for event_id: $event_id');</script>";
    }
}

//pang format lang
$eventStart = isset($requestDetails['event_start']) ? (new DateTime($requestDetails['event_start']))->format('F j, Y') : 'N/A';
$eventEnd = isset($requestDetails['event_end']) ? (new DateTime($requestDetails['event_end']))->format('F j, Y') : 'N/A';


// $duration = $formattedIssuedDate." - ". $formattedExpirationDate;

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

