<?php
include_once("../includes/model.php");

if (isset($_POST["logout"])) {
    session_destroy();
    location("../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if an image is being uploaded
    if (!empty($_FILES['image']['tmp_name'])) {
        // Find the existing image and remove it
        $existingImagePath = $_SERVER['DOCUMENT_ROOT'] . "/EPABRGYMO/dataImages/" . $_POST['existingImage'];
        if (file_exists($existingImagePath)) {
            unlink($existingImagePath);
        }
        
        // Upload the new image
        if (uploadImage($_FILES['image'], "Resident", $_SESSION['user_id'])) {
            // Redirect after successful image update
            header("Location: ../profile.php");
            exit;
        } else {
            // Handle upload failure (optional)
            echo "Image upload failed.";
        }
    } else {
        // Handle case where no image was uploaded (optional)
        echo "No image selected for upload.";
    }
}
