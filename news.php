<?php
session_start();
include("config.php");
?>
<!DOCTYPE html>
<html>

<head>
<title>My Study KPI</title>
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

<h2>List of News</h2>

<div style="padding:0 10px;">
    <div style="text-align: right; padding:10px;">
        <form action="news_action.php" method="post">
            <input type="text" placeholder="Search.." name="search">
            <input type="submit" value="Search">
        </form> 
    </div>
    <table border="3" width="100%" id="projectable">
        <tr>
            <th width="5%">No</th>
            <th width="30%">News</th>
            <th width="15%">Remark</th>
            <th width="10%">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM news WHERE userID=". $_SESSION["UID"];
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $numrow=1;
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $numrow . "</td><td>". $row["news"] .
                         "</td><td>" . $row["remark"] . "</td>";
                    echo '<td> <a href="news_edit.php?id=' . $row["newsID"] . '">Edit</a>&nbsp;|&nbsp;';
                    echo '<a href="news_delete.php?id=' . $row["newsID"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                    echo "</tr>" . "\n\t\t";
                    $numrow++;
                }
            } else {
                echo '<tr><td colspan="5">0 results</td></tr>';
            } 
            
            mysqli_close($conn);
        ?>
    </table>
    <?php
        if(isset($_SESSION["UID"])){
    ?>
        <div style="text-align: right; padding-top:10px;">
        <input type= "button"  onClick="show_AddEntry()" style="cursor: pointer;" value= "Add New"/>
        <input type= "button"  onClick="cancelRegister()" style="cursor: pointer;" value= "Cancel"/>
        </div>
    
    <?php
    }
    ?>
</div>

<div style="padding:0 10px; display:none;" id="challengeDiv">
    <h3 align="center">Add news</h3>
    <p align="center">Required field with mark*</p>

    <form method="POST" action="news_action.php" enctype="multipart/form-data" id="form" style="display: block;">
        <table border="3" id="myTable">
            <tr>
                <td>News*</td>
                <td>:</td>
                <td>
                    <textarea rows="4" name="news" cols="20" required></textarea>
                </td>
            </tr>
            <tr>
                <td>Remark</td>
                <td>:</td>
                <td>
                    <textarea rows="4" name="remark" cols="20"></textarea>
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
    <p>Copyright (c) 2023 - Cassily Corp.</p>
</footer>

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
function cancelRegister(){
    var x = document.getElementById("challengeDiv");
    x.style.display = 'None';
}
 function show_AddEntry() {
    var x = document.getElementById("challengeDiv");
    x.style.display = 'Block';
}

</script>
</body>
</html>
