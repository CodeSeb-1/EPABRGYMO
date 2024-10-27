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
                <h1><?php echo $_SESSION['user_fullname']; ?></h1><br>
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
                    <strong>Birthday:</strong> <span><?php echo  $formattedDate = date('F j, Y', strtotime($_SESSION['user_birthdate'])); ?></span> 
                </div>
            </div>
        </div>
    </div>
    <?php include_once("footer.php");?>
    <script src="navbar.js"></script>  
</body>
</html>
