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

<div style="padding:0 10px;" id="homestaylistDiv">
<br>
<h3 align="center">Add Homestay List</h3>
 <p align="center">Required field with mark*</p>

 <form method="POST" action="managehomestay_add_action.php" enctype="multipart/form-data" id="form2">
 <table border="2">

 <tr>
 <td>Homestay Name*</td>
 <td>:</td>
 <td>
 <textarea rows="4" name="hsname" cols="20" required></textarea>
 </td>
 </tr>

 <tr>
 <td>Homestay Description*</td>
 <td>:</td>
 <td>
 <textarea rows="4" name="hsdesc" cols="20" required></textarea>
 </td>
 </tr>

 <tr>
 <td>Price per Night*</td>
 <td>:</td>
 <td>
 <input type="text" name="hsprice" size="5" required> 
 </td>
 </tr>

 <tr>
 <td>Upload photo*</td>
 <td>:</td>
 <td>
 Max size: 10Mb<br>
 <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png" required>
 </td>
 </tr>

 <tr>
 <td colspan="3" align="right"> 
 <input type="submit" value="Submit" name="B1">
 <input type="reset" value="Reset" name="B2">
 <input type="reset" class="btn" value="Cancel" onClick="cancelAdd()">
 </td>
 </tr>

 </table>
 </form>
 <br><br><br><br><br><br>
</div>
<p></p>

<script>
function cancelAdd(){
    window.location.href = 'managehomestay.php';
}
</script>

</body>
</html>