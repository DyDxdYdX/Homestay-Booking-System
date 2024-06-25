<?php
include('config.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
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

    <h2>| Check in/out from Homestay</h2>
    <div class="row">
        <table border="2" width="100%" id="projectable" style="margin-right: 20px;">
            <tr>
                <th width="5%">No</th>
                <th width="30%">Homestay Name</th>
                <th width="30%">Home Owner</th>
                <th width="25%">Check In/Out Date</th>
                <th width="10%">Action</th>
            </tr>
            <?php
            $userID = $_SESSION["UID"];
            $sql = "SELECT booking.*, homestaylist.hsname, profile.username
                    FROM booking
                    INNER JOIN homestaylist ON homestaylist.hslistID = booking.hslistID
                    INNER JOIN profile ON profile.userID = homestaylist.userID
                    WHERE booking.userID = ". $_SESSION["UID"];
            $result = mysqli_query($conn, $sql);
                    
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $numrow=1;
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $numrow . "</td> <td>" . $row["hsname"] . "</td> <td>" . $row["username"] . 
                        "</td> <td> " . $row["checkIN"] ." | ". $row["checkOUT"] . " </td> ";
                    echo '<td>';
                    echo '<a href="checkin_checkout_add.php?id=' . $row["bookingID"] . '" > Update date </a> </td>';
                    $numrow++;
                }
            }else{
                echo '<tr><td colspan="6">0 results</td></tr>';
            }
            ?>
        </table>
    </div>
    
    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>