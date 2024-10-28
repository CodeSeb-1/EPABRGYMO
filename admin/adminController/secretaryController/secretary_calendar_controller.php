<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/admin/calendar.php');
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

$color_event = '';
if (isset($_POST["add_event"])) {
    $user = $_POST["users"];
    $_SESSION['event_user_position'] = $user;
    $color_event= $user;
    
    $event_name = $_POST["event_name"];
    $event_description = $_POST["event_description"];
    $event_address = $_POST["event_address"];
    $event_start = $_POST["event_start"];

    $event_duration = $_POST["event_duration"];

    $startDate = new DateTime($event_start);
    $startDate->modify('+' . $event_duration . ' days');
    $event_end = $startDate->format('Y-m-d H:i:s');

    $checkQuery = [
        'query' => "SELECT COUNT(*) FROM events
                    WHERE event_address = ?
                    AND (
                        (event_start <= ? AND event_end >= ?) OR
                        (event_start <= ? AND event_end >= ?)
                    )
                    AND (DATE_FORMAT(event_start, '%Y-%m-%d') = DATE_FORMAT(?, '%Y-%m-%d'))",
        'bind' => 'ssssss',
        'value' => [
            $event_address,
            $event_end,     
            $event_start,  
            $event_start,   
            $event_start,  
            $event_start   
        ]
    ];

    $check_results = select($checkQuery);

    // check if may overlap na events
    if ($check_results && $check_results[0]['COUNT(*)'] > 0) {
        $_SESSION['modal_btn'] = true;
        $_SESSION['message_modal'] = "There is an event at the same location on the same date.";
        echo "<script>window.history.back(); window.location.href='../secretary_calendar.php'</script>";

        // echo "<script>alert('There is an event at the same location on the same date.'); window.location.href='../tanod_calendar.php';</script>";
    } else {

        if($event_start > $event_end) {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "inang yan mas malaki a ung event start e";
            echo "<script>window.history.back(); window.location.href='../secretary_calendar.php'</script>";
        } else {
            $data = [
                "query" => "INSERT INTO events (event_user_position, event_name, event_description, event_address, event_start, event_end)
                            VALUES (?,?,?,?,?,?)",
                "bind" => "ssssss",
                "value" => [$_SESSION['event_user_position'], $event_name, $event_description, $event_address, $event_start, $event_end]
            ];

            $result = insertData($data, "Events");
            if ($result) {
                $_SESSION['modal_btn'] = true;
                $_SESSION['message_modal'] = "Event added successfully.";
                echo "<script>window.location.href='../../secretary/secretary_calendar.php'</script>";
            } else {
                $_SESSION['modal_btn'] = true;
                $_SESSION['message_modal'] = "Failed to add event.";
                echo "<script>window.history.back(); window.location.href='../secretary_calendar.php'</script>";
            }
        }
        // $_SESSION['modal_btn'] = true;
        // $_SESSION['message_modal'] = "ewn ko ba.";
        // echo "<script>alert('3'); window.history.back(); window.location.href='../secretary_calendar.php'</script>";
    }
    
} else if (isset($_POST['save_event'])) {
    $event_id = $_SESSION['event_id'];

    $user = $_POST["users"];
    $event_name = $_POST["event_name"];
    $event_description = $_POST["event_description"];
    $event_address = $_POST["event_address"];
    $event_start = $_POST["event_start"];
    $event_end = $_POST["event_end"];


    // Check for overlapping events
    $checkQuery = [
        'query' => "SELECT COUNT(*) FROM events
                    WHERE event_address = ?
                    AND (
                        (event_start <= ? AND event_end >= ?) OR
                        (event_start <= ? AND event_end >= ?)
                    )
                    AND (DATE_FORMAT(event_start, '%Y-%m-%d') = DATE_FORMAT(?, '%Y-%m-%d'))
                    AND event_id != ?", // Exclude the current event
        'bind' => 'ssssssi',
        'value' => [
            $event_address,
            $event_end,
            $event_start,
            $event_start,
            $event_start,
            $event_start,
            $event_id
        ]
    ];

    $check_results = select($checkQuery);

    if ($check_results && $check_results[0]['COUNT(*)'] > 0) {
        $_SESSION['modal_btn'] = true;
        $_SESSION['message_modal'] = "There is an overlapping event at the same location on the same date.";
        echo "<script>window.history.back(); window.location.href='../secretary_calendar.php'</?";
    } else {
        // Update the event in the database
        $updateQuery = [
            "query" => "UPDATE events SET event_user_position = ?, event_name = ?, event_description = ?, 
                        event_address = ?, event_start = ?, event_end = ? WHERE event_id = ?",
            "bind" => "ssssssi",
            "value" => [$user, $event_name, $event_description, $event_address, $event_start, $event_end, $event_id]
        ];

        $result = updateData($updateQuery, "Events");

        if ($result) {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "Event updated successfully.";
            echo "<script>window.location.href='../../secretary/secretary_calendar.php'</script>";
        } else {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "Failed to update event.";
            echo "<script>window.history.back(); window.location.href='../secretary_calendar.php'</script>";
        }
    }
    unset($event_id);
    
} else if (isset($_POST['delete_event'])) {

    $event_id = $_SESSION['event_id'];

    $deleteQuery = [
        "query" => "DELETE FROM events WHERE event_id = ?",
        "bind" => "i",
        "value" => [$event_id]
    ];

    deleteData($deleteQuery, ['table' => "Events", 'primaryKey' => $event_id]);
    $_SESSION['modal_btn'] = true;
    $_SESSION['message_modal'] = "Event deleted successfully.";
    echo "<script>window.location.href='../../secretary/secretary_calendar.php'</script>";
    unset($event_id);
}



$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

$calendar = new Calendar($selectedYear . '-' . $selectedMonth . '-01', false);

$data = [
    'query' => "
        SELECT event_name, event_user_position, event_start, event_end, event_description, event_address 
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

