<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');


if(isset($_POST['add_news'])) {
    $insert_news = [
        'query' => "INSERT INTO news (news_name, news_description)
                    VALUES (?,?)",
        "bind"=> "ss",
        "value"=> [$_POST['news_name'], $_POST['news_description']],
    ];
    
    $results = insertData($insert_news, "News");
    if($results) {
        echo"<script> alert('Success'); window.location.href='../../secretary/secretary_news.php' </script>";
    }

}