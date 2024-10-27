<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Login - Barangay Maronquillo</title>
    <link rel="stylesheet" href="assets/LRstyle.css">
    <link rel="stylesheet" href="assets/text.css?">
    <link rel="icon" href="assets/SECONDARYLOGO.png" type="image/png" sizes="32x32">
</head>
<body>
    <div class="container">
        <div class="login-section">
            <p class="welcome-text">WELCOME TO</p>
            <img src="assets/LOGO.png" id="loginLogo" alt="LOGO"><br>
            <form action="userController/login_controller.php" method="POST" class="login-form">
                <p class="description">Login to access Barangay Maronquillo's management features and stay updated on the latest events.</p>
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="" required>
                    <label for="password">Password</label>
                </div>
                <button type="submit" name="login" class="sign-in-btn">Sign in</button>
            </form>
            <p class="sign-up-text">Don't have an account? <a href="register.php">Sign Up Now</a></p>
        </div>
        <div class="image-section">
            <div class="image-overlay">
                <img src="assets/LOGO-BRGY.png" id="logo" alt="secondary logo"><br>
                <p>E-PaBrgyMo is a Digital Platform for Barangay Management and Operations for Barangay Maronquillo</p>
                <h1 class="tagline">Isang Pindot, Lahat Sagot!</h1>
            </div>
        </div>
    </div>
</body>
</html>