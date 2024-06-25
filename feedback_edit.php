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
<body onLoad="show_Add()">
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
    $hsname = '';
    $dateIN = '';
    $dateOUT = '';
    $rating = '';
    $fdback = '';

    if(isset($_GET["id"]) && $_GET["id"] != ""){
        $sql = "SELECT * FROM feedbacks WHERE fdbackID = " . $_GET['id'] . " AND userID = " . $_SESSION["UID"];

        //echo $sql . "<br>";
        $result = mysqli_query($conn, $sql);
            
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id = $row["fdbackID"];
            $hsname = $row["hsname"];
            $dateIN = $row["dateIN"];
            $dateOUT = $row["dateOUT"];
            $rating = $row["rating"];
            $fdback = $row["fdback"];
        }        
    }

    mysqli_close($conn);
    ?>
    <h2>| Review Form</h2>
    <div>    
        <form method="post" action="feedback_edit_action.php" id="form2"  style="margin: 20px;">
            <table>
                <input type="hidden" id="fid" name="fid" value="<?=$_GET['id']?>">
                <tr>
                    <td id="label">Homestay Name:</td>
                    <td id="tableform">
                        <textarea rows="2" id="hsname" name="hsname"><?php echo $hsname;?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td id="label">Stay Date:</td>
                    <td id="tableform">
                    <input type="date" id="dateIN" name="dateIN" value=<?php echo $dateIN; ?>>
                    </td>
                </tr>
                <tr>
                    <td id="label">Leave Date:</td>
                    <td id="tableform">
                        <input type="date" id="dateOUT" name="dateOUT" value=<?php echo $dateOUT; ?>>
                    </td>
                </tr>
                <tr>
                    <td id="label">Rating:</td>
                    <td id="tableform">
                        <input type="radio" id="rating" name="rating" <?php if($rating==1) {echo "checked";}?> value="1">
                        <input type="radio" id="rating" name="rating" <?php if($rating==2) {echo "checked";}?> value="2">
                        <input type="radio" id="rating" name="rating" <?php if($rating==3) {echo "checked";}?> value="3">
                        <input type="radio" id="rating" name="rating" <?php if($rating==4) {echo "checked";}?> value="4">
                        <input type="radio" id="rating" name="rating" <?php if($rating==5) {echo "checked";}?> value="5">
                    </td>
                </tr>
                <tr>
                    <td id="label">Feedback:</td>
                    <td id="tableform">
                        <textarea rows="2" id="fdback" name="fdback"><?php echo $fdback;?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" value="Submit" name="B1"></th>
                </tr>
            </table>
        </form>
    </div>
<p></p>

<footer>
    <p>Copyright (c) 2023 - Caasili.Corp</p>
</footer>

<script>

function resetForm() {
    document.getElementById("myForm").reset();
}

function clearForm() {
    var form = document.getElementById("myForm");
    if (form) {
        var inputs = form.getElementsByTagName("input");
        var textareas = form.getElementsByTagName("textarea");

        //clear select
        form.getElementsByTagName("select")[0].selectedIndex=0;        
        
        //clear all inputs
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type !== "button" && inputs[i].type !== "submit" && inputs[i].type !== "reset") {
                 inputs[i].value = "";
            }
        }

        //clear all textareas
        for (var i = 0; i < textareas.length; i++) {
            textareas[i].value = "";
        }
    } else {
        console.error("Form not found");
    }
}

function show_Add() {
    var x = document.getElementById("activityDiv");
    x.style.display = 'Block';
}
</script>

</body>

</html>