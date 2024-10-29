<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
$events = [
    'query' => 'SELECT * FROM events WHERE event_end >= CURDATE()',
    'bind' => '',
    'value' => '',
];


$news = [
    'query' => 'SELECT * FROM news 
                WHERE (YEAR(news_date) = YEAR(CURDATE()) AND MONTH(news_date) = MONTH(CURDATE()))
                OR (YEAR(news_date) = YEAR(CURDATE()) AND MONTH(news_date) = MONTH(CURDATE()) - 1)
                OR (MONTH(CURDATE()) = 1 AND YEAR(news_date) = YEAR(CURDATE()) - 1 AND MONTH(news_date) = 12)
                ORDER BY news_date DESC',
    'bind' => '',
    'value' => '',
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

function display_news() {
    global $news; // Assuming $news contains the result set from the database

    displayAll($news, null, function ($row, $id) {
        $news_date = new DateTime($row['news_date']);
        $formatted_date = $news_date->format('F j, Y g:i A');  

        $img_path = "/EPABRGYMO/dataImages/News.{$row['news_id']}.jpg";

        echo "
        <a class='news-card'>
            <img src='$img_path' alt='News Image'>
            <div class='news-content'>
                <h3>{$row['news_name']}</h3>
                <p>{$row['news_description']}</p>
                <p class='date'>Published on: $formatted_date</p>
            </div>
        </a>";
    });
}



