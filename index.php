<?php
include_once("userController/index_controller.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPABRGYMO</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_circle_right" />
    <link rel="stylesheet" href="assets/style1.css?????????">
</head>

<body>
    <?php include_once("header.php");
    nav("home") ?>
    <main>
        <div class="container">
            <section class="hero">
                <div class="hero-content">
                    <h1><span class="title-page">Request Documents</span> from your Barangay <span class="title-page">Online</span></h1>
                    <p>Easily request official documents from your barangay. Our online system provides a convenient way
                        to access Barangay Clearance, Certificates of Residency, Business Permits, and more.</p>
                    
                </div>
                <div class="hero-image">
                    <img src="assets/BGRYLOGO.png" alt="Picture">
                </div>
            </section>
        </div>

        <section class="news-section">
            <div class="container">
                <div class="title">
                    <h2>Latest News</h2>
                    <a href="news.php" class="see-all">
                        See all &#8594;
                    </a>
                </div>
                <div class="news-container">
                    <?php display_news(); ?>
                </div>
            </div><br><br><br><hr><br><br><br>
            <div class="event-con">
                <div class="container">
                    <h2>Events</h2><br>
                    <div class="event-layout">
                    <?php 
                        display_events();
                    ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include_once("footer.php") ?>
    <script src="javascript/navbar.js??????"></script>
</body>

</html>