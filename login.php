<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo</title>
    <link rel="stylesheet" href="assets/style.css??????????">
    <link rel="icon" href="assets/SECONDARYLOGO.png" type="image/png" sizes="32x32">
</head>
<body>
    <main>
        <div class="form-container">
            <div class="left-section login">
                <div class="container">
                    <h2>WELCOME TO</h2>
                    <img src="assets/LOGO.png" id="loginLogo" alt="LOGO">
                    <p>Login to access Barangay Maronquillo's management <br> features and stay updated on the latest events.</p><br>
                    <form action="userController/login_controller.php" method="POST">
                        <div class="forms2">
                            <div class="field">
                                <input type="text" id="email" name="email" placeholder="" required>
                                <label for="email">Enter Email</label>
                            </div>
                            <div class="field">
                                <input type="password" id="password" name="password" placeholder="" required> 
                                <label for="password">Enter Password</label>
                            </div>
                            <div class="button">
                            <input type="submit" name="login" value="SIGN IN"> 
                            </div>
                        </div>
                    </form>
                    <p>Don't have an account? <a href="register.php"> Sign Up Now</a> </p>
                </div>
            </div>
            <div class="right-section">
                <div class="information">
                    <img src="assets/SECONDARYLOGO.png" alt="secondary logo">
                    <p>E-PaBrgyMo is a Digital Platform for Barangay <br> Management and Operations for Barangay Maronquillo</p>
                    <h2>Isang Pindot, Lahat Sagot!</h2>
                </div>
                <div class="f-color"></div>
            </div>
        </div>
    </main>
</body>
</html>

<!-- 
asdasdsadaasdsad
eto na ung mga nasa input tag
$email = POST['email'];
$password = POST['password'];

gawa nalang function para pang check if exisiting tapos gamit nalang session?

Pakyuu

http://127.0.0.1:5500


-->