<?php
include '../calendar.php';
include_once("../adminController/tanod_calendar_controller.php");
// include_once("../adminController/secretaryController/secretary_calendar_controller.php");
include_once("../adminController/secretaryController/secretary_news_controller.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css??">
    <link rel="stylesheet" href="../../assets/modal.css?">
    <link rel="stylesheet" href="../../assets/success-modal.css">
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
            <h1>Add News</h1><br>
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
                        <img src="../../assets/holder-image.png" id="userpicture" alt="image holder">
                    </div>
                </div>
            </section><hr>
            <section class="view-events">
                <?php
                    display_news();
                ?>
            </section>    
            <div id="eventModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modalEventName"></h3>
                        <span class="close">&times;</span>
                    </div>
                    <img id="modalEventImage" alt="Event Image"><br>
                    <div class="form-content">
                        <div class="form-column">
                            <div class="form-group">
                                <label>News:</label>
                                <span id="modalNews"></span>
                            </div>
                            <div class="form-group">
                                <label>Description:</label>
                                <span id="modalEventDescription"></span>
                            </div>
                        </div>
                        <div class="form-column">
                            <div class="form-group">
                                <label>Date:</label>
                                <span id="modalDate"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-sec" onclick="closeModal()">Close</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="successModal" class="modal">
        <div class="modal-content success">
            <div class="modal-header">
                <h2>Success</h2>
                <span class="close" onclick="closeSuccessModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p><?php echo$_SESSION['message_modal'] ?? ''; ?></p><br>
            </div>
            <div class="modal-footer">
                <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
    <?php include_once("../../show-success-error-modal.php") ?>
    <script src="../../javascript/modal-news.js"></script>
    <script src="../../javascript/image.js"></script>
</body>
</html>