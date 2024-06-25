<?PHP
session_start();
include('config.php');

//variables
$action="";
$id="";
$news = "";
$remark = "";



//this block is called when button Submit is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $news = $_POST["news"];
    $remark = $_POST["remark"];
    
    $sql = "INSERT INTO news (userID, news, remark)
    VALUES (" . $_SESSION["UID"] . ", '" . $news . "','" . $remark . "')";
    $status = insertTo_DBTable($conn, $sql);

    if ($status) {
       echo "Form data saved successfully!<br>";
       echo '<a href="news.php">Back</a>';             
    } else {
        echo '<a href="news.php">Back</a>';
   }  

}

//close db connection
mysqli_close($conn);

//Function to insert data to database table
function insertTo_DBTable($conn, $sql){
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        return false;
    }
}
?>
