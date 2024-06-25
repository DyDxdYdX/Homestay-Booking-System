<!-- Author: MOHD. NAZMI BIN NORMAN BI21110356 -->
<?php
session_start();
include("config.php");
?>
<!DOCTYPE html>
<html>

<head>
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

<br>
<h2 align="center">| List of Homestay Added</h2>
<div style="padding:0 30px;">

 <table border="2" width="100%" id="projectable">
 <tr>
 <th width="5%">No</th>
 <th width="30%">Homestay Name</th>
 <th width="30%">Description</th>
 <th width="15%">Price/Night</th>
 <th width="15%">Photo</th>
 <th width="10%">Action</th>
 </tr>
 
 <?php
 $userID = $_SESSION["UID"];
 $sql = "SELECT * FROM homestaylist WHERE userID='$userID'";
 $result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
// output data of each row
 $numrow=1;
 while($row = mysqli_fetch_assoc($result)) {
 echo "<tr>";
 echo "<td>" . $numrow . "</td> <td>" . $row["hsname"] . "</td> <td>" . $row["hsdesc"] . "</td> <td>" . $row["hsprice"] . "</td>";
    // Displaying photo as a link to open in a new tab
    echo '<td>';
    if(!empty($row["imgpath"])) {
        $imagePath = 'uploads/' . $row["imgpath"]; // Assuming the database field contains the image name or relative path
        $filename = basename($row["imgpath"]); // Get the filename from the path

        echo '<a href="' . $imagePath . '" target="_blank">' . $filename . '</a>';
    } else {
        echo 'No photo available';
    }
    echo '</td>';

 echo '<td> <a class="ed1" href="managehomestay_edit.php?id=' . $row["hslistID"] . '">Edit</a>&nbsp;|&nbsp;';
 echo '<a class="del2" href="managehomestay_delete.php?id=' . $row["hslistID"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
 echo "</tr>" . "\n\t\t";
 $numrow++;
 }
 } else {
 echo '<tr><td colspan="7">0 results</td></tr>';
 } 
 
 mysqli_close($conn);
 ?>
 </table>

 <?php
 $userID = $_SESSION["UID"];
 if(isset($_SESSION["UID"])){
 ?>
 <div style="text-align: center; padding-top:10px;">
 <input type="button" value="Add New" onClick="Add_New()">
 </div>

 <?php
}
?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>

<script>
//for responsive sandwich menu
function myFunction() {
 var x = document.getElementById("myTopnav");
 if (x.className === "topnav") {
x.className += " responsive";
 } else {
 x.className = "topnav";
 }
}

function Add_New(){
    window.location.href = 'managehomestay_add.php';
}
</script>

</body>
</html>