<?php
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    if (isset($_SESSION["UID"])) {
        if ($_SESSION["usertype"] == "1") {
            include 'logged_menu_admin.php';
        } else if ($_SESSION["usertype"] == "2") {
            include 'logged_menu_homeowner.php';
        } else {
            include 'logged_menu_customer.php';
        }
    } else {
        include 'menu.php';
    }
    ?>

    <h2>| View Homestay</h2>

    <h3 style="margin-left: 35px">List of Available Homestay</h3>
    <div style="margin: 20px">
    <table id="projectable">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Home Owner</th>
            <th>Price/night</th>
        </tr>
        <?php
        $sql = "SELECT * FROM homestaylist LEFT JOIN profile ON homestaylist.userID = profile.userID";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $numrow=1;
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $numrow . "</td><td>". $row["hsname"] ."</td><td>". $row["hsdesc"]. "</td><td>". $row["username"]. "</td><td>RM" . $row["hsprice"] ."</td>";
                //echo '<td><a href="add_order.php?id=' . $row["hslistID"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                
                echo "</tr>" . "\n\t\t";
                echo "<tr>";
                ?>
                <td colspan = '5' style = "text-align:center;"><img class="image" src="uploads/<?=$row["imgpath"]?>"></td>
                <?php
                echo "</tr>". "\n\t\t";
                $numrow++;
            }
        } else {
        echo '<tr><td colspan="4">0 results</td></tr>';
        } 
        ?>
    </table>
    </div>
    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>

</html>

<?php
mysqli_close($conn);
?>