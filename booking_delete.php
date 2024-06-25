<?php
session_start();
include('config.php');
//this action is called when the Delete link is clicked
if(isset($_GET["id"]) && $_GET["id"] != ""){
    $bookingID = $_GET["id"];
    
    $sql = "DELETE FROM booking WHERE bookingID=" . $bookingID;
    //echo $sql . "<br>";
    
    if (mysqli_query($conn, $sql)) {
        echo "Booking Canceled Successfully<br>";
        echo '<a href="booking.php">Back</a>';
     } else {
        echo "Error cancel booking: " . mysqli_error($conn) . "<br>";
        echo '<a href="booking.php">Back</a>';
    }
}
mysqli_close($conn);
?>