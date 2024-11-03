<?php include_once("userController/news_controller.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPABRGYMO</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_circle_right" />
    <link rel="stylesheet" href="assets/style1.css?????????">
    <link rel="stylesheet" href="assets/news.css??">
</head>
<body>
<?php include_once("header.php");
    nav("home") ?>
    <section class="news">
        <div class="news-feed__container">
            <div class="news_title">
                <a href="index.php">← back to home page</a>
                <h1>News</h1>
            </div><br>
            <div class="news-feed__grid">
                <?php display_news(); ?>
            </div>
        </div>
    </section>
    <?php include_once("footer.php") ?>
    <script src="javascript/navbar.js??????"></script>
</body>
</html>