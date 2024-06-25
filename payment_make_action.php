<?PHP
session_start();
include('config.php');

//variables
$action="";
$id = "";
$hsname = "";   
$payment_method = "";
$amount_paid = "";

//this block is called when button Submit is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $id = $_POST["cid"];
    $payment_method = $_POST["payment_method"];
    $amount_paid = $_POST["amount_paid"];

    $sql = "UPDATE booking SET payment_method= '$payment_method', amount_paid = ' $amount_paid', payment_status='Paid' WHERE bookingID =" . $id . " AND userID = ". $_SESSION["UID"];

    $status = update_DBTable($conn, $sql);

    if ($status) {
        echo "Payment is successfully made!<br>";
        echo '<a href="payment.php">Back</a>';             
    } else {
        echo '<a href="payment.php">Back</a>';
    }  
        
}

//close db connection
mysqli_close($conn);

//Function to insert data to database table
function update_DBTable($conn, $sql){
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        return false;
    }
}
?>