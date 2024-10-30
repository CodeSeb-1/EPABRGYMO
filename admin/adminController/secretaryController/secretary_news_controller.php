<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$start = 0;
$rows_per_page = 10;
$selectedStatus = $_GET['status'] ?? 'Table';
$filterStatus = $selectedStatus !== 'Table' ? $selectedStatus : null;
$record_sql = "SELECT * FROM news";

$records = $con->query($record_sql);
$nr_of_rows = $records->num_rows;

$pages = ceil($nr_of_rows / $rows_per_page);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$page = max(1, min($page, $pages)); 

$start = ($page - 1) * $rows_per_page;

$events = [
    'query' => "SELECT * FROM news ORDER BY news_id DESC LIMIT $start, $rows_per_page",
    'bind' => '',
    'value' => '',
];

if(isset($_POST['add_news'])) {
    $insert_news = [
        'query' => "INSERT INTO news (news_name, news_description)
                    VALUES (?,?)",
        "bind"=> "ss",
        "value"=> [$_POST['news_name'], $_POST['news_description']],
    ];
    
    $results = insertData($insert_news, "News");
    $insertNotification = [
        "query" => "INSERT INTO notifications (user_id, type, message, link) VALUES (?,?,?,?)",
        "bind" => "isss",
        "value" => ["0", "News", $_POST['news_name'], "index.php"]
    ];
    insertData($insertNotification);
    if($results) {
        $_SESSION['modal_btn'] = true;
        $_SESSION['message_modal'] = "News Added";
        echo "<script>window.location.href='../../secretary/secretary_news.php?status=" . urlencode($selectedStatus) . "' </script>";
    }
} else if (isset($_POST['edit_news'])) {
    $news_id = $_SESSION['news_id'];

} else if (isset($_POST['delete_news'])) {
    $news_id = $_SESSION['news_id'];

    $deleteImage = [
        'table' => 'News',
        'primaryKey' => $news_id
    ];
    $deleteQuery = [
        'query' => "DELETE FROM news WHERE news_id = ?",
        'bind' => 'i',
        'value' => [$news_id]
    ];

    deleteData($deleteQuery, $deleteImage);

    $_SESSION['modal_btn'] = true;
    $_SESSION['message_modal'] = "News deleted";
    echo "<script>window.location.href='../../secretary/secretary_news.php'</script>";
}

function display_news_table() {
    global $events, $colors;

    displayAll($events, null, function ($row, $id) use ($colors) {
        global $page, $filterStatus;

        $date = new DateTime($row['news_date']);
        $end_date = $date->format('F j, Y');     
        
        $line_color = '#CCD0CF';

        $img_path = "/EPABRGYMO/dataImages/News.{$row['news_id']}.jpg";

        echo "
        <tr>
            <td>{$row['news_name']}</td>
            <td class='description'>{$row['news_description']}</td>
            <td>{$row['news_date']}</td>
            <td>
                <a href='secretary_news.php?page=$page&status=$filterStatus&news_id={$row['news_id']}' id='view'>View</a>
            </td>
        </tr>
        ";
    });
}

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

$requestDetails = null;
if (isset($_GET['news_id'])) {
    $news_id = $_GET['news_id'];

    $data = [
        'query' => "SELECT * FROM news 
                    WHERE news_id = ?;
                    ",
        'bind' => 'i',
        'value' => [$news_id]
    ];

    $requestDetails = select($data, true);
    if (!$requestDetails) {
        echo "<script> alert('No results found for event_id: $news_id');</script>";
    }
}
