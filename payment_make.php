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
    $id = "";
    $hsname = "";
    $payment_method = "";
    $amount_paid = "";

    if(isset($_GET["id"]) && $_GET["id"] != ""){
        $sql = "SELECT * FROM booking 
                LEFT JOIN homestaylist ON booking.hslistID = homestaylist.hslistID
                WHERE booking.userID = " . $_SESSION["UID"];

        //echo $sql . "<br>";
        $result = mysqli_query($conn, $sql);
            
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id = $row["bookingID"];
            $hsname = $row["hsname"];
            $payment_method = $row["payment_method"];
            $amount_paid = $row["amount_paid"];
        }        
    }

    mysqli_close($conn);
?>

<div style="padding:0 10px;" id="challengeDiv">
    <h3 align="center">Make Payment</h3>
    <p align="center">Required field with mark*</p>

    <form method="POST" action="payment_make_action.php" enctype="multipart/form-data" id="form" style="display: block;">
    <input type="hidden" id="cid" name="cid" value="<?=$_GET['id']?>">
        <table border="3" id="myTable">
            <tr>
                <td>Home Stay Booked*</td>
                <td>:</td>
                <td>
                    <p><?php echo $hsname;?></p>
                </td>
            </tr>
            <tr>
                <td>Payment Method</td>
                <td>:</td>
                <td>
                    <select name = "payment_method" required>
                        <option>Select Method</option>
                        <option value="CASH">CASH</option>
                        <option value="ONLINE BANKING">ONLINE BANKING</option>
                        <option value="E_WALLET">E_WALLET</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Payment Amount</td>
                <td>:</td>
                <td>
                    <textarea name = "amount_paid" required></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right"> 
                <input type="submit" value="Submit" name="B1">                
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