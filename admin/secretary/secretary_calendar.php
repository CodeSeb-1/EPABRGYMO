<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/admin/calendar.php');
// include_once("../adminController/tanod_calendar_controller.php");
include_once("../adminController/secretaryController/secretary_calendar_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css??????????">
    <link rel="stylesheet" href="../../assets/modal.css??">
    <link rel="stylesheet" href="../../assets/success-modal.css??????">
    <link rel="stylesheet" href="../../assets/pagination.css">
    <style>
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
            height: 130px; /* Set a fixed height */
            overflow-y: auto; /* Make it scrollable on the y-axis */
            width: 100%; /* Optional: makes the textarea responsive */
            resize: none; /* Optional: prevents resizing of the textarea */
            border-radius: 4px; /* Optional: rounds the corners */
            border: none;
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
                <div class="event-form" id="calendarss">
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
                            <label>Duration Days:</label>
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
                                <select name="users" disabled required>
                                    <option value="<?= $requestDetails['event_user_position'] ?? '' ?>"><?php echo $requestDetails['event_user_position'] ?? ''; ?></option>
                                    <option value="Tanod">Tanod</option>
                                    <option value="Health Workers">Health Workers</option>
                                    <option value="Kagawad">Kagawad</option>
                                    <option value="BrgyCaptain">Brgy Captain</option>
                                </select>       
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
                                <textarea id="event_description" name="event_description" disabled required><?= $requestDetails['event_description'] ?? '' ?></textarea>
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
                <div class="form-actions" id="form-actions">
                    <?php
                    $current_date = date("Y-m-d");
                    $endDate = $requestDetails['event_end'];

                    if($endDate >= $current_date) {?>
                        <button type="submit" name="delete_event" class="btn btn-sec">Remove</button>
                        <button type="button" class="btn btn-primary" onclick="toggleEdit()" id="editBtn">Edit</button> 
                        <button type="submit" name="save_event" class="btn btn-primary" style="display: none;" id="saveBtn">Save</button>
                    <?php
                    }
                    ?>
                    
                </div>
            </form>
        </div>
    </div>
    <?php include_once("../../full_image_modal.php"); ?>
    <div id="successModal" class="modal">
        <div class="modal-content success">
            <div class="modal-header">
                <?php
                    if($_SESSION['modal_title'] ?? '' === "Error") {
                        echo "<h2 style='color:#C90508';>Error</h2>";
                        unset($_SESSION['modal_title']);
                    } else {
                        echo "<h2 style='color:green';>Success</h2>";
                    }
                ?>
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
    <script src="../../javascript/image.js"></script>
    <?php include_once("../../modal-open-close.php") ?>
    <script src="../../javascript/toggle-edit.js?"></script>
    <script src="../../javascript/open-image-modal.js"></script>
</body>
</html>