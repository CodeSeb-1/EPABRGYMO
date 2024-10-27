<?php
include_once("../includes/model.php");

function calculateAge($birthday)
{
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age; //
}

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
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_purok'] = $user['user_purok'];
        $_SESSION['user_address'] = $user['user_address'];
        $_SESSION['user_fullname'] = "{$user['user_firstname']}" . " {$user['user_middlename']}" . " {$user['user_lastname']}";
        $_SESSION['user_age'] = calculateAge($user['user_birthdate']);
        $_SESSION['user_birthdate'] = $user['user_birthdate'];
        $_SESSION['user_contact'] = $user['user_phoneNo'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['user_type'] = $user['user_type'];

        if ($user['user_verification'] == "Not Verified") {

            //para lang sa verification ung gmail para iupdate ung user_verification na column sa users
            $_SESSION['gmail'] = $email;
            $verification_code = generateVerificationCode();
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['otp_generation_time'] = time(); //para sa 60secs

            sendVerificationEmail($email, $verification_code);
            location("../verification.php");
        } else {

            if ($user['user_type'] === "Resident") {
                location("../index.php");
            } else if ($user['user_type'] === "Tanod") {
                location("../admin/tanod/tanod_calendar.php");
            } else if ($user['user_type'] === "Secretary") {
                location("../admin/secretary/secretary_calendar.php");
            }

        }
    } else {
        echo "
        <script>alert('Wrong Credentials'); window.location.href='../login.php'; 
        window.history.back();
        </script>";
    }
}

