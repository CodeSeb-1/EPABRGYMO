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
    <link rel="stylesheet" href="../../assets/event-calendar.css">
</head>
<body>
    <?php
        include_once("../header.php");
    ?>
    <div class="main-container">
        <nav class="sidebars">
            <a href="tanod_calendar.php">
                <div class="menu-item active">
                    <span class="material-symbols-outlined">calendar_month</span>                
                    <span>Events</span>
                </div>
            </a>
            <a href="tanod_duty_shifts.php">
                <div class="menu-item">
                    <span class="material-symbols-outlined">today</span>
                    <span>Duty Shifts</span>
                </div>    
            </a>
            <a href="tanod_incident_report.php">
                <div class="menu-item">
                    <span class="material-symbols-outlined">report</span>
                    <span>Incident Report</span>
                </div> 
            </a>
        </nav>
        <main class="content">
            <div class="content home">
            <h1>Add Event</h1>
            <section class="add-event">
                <div class="event-form">
                    <form action="../adminController/tanod_calendar_controller.php" method="POST" enctype="multipart/form-data">
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
                        <img src="../../assets/brgy.png" id="userpicture" alt="">
                    </div>
                </div>
            </section><hr>


            <h1>Calendar</h1>
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
        </main>
    </div>
    <script src="../../javascript/image.js"></script>
</body>
</html>