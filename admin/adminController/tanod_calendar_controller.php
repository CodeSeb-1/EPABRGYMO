<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

if (isset($_POST["add_event"])) {
    $user = $_POST["user"];
    $event_name = $_POST["event_name"];
    $event_description = $_POST["event_description"];
    $event_address = $_POST["event_address"];
    $event_start = $_POST["event_start"];
    $event_end = $_POST["event_end"];

    // Check for overlapping events with the same address
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
        $data = [
            "query" => "INSERT INTO events (event_name, event_description, event_address, event_start, event_end)
                        VALUES (?,?,?,?,?)",
            "bind" => "sssss",
            "value" => [$event_name, $event_description, $event_address, $event_start, $event_end]
        ];

        $result = insertData($data);
        if ($result) {
            echo "<script>alert('Event added successfully.');</script>";
        } else {
            echo "<script>alert('Failed to add event.');</script>";
        }
        location("../tanod/tanod_calendar.php");
    }
}

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

$calendar = new Calendar($selectedYear . '-' . $selectedMonth . '-01', false);

$data = [
    'query' => "SELECT event_name, event_start, event_end, event_description, event_address FROM events WHERE MONTH(event_start) = ? AND YEAR(event_start) = ?",
    'bind' => 'ii',
    'value'=> [$selectedMonth, $selectedYear]
];

$results = select($data); 


$colors = ['red', 'green', 'blue', 'orange', 'purple', 'pink'];
$colorCount = count($colors);

$currentColorIndex = 0;

if ($results && is_array($results)) {
    foreach ($results as $result) {
        $startDate = new DateTime($result['event_start']);
        $endDate = new DateTime($result['event_end']);
        $duration = $endDate->diff($startDate)->days + 1;

        $color = $colors[$currentColorIndex];

        $calendar->add_event(
            $result['event_name'],
            $result['event_start'], 
            $duration,
            $color, // Use the current color
            $result['event_description'], 
            $result['event_address'] 
        );

        $currentColorIndex = ($currentColorIndex + 1) % $colorCount;
    }
} else {
    error_log("No events found or an error occurred: " . print_r($results, true));
}