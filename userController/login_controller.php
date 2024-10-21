<?php
include_once("../includes/model.php");

if (isset($_POST["login"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Check if the user exists by email
    $check_email = [
        'query' => 'SELECT * FROM users WHERE user_email = ?',
        'bind' => 's',
        'value' => [$email]
    ];

    $user = select($check_email, true);

    if ($user && password_verify($password, $user['user_password'])) {
        $_SESSION['user_id'] = $user['user_id'];//eto para sa user id
        $_SESSION['user_purok'] = $user['user_purok'];
        $_SESSION['user_fullname'] = "{$user['user_firstname']}{$user['user_middlename']} {$user['user_lastname']}";

        
        if ($user['user_verification'] == "Not Verified") {

            //para lang sa verification ung gmail para iupdate ung user_verification na column sa users
            $_SESSION['gmail'] = $email;
            $verification_code = generateVerificationCode();
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['otp_generation_time'] = time(); //para sa 60secs

            sendVerificationEmail($email, $verification_code);
            location("../verification.php");
        } else {
            
            if($user['user_type'] === "Resident") {
                location("../index.php");
            }

        }
    } else {
        echo "<script>alert('Wrong Credentials'); window.location.href='../login.php';</script>";
    }

}

