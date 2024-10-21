<?php
include_once("../includes/model.php");

if(isset($_POST["register"])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact = $_POST['phone'];
    $password = $_POST['password'];
    $purok = $_POST['purok'];
    $birthday = $_POST['birthday'];

    //check if exisiting na ung email
    $check_email = [
        'query' => 'SELECT user_email FROM users WHERE user_email = ?',
        'bind' => 's',
        'value'=> [$email]
    ];

    $result = select($check_email);
    if(!$result) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $_SESSION['gmail'] = $email;
 
        $register = [
            'query' => "INSERT INTO 
                            users (user_firstname, user_middlename, user_lastname, user_email, user_phoneNo, user_password, user_purok, user_birthdate, user_verification)
                        VALUES (?,?,?,?,?,?,?,?,?)",
            'bind' => 'sssssssss',
            'value'=> [$firstname, $middlename, $lastname, $email, $contact, $hashed_password, $purok, $birthday, "Not Verified"]
        ];
        

        insertData($register, "Resident");

        $verification_code = generateVerificationCode(); 
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['otp_generation_time'] = time(); // Store the current time


        sendVerificationEmail($_POST["email"], $verification_code); 

        location("../verification.php");

    } else {
        echo "<script>alert('email already use or try login for code verification');</script>";
    }
}