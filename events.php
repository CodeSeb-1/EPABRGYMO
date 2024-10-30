<?php 
include_once("userController/events_controller.php"); 
include_once("userController/calendar_controller.php"); 
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
    
    <link rel="stylesheet" href="assets/news.css???">
    <link rel="stylesheet" href="assets/modal.css">
    <style>
        .calendar {
            display: flex;
            flex-flow: column;
            /* box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1); */
        }
        .calendar .header .month-year {
            font-size: 20px;
            font-weight: bold;
            color: #636e73;
            padding: 20px 0;
        }
        .calendar .days {
            display: flex;
            flex-flow: wrap;
        }
        .calendar .days .day_name {
            width: calc(100% / 7);
            border-right: 1px solid var(--second-main-red);
            padding: 20px;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            background: var(--second-main-red);
        }
        .calendar .days .day_name:nth-child(7) {
            border: none;
        }
        .calendar .days .day_num {
            display: flex;
            flex-flow: column;
            width: calc(100% / 7);
            border-right: 1px solid #e6e9ea;
            border-bottom: 1px solid #e6e9ea;
            padding: 15px;
            font-weight: bold;
            color: #7c878d;
            cursor: pointer;
            min-height: 100px;
        }
        .calendar .days .day_num span {
            display: inline-flex;
            width: 30px;
            font-size: 14px;
        }
        .calendar .days .day_num .event {
            margin-top: 10px;
            font-weight: 500;
            font-size: 14px;
            padding: 3px 6px;
            border-radius: 4px;
            background-color: #f7c30d;
            color: #fff;
            word-wrap: break-word;
        }

        .calendar .days .day_num .event.green {
            background-color: #51ce57;
            transition: ease-in-out .2s;
        }
        .calendar .days .day_num .event.blue {
            background-color: #518fce;
            transition: ease-in-out .2s;
        }
        .calendar .days .day_num .event.red {
            background-color: #ce5151;
            transition: ease-in-out .2s;
        }
        .calendar .days .day_num .event.purple {
            background-color: #a45eb4;
            transition: ease-in-out .2s;
        }
        .calendar .days .day_num .event.green:hover,
        .calendar .days .day_num .event.blue:hover,
        .calendar .days .day_num .event.red:hover,
        .calendar .days .day_num .event.purple:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .calendar .days .day_num:nth-child(7n+1) {
            border-left: 1px solid #e6e9ea;
        }
        .calendar .days .day_num:hover {
            background-color: #fdfdfd;
        }
        .calendar .days .day_num.ignore {
            background-color: #fdfdfd;
            color: #ced2d4;
            cursor: inherit;
        }
        .calendar .days .day_num.selected {
            background-color: #f1f2f3;
            cursor: inherit;
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
            color: gray;
            font-size: 30px;
            cursor: pointer;
            z-index: 1000;
        }

        textarea {
            height: 130px; /* Set a fixed height */
            overflow-y: auto; /* Make it scrollable on the y-axis */
            width: 100%; /* Optional: makes the textarea responsive */
            resize: none; /* Optional: prevents resizing of the textarea */
            border-radius: 4px; /* Optional: rounds the corners */
            border: none;
        }

        .coloring-about {
    display: flex;
    flex-direction: column;
    gap: 10px; 
    position: static;
    right: 3%;
    top: 3%;
}

.color-item {
    display: flex; 
    align-items: center; 
}

.color-swatch {
    width: 20px;
    height: 10px; 
    border-radius: 4px; 
    margin-right: 10px; 
}

.color-label {
    font-size: 14px;
    color: #333;
    font-weight: 500; 
}
    </style>
