<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
$events = [
    'query' => 'SELECT * FROM events',
    'bind'=> '',
    'value'=> '',
];


function display_events() {
    global $events;

    displayAll($events, null, function ($row, $id) {
        $start = new DateTime($row['event_start']);
        $end = new DateTime($row['event_end']);

        $start_date = $start->format('F j, Y'); 
        $start_time = $start->format('g:i A');  
        $end_date = $end->format('F j, Y');     

        $img_path = "/EPABRGYMO/dataImages/Events.{$row['event_id']}.jpg";

        echo "
        <div class='event-card'>
            <div class='event-info'>
                <h3>{$row['event_name']}</h3>
                <p class='location'>Location: {$row['event_address']}</p>
                <p class='time'>Start: $start_date at $start_time</p>
                <p class='time'>End: $end_date</p>
                <p class='description'>{$row['event_description']}</p>
            </div>
            <img src='$img_path' alt='Event Image'>
        </div>";
    });
}


