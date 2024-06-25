<?php
session_start();
include("config.php");

function getNumberUser($usertype){
    global $conn;
    $query = "SELECT COUNT(*) as count FROM user WHERE usertype = $usertype ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function getTotalHomeListed(){
    global $conn;
    $query = "SELECT COUNT(*) as count FROM homestaylist";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function getTotalBooking(){
    global $conn;
    $query = "SELECT COUNT(*) as count FROM booking";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

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
    <h2>| Report</h2>
    <div class="row">
        <table id="projectable" style="margin-right: 20px;">
            <tr>
                <td width = 150px>Total number of user</td>
                <td>
                    <?php
                    $admin = getNumberUser('1');
                    $homeonwer = getNumberUser('2');
                    $customer = getNumberUser('3');
                    $total = $admin + $homeonwer + $customer;
                    ?>
                    Admin - <?php echo $admin?>
                    <br>
                    Home Owner - <?php echo $homeonwer?>
                    <br>
                    Customer - <?php echo $customer?>
                    <br>
                    Total - <?php echo $total?>
                </td>
            </tr>
            <tr>
                <td>Total number of home listed</td>
                <td>
                    <?php
                    $home = getTotalHomeListed();
                    echo $home;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Total number of booking</td>
                <td>
                    <?php
                    $booking = getTotalBooking();
                    echo $booking;
                    ?>
                </td>
            </tr>
        </table>
    </div>
    
    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>
</html>