<?php
// include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

// if (isset($_POST["verify"])) {
//     $otp_input = isset($_POST['otp']) ? implode('', $_POST['otp']) : '';
//     $verification_code = isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : '';
//     $otp_generation_time = isset($_SESSION['otp_generation_time']) ? $_SESSION['otp_generation_time'] : 0;

//     if ((time() - $otp_generation_time) > 60) {
//         // OTP has expired
//         echo "<script>alert('OTP has expired. Please request a new OTP.'); window.location.href='../verification.php';</script>";
//     } else if ($otp_input === $verification_code) { 
//         // OTP is correct
//         $update_verification = [
//             'query' => 'UPDATE users SET user_verification = ? WHERE user_email = ?',
//             'bind' => 'ss',
//             'value' => ["Verified", $_SESSION['gmail']]
//         ];
        
//         $result = updateData($update_verification);

//         if ($result) {
//             $_SESSION['modal_btn'] = true;
//             $_SESSION['message_modal'] = "Account verified successfully!";
//             echo"<script>window.location.href='../verification.php'</script>";
//             // session_destroy();//para sa iba naman
//         } else {
//             $_SESSION['modal_btn'] = true;
//             $_SESSION['message_modal'] = "Failed to verify account. Please try again.";
//             header("Location: ../verification.php");
//             exit;
//         }
//     } else {
//         // OTP is incorrect
//         $_SESSION['modal_btn'] = true;
//         $_SESSION['message_modal'] = "Invalid OTP. Please try again.";
//         header("Location: ../verification.php");
//         exit;
//     }
// }
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

if (isset($_POST["verify"])) {
    $otp_input = isset($_POST['otp']) ? implode('', $_POST['otp']) : '';
    $verification_code = isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : '';

    if ($otp_input === $verification_code) { 
        // OTP is correct
        $update_verification = [
            'query' => 'UPDATE users SET user_verification = ? WHERE user_email = ?',
            'bind' => 'ss',
            'value' => ["Verified", $_SESSION['gmail']]
        ];
        
        $result = updateData($update_verification);

        if ($result) {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "Account verified successfully!";
            echo"<script>window.location.href='../verification.php'</script>";
        } else {
            $_SESSION['modal_btn'] = true;
            $_SESSION['message_modal'] = "Failed to verify account. Please try again.";
            header("Location: ../verification.php");
            exit;
        }
    } else {
        // OTP is incorrect
        $_SESSION['modal_btn'] = true;
        $_SESSION['message_modal'] = "Invalid OTP. Please try again.";
        header("Location: ../verification.php");
        exit;
    }
}
