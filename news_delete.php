<?PHP
session_start();
include('config.php');

//this action called when Delete link is clicked
if(isset($_GET["id"]) && $_GET["id"] != ""){
    $id = $_GET["id"];
    $sql = "DELETE FROM news WHERE newsID=" . $id . " AND userID=" . $_SESSION["UID"];
    //echo $sql . "<br>";
    
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully<br>";
        echo '<a href="news.php">Back</a>';
     } else {
        echo "Error deleting record: " . mysqli_error($conn) . "<br>";
        echo '<a href="news.php">Back</a>';
    }
}
mysqli_close($conn);
?>