<?php require_once("header.php"); ?>
<body>
    <div class="wrapper">
        <section class="form login">
            <header>Chat App</header>
            <form action="#">
                <div class="error-txt"></div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email">
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password">
                    <i class="fa-regular fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" value="Login">
                </div>
            </form>
            <div class="link">Don't have account? <a href="signup.php">Register now</a></div>
        </section>
    </div>
    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/login.js"></script>
</body>
</html>