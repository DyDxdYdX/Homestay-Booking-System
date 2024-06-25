<!-- Author: MOHD. NAZMI BIN NORMAN BI21110356 -->
<?php
session_start();
include("config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homestay Booking System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        function EditP() {
            window.location.href = 'profile_edit.php';
        }
    </script>
</head>
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

<?php
 $userID = $_SESSION["UID"]; // Assuming UID holds the logged-in user's ID

    // Query to fetch data from both tables using a JOIN statement
    $sql = "SELECT u.*, p.*
            FROM user AS u INNER JOIN profile AS p ON u.userID = p.userID
            WHERE u.userID = '$userID'"; // Fetching data for the logged-in user

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = $row["username"];
            $phoneNo = $row["phoneNo"];
            $address = $row["address"];
            $img = $row["img_profile"];
            $img = 'uploads/' . $img;
        }
    }
?>

<body>
    <div class="header">
        <h2>| User Info</h2>
    </div>

    <div class="row">
        <div class="col-left">
            <?php
            if(isset($_SESSION["UID"])){
                if ($row["img_profile"]!="-") {
                    ?>
                    <img class="avatar" src=<?php echo $img;?> alt="Profile Photo">
                    <?php
                } else {
                    ?>
                    <img class="avatar" src="img/avatar.png" alt="Avatar">
                    <?php
                }
            }
            ?>
        </div>

        <div class="col-right">
            <p><b>USER INFORMATION:</b></p>
            <table width="100%" style="border-collapse: collapse;" id="projectable">
                <tr>
                    <td width="164">Name</td>
                    <td><?= $username ?></td>
                </tr>
                <tr>
                    <td width="164">Phone Number</td>
                    <td><?= $phoneNo ?></td>
                </tr>
                <tr>
                    <td width="164">Address</td>
                    <td><?= $address ?></td>
                </tr>
            </table>
            <br>
            <div style="text-align: center; padding-bottom:5px;">
                <input type="button" value="EDIT" onClick="EditP()">
            </div>
        </div>
    </div>
    <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>
</html>
