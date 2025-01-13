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

    <h2>User Management</h2>

    <?php
    function displayUserTable($conn, $status)
    {
        $sql = "SELECT * FROM user WHERE user_STATUS = '$status' AND usertype != '1'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $numrow = 1;
            echo '<table>
                    <tr>
                        <th>No</th>
                        <th>User Name</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>$numrow</td>
                        <td>{$row['userEmail']}</td>
                        <td>{$row['usertype']}</td>
                        <td>";
                if ($status == 'Blocked') {
                    echo "<a href=\"user_manage_activate.php?id={$row['userID']}\" onClick=\"return confirm('Activate?');\">Activate</a>";
                } else {
                    echo "<a href=\"user_manage_block.php?id={$row['userID']}\" onClick=\"return confirm('Block?');\">Block</a>";
                }
                echo "</td></tr>";
                $numrow++;
            }
            echo '</table>';
        } else {
            echo '<p>0 results</p>';
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

    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>

</html>

<?php
mysqli_close($conn);
?>
