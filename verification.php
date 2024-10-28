<?php 
include_once("userController/verification_controller.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo - OTP Verification</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="assets/SECONDARYLOGO.png" type="image/png" sizes="32x32">
    <link rel="stylesheet" href="assets/modal.css???">
    <link rel="stylesheet" href="assets/success-modal.css">
    <style>
        .otp-container {
            text-align: center;
        }
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        .otp-inputs input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
        .resend {
            color: #0000ff;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            display: none;
        }
        .resend:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <main>
        <div class="form-container">
            <div class="left-section login">
                <div class="container">
                    <h2>OTP VERIFICATION</h2>
                    <img src="assets/LOGO.png" id="loginLogo" alt="LOGO">
                    <p>Enter the OTP you received to verify your account and access Barangay Maronquillo's management features.</p><br>
                    <form action="userController/verification_controller.php" method="post">
                        <div class="forms1">
                            <div class="otp-container">
                                <p>Enter the OTP sent to your email</p>
                                <div class="otp-inputs">
                                    <input type="text" name="otp[]" maxlength="1" required>
                                    <input type="text" name="otp[]" maxlength="1" required>
                                    <input type="text" name="otp[]" maxlength="1" required>
                                    <input type="text" name="otp[]" maxlength="1" required>
                                    <input type="text" name="otp[]" maxlength="1" required>
                                    <input type="text" name="otp[]" maxlength="1" required>
                                </div>
                                <p id="countdown-timer"></p>
                                <a href="userController/resend_otp.php" class="resend" id="resend-otp">Resend OTP ›</a>
                            </div>
                            <div class="button">
                                <input type="submit" name="verify" value="VERIFY OTP">
                            </div>
                        </div>
                    </form>
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
        <div id="successModal" class="modal">
                <div class="modal-content success">
                    <div class="modal-header">
                        <h2>Success</h2>
                        <span class="close" onclick="closeSuccessModal()">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p><?php echo$_SESSION['message_modal'] ?? ''; ?></p><br><br>
                    </div>
                    <div class="modal-footer">
                        <?php if($_SESSION['message_modal'] === "Account verified successfully!") {?>
                            <button onclick="closeSuccessModal('login.php')" class="btn btn-primary">OK</button>
                            <?php session_destroy(); ?>
                        <?php } else {?>
                            <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
    <?php include_once("show-success-error-modal.php") ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const countdownTime = 60; 
            const otpGenerationTime = <?php echo isset($_SESSION['otp_generation_time']) ? $_SESSION['otp_generation_time'] : 0; ?>;
            const currentTime = Math.floor(Date.now() / 1000); 
            
            const otpExpired = currentTime - otpGenerationTime > countdownTime;
            const timerElement = document.getElementById("countdown-timer");
            const resendLink = document.getElementById("resend-otp");

            if (!otpExpired) {
                const elapsedTime = currentTime - otpGenerationTime;
                let timeRemaining = countdownTime - elapsedTime;

                timerElement.textContent = `Time remaining: ${timeRemaining} seconds`;

                const countdown = setInterval(function() {
                    timeRemaining--;
                    timerElement.textContent = `Time remaining: ${timeRemaining} seconds`;

                    if (timeRemaining <= 0) {
                        clearInterval(countdown);
                        timerElement.textContent = "Time's up!";
                        resendLink.style.display = "inline"; 
                    }
                }, 1000);
            } else {
                timerElement.textContent = "OTP expired. Please resend.";
                resendLink.style.display = "inline";
            }
        });
    </script>
</body>
</html>
