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
                <div class="menu-item">
                    <span class="material-symbols-outlined">calendar_month</span>                
                    <span>Calendar</span>
                </div>
            </a>
            <a href="tanod_duty_shifts.php">
                <div class="menu-item active">
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

            <section class="events">
                <h2>Duty Shifts</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Inventory</th>
                            <th>Color</th>
                            <th>Price</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="/placeholder.svg?height=50&width=50" alt="Men Gray Hoodie" style="width: 50px; height: 50px; margin-right: 10px;">
                                Men Gray Hoodie
                            </td>
                            <td>86 in stock</td>
                            <td>Black</td>
                            <td>$49.90</td>
                            <td>5.0 (12 Votes)</td>
                        </tr>
                        <tr>
                            <td>
                                <img src="/placeholder.svg?height=50&width=50" alt="Women Striped T-Shirt" style="width: 50px; height: 50px; margin-right: 10px;">
                                Women Striped T-Shirt
                            </td>
                            <td>56 in stock</td>
                            <td>White</td>
                            <td>$34.90</td>
                            <td>4.8 (24 Votes)</td>
                        </tr>
                        <tr>
                            <td>
                                <img src="/placeholder.svg?height=50&width=50" alt="Women White T-Shirt" style="width: 50px; height: 50px; margin-right: 10px;">
                                Women White T-Shirt
                            </td>
                            <td>0 in stock</td>
                            <td>White</td>
                            <td>$29.90</td>
                            <td>4.9 (31 Votes)</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>