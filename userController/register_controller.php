<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
// session_start();

if (isset($_POST["register"])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact = $_POST['phone'];
    $password = $_POST['password'];
    $purok = $_POST['purok'];
    $address = $_POST['street'] . ", Maronquillo, San Rafael, Bulacan";
    $birthday = $_POST['birthday'];

    // Check if email exists in the masterlist
    $check_email_master_list = [
        'query' => 'SELECT masterlist_email FROM masterlist WHERE masterlist_email = ?',
        'bind' => 's',
        'value' => [$email]
    ];
    
    $result_list = select($check_email_master_list);

    if (!$result_list) {
        $_SESSION['modal_btn'] = true;
        $_SESSION['message_modal'] = "Email is not in the masterlist";
        echo "<script>window.history.back(); window.location.href='../register.php'</script>";
    } else {
        // Check if email already exists in the users table
        $check_email = [
            'query' => 'SELECT user_email, user_verification FROM users WHERE user_email = ?',
            'bind' => 's',
            'value' => [$email]
        ];

        $result = select($check_email, true);

        if ($result['user_verification'] === "Not Verified") {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "Email already registered you may login for verification";
            location("../register.php");

            // echo "<script>alert('Email already registered you may login for verification'); window.location.href='../register.php';</script>";
        } else if ($result['user_verification'] === "Verified") {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "Email is already registered and verified. Please log in.";
            location("../register.php");
            // echo "<script>alert('Email is already registered and verified. Please log in.'); window.location.href='../register.php';</script>";
        } else {
            // Proceed with registration
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $_SESSION['gmail'] = $email;

            $register = [
                'query' => "INSERT INTO 
                                users (user_firstname, user_middlename, user_lastname, user_email, user_phoneNo, user_password, user_purok, user_address, user_birthdate, user_verification)
                            VALUES (?,?,?,?,?,?,?,?,?,?)",
                'bind' => 'ssssssssss',
                'value' => [$firstname, $middlename, $lastname, $email, $contact, $hashed_password, $purok, $address, $birthday, "Not Verified"]
            ];

            insertData($register, "Resident");

            $verification_code = generateVerificationCode();
            $_SESSION['verification_code'] = $verification_code;
            $_SESSION['otp_generation_time'] = time(); // Store the current time

            sendVerificationEmail($email, $verification_code);

            location("../verification.php");
        }
    }
}