</head>
<body>
<?php include_once("header.php");
    nav("home") ?>
    <section class="news">
        
        <div class="news-feed__container">
            <div class="news_title">
                <a href="index.php">← back to home page</a>
                <h1>Events</h1>
            </div><br>
                <form method="GET" action="" id="calendar-id">
                    <label for="month">Select Month:</label>
                    <select name="month" id="month" onchange="this.form.submit()">
                        <?php
                        // Loop through months
                        for ($m = 1; $m <= 12; $m++) {
                            $monthName = date('F', mktime(0, 0, 0, $m, 10)); // Get month name
                            $selected = ($m == $selectedMonth) ? 'selected' : ''; // Mark selected month
                            echo "<option value='$m' $selected>$monthName</option>";
                        }
                        ?>
                    </select>

                    <!-- Year selection -->
                    <label for="year">Select Year:</label>
                    <select name="year" id="year" onchange="this.form.submit()">
                        <?php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y <= $currentYear + 5; $y++) {
                            $selected = ($y == $selectedYear) ? 'selected' : '';
                            echo "<option value='$y' $selected>$y</option>";
                        }
                        ?>
                    </select>
                </form>
                <div class="coloring-about">
                        <div class="color-item">
                            <div class="color-swatch" style="background-color: #ce5151;"></div>
                            <span class="color-label">Tanod</span>
                        </div>
                        <div class="color-item">
                            <div class="color-swatch" style="background-color: #51ce57;"></div>
                            <span class="color-label">Health Workers</span>
                        </div>
                        <div class="color-item">
                            <div class="color-swatch" style="background-color: #518fce;"></div>
                            <span class="color-label">Kagawad</span>
                        </div>
                        <div class="color-item">
                            <div class="color-swatch" style="background-color: #a45eb4;"></div>
                            <span class="color-label">Brgy Captain</span>
                        </div>
                    </div>
                <?=$calendar?>
                <br><br>
            <div class="news-feed__grid">
                <?php display_eventss(); ?>
            </div>
        </div>
    </section>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Event Details</h2>
                <span class="close" id="closeModal">&times;</span>
            </div>
            <form action="../adminController/secretaryController/secretary_calendar_controller.php" method="POST">
                <?php $_SESSION['event_id'] = $requestDetails['event_id']; ?>
                <input type="hidden" name="event_id_edit" id="event_id_edit" value="<?= $requestDetails['event_id'] ?? '' ?>">
                <img 
                    id="modalEventImage" 
                    src="<?php echo "/EPABRGYMO/dataImages/Events.{$requestDetails['event_id']}.jpg"; ?>" 
                    alt="image" 
                    onclick="openImageModal(this.src)"
                    style="cursor: pointer;"
                ><br><br>
                <!-- <img id="modalEventImage" src="<?php echo "/EPABRGYMO/dataImages/Events.{$requestDetails['event_id']}.jpg"; ?>" alt=""><br><br><br> -->
                <div id="modal-body" class="form-content">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="event_user_position">User Position:</label>
                            <span>
                            <input type="text" id="event_name" name="event_name" value="<?= $requestDetails['event_user_position'] ?? '' ?>" disabled required>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="event_name">Event:</label>
                            <span>
                                <input type="text" id="event_name" name="event_name" value="<?= $requestDetails['event_name'] ?? '' ?>" disabled required>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="event_address">Address:</label>
                            <span>
                                <input type="text" id="event_address" name="event_address" value="<?= $requestDetails['event_address'] ?? '' ?>" disabled required>
                            </span>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="event_start">Description:</label>
                            <span>
                                <textarea id="event_name" name="event_name" disabled required><?= $requestDetails['event_description'] ?? '' ?></textarea>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="event_start">Start Date:</label>
                            <span>
                                <input type="datetime-local" id="event_start" name="event_start" value="<?= $requestDetails['event_start'] ?? '' ?>" disabled required>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="event_end">End Date:</label>
                            <span>
                                <input type="date" id="event_end" name="event_end" value="<?= $requestDetails['event_end'] ?? '' ?>" disabled required>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include_once("full_image_modal.php"); ?>
    <?php include_once("footer.php") ?>
    <?php include_once("modal-open-close.php") ?>
    <script src="javascript/open-image-modal.js"></script>
    <script src="javascript/navbar.js??????"></script>
</body>
</html>