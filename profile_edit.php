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
 <h2>| User Edit Information</h2>
 <div class="row">
    <div class="col-left">
    <img class="image" src="<?php echo $img; ?>" alt="Profile Photo">
    </div>

    <div class="col-right"> 
        <form id="form2" style="display: block;" action="profile_edit_action.php" method="post" enctype="multipart/form-data">
            <table border="3" style="border-collapse: collapse;">
            
            <tr>
                <td width="164">Name</td>
                <td><input type="text" name="username" size="20" value="<?=$username?>"></td>
            </tr>
            <tr>
                <td width="164">Phone Number</td>
                <td><input type="text" name="phoneNo" size="20" value="<?=$phoneNo?>"></td>
            </tr>
            <tr>
                <td width="164">Address</td>
                <td><input type="text" name="address" size="20" value="<?=$address?>"></td>
            </tr>
            <tr>
                <td>Upload photo:</td>
                <td>
                Max size: 10 Mb<br>
                <input type="file" name="fileToUpload" id="fileToUpload" value="<?=$img?>" accept=".jpg, .jpeg, .png">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;">
                    <input type="submit" value="Update"> 
                    <input type="reset" value="Reset">
                    <input type="button" value="Cancel" onclick="window.location.href='profile.php'">
                </td>
            </tr>

            </table>
        </form>
    </div>
 </div>
 <footer>
        <p>Copyright (c) 2023 - Cassily Corp.</p>
    </footer>
</body>
</html>