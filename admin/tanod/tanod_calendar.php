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
    <link rel="stylesheet" href="../../assets/event-calendar.css?">
</head>
<body>
    <header>
        <img src="../../assets/LOGO.png" alt="logo">
        <div class="user-info">
            <div>TAMOD</div> |
            <img src="../../assets/image.png" alt="User profile">
            <span>Mark Jelo Teofro</span>
            <button class="logout-btn">Logout</button>
        </div>
    </header>
    <div class="main-container">
        <nav class="sidebar">
            <a href="tanod_calendar.php">
                <div class="menu-item active">
                    <span class="material-symbols-outlined">calendar_month</span>                
                    <span>Calendar</span>
                </div>
            </a>
            <a href="tanod_duty_shifts.php">
                <div class="menu-item">
                    <span class="material-symbols-outlined">today</span>
                    <span>Duty Shifts</span>
                </div>    
            </a>
            <a href="">
                <div class="menu-item">
                    <span class="material-symbols-outlined">report</span>
                    <span>Incident Report</span>
                </div> 
            </a>
        </nav>
        <main class="content">
            <div class="content home">
            <section class="add-event">
                <h1>Add Event</h1>
                <form action="../adminController/tanod_calendar_controller.php" method="POST">
                    <input type="text" name="user" placeholder="User type">
                    <input type="text" name="event_name" placeholder="Event Name" required>
                    <input type="text" name="event_description" placeholder="Event Description" required>
                    <input type="text" name="event_address" placeholder="Event Address" required>
                    <label>Start Date  <input type="datetime-local" name="event_start" placeholder="Event Start" required></label>
                    <label>End Date <input type="datetime-local" name="event_end" placeholder="Event End" required></label>
                    <input type="submit" name="add_event" value="Add Event">
                </form>
            </section>



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
</body>
</html>