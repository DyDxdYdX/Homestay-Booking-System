<?php
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html>
<head>
<script>
    function cancelAdd(){
        window.location.href = 'checkin_checkout.php';
    }
    </script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <h2>| Add Check in/out date</h2>
    <form action="checkin_checkout_add_action.php" method="POST" id="form2" style="margin-left: 20px; margin-right: 20px;">
        <!--hidden value: id to be submitted to action page-->
        <input type="hidden" name="bookingID" value="<?=$_GET['id']?>">
        <table border='3'>
            <tr>
                <td>Check In Date</td>
                <td>
                    <input type="date" name="checkIN">
                </td>
            </tr>
            <tr>
                <td>Check Out Date</td>
                <td>
                    <input type="date" name="checkOUT">
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right">
                    <input type="submit" value="Submit" name="B1">
                    <input type="reset" value="Reset" name="B2">
                    <input type="reset" class="btn" value="Cancel" onClick="cancelAdd()">
                </td>
            </tr>
        </table>
    </form>
    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>
</html>