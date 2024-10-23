<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$events = [
    'query' => 'SELECT * FROM events',
    'bind'=> '',
    'value'=> '',
];

$colors = [
    "Tanod" => "#ce5151",
    "Health Workers" => "#51ce57",
    "Kagawad" => "#518fce",
    "BrgyCaptain" => "#a45eb4"
];

function display_events() {
    global $events, $colors;

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




