<?php
include('config.php');
session_start();

function getHomeownerBookings($conn, $userID) {
    $sql = "SELECT booking.*, homestaylist.hsname, profile.username
            FROM booking
            INNER JOIN homestaylist ON homestaylist.hslistID = booking.hslistID
            INNER JOIN profile ON profile.userID = booking.userID
            WHERE homestaylist.userID = ?";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getCustomerBookings($conn, $userID) {
    $sql = "SELECT booking.*, homestaylist.hsname, profile.username
            FROM booking
            INNER JOIN homestaylist ON homestaylist.hslistID = booking.hslistID
            INNER JOIN profile ON profile.userID = homestaylist.userID
            WHERE booking.userID = ?";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getAvailableHomestays($conn) {
    $sql = "SELECT * FROM homestaylist";
    return mysqli_query($conn, $sql);
}

function renderHomeownerBookingTable($result) {
    ?>
    <table width="100%" id="projectable" style="margin-right:20px;">
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
        if (mysqli_num_rows($result) > 0) {
            $numrow = 1;
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $numrow; ?></td>
                    <td><?php echo htmlspecialchars($row["hsname"]); ?></td>
                    <td><?php echo htmlspecialchars($row["username"]); ?></td>
                    <td><?php echo htmlspecialchars($row["book_date"]); ?></td>
                    <td><?php echo htmlspecialchars($row["checkIN"]) . " | " . htmlspecialchars($row["checkOUT"]); ?></td>
                    <td><?php echo htmlspecialchars($row["payment_status"]); ?></td>
                    <td>
                        <a href="booking_delete.php?id=<?php echo $row["bookingID"]; ?>"
                           onClick="return confirm('Cancel Booking?');">Cancel Booking</a>
                    </td>
                </tr>
                <?php
                $numrow++;
            }
        } else {
            echo '<tr><td colspan="7">0 results</td></tr>';
        }
        ?>
    </table>
    <?php
}

function renderCustomerBookingTable($result) {
    ?>
    <table border="2" id="projectable" style="margin-right:20px;">
        <tr>
            <th width="5%">No</th>
            <th width="30%">Homestay Name</th>
            <th width="30%">Home Owner</th>
            <th width="15%">Book Date</th>
            <th width="10%">Action</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $numrow = 1;
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $numrow; ?></td>
                    <td><?php echo htmlspecialchars($row["hsname"]); ?></td>
                    <td><?php echo htmlspecialchars($row["username"]); ?></td>
                    <td><?php echo htmlspecialchars($row["book_date"]); ?></td>
                    <td>
                        <a href="booking_delete.php?id=<?php echo $row["bookingID"]; ?>"
                           onClick="return confirm('Delete?');">Cancel Booking</a>
                    </td>
                </tr>
                <?php
                $numrow++;
            }
        } else {
            echo '<tr><td colspan="5">0 results</td></tr>';
        }
        ?>
    </table>
    <?php
}
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
    if(isset($_SESSION["UID"])) {
        if($_SESSION["usertype"] == "1") {
            include 'logged_menu_admin.php';
        } else if($_SESSION["usertype"] == "2") {
            include 'logged_menu_homeowner.php';
            ?>
            <h2>| View booking</h2>
            <div class="row">
                <?php
                $result = getHomeownerBookings($conn, $_SESSION["UID"]);
                renderHomeownerBookingTable($result);
                ?>
            </div>
            <?php
        } else {
            include 'logged_menu_customer.php';
            ?>
            <h2>| Manage booking</h2>
            <div class="row">
                <?php
                $result = getCustomerBookings($conn, $_SESSION["UID"]);
                renderCustomerBookingTable($result);
                ?>
            </div>
            <div style="text-align: center; padding-top:10px;">
                <input type="button" value="Add New" onClick="Add_New()" style="margin-bottom: 20px;">
            </div>
            <?php
        }
    } else {
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