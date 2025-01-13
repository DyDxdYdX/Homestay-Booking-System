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
        if (isset($_SESSION["UID"])) {
            require 'menu_functions.php';
            getMenu($_SESSION["usertype"]);
        } else {
            include 'menu.php';
        }
    ?>

<?php
    $id = "";
    $news = "";
    $remark = "";

    if(isset($_GET["id"]) && $_GET["id"] != ""){
        $sql = "SELECT * FROM news WHERE newsID = " . $_GET['id'] . " AND userID = " . $_SESSION["UID"];

        //echo $sql . "<br>";
        $result = mysqli_query($conn, $sql);
            
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id = $row["newsID"];
            $news = $row["news"];
            $remark = $row["remark"];
        }        
    }

    mysqli_close($conn);
?>

<div style="padding:0 10px;" id="challengeDiv">
    <h3 align="center">Edit news</h3>
    <p align="center">Required field with mark*</p>

    <form method="POST" action="news_edit_action.php" enctype="multipart/form-data" id="form" style="display: block;">
    <input type="hidden" id="cid" name="cid" value="<?=$_GET['id']?>">
        <table border="3" id="myTable">
            <tr>
                <td>News*</td>
                <td>:</td>
                <td>
                    <textarea rows="4" name="news" cols="20" required><?php echo $news;?></textarea>
                </td>
            </tr>
            <tr>
                <td>Remark</td>
                <td>:</td>
                <td>
                    <textarea rows="4" name="remark" cols="20"><?php echo $remark;?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right"> 
                <input type="submit" value="Submit" name="B1">                
                <input type="reset" value="Reset" name="B2">
                </td>
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
