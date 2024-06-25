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
    <h2>Payment</h2>
    <div class="row">
        <table border="2" width="100%" id="projectable" style = "margin-right:20px;">
            <tr>
                <th>No</th>
                <th>Homestay Booked</th>
                <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM booking 
                    LEFT JOIN homestaylist ON booking.hslistID = homestaylist.hslistID
                    WHERE booking.userID = " . $_SESSION["UID"];
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $numrow=1;
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $numrow . "</td> <td>" . $row["hsname"] . "</td> <td>" . $row["payment_status"] . "</td><td> " . $row["payment_method"] ."</td><td> ". $row["amount_paid"] . " </td>";
                    echo '<td> <a href="payment_make.php?id=' . $row["bookingID"] . '" onClick="return confirm(\'Pay Now?\');">Pay Now</a>';
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
</html>