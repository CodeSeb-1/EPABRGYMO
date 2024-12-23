<?php 
session_start();
if (!isset($_SESSION["unique_id"])) {
    header("location: login.php");
}

require_once("header.php"); 
include_once("includes/db.php");
?>
<?php require_once("header.php"); ?>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php
                $user_id = mysqli_real_escape_string($con, $_GET["user_id"]);//eto ung katext mo
                    $sql = mysqli_query($con,"SELECT * FROM users WHERE unique_id = '{$user_id}'");
                    if(mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                ?>
                <a href="users.php" class="back-icon"><i class="fa-solid fa-arrow-left"></i></a>
                <img src="uploads/<?php echo $row['img'] ?>" alt="Profile Pic">
                <div class="details">
                    <span><?php echo $row['fname'] . " ". $row['lname']; ?></span>
                    <p><?php echo $row['status'] ?></p>
                </div>
            </header>

            <div class="chat-box">
                
            </div>

            <form action="#" class="typing-area" autocomplete="off">
                <input type="text" name="outgoing_id" value="<?php echo$_SESSION["unique_id"]; ?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here...">
                <button><i class="fa-brands fa-telegram"></i></button>
            </form>
        </section>
    </div>
    <script src="javascript/chat.js"></script>
</body>
</html>