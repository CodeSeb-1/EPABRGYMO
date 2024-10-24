<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo</title>
    <link rel="stylesheet" href="assets/style.css????????????">
    <link rel="icon" href="assets/SECONDARYLOGO.png" type="image/png" sizes="32x32">
</head>

<body>
    <main>
        <div class="form-container">
            <div class="left-section register">
                <div class="container">
                    <img src="assets/LOGO.png" id="registerLogo" alt="LOGO">
                    <h2>SIGN UP</h2>
                    <p>To sign up please fill out the required information</p>
                    <form method="POST" action="userController/register_controller.php" enctype="multipart/form-data">
                        <div class="forms">
                            <div class="field-information">
                                <div class="field">
                                    <input type="text" id="firstname" name="firstname" placeholder="" required>
                                    <label for="firstname">First name</label>
                                </div>
                                <div class="field">
                                    <input type="text" id="middlename" name="middlename" placeholder="" required>
                                    <label for="middlename">Middle name</label>
                                </div>
                                <div class="field">
                                    <input type="text" id="lastname" name="lastname" placeholder="" required>
                                    <label for="lastname">Last name</label>
                                </div>
                            </div>
                            <div class="field-grid">
                                <div class="field">
                                    <input type="text" id="email" name="email" placeholder="" required>
                                    <label for="email">Enter Email</label>
                                </div>
                                <div class="field">
                                    <input type="text" id="phone" name="phone" placeholder="" required>
                                    <label for="phone">Enter Phone No.</label>
                                </div>
                                <div class="field">
                                    <input type="password" id="password" name="password" placeholder="" required>
                                    <label for="password">Enter Password</label>
                                </div>
                                <div class="field">
                                    <input type="text" id="purok" name="purok" placeholder="" required>
                                    <label for="purok">Purok</label>
                                </div>
                                <div class="field">
                                    <input type="text" id="street" name="street" placeholder="" required>
                                    <label for="street">House no., Street</label>
                                </div>
                                <div class="field">
                                    <input type="date" id="birthday" name="birthday" placeholder="" required>
                                    <label for="birthday">Birthday</label>
                                </div>
                            </div>
                            <div class="button">
                                <input type="submit" value="SIGN UP" name="register">
                            </div>
                        </div>
                        <div class="profile-picture">
                            <h2>PROFILE PICTURE</h2><br>
                            <div class="profile-con">
                                <img src="assets/USER.png" id="userpicture" alt="user profile picture">
                                <div class="custom-file-input">
                                    <input type="file" id="fileUpload" name="image"
                                        onchange="previewImage(this); required">
                                    <label for="fileUpload">Choose File</label>
                                </div><br>
                            </div>
                        </div>
                    </form>
                    <p>Already have an account? <a href="login.php">Sign In</a></p>
                </div>
            </div>
        </div>
    </main>
    <script src="image.js"></script>
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