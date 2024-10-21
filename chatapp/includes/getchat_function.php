<?php

session_start();

if(isset($_SESSION["unique_id"])){
    include_once("db.php");

    $outgoing_id = mysqli_real_escape_string($con, $_POST["outgoing_id"]);
    $incoming_id = mysqli_real_escape_string($con, $_POST["incoming_id"]);
    $output = "";

    $sql = "SELECT * FROM messages 
            LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
            WHERE (outgoing_msg_id = {$outgoing_id} AND  incoming_msg_id = {$incoming_id})
            OR (outgoing_msg_id = {$incoming_id} AND  incoming_msg_id = {$outgoing_id}) ORDER BY msg_id ASC";

    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            if($row['outgoing_msg_id'] === $outgoing_id) {//if this is equal to then he is a sender 
                $output .= '
                    <div class="chat outgoing">
                        <div class="details">
                            <p>'.$row['msg'].'</p>
                        </div>
                    </div>
                ';

            } else { //receiver
                $output .= '
                    <div class="chat incoming">
                        <img src="./uploads/'.$row['img'].'" alt="Profile pic">
                        <div class="details">
                            <p>'.$row['msg'].'</p>
                        </div>
                    </div>
                ';
            }
        }
        echo $output;
    }
} else {
    header("../login.php");
}