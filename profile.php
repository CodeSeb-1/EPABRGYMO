<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/style1.css">
    <style>
        /* Add this style to initially hide the file input */
        .file-input {
            display: none;
            margin-bottom: 10px;
        }

        .btn-save {
            background-color: rgb(134, 152, 241);
            color: #fff;
        }

        .btn-cancel {
            background: #C90508;
            color: #fff;
        }
    </style>
    <script>
        let isEditing = false; // Track editing state

        function toggleFileInput() {
            const fileInput = document.getElementById('file-input');
            const saveButton = document.getElementById('save-button');
            const editButton = document.getElementById('edit-button');
            const cancelButton = document.getElementById('cancel-button');
            const logoutButton = document.getElementById('logout-button');

            if (!isEditing) {
                fileInput.style.display = 'block'; // Show file input
                saveButton.style.display = 'inline'; // Show save button
                cancelButton.style.display = 'inline'; // Show cancel button
                editButton.style.display = 'none'; // Hide edit button
                logoutButton.style.display = 'none'; // Hide logout button
            } else {
                fileInput.style.display = 'none'; // Hide file input
                saveButton.style.display = 'none'; // Hide save button
                cancelButton.style.display = 'none'; // Hide cancel button
                editButton.style.display = 'inline'; // Show edit button
                logoutButton.style.display = 'inline'; // Show logout button
            }

            isEditing = !isEditing; // Toggle editing state
        }
    </script>
</head>
<body>
    <?php
        include_once("header.php");
        nav("profile");
        $img_path = file_exists($img = $_SERVER['DOCUMENT_ROOT'] . "/EPABRGYMO/dataImages/Resident.{$_SESSION['user_id']}.jpg") ? "/EPABRGYMO/dataImages/Resident.{$_SESSION['user_id']}.jpg" : "assets/profile.jpg";      
    ?>
    <div class="container">
        <div class="profile">
            <div class="line"></div>
            <div class="profile-picture-section">
                <div class="profile-picture-container">
                    <img src="<?php echo $img_path ?>" alt="Profile Picture" id="userpicture" class="profile-picture">
                </div>
                <h1><?php echo $_SESSION['user_fullname']; ?></h1><br>
                <form action="userController/profile_controller.php" method="POST" enctype="multipart/form-data">
                    <div class="file-input" id="file-input">
                        <input type="file" name="image" onchange="previewImage(this);">
                    </div>
                    <input type="hidden" name="existingImage" value="<?php echo basename($img_path); ?>">
                    <button type="button" class="btn btn-edit" id="edit-button" onclick="toggleFileInput()">Edit Profile</button>
                    <button type="submit" id="save-button" class="btn btn-save" style="display: none;">Save</button>
                    <button type="button" id="cancel-button" class="btn btn-cancel" style="display: none;" onclick="toggleFileInput()">Cancel</button>
                    <button type="submit" name="logout" id="logout-button" class="btn btn-primary">Logout</button>
                </form>
            </div><hr>
            <div class="content">
                <h3>BASIC INFORMATION</h3>
                <div class="info-item">
                    <strong>Phone:</strong> <span><?php echo $_SESSION['user_contact']; ?></span> 
                </div>
                <div class="info-item">
                    <strong>Address:</strong> <span><?php echo $_SESSION['user_address']; ?></span> 
                </div>
                <div class="info-item">
                    <strong>E-mail:</strong> <span><?php echo $_SESSION['user_email']; ?></span> 
                </div>
                <div class="info-item">
                    <strong>Birthday:</strong> <span><?php echo date('F j, Y', strtotime($_SESSION['user_birthdate'])); ?></span> 
                </div>
            </div>
        </div>
    </div>
    <?php include_once("footer.php");?>
    <script src="javascript/navbar.js"></script>  
    <script src="javascript/image.js"></script>
</body>
</html>
