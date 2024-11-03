<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$news = [
    'query' => 'SELECT * FROM events ORDER BY event_id',
    'bind' => '',
    'value' => '',
];


function display_eventss() {
    global $news; // Assuming $news contains the result set from the database

    displayAll($news, null, function ($row, $id) {
        $news_date = new DateTime($row['event_start']);
        $news_date1 = new DateTime($row['event_end']);
        $formatted_date = $news_date->format('F j, Y');
        $formatted_date1 = $news_date1->format('F j, Y'); 


        $img_path = "/EPABRGYMO/dataImages/Events.{$row['event_id']}.jpg";
        echo "
            <a href='view_full_events.php?id={$row['event_id']}' class='news-feed__card news-feed__card--science'>
                <img src='$img_path?height=200&width=300' alt='Event Image' class='news-feed__image news-feed__image--science'>
                <div class='news-feed__content news-feed__content--science'>
                    <h2 class='news-feed__title news-feed__title--science'>{$row['event_name']}</h2>
                    <p class='news-feed__description news-feed__description--science'>{$row['event_description']}</p>
                    <div class='title-date'>
                        <p>Date:</p>
                        <p>$formatted_date - $formatted_date1</p>
                    </div>
                    <div class='title-date'>
                        <p>Location:</p>
                        <p>{$row['event_address']}</p>
                    </div>
                </div>
            </a>
        ";
    });
}




