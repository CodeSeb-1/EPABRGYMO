<?php
include '../calendar.php';
include_once("../adminController/tanod_calendar_controller.php");
include_once("../adminController/secretaryController/secretary_ordinance_shifting_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css?????">
    <style>
        :root {
            --main-red:#D04848;
            --main-hover-red: #b73c3c;
            --second-main-red: #C90508;
            --white: #fff;
            --background-middle-white: #f0f2f5;
            --sidebar-text-color: #7a7a7a;
            --input-color-gray: #636e73;
            --light-black: #1A1A19;
        }

        .schedule-form {
            display: flex;
            align-items: center;
            width: 100%;
            font-size: 13px;
        }

        .schedule-form, .schedule-display {
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 30px;
        }

        img#userpicture {
            height: 390px;
            width: 550px;
            object-fit: cover;
            pointer-events: none;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--input-color-gray);
        }
        select, input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            color: var(--input-color-gray);
            font-size: 13px;
            transition: border-color 0.3s ease;
        }
        select:focus, input[type="text"]:focus {
            outline: none;
            border-color: var(--light-black);
        }
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            font-weight: normal;
            cursor: pointer;
        }
        .checkbox-label input {
            margin-right: 8px;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: var(--second-main-red);
            color: #fff;
            border: none;
            font-size: 13px;
            font-weight: 400;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: var(--main-hover-red);
        }
        .schedule-item {
            background-color: #f8f9fa;
            border-left: 4px solid var(--main-hover-red);
            padding: 15px;
            margin-bottom: 10px;
            transition: transform 0.2s ease;
        }
        .schedule-item:hover {
            transform: translateX(5px);
        }
        .schedule-item strong {
            color: var(--primary-color);
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
            sidebar("ordinance");
        ?>
        <main class="content">
            <div class="content home">
            <h1>Ordinance Shifting</h1><br>
            <section class="add-event">
                <div class="schedule-form">
                    <form id="scheduleForm">
                    <h1>Kagawad</h1><br>
                        <div class="form-group">
                            <label>Select Day(s):</label>
                            <div class="select-group">
                                <select name="day" id="day-select">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="person">Assign Person:</label>
                            <select name="barangay_officials">
                                <option value="">Choose user</option>
                                <?php display_users(); ?>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="submit-btn">Add to Schedule</button>
                    </form>
                    <div class="image-container">
                        <img src="../../assets/holder-image.png" id="userpicture" alt="image holder">
                    </div>
                </div>
            </section><hr>


            </div>
        </main>
    </div>
    <script src="../../javascript/image.js"></script>
</body>
</html>