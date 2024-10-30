<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
if(isset($_POST['logout'])) {
    session_destroy();
    location("../../login.php");
}
?>
<header>
    <?php
        $img_path = file_exists($img = $_SERVER['DOCUMENT_ROOT'] . "/EPABRGYMO/dataImages/Resident.{$_SESSION['user_id']}.jpg") ? "/EPABRGYMO/dataImages/Resident.{$_SESSION['user_id']}.jpg" : "assets/profile.jpg";      
    ?>
    <img src="../../assets/LOGO.png" alt="logo">
    <div class="user-info">
        <div><?php echo$_SESSION['user_type']; ?></div> |
        <img src="<?php echo$img_path?>" alt="logo">
        <span><?php echo$_SESSION['user_fullname']; ?></span>
        <form method="POST">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>
</header>
