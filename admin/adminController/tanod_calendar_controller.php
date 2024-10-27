<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

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
        echo "<script>alert('There is an event at the same location on the same date.'); window.location.href='../tanod_calendar.php';</script>";
    } else {

        if($event_start > $event_end) {
            echo "<script>alert('inang yan mas malaki a ung event start e'); window.location.href='../tanod_calendar.php';</script>";
        } else {
            $data = [
                "query" => "INSERT INTO events (event_user_position, event_name, event_description, event_address, event_start, event_end)
                            VALUES (?,?,?,?,?,?)",
                "bind" => "ssssss",
                "value" => [$_SESSION['event_user_position'], $event_name, $event_description, $event_address, $event_start, $event_end]
            ];

            $result = insertData($data, "Events");
            if ($result) {
                echo "<script>alert('Event added successfully.');</script>";
            } else {
                echo "<script>alert('Failed to add event.');</script>";
            }
            location("../tanod/tanod_calendar.php");
        }
    }
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