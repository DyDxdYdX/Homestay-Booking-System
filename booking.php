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
            ?>
            <h2>| View booking</h2>
            <div class="row">
                <table width="100%" id="projectable" style = "margin-right:20px;">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Homestay Name</th>
                        <th width="20%">Customer Name</th>
                        <th width="15%">Book Date</th>
                        <th width="15%">Check In/Out Date</th>
                        <th width="15%">Payment Status</th>
                        <th width="10%">Action</th>
                    </tr>
                    <?php
                    $sql = "SELECT booking.*, homestaylist.hsname, profile.username
                            FROM booking
                            INNER JOIN homestaylist ON homestaylist.hslistID = booking.hslistID
                            INNER JOIN profile ON profile.userID = booking.userID
                            WHERE homestaylist.userID = ". $_SESSION["UID"];
                    $result = mysqli_query($conn, $sql);
                
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        $numrow=1;
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $numrow . "</td> <td>" . $row["hsname"] . "</td> <td>" . $row["username"] . 
                                "</td> <td>" . $row["book_date"] . "</td><td> " . $row["checkIN"] ." | ". $row["checkOUT"] . " </td><td>".$row["payment_status"]."</td>";
                            echo '<td> <a href="booking_delete.php?id=' . $row["bookingID"] . '" onClick="return confirm(\'Cancel Booking?\');">Cancel Booking</a>';
                            $numrow++;
                        }
                    }else{
                        echo '<tr><td colspan="7">0 results</td></tr>';
                    }
                    ?>
                </table>
            </div>
            <?php
        }else{
            include 'logged_menu_customer.php';
            ?>
                <h2>| Manage booking</h2>
                <div class="row">
                <table border="2" id="projectable" style = "margin-right:20px;">
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Homestay Name</th>
                        <th width="30%">Home Owner</th>
                        <th width="15%">Book Date</th>
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
                                "</td> <td>" . $row["book_date"] . "</td> ";
                            echo '<td>';
                            echo '<a href="booking_delete.php?id=' . $row["bookingID"] . '"  onClick="return confirm(\'Delete?\');"> Cancel Booking </a> </td>';
                            $numrow++;
                        }
                    }else{
                        echo '<tr><td colspan="6">0 results</td></tr>';
                    }
                    ?>
                </table>
                </div>
                <div style="text-align: center; padding-top:10px;">
                <input type="button" value="Add New" onClick="Add_New()" style="margin-bottom: 20px;">
                </div>
            <?php
        }
    }else{
            include 'menu.php';
        }
    ?>
    
    <div style="display: none;" id="form">
        <form action="booking_add_action.php" method="POST">
                <table>
                    <tr>
                        <td>Homestay Name</td>
                        <td>
                            <select name="hslistID">
                                <?php
                                if(isset($_SESSION['UID'])){
                                    $sql = "SELECT * FROM homestaylist";
                                    $result = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($result) > 0){
                                        $numrow=1;
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<option value=".$row['hslistID'].">".$row['hsname']."</option>";
                                        }
                                    }else{
                                        echo "<option>No Available Homestay</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">
                            <input type="submit" value="Submit" name="B1">
                            <input type="reset" value="Reset" name="B2">
                            <input type="reset" class="btn" value="Cancel" onClick="cancelAdd()"></td>
                    </tr>
                </table>
            </form>
    </div>
    
    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>

<script>
    function Add_New(){
        var x = document.getElementById("form");
        x.style.display = 'block';
    }
    function cancelAdd(){
        var x = document.getElementById("form");
        x.style.display = 'none';
    }
</script>
</body>
</html>