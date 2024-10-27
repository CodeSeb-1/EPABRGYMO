<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');
function nav($active)
{
    echo '
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="assets/LOGO.png" alt="Logo">
                </div>
                <ul class="menu">
                    <li><a href="index.php" class="' . ($active == "home" ? "active" : "") . '">Home</a></li>
                    <li><a href="request.php" class="' . ($active == "request" ? "active" : "") . '">Request</a></li>
                    <li><a href="chat.php" class="' . ($active == "chat" ? "active" : "") . '">Chat</a></li>
                    <li><a href="report.php" class="' . ($active == "reports" ? "active" : "") . '">Reports</a></li>
                </ul>
                <div class="user-info">
                    <img src="assets/image.png" alt="">
                    <a href="profile.php" class="'.($active == "profile" ? "active" : "").'"><span>' . $_SESSION["user_fullname"] . '</span></a>
                </div>
            </nav>
        </div>
    </header>
    ';
}

