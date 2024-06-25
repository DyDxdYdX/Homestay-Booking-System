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

    <h2>| Feedback and review</h2>

    <div class="row">
        <table border="3" width="100%" id="projectable" style = "margin-right:20px;">
            <tr>
                <th width="5%">No</th>
                <th width="30%">Homestay Name</th>
                <th width="15%">Check In</th>
                <th width="15%">Check Out</th>
                <th width="5%">Rating</th>
                <th width="20%">Feedback</th>
                <th width="10%">Action</th>
            </tr>
            <?php
                $sql = "SELECT * FROM feedbacks WHERE userID=". $_SESSION["UID"];
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $numrow=1;
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $numrow . "</td><td>". $row["hsname"] . "</td><td>" . $row["dateIN"] . "</td><td>" . $row["dateOUT"] . "</td><td>" 
                        . $row["rating"] ."</td><td>" . $row["fdback"] . "</td>";
                        echo '<td> <a href="feedback_edit.php?id=' . $row["fdbackID"] . '">Edit</a>&nbsp;|&nbsp;';
                        echo '<a href="feedback_delete.php?id=' . $row["fdbackID"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                        echo "</tr>" . "\n\t\t";
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="7">0 results</td></tr>';
                } 
    
            ?>
        </table>
    </div>

    <?php
    $hsname = '';
    $dateIN = '';
    $dateOUT = '';
    $rating = '';
    $fdback = '';

    if (isset($_GET['fdbackID'])){
        $fdbackID = $_GET['fdbackID'];

        $sql = "SELECT * FROM feedbacks LEFT JOIN homestaylist ON feedbacks.userID = homestaylist.userID";
        $result = mysqli_query($conn, $sql);

        $result = mysqli_query($conn ,$sql);
        if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hsname = $row['hsname'];
        $dateIN = $row['dateIN'];
        $dateOUT = $row['dateOUT'];
        $rating = $row['rating'];
        $fdback = $row['fdback'];
        }
    }

    
    ?>

    <div> 
        <h2>| Add Review Form</h2>
        <div>
            <form method="post" action="feedback_action.php" id="form" style="display: block;">
                <table>
                    <tr>
                        <td id="label">Homestay Name:</td>
                        <td id="tableform">
                            <select name="hsname">
                                <?php
                                if(isset($_SESSION['UID'])){
                                    $sql = "SELECT * FROM homestaylist";
                                    $result = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($result) > 0){
                                        $numrow=1;
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<option value=".$row['hsname'].">".$row['hsname']."</option>";
                                        }
                                    }else{
                                        echo "<option>No Available Option</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td id="label">Stay Date:</td>
                        <td id="tableform">
                            <input type="date" id="dateIN" name="dateIN" value=<?= $dateIN ?>>
                        </td>
                    </tr>
                    <tr>
                        <td id="label">Leave Date:</td>
                        <td id="tableform">
                            <input type="date" id="dateOUT" name="dateOUT" value=<?= $dateOUT ?>>
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
                            <textarea rows="2" id="fdback" name="fdback"><?= $fdback?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td><input type="submit" value="Submit" name="B1"></th>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <footer>
        <p>Copyright (c) 2023 - Cassily Corp. </p>
    </footer>
    </body>
</html>

<?php
mysqli_close($conn);
?>