<?php
include_once("../includes/model.php");

if(isset($_POST["logout"])) {
    session_destroy();
    location("../login.php");
}