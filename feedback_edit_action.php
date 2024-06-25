<?PHP
session_start();
include('config.php');

//variables
$hsname = '';
$dateIN = '';
$dateOUT = '';
$rating = '';
$fdback = '';

//this block is called when button Submit is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $id = $_POST["fid"];
    $hsname = $_POST["hsname"];
    $dateIN = $_POST["dateIN"];
    $dateOUT = $_POST["dateOUT"];
    $rating = $_POST["rating"];
    $fdback = $_POST["fdback"];

    $sql = "UPDATE feedbacks SET hsname= '$hsname', dateIN = '$dateIN', dateOUT = '$dateOUT', rating = '$rating', fdback = '$fdback' WHERE fdbackID =" . $id . " AND userID = ". $_SESSION["UID"];

    $status = update_DBTable($conn, $sql);

    if ($status) {
        echo "Form data updated successfully!<br>";
        echo '<a href="feedback.php">Back</a>';             
    } else {
        echo '<a href="feedback.php">Back</a>';
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