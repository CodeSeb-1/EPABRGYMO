<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

require_once("db.php");
session_start();    

function insertData($data, $table = "") {
    global $con;

    if ($stmt = $con->prepare($data['query'])) {
        $values = $data['value'];
        
        if (!empty($data['bind']) && !empty($values)) {
            $stmt->bind_param($data['bind'], ...$values);
        }

        $stmt->execute();
        $last_id = $con->insert_id; 

        if (!empty($_FILES['image']['tmp_name'])) {
            uploadImage($_FILES['image'], $table, $last_id);
        }
        
        $stmt->close();
        return $last_id; 
    }
    return false; 
}


function updateData($data, $table = "") {
    global $con;

    if ($stmt = $con->prepare($data['query'])) {
        $values = $data['value'];

        if (!empty($data['bind']) && !empty($values)) {
            $stmt->bind_param($data['bind'], ...$data['value']);
        }

        $stmt->execute();
        $record_id = $data['value'][count($data['value']) - 1]; 
        
        if (!empty($_FILES['image']['tmp_name'])) {
            $imagePath = "dataImages/" . $_POST['existingImage'];
            if (file_exists($imagePath)) {
                unlink($imagePath); 
            }
            uploadImage($_FILES['image'], $table, $record_id); // Upload new image
        }

        $stmt->close();
        return true;
    }
    return false;
}



function select($data, $singleRow = false) {
    global $con;

    if ($stmt = $con->prepare($data['query'])) {
        if (!empty($data['bind']) && !empty($data['value'])) {
            $stmt->bind_param($data['bind'], ...$data['value']);
        }

        $stmt->execute();
        $results = $stmt->get_result();
        $stmt->close();

        return $singleRow ? $results->fetch_assoc() : $results->fetch_all(MYSQLI_ASSOC);
    } else {
        error_log("Failed to prepare statement: " . $con->error);
        return false;
    }
}

function displayAll($data = null, $id = null, $output = null) {
    $checkResult = select($data);

    if ($checkResult === false) {
        return ''; 
    }

    $return_output = '';
    foreach ($checkResult as $row) {
        $return_output .= $output($row, $id);
    }
    return $return_output;
}

function uploadImage($file, $table, $last_id): bool {
    $filepath = $_SERVER['DOCUMENT_ROOT'] . "/EPABRGYMO/dataImages/$table.$last_id.jpg";
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return true;
    }
    return false;
}


function findImageFile($table, $id) {
    $filePath = $_SERVER['DOCUMENT_ROOT'] . "/EPABRGYMO/dataImages/$table.$id.jpg";
    return file_exists($filePath) ? basename($filePath) : null;
}

function deleteData($data, $deleteImage = false) {
    global $con;
    $success = false; 
    if ($stmt = $con->prepare($data['query'])) {
        if (!empty($data['bind']) && !empty($data['value'])) {
            $stmt->bind_param($data['bind'], ...$data['value']);
        }

        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $success = true; 
        }

        // Check if we need to delete an image
        if ($deleteImage && !empty($deleteImage['table']) && !empty($deleteImage['primaryKey'])) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . "/EPABGRYMO/dataImages/{$deleteImage['table']}.{$deleteImage['primaryKey']}.jpg";
            if (file_exists($filePath)) {
                unlink($filePath); 
            }
        }

        $stmt->close();
    }
    return $success;
}

function generateVerificationCode() {
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}


function UpdateUserVerification($email, $verification) {
    global $con;

    // Correct SQL query with correct placeholders
    $sql = "UPDATE users set user_verification = ? WHERE user_email = ?";

    $stmt = $con->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }

    // Correct number of parameters in bind_param
    $stmt->bind_param("ss", $verification, $email);

    if ($stmt->execute()) {
        $newUserId = $con->insert_id;
        $_SESSION["user_id"] = $newUserId;
        $_SESSION["alert"] = true;

        return "Verifiying Account Successfully Completed.";
    }
}

function sendVerificationEmail($email, $verification_code) {

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'epabrgymo@gmail.com';           // SMTP username
        $mail->Password   = 'mpdf widx opax tnve';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        // Disable certificate verification (development only)
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );

        // Enable SMTP debugging
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

        // Recipients
        $mail->setFrom('epabrgymo@gmail.com', 'EPABRGYMO');  // Sender's email address and name
        $mail->addAddress($email);                                          // Recipient's email address

        // Content
        $mail->isHTML(true);                                                // Set email format to HTML
        $mail->Subject = 'Verification Code for Registration';              // Email subject
        $mail->Body    = "Your verification code is: <strong>{$verification_code}</strong>"; // Email body

        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false; // Email not sent
    }
}

function location($location) {
    header("location: $location");
}


function NotActive() {
    if(empty($_SESSION['uid'])) location("login.php");
}


function getUnreadCount($user_id)
{
    $query = "SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = ? AND is_read = 0";
    $data = [
        'query' => $query,
        'bind' => 'i',
        'value' => [$user_id]
    ];
    $result = select($data);
    return $result[0]['unread_count'] ?? 0;
}

function markAsRead($notification_id)
{
    $query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $data = [
        'query' => $query,
        'bind' => 'i',
        'value' => [$notification_id]
    ];
    return updateData($data, 'notifications');
}
