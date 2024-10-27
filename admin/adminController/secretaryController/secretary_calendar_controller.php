<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$events = [
    'query' => 'SELECT * FROM events',
    'bind'=> '',
    'value'=> '',
];

function display_events() {
    global $events, $colors;

    $colors = [
        "Tanod" => "#ce5151",
        "Health Workers" => "#51ce57",
        "Kagawad" => "#518fce",
        "BrgyCaptain" => "#a45eb4"
    ];

    displayAll($events, null, function ($row, $id) use ($colors) {
        $start = new DateTime($row['event_start']);
        $end = new DateTime($row['event_end']);

        $start_date = $start->format('F j, Y'); 
        $start_time = $start->format('g:i A');  
        $end_date = $end->format('F j, Y');     
        
        // Get the user type and corresponding color
        $user_type = $row['event_user_position'];
        $line_color = isset($colors[$user_type]) ? $colors[$user_type] : 'gray';

        $img_path = "/EPABRGYMO/dataImages/Events.{$row['event_id']}.jpg";

        echo "
        <div class='event-card' onclick=\"showModal('{$row['event_name']}', '{$row['event_user_position']}', '{$row['event_address']}', '$start_date at $start_time', '$end_date', '{$row['event_description']}', '$img_path')\">
            <div class='line' style='background: $line_color;'></div>
            <div class='event-info'>
                <h3>{$row['event_name']}</h3>
                <p>{$row['event_user_position']}</p>
                <p class='location'>Location: {$row['event_address']}</p>
                <p class='time'>Start: $start_date at $start_time</p>
                <p class='time'>End: $end_date</p>
            </div>
            <img src='$img_path' alt='Event Image' style='width:100px; height:100px;'>
        </div>";
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


