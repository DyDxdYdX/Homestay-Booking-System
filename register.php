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
        <h2>| User Registration </h2>
        <div class="row">
            <form action="register_action.php" method="post" id="registerDiv">
                <label for="usertype">User type</label><br>
                <select id="usertype" name="usertype" required>                        
                    <option value="1">Admin</option>;
                    <option value="2">Home Owner</option>;
                    <option value="3">User</option>;
                </select><br><br>

                <label for="userEmail">User Email:</label><br>
                <input type="email" id="userEmail" name="userEmail" required><br><br>

                <label for="userPwd">Password:</label><br>
                <input type="password" id="userPwd" name="userPwd" required><br><br>

                <label for="userPwd">Confirm Password:</label><br>
                <input type="password" id="confirmPwd" name="confirmPwd" required><br><br>

                <button type="submit" value="Register" style="cursor: pointer;">Submit</button>
                <button type="reset" value="Reset" style="cursor: pointer;">Reset</button>
                <button type="reset" value="Cancel" onClick="location.href = 'login.php'" style="cursor: pointer;">Cancel</button>
            </form>
            </div>
        </div>

        <footer>
            <p>Copyright (c) 2023 - Cassily Corp.</p>
        </footer>
    </body>
</html>
