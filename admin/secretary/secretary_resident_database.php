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
                <div class="menu-item">
                    <span class="material-symbols-outlined">description</span>                    
                    <span>Document Request</span>
                </div>    
            </a>
            <a href="secretary_resident_database.php">
                <div class="menu-item active">
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
            <h1>Master List</h1>
            <section class="events">
                <table>
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Age</th>
                            <th>Birthday</th>
                            <th>Contact No.</th>
                            <th>Email</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Marcos Revillieza</td>
                            <td>69</td>
                            <td>September 69, 1990</td>
                            <td>09696969696</td>
                            <td>Marcos@gmail.com</td>
                            <td>123, Bulacan, Manila</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="../../javascript/image.js"></script>
</body>
</html>