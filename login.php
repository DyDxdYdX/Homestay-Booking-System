<?php
session_start();
include("config.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,  initial-scale=1.0">
        <script src="script/script.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <title>Homestay Booking System</title>
    </head>
    <body>
    <div class="bg-image"></div>

    <div class="bg-text">
        <h1>Homestay Booking System</h1>
    </div>

        <?php
        if(isset($_SESSION["UID"])){
            if($_SESSION["usertype"] == "1"){
                include 'logged_menu_admin.php';
            }else if($_SESSION["usertype"] == "2"){
                include 'logged_menu_homeowner.php';
            }else{
                include 'logged_menu_customer.php';
            }
        }
        else{
            include 'menu.php';
        }
        ?>
        <h2>| Login </h2>
        <div class = "row">
            <form action="login_action.php" method="post">
                <div>

                </div>
                <div class="container">
                    <label for="uname"><b>User Email</b></label><br>
                    <input type="text" placeholder="User Email" name="userEmail" required><br>

                    <label for="psw"><b>Password</b></label><br>
                    <input type="password" placeholder="Enter Password" name="userPwd" required><br>

                    <button type="submit">Login</button>
                </div>
                <br>
                <div class="container" style=" background-color:#f1f1f1; padding-top: 20px; padding-bottom: 20px; text-align:center;">
                    <span class="psw">
                        <a href="register.php" style="cursor: pointer;">New user? Register new account.</a>
                    </span>
                </div>
            </form>
        </div>

        <footer>
            <p>Copyright (c) 2023 - Cassily Corp.</p>
        </footer>
    </body>
</html>
