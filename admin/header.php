<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
if(isset($_POST['logout'])) {
    session_destroy();
    location("../../login.php");
}
?>
<header>
    <img src="../../assets/LOGO.png" alt="logo">
    <div class="user-info">
        <div><?php echo$_SESSION['user_type']; ?></div> |
        <img src="../../assets/image.png" alt="User profile">
        <span><?php echo$_SESSION['user_fullname']; ?></span>
        <form method="POST">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>
</header>
