<?php
include_once("../includes/model.php");

$verification_code = generateVerificationCode();
$_SESSION['verification_code'] = $verification_code;
$_SESSION['otp_generation_time'] = time(); 

sendVerificationEmail($_SESSION['gmail'], $verification_code); 

header("Location: ../verification.php");
