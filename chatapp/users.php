<?php 
session_start();
if (!isset($_SESSION["unique_id"])) {
    header("location: login.php");
}

require_once("header.php"); 
include_once("includes/db.php");
?>
<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <?php
                    $sql = mysqli_query($con,"SELECT * FROM users WHERE unique_id = '{$_SESSION['unique_id']}'");
                    if(mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                ?>
                <div class="content">
                    <img src="uploads/<?php echo $row['img'] ?>" alt="Profile Pic">
                    <div class="details">
                        <span><?php echo $row['fname'] . " ". $row['lname']; ?></span>
                        <p><?php echo $row['status'] ?></p>
                    </div>
                </div>
                <a href="#" class="logout">Logout</a>
            </header>

            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <div class="users-list">
                
            </div>
        </section>
    </div>

    <script src="javascript/users.js"></script>
</body>
</html>