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

    <h2>| User Management</h2>
    <div class="row">
    <?php

    function displayUserTable($conn, $status)
    {
        $sql = "SELECT * FROM user WHERE user_STATUS = '$status' AND usertype != '1'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $numrow = 1;
            echo '<table id="projectable" style="margin-right: 20px;">
                    <tr>
                        <th width="5%">No</th>
                        <th width="60%">User Name</th>
                        <th width="20%">User Type</th>
                        <th width="15%">Action</th>
                    </tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                $userRole = ($row['usertype'] == '2') ? "Home Owner" : "Customer";
                echo "<tr>
                        <td>$numrow</td>
                        <td>{$row['userEmail']}</td>
                        <td>{$userRole}</td>
                        <td>";
                if ($status == 'Blocked') {
                    echo "<a href=\"user_manage_action.php?id={$row['userID']}&action=activate\" onClick=\"return confirm('Activate?');\">Activate</a>";
                } else {
                    echo "<a href=\"user_manage_action.php?id={$row['userID']}&action=block\" onClick=\"return confirm('Block?');\">Block</a>";
                }
                echo "</td></tr>";
                $numrow++;
            }
            echo '</table>';
        } else {
            echo '<p style="width:100%;">0 results</p>';
        }
    }

    ?>

    <h3>List of Active Users</h3>
    <?php
    displayUserTable($conn, 'Active');
    ?>

    <h3>List of Blocked Users</h3>
    <?php
    displayUserTable($conn, 'Blocked');
    ?>
    </div>
    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>

</html>

<?php
mysqli_close($conn);
?>

