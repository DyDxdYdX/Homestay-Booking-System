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
    $id = $_POST["cid"];
    $news = $_POST["news"];
    $remark = trim($_POST["remark"]);

    $sql = "UPDATE news SET news= '$news', remark = '$remark' WHERE newsID =" . $id . " AND userID = ". $_SESSION["UID"];

    $status = update_DBTable($conn, $sql);

    if ($status) {
        echo "Form data updated successfully!<br>";
        echo '<a href="news.php">Back</a>';             
    } else {
        echo '<a href="news.php">Back</a>';
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