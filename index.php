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

    <h2>| Welcome to Homestay Booking System</h2>
    

    <div class = "row" style="display:block;">
        <div>
            <b>Announcement</b></p>
            <p>No new announcement</p>
        </div>
        <div>
            <p><b>News</b></p>

            <?php
            // Include the connection to the database (config.php)
            include("config.php");

            // Fetch and display news from the database
            $sql = "SELECT * FROM news ORDER BY newsID DESC LIMIT 5"; // You can adjust the query as needed
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>" . $row['news'] . "</p>";
                }
            } else {
                echo "<p>No news available</p>";
            }

            mysqli_close($conn);
            ?>
        </div>  
    </div>



    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>
</html>