<?php

session_start();

include_once ("db.php");

$fname = mysqli_real_escape_string($con, $_POST["firstname"]);
$lname = mysqli_real_escape_string($con, $_POST["lastname"]);
$email = mysqli_real_escape_string($con, $_POST["email"]);
$password = mysqli_real_escape_string($con, $_POST["password"]);

if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $sql1 = "SELECT email FROM users WHERE email = '{$email}'";
        $result = mysqli_query($con, $sql1);

        if(mysqli_num_rows($result) > 0) {
            echo "$email - This email already exists!";
        } else {

            if(isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];//get user upload
                $img_type = $_FILES['image']['type'];//get upload img type
                $tmp_name = $_FILES['image']['tmp_name'];//pang temp lang

                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                $extenstions = ['png', 'jpeg', 'jpg'];
                if(in_array($img_ext, $extenstions) === true) {//check lang if may same type
                    $time = time();//return current time
                    $new_img_name = $time.$img_name;

                    if(move_uploaded_file($tmp_name, "../uploads/".$new_img_name)) {
                        $status = "Active now";
                        $random_id = rand(time(), 10000000);

                        $sql2 = mysqli_query($con, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ('$random_id', '$fname', '$lname', '$email', '$password', '$new_img_name', '$status')");
    
                        if($sql2) { 

                            $sql3 = "SELECT * FROM users WHERE email = '{$email}'";
                            $result3 = mysqli_query($con, $sql3);
                            
                            if(mysqli_num_rows($result3) > 0) {

                                $row = mysqli_fetch_assoc($result3);
                                $_SESSION['unique_id'] = $row['unique_id']; 

                                echo "success";//eto ung pang check don sa jquery
                            }


                        } else echo "Something went wrong in inserting";
                    }

                } else {
                    echo "Please select an image file - jpeg jpg png";
                }
            } else {
                echo "Please select an Image file";
            }
        }
    } else {
        echo"$email this is not email";
    }

} else {
    echo "All input field are required";
}
