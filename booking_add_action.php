<?PHP
session_start();
include('config.php');

//variables
$hslistID="";
$book_date = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userID = $_SESSION["UID"];
    $hslistID = $_POST["hslistID"];

    $sql = "INSERT INTO booking (userID, hslistID)
            VALUES ('$userID','$hslistID')";
    $status = insertTo_DBTable($conn,$sql);
    if($status){
        echo "Successfully booking! Enjoy your Holiday.<br>";
        echo '<a href="booking.php">Back</a>';
    }else{
        echo "Booking Failed! Please try again.<br>";
        echo '<a href="booking.php">Back</a>';
    }
}

mysqli_close($conn);

function insertTo_DBTable($conn, $sql){
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        return false;
    }
}
?>