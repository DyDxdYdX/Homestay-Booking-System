<?PHP
session_start();
include('config.php');

//variables
$bookingID = "";
$checkIN = "";
$checkOUT = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userID = $_SESSION["UID"];
    $bookingID = $_POST["bookingID"];
    $checkIN = $_POST["checkIN"];
    $checkOUT = $_POST["checkOUT"];

    $sql = "UPDATE booking SET checkIN = '$checkIN', checkOUT = '$checkOUT' WHERE bookingID = $bookingID AND userID = $userID";
    $status = insertTo_DBTable($conn,$sql);
    if($status){
        echo "Date Successfully added!<br>";
        echo '<a href="checkin_checkout.php">Back</a>';
    }else{
        echo "Date Update Failed! Please try again.<br>";
        echo '<a href="checkin_checkout.php">Back</a>';
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