<?php
include '../calendar.php';
include_once("../adminController/tanod_calendar_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css????">
</head>
<body>
    <?php
        include_once("../header.php");
    ?>
    <div class="main-container">
        <?php
            include_once("sidebar.php");
            sidebar("news");
        ?>
        <main class="content">
            <div class="content home">
            <h1>Add News</h1>
            <section class="add-event">
                <div class="event-form">
                    <form action="../adminController/secretaryController/secretary_news_controller.php" method="POST" enctype="multipart/form-data">
                        <div class="field">
                            <label>News Name:</label>
                            <input type="text" name="news_name" placeholder="News Name" required>
                        </div>
                        <div class="field">
                            <label>Description:</label>
                            <textarea name="news_description" style=" height: 240px; resize: none;" placeholder="Description"></textarea>
                        </div>
                        <div class="field">
                            <label>Photo:</label>
                            <input type="file" name="image" onchange="previewImage(this);">
                        </div>                        
                        <div class="field">
                            <label></label>
                            <input type="submit" name="add_news" value="Add News">
                        </div>
                    </form>
                    <div class="image-container">
                        <img src="../../assets/brgy.png" id="userpicture" alt="">
                    </div>
                </div>
            </section><hr>
        </main>
    </div>
    <script src="../../javascript/image.js"></script>
</body>
</html>