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
    <link rel="stylesheet" href="../../assets/event-calendar.css???">
</head>
<body>
    <?php include_once("../header.php");?>
    <div class="main-container">
        <nav class="sidebars">
            <a href="tanod_calendar.php">
                <div class="menu-item">
                    <span class="material-symbols-outlined">calendar_month</span>                
                    <span>Events</span>
                </div>
            </a>
            <a href="tanod_duty_shifts.php">
                <div class="menu-item active">
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
            <h1>Duty Shifts</h1>

            <section class="events">
                <table>
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>Fullname</th>
                            <th>Scheduled</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="../../assets/image.png" alt="profile picture" style="width: 50px; height: 50px;">
                            </td>
                            <td>Mark Jolo L. Tadeo</td>
                            <td>June 200,1666</td>
                        </tr>
                        <tr>
                            <td>
                            <img src="../../assets/image.png" alt="profile picture" style="width: 50px; height: 50px;">
                            </td>
                            <td>Mark Jolo L. Tadeo</td>
                            <td>June 200,1666</td>
                        </tr>
                        <tr>
                            <td>
                            <img src="../../assets/image.png" alt="profile picture" style="width: 50px; height: 50px;">
                            </td>
                            <td>Mark Jolo L. Tadeo</td>
                            <td>June 200,1666</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>