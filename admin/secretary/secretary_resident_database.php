<?php
include '../calendar.php';
include_once("../adminController/secretaryController/secretary_resident_controller.php");
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
            <h1>Add Resident</h1><br>
            <section class="add-event">
                <div class="event-form">
                    <form action="../adminController/secretaryController/secretary_resident_controller.php" method="POST" enctype="multipart/form-data">
                        <div class="field">
                            <label>First name:</label>
                            <input type="text" name="firstname" placeholder="First name" required>
                        </div>
                        <div class="field">
                            <label>Middle name:</label>
                            <input type="text" name="middlename" placeholder="Middle name" required>
                        </div>                        
                        <div class="field">
                            <label>Last name:</label>
                            <input type="text" name="lastname" placeholder="Last name" required>
                        </div>
                        <div class="field">
                            <label>Contact No.:</label>
                            <input type="text" name="contact" placeholder="Contact No." required>
                        </div>
                        <div class="field">
                            <label>Birthdate:</label>
                            <input type="date" name="birthdate" required>
                        </div>
                        <div class="field">
                            <label>Email: </label>
                            <input type="text" name="email" placeholder="Email" required>
                        </div>
                        <div class="field">
                            <label>Address:</label>
                            <input type="text" name="address" placeholder="House no., Street" required>
                        </div>
                        <div class="field">
                            <label></label>
                            <input type="submit" name="add_resident" value="Add Resident">
                        </div>
                    </form>
                    <div class="image-container">
                        <img src="../../assets/brgy.png" id="userpicture" alt="">
                    </div>
                </div>
            </section><hr>


            <h1>Master List</h1><br>
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
                        <?php
                         display_resident();
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="../../javascript/image.js"></script>
</body>
</html>