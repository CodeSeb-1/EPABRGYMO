<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$news = [
    'query' => 'SELECT * FROM news ORDER BY news_id',
    'bind' => '',
    'value' => '',
];


function display_news() {
    global $news; // Assuming $news contains the result set from the database

    displayAll($news, null, function ($row, $id) {
        $news_date = new DateTime($row['news_date']);
        $formatted_date = $news_date->format('F j, Y g:i A');  

        $img_path = "/EPABRGYMO/dataImages/News.{$row['news_id']}.jpg";
        echo "
            <a href='view_full_news.php?id={$row['news_id']}' class='news-feed__card news-feed__card--science'>
                <img src='$img_path?height=200&width=300' alt='Science news' class='news-feed__image news-feed__image--science'>
                <div class='news-feed__content news-feed__content--science'>
                    <h2 class='news-feed__title news-feed__title--science'>{$row['news_name']}</h2>
                    <p class='news-feed__description news-feed__description--science'>{$row['news_description']}</p>
                    <div class='title-date'>
                        <p>Published on:</p>
                        <p>$formatted_date</p>
                    </div>
                </div>
            </a>
        ";
    });
}




