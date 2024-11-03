<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
$events = [
    'query' => 'SELECT * FROM events ORDER BY event_id DESC LIMIT 4',
    'bind' => '',
    'value' => '',
];


// $news = [
//     'query' => 'SELECT * FROM news 
//                 WHERE (YEAR(news_date) = YEAR(CURDATE()) AND MONTH(news_date) = MONTH(CURDATE()))
//                 OR (YEAR(news_date) = YEAR(CURDATE()) AND MONTH(news_date) = MONTH(CURDATE()) - 1)
//                 OR (MONTH(CURDATE()) = 1 AND YEAR(news_date) = YEAR(CURDATE()) - 1 AND MONTH(news_date) = 12)
//                 ORDER BY news_date DESC',
//     'bind' => '',
//     'value' => '',
// ];

$news = [
    'query' => 'SELECT * FROM news ORDER BY news_id DESC LIMIT 4',
    'bind' => '',
    'value' => '',
];





function display_events() {
    global $events;
        
    $count = 0;
    $hasDisplayedFeatured = false;
    $event_featured = "";

    displayAll($events, 1, function ($row, $id) use (&$event_featured) { 
        static $displayed = false; 

        if ($displayed) return; 

        $start = new DateTime($row['event_start']);
        $end = new DateTime($row['event_end']);

        $start_date = $start->format('F j, Y');
        $start_time = $start->format('g:i A');
        $end_date = $end->format('F j, Y');

        $img_path = "/EPABRGYMO/dataImages/Events.{$row['event_id']}.jpg";

        $event_featured .= "
            <div class='event-featured-content'>
                <h2>{$row['event_name']}</h2>
                <p class='event-time'>Start: $start_date at $start_time</p>
                <p class='event-time'>End: $end_date</p>
                <p class='event-content'>{$row['event_description']}</p>
                <div class='event-location'>
                    <p>Location:</p>
                    <p>{$row['event_address']}</p>
                </div>
            </div>
            <div class='event-featured-image'>
                <img src='$img_path' alt='Event Image'>
            </div>";

        $displayed = true;
    });

    echo "
        <div class='event-featured'>
            $event_featured
        </div>
    ";
    
    
    echo '<div class="event-list">';
    
    displayAll($events, null, function ($row, $id) use (&$count, &$hasDisplayedFeatured) {
        if (!$hasDisplayedFeatured) {
            $hasDisplayedFeatured = true;
            return;
        }
        
        if ($count >= 3) return;
        
        $start = new DateTime($row['event_start']);
        $end = new DateTime($row['event_end']);
        
        $start_date = $start->format('F j, Y');
        $start_time = $start->format('g:i A');
        $end_date = $end->format('F j, Y');
                
        echo "
            <div class='event-item'>
                <div class='event-item-content'>
                    <h2>{$row['event_name']}</h2>
                    <p class='event-time'>$start_date at $start_time</p>
                    <p class='event-content'>{$row['event_description']}</p>
                     <div class='event-location'>
                        <p>Location:</p>
                        <p>{$row['event_address']}</p>
                    </div>
                </div>
            </div>";
        
        $count++;
    });
    
    echo '<a href="events.php" class="event-view-all">
            See All Events
          </a>';
    
    echo '</div>'; 
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
                <h3 class='news-title'>{$row['news_name']}</h3>
                <p class='description'>{$row['news_description']}</p>
                <div class='title-date'>
                    <p class='published'>
                        Published on:
                    </p>
                    <p class='date'>
                        $formatted_date
                    </p>
                </div>
            </div>
        </a>";
    });
}



