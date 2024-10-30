<?php
include '../calendar.php';
include_once("../adminController/tanod_calendar_controller.php");
// include_once("../adminController/secretaryController/secretary_calendar_controller.php");
include_once("../adminController/secretaryController/secretary_news_controller.php");

$selectedStatus = isset($_GET['status']) ? $_GET['status'] : 'Card';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css??">
    <link rel="stylesheet" href="../../assets/modal.css???">
    <link rel="stylesheet" href="../../assets/pagination.css">
    <link rel="stylesheet" href="../../assets/success-modal.css?">
    <style>
        select {
            margin-bottom: 20px;
        }
        #modalEventImage {
            height: 330px;
            width: 100%;
            margin-left: 50%;
            object-fit: cover;
            transform: translateX(-50%);
        }

        #fullImageModal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1999; /* Ensure it's on top of other elements */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Dark background */
        }

        #fullImageModal .modal-content {
            position: relative;
            margin: 10% auto;
            padding: 0;
            width: 80%;
            max-width: 800px; /* Adjust max width as needed */
            border-radius: 5px;
            overflow: hidden;
        }

        #fullImageModal .close {
            position: absolute;
            top: 10px;
            right: 15px;
            color: black;
            font-size: 30px;
            cursor: pointer;
            z-index: 1000;
        }

        textarea {
            height: 150px; /* Set a fixed height */
            overflow-y: auto; /* Make it scrollable on the y-axis */
            width: 100%; /* Optional: makes the textarea responsive */
            resize: none; /* Optional: prevents resizing of the textarea */
            border-radius: 4px; /* Optional: rounds the corners */
            border: none;
        }

        .description {
            display: -webkit-box;                /* Enables the box layout */
            -webkit-box-orient: vertical;       /* Defines the orientation of the box */
            -webkit-line-clamp: 1;               /* Limits to one line */
            overflow: hidden;                    /* Hides any overflowing text */
            text-overflow: ellipsis;             /* Displays ellipsis for clipped text */
            max-height: 5em;                   /* Optional: Ensures max height corresponds to one line */
            line-height: 1.2em;                  /* Set a line height that corresponds to max height */
            width: 500px;                 
            white-space: nowrap;                
        }
    </style>
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
                            <textarea name="news_description" style="height: 240px; resize: none;" placeholder="Description"></textarea>
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
                <section class="view-news-table" id="view">
                    <table>
                        <thead>
                            <tr>
                                <th>News</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php display_news_table(); ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <span>Showing <?php echo $page; ?> of <?php echo $pages; ?></span>
                        <a href="?page=1&status=<?= urlencode($selectedStatus) ?>#table">First</a>
                        <a href="?page=<?= max(1, $page - 1) ?>&status=<?= urlencode($selectedStatus) ?>#table">Previous</a>
                        
                        <div class="page-numbers">
                            <?php for ($i = 1; $i <= $pages; $i++): ?>
                                <a href="?page=<?= $i ?>&status=<?= urlencode($selectedStatus) ?>#table" <?= ($i == $page) ? 'class="active"' : '' ?>><?= $i ?></a>
                            <?php endfor; ?>
                        </div>
                        
                        <a href="?page=<?= min($pages, $page + 1) ?>&status=<?= urlencode($selectedStatus) ?>#table">Next</a>
                        <a href="?page=<?= $pages ?>&status=<?= urlencode($selectedStatus) ?>#table">Last</a>
                    </div>
                </section>
                <!-- Full Image Modal -->
            <?php include_once("../../full_image_modal.php"); ?>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">News Details</h2>
                        <span class="close" id="closeModal">&times;</span>
                    </div>
                    <form action="../adminController/secretaryController/secretary_news_controller.php" method="POST">
                        <?php $_SESSION['news_id'] = $requestDetails['news_id'] ?? '';?>
                        <input type="hidden" name="event_id_edit" id="event_id_edit" value="<?= $requestDetails['news_id'] ?? '' ?>">
                        <img 
                            id="modalEventImage" 
                            src="<?php echo "/EPABRGYMO/dataImages/News.{$requestDetails['news_id']}.jpg"; ?>" 
                            alt="" 
                            onclick="openImageModal(this.src)"
                            style="cursor: pointer;"
                        ><br><br>
                   
                        <div id="modal-body" class="form-content">
                            <div class="form-column">
                                <div class="form-group">
                                    <label for="event_name">News:</label>
                                    <span>
                                        <input type="text" id="news_name" name="news_name" value="<?= $requestDetails['news_name'] ?? '' ?>" disabled required>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="event_start">Date:</label>
                                    <span>
                                        <input type="text" id="news_date" name="news_date" value="<?= $requestDetails['news_date'] ?? '' ?>" disabled required>
                                    </span>
                                    <label for="event_address">Description:</label>
                                    <span>
                                        <input type="text" id="news_description" name="news_description" value="<?= $requestDetails['news_description'] ?? '' ?>" disabled required>
                                    </span>
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label for="event_address">Description:</label>
                                    <span>
                                        <textarea id="news_description" name="news_description" disabled required><?= $requestDetails['news_description'] ?? '' ?></textarea>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions" id="form-actions">
                            <button type="submit" name="delete_news" class="btn btn-sec">Remove</button>
                            <!-- <button type="button" class="btn btn-primary" onclick="toggleEdit()" id="editBtn">Edit</button>  -->
                            <button type="submit" name="edit_news" class="btn btn-primary" style="display: none;" id="saveBtn">Save</button>
                        </div>
                    </form>
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
                <p><?php echo $_SESSION['message_modal'] ?? ''; ?></p><br>
            </div>
            <div class="modal-footer">
                <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
    <?php include_once("../../show-success-error-modal.php") ?>
    <script src="../../javascript/modal-news.js"></script>
    <script src="../../javascript/image.js"></script>
    <?php include_once("../../modal-open-close.php") ?>
    <script src="../../javascript/toggle-edit.js"></script>
    <script src="../../javascript/open-image-modal.js"></script>
</body>
</html>
