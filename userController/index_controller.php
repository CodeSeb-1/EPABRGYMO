<?php
include_once("../includes/model.php");

$events = [
    'query' => 'SELECT * FROM events',
    'bind'=> '',
    'value'=> '',
];


function display_events() {
    global $events;

    // Use a relative URL path instead of document root path
    

    displayAll($events, null, function ($row, $id)  {
        $img_path = "/EPABRGYMO/dataImages/Events.{$row['event_id']}.jpg";
        echo "
        <div class='event-card'>
            <div class='event-info'>
                <h3>{$row['event_name']}</h3>
                <p class='location'>Location: {$row['event_address']}</p>
                <p class='time'>Duration: {$row['event_start']} - {$row['event_end']}</p>
                <p class='description'>{$row['event_description']}</p>
            </div>
            <img src='$img_path' alt='Event Image'>
        </div>";
    });
}

