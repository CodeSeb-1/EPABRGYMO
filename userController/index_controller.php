<?php
include_once("../includes/model.php");

$events = [
    'query' => 'SELECT * FROM events',
    'bind'=> '',
    'value'=> '',
];


function display_events() {
    global $events;

    displayAll($events, null, function ($row, $id) {
        return '';
    }); 
}