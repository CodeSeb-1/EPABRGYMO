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
    <link rel="stylesheet" href="../../assets/event-calendar.css??">
</head>
<body>
    <?php
        include_once("../header.php");
    ?>
    <div class="main-container">
        <nav class="sidebar">
            <a href="secretary_calendar.php">
                <div class="menu-item">
                    <span class="material-symbols-outlined">calendar_month</span>                
                    <span>Events</span>
                </div>
            </a>
            <a href="secretary_document_request.php">
                <div class="menu-item active">
                    <span class="material-symbols-outlined">description</span>                    
                    <span>Document Request</span>
                </div>    
            </a>
            <a href="secretary_resident_database.php">
                <div class="menu-item">
                    <span class="material-symbols-outlined">groups</span>                    
                    <span>Master List</span>
                </div> 
            </a>
            <a href="secretary_ordinance_shifting.php">
                <div class="menu-item">
                    <span class="material-symbols-outlined">task</span>                    
                    <span>Ordinance Shifting</span>
                </div> 
            </a>
        </nav>
        <main class="content">
            <div class="content home">
            <h1>Document Request</h1>
            <section class="events">
                <form action="#">
                    <select name="">
                        <option value="Pending">Pending</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Ready To Claim">Ridy to Claim</option>
                    </select>
                </form><br>
                <table>
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Document Type</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Request Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Oloj</td>
                            <td>Document</td>
                            <td>Sceret</td>
                            <td>Pending</td>
                            <td>1111-11-11-11</td>
                            <td>View Details</td>
                        </tr>
                        <tr>
                            <td>Oloj</td>
                            <td>Document</td>
                            <td>Sceret</td>
                            <td>Pending</td>
                            <td>1111-11-11-11</td>
                            <td>View Details</td>
                        </tr>
                        <tr>
                            <td>Oloj</td>
                            <td>Document</td>
                            <td>Sceret</td>
                            <td>Pending</td>
                            <td>1111-11-11-11</td>
                            <td>View Details</td>
                        </tr>
                        <tr>
                            <td>Oloj</td>
                            <td>Document</td>
                            <td>Sceret</td>
                            <td>Pending</td>
                            <td>1111-11-11-11</td>
                            <td>View Details</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="../../javascript/image.js"></script>
</body>
</html>