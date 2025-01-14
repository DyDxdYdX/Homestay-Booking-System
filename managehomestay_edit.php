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

<body onLoad="show_AddEntry()">
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
    $id ="";
    $hsname = "";
    $hsdesc = "";
    $hsprice =" ";
    $img = "";

    if(isset($_GET["id"]) && $_GET["id"] != ""){
        $sql = "SELECT * FROM homestaylist WHERE hslistID = " . $_GET['id'] . " AND userID = " . $_SESSION["UID"];

        //echo $sql . "<br>";
        $result = mysqli_query($conn, $sql);
            
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id = $row["hslistID"];
            $hsname = $row["hsname"];
            $hsdesc = $row["hsdesc"];
            $hsprice = $row["hsprice"];
            $img = $row["imgpath"];
        }        
    }

    mysqli_close($conn);
?>

<div style="padding:0 10px;" id="homestaylistDiv">
    <br>
    <h3 align="center">Edit Exisitng Homestay List</h3>
    <p align="center">Required field with mark*</p>

    <form method="POST" action="managehomestay_edit_action.php" id="form2" enctype="multipart/form-data" style="margin: 20px;">
        <!--hidden value: id to be submitted to action page-->
        <input type="hidden" id="hslistID" name="hslistID" value="<?=$_GET['id']?>">
        <table border="2" id="myTable">

<tr>
 <td>Homestay Name*</td>
 <td>:</td>
 <td>
 <textarea rows="4" name="hsname" cols="20" required><?php echo $hsname;?></textarea>
 </td>
 </tr>

 <tr>
 <td>Homestay Description*</td>
 <td>:</td>
 <td>
 <textarea rows="4" name="hsdesc" cols="20" required><?php echo $hsdesc;?></textarea>
 </td>
 </tr>

 <tr>
 <td>Homestay Price per Night*</td>
 <td>:</td>
 <td>
 <textarea rows="4" name="hsprice" cols="20" required><?php echo $hsprice;?></textarea>
 </td>
 </tr>

<tr>
 <td>Photo</td>
 <td>:</td>
<td>
<input type="text" disabled value="<?php echo $img;?>">
</td>
 </tr>

<tr>
<td>Upload photo</td>
<td>:</td>
<td>
 Max size: 10Mb<br>
 <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png">
</td>
</tr>

            <tr>
                <td colspan="3" align="right">
                <input type="submit" value="Submit" name="B1">                
                <input type="reset" value="Reset" name="B2" onClick="resetForm()">
                <input type="button" value="Cancel" onclick="window.location.href='managehomestay.php'">
            </tr>
        </table>
    </form>
</div>
<br><br><br><br><br>
<p></p>

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

//reset form after modification to a php echo to fields
function resetForm() {
 document.getElementById("myForm").reset();
}

function show_AddEntry() {  
    var x = document.getElementById("homestaylistDiv");
    x.style.display = 'block';
    var firstField = document.getElementById('sem');
    firstField.focus();
}
</script>

</body>
</html>
