<?php
include '../calendar.php';
include_once("../adminController/tanod_calendar_controller.php");
include_once("../adminController/secretaryController/secretary_calendar_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css?">
    <link rel="stylesheet" href="../../assets/modal.css?">
    <link rel="stylesheet" href="../../assets/success-modal.css">
    <link rel="stylesheet" href="../../assets/pagination.css">
    <style>
        #modalEventImage {
            height: 400px;
            width: 100%;
            margin-left: 50%;
            object-fit: cover;
            transform: translateX(-50%);
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
            sidebar("calendar");
        ?>
        <main class="content">
            <div class="content home">
            <h1>Add Event</h1><br>
            <section class="add-event">
                <div class="event-form">
                    <form action="../adminController/secretaryController/secretary_calendar_controller.php" method="POST" enctype="multipart/form-data">
                        <div class="field">
                            <label>User:</label>
                            <select name="users">
                                <option value="Tanod">Tanod</option>
                                <option value="Health Workers">Health Workers</option>
                                <option value="Kagawad">Kagawad</option>
                                <option value="BrgyCaptain">Brgy Captain</option>
                            </select> 
                        </div>
                        <div class="field">
                            <label>Event:</label>
                            <input type="text" name="event_name" placeholder="Event Name" required>
                        </div>
                        <div class="field">
                            <label>Photo:</label>
                            <input type="file" name="image" onchange="previewImage(this);">
                        </div>                        
                        <div class="field">
                            <label>Description:</label>
                            <input type="text" name="event_description" placeholder="Event Description" required>
                        </div>
                        <div class="field">
                            <label>Address:</label>
                            <input type="text" name="event_address" placeholder="Event Address" required>
                        </div>
                        <div class="field">
                            <label>Start Date:</label>
                            <input type="datetime-local" name="event_start" placeholder="Event Start" required>
                        </div>
                        <div class="field">
                            <label>Duration</label>
                            <input type="number" name="event_duration" placeholder="Event Duration Days" required>
                        </div>
                        <div class="field">
                            <label></label>
                            <input type="submit" name="add_event" value="Add Event">
                        </div>
                    </form>
                    <div class="image-container">
                        <img src="../../assets/holder-image.png" id="userpicture" alt="image holder">
                    </div>
                </div>
            </section><hr>

            <h1>Calendar</h1><br>
                <form method="GET" action="">
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

                <!-- Display the calendar -->
                <?=$calendar?>
            </div>
            <div class="content">
                <h1>Events</h1>
                <div class="color-abt">
                    <form method="GET"><br>
                        <p class="event-word">Here are the barangay events showcasing our officers' dedication to community engagement and well-being.</p><br>
                        <select name="status" onchange="this.form.action='#table'; this.form.submit();">
                            <option value="All" <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option>
                            <option value="Tanod" <?= $selectedStatus === 'Tanod' ? 'selected' : '' ?>>Tanod</option>
                            <option value="Health Workers" <?= $selectedStatus === 'Health Workers' ? 'selected' : '' ?>>Health Workers</option>
                            <option value="Kagawad" <?= $selectedStatus === 'Kagawad' ? 'selected' : '' ?>>Kagawad</option>
                            <option value="BrgyCaptain" <?= $selectedStatus === 'BrgyCaptain' ? 'selected' : '' ?>>Brgy Captain</option>
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
                </div>
                <br>
                <!-- <section class="view-events">
                    <?php
                        display_events();
                    ?>
                </section>     -->

                <table id="table">
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>User</th>
                            <th>Event Name</th>
                            <th>Address</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php display_events(); ?>
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
            </div>
        </main>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Event Details</h2>
                <span class="close" id="closeModal">&times;</span>
            </div>
            <form action="../adminController/secretaryController/secretary_document_request_controller.php" method="POST">
                <input type="hidden" name="event_id" id="event_id" value="<?= $requestDetails['event_id'] ?? '' ?>">
                <img id="modalEventImage" src="<?php echo "/EPABRGYMO/dataImages/Events.{$requestDetails['event_id']}.jpg"; ?>" alt=""><br><br><br>
                <div id="modal-body" class="form-content">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="request_name">User Position:</label>
                            <span id="request_name"><?= $requestDetails['event_user_position'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="request_name">Event:</label>
                            <span id="request_name"><?= $requestDetails['event_name'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="request_name">Address:</label>
                            <span id="request_name"><?= $requestDetails['event_address'] ?? '' ?></span>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="request_purpose" class="<?=$statusClass?>">Event Address:</label>
                            <span id="request_purpose"><?= $requestDetails['event_address'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="request_date">Start Date:</label>
                            <span id="request_date"><?= $eventStart ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="request_status">End Date:</label>
                            <span id="request_status"><?= $eventEnd ?? '' ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-actions" id="form-actions">
                    <button type="submit" name="delete_event" class="btn btn-sec">Remove</button> 
                    <button type="submit" name="edit_event" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
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
    <!-- <script src="../../javascript/modal-event.js"></script> -->
    <script src="../../javascript/image.js"></script>
    <script>
        var modal = document.getElementById("myModal");
        var span = document.getElementById("closeModal");

        <?php if ($requestDetails): ?>
            modal.style.display = "block";
            window.location.href = "#table"; 
        <?php endif; ?>

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>