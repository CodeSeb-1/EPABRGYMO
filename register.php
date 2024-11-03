<?php include_once("userController/register_controller.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Registration - Barangay Maronquillo</title>
    <link rel="stylesheet" href="assets/LRstyle.css???">
    <link rel="stylesheet" href="assets/text.css?">
    <link rel="stylesheet" href="assets/modal.css">
    <link rel="stylesheet" href="assets/success-modal.css">
    <link rel="icon" href="assets/SECONDARYLOGO.png" type="image/png" sizes="32x32">
</head>
<body>
    <div class="container">
        <div class="register-section">
            <p class="welcome-text">REGISTER FOR</p>
            <img src="assets/LOGO.png" id="register" alt="LOGO"><br>
            <form method="POST" action="userController/register_controller.php" enctype="multipart/form-data">
                <div class="name-fields">
                    <div class="input-group">
                        <input type="text" id="firstname" name="firstname" placeholder="" required>
                        <label for="firstname">First name</label>
                    </div>
                    <div class="input-group">
                        <input type="text" id="middlename" name="middlename" placeholder="">
                        <label for="middlename">Middle name</label>
                    </div>
                    <div class="input-group">
                        <input type="text" id="lastname" name="lastname" placeholder="" required>
                        <label for="lastname">Last name</label>
                    </div>
                </div>
                <div class="input-grid">
                    <div class="input-group">
                        <input type="email" id="email" name="email" placeholder="" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="input-group">
                        <input type="tel" id="phone" name="phone" placeholder="" required>
                        <label for="phone">Contact No.</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="" required>
                        <label for="password">Password</label>
                    </div>
                    <div class="input-group">
                        <input type="number" id="purok" name="purok" min="1" max="7" placeholder="" required>
                        <label for="purok">Purok</label>
                    </div>
                    <div class="input-group">
                        <input type="text" id="houseno" placeholder="" name="street" required>
                        <label for="houseno">House no, Street</label>
                    </div>
                    <div class="input-group">
                        <input type="date" id="birthday" name="birthday" required>
                        <label for="birthday">Birthday</label>
                    </div>
                </div>
                <div class="input-group">
                    <input type="file" id="profile-picture" name="image" accept="image/*">
                </div>
                <button type="submit" name="register" class="register-btn">Register</button>
            </form>
            <p class="login-text">Already have an account? <a href="login.php">Log In</a></p>
        </div>
        <div class="image-section">
            <div class="image-overlay">
                <img src="assets/LOGO-BRGY.png" id="logo" alt="secondary logo"><br>
                <p>E-PaBrgyMo is a Digital Platform for Barangay Management and Operations for Barangay Maronquillo</p>
                <h1 class="tagline">Isang Pindot, Lahat Sagot!</h1>
            </div>
        </div>
    </div>
            <div id="successModal" class="modal">
                <div class="modal-content success">
                    <div class="modal-header">
                        <h2>Checking</h2>
                        <span class="close" onclick="closeSuccessModal()">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p><?php echo$_SESSION['message_modal'] ?? ''; ?></p><br>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
    <?php include_once("show-success-error-modal.php") ?>
    <script src="javascript/image.js"></script>
</body>
</html>