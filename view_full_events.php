<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$data = [
    "query" => "SELECT * FROM events WHERE event_id = ?",
    "bind" => "i",
    "value" => [$event_id]
];

$events_item = select($data, true);

if ($events_item) {    
    $news_date = new DateTime($events_item['event_start']);
    $news_date1 = new DateTime($events_item['event_end']);
    $formatted_date = $news_date->format('F j, Y');
    $formatted_date1 = $news_date1->format('F j, Y');


    $img_path = "/EPABRGYMO/dataImages/Events.{$events_item['event_id']}.jpg";
} else {
    echo "<p>Article not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPABRGYMO</title>
    <link rel="stylesheet" href="assets/style1.css?????????">
    <link rel="stylesheet" href="assets/news.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
        }
        .news-cons {
            background-color: #f4f4f4;
            padding: 20px 0;
        }
        .epabrgymo-container { /* Unique class */
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .epabrgymo-article-image { /* Unique class */
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .epabrgymo-article-title { /* Unique class */
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #1a1a1a;
            font-family: "Newsreader", serif;
        }
        .epabrgymo-article-meta { /* Unique class */
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }
        .epabrgymo-article-content { /* Unique class */
            font-size: 14px;
            line-height: 1.8;
        }
        .epabrgymo-back-link { /* Unique class */
            display: inline-block;
            margin-top: 20px;
            color: #C90508;
            text-decoration: none;
        }
    </style>
</head>
<body>
<?php include_once("header.php");
    nav("home") ?>
    <section class="news-cons">
        <div class="epabrgymo-container"> <!-- Updated class name -->
            <img src="<?php echo $img_path; ?>" alt="Article image" class="epabrgymo-article-image"> <!-- Updated class name -->
            <h1 class="epabrgymo-article-title"><?php echo htmlspecialchars($events_item['event_name']); ?></h1> <!-- Updated class name -->
            <div class='title-date'>
                <p>Date:</p>
                <p><?php echo "$formatted_date - $formatted_date1"; ?></p>
            </div>
            <div class='title-date'>
                <p>Location:</p>
                <p><?php echo htmlspecialchars($events_item['event_address']); ?></p>
            </div><br>
            <div class="epabrgymo-article-content"> <!-- Updated class name -->
                <?php echo nl2br(htmlspecialchars($events_item['event_description'])); ?>
            </div>
            <a href="events.php" class="epabrgymo-back-link">← Back to Events Feed</a> <!-- Updated class name -->
        </div>
    </section>
    <script src="javascript/navbar.js??????"></script>
</body>
</html>
