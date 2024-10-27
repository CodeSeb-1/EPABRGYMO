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
        $_SESSION['modal_btn'] = true;
        $_SESSION['message_modal'] = "News Added";
        echo"<script>window.location.href='../../secretary/secretary_news.php' </script>";
    }
}

$events = [
    'query' => 'SELECT * FROM news',
    'bind'=> '',
    'value'=> '',
];

function display_news() {
    global $events, $colors;

    displayAll($events, null, function ($row, $id) use ($colors) {
        $date = new DateTime($row['news_date']);
        $end_date = $date->format('F j, Y');     
        
        $line_color = '#CCD0CF';

        $img_path = "/EPABRGYMO/dataImages/News.{$row['news_id']}.jpg";

        echo "
        <div class='event-card' onclick=\"showModal('{$row['news_name']}', '{$row['news_description']}', '{$row['news_date']}', '$img_path')\">
            <div class='line' style='background: $line_color;'></div>
            <div class='event-info'>
                <h3>{$row['news_name']}</h3>
                <p>{$row['news_description']}</p>
                <p class='location'>$end_date</p>
            </div>
            <img src='$img_path' alt='Event Image' style='width:100px; height:100px;'>
        </div>";
    });
}
