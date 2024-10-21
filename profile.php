<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/style1.css?">
</head>
<body>
    <?php
        include_once("header.php");
        nav("profile");
    ?>
    <div class="container">
        <div class="profile">
            <div class="line"></div>
            <div class="profile-picture-section">
                <div class="profile-picture-container">
                    <img src="assets/image.png" alt="Jeremy Rose" class="profile-picture">
                </div>
                <h1>Mark Jolo Tadeo</h1><br>
                <form action="userController/profile_controller.php" method="POST">
                    <button type="submit" name="logout" class="btn btn-primary">Logout</button>
                    <button class="btn btn-edit">Edit Profile</button>
                </form>
            </div><hr>
            <div class="content">
                <h3>BASIC INFORMATION</h3>
                <div class="info-item">
                    <strong>Phone:</strong> <span><?php echo $_SESSION['user_contact']; ?></span> 
                </div>
                <div class="info-item">
                    <strong>Address:</strong> <span><?php echo $_SESSION['user_address']; ?></span> 
                </div>
                <div class="info-item">
                    <strong>E-mail:</strong> <span><?php echo $_SESSION['user_email']; ?></span> 
                </div>
                <div class="info-item">
                    <strong>Birthday:</strong> <span><?php echo $_SESSION['user_birthdate']; ?></span> 
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="information">
            <div class="about">
                <img src="assets/PRIMARY LOGO -  BLACK 1.png" alt="logo"><br>
                <div class="info-about">
                    <p>Is a Digital Platform for Barangay Management and Operations for Barangay Moronquillo</p>
                </div><br><br>
                <p>Copyright E-PaBrgyMo</p>
            </div>
            <div class="get-in-touch">
                <h3>GET IN TOUCH</h3>
                <div class="get-container">
                    <img src="assets/location_on.png" alt="location">
                    <p>8819 Ohio St. South Gate,
                        CA 90280</p>
                </div>
                <div class="get-container">
                    <img src="assets/email.png" alt="email">
                    <p>Ourstudio@hello.com</p>
                </div>
                <div class="get-container">
                    <img src="assets/call.png" alt="call">
                    <p>+1 386-688-3295</p>
                </div>
            </div>
            <div class="services">
                <h3>SERVICES</h3>
                <p>Latest News</p>
                <p>Events</p>
                <p>Request Documents</p>
                <p>File a Complain</p>
                <p>Chat System</p>
            </div>
            <div class="informations">
                <h3>INFORMATIONS</h3>
                <p>Home</p>
                <p>Contacts</p>
                <p>Organization Chart</p>
                <p>About Us</p>
            </div>
        </div>
    </footer>
    <script src="navbar.js"></script>  
</body>
</html>
