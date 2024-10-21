<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link rel="stylesheet" href="assets/style1.css">
</head>
<body>
    <?php 
        include_once("header.php");
        nav("chat");
    ?>
    <div class="chat-container">
        <div class="sidebar">
            <input type="text" class="search-bar" placeholder="Search...">
            <ul class="conversation-list">
                <a href="index.html">
                    <li class="conversation-item">
                        <img src="assets/image.png" alt="TANOD">
                        <span>TANOD</span>
                    </li>
                </a>
                
                <a href="#">
                    <li class="conversation-item" style="background-color: #f0f2f5;">
                        <img src="assets/image.png" alt="MOTHERLEADER">
                        <span>MOTHERLEADER</span>
                    </li>
                </a>
                
                <a href="#">
                    <li class="conversation-item">
                        <img src="assets/image.png" alt="HEALTH WORKERS">
                        <span>HEALTH WORKERS</span>
                    </li>
                </a>
                
                <a href="#">
                    <li class="conversation-item">
                        <img src="assets/image.png" alt="KAGAWAD">
                        <span>KAGAWAD</span>
                    </li>
                </a>
                
                <a href="#">
                    <li class="conversation-item">
                        <img src="assets/image.png" alt="BRGY CAPTAIN">
                        <span>BRGY CAPTAIN</span>
                    </li>
                </a>
                <a href="#">
                    <li class="conversation-item">
                        <img src="assets/image.png" alt="SECRETARY">
                        <span>SECRETARY</span>
                    </li>
                </a>
            </ul>
        </div>
        <div class="chat-area">
            <div class="chat-header">
                <img src="https://via.placeholder.com/40" alt="Luis Pittman">
                <h2>Luis Pittman</h2>
            </div>
            <div class="chat-messages">
                <div class="message sent">
                    <div class="message-content">
                        Hi, I wonder when if there is going to be anything new for spring?
                    </div>
                    <div class="message-time">12:24 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        Hi Luis, can you please be more specific?
                    </div>
                    <div class="message-time">12:31 AM</div>
                </div>
                <div class="message sent">
                    <div class="message-content">
                        Sure, I want to know when the new spring collection for men is coming
                    </div>
                    <div class="message-time">12:35 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        Thank you for taking interest in our upcoming products. You can have a look at the upcoming collection in our blog post.
                    </div>
                    <div class="message-time">12:45 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        Thank you for taking interest in our upcoming products. You can have a look at the upcoming collection in our blog post.
                    </div>
                    <div class="message-time">12:45 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        Thank you for taking interest in our upcoming products. You can have a look at the upcoming collection in our blog post.
                    </div>
                    <div class="message-time">12:45 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        Thank you for taking interest in our upcoming products. You can have a look at the upcoming collection in our blog post.
                    </div>
                    <div class="message-time">12:45 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        Thank you for taking interest in our upcoming products. You can have a look at the upcoming collection in our blog post.
                    </div>
                    <div class="message-time">12:45 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        Thank you for taking interest in our upcoming products. You can have a look at the upcoming collection in our blog post.
                    </div>
                    <div class="message-time">12:45 AM</div>
                </div>
                <div class="message received">
                    <div class="message-content">
                        Thank you for taking interest in our upcoming products. You can have a look at the upcoming collection in our blog post.
                    </div>
                    <div class="message-time">12:45 AM</div>
                </div>
                <div class="message received">
                    <div class="message-images">
                        <img src="https://via.placeholder.com/100" alt="Product 1">
                        <img src="https://via.placeholder.com/100" alt="Product 2">
                    </div>
                    <div class="message-time">12:59 AM</div>
                </div>
                <div class="message received">
                    <div class="message-images">
                        <img src="https://via.placeholder.com/100" alt="Product 1">
                        <img src="https://via.placeholder.com/100" alt="Product 2">
                    </div>
                    <div class="message-time">12:59 AM</div>
                </div>
                <div class="message received">
                    <div class="message-images">
                        <img src="https://via.placeholder.com/100" alt="Product 1">
                        <img src="https://via.placeholder.com/100" alt="Product 2">
                    </div>
                    <div class="message-time">12:59 AM</div>
                </div>
            </div>
            <div class="chat-input">
                <input type="text" placeholder="Your message...">
                <button>Send</button>
            </div>
        </div>
    </div>
    <script src="navbar.js"></script>
</body>
</html>