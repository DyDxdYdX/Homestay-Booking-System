<?PHP
session_start();
include('config.php');



if ($_SERVER["REQUEST_METHOD"]== "POST"){
    //Prepare first data
    $hsname = $_POST['hsname'];
    $dateIN = $_POST['dateIN'];
    $dateOUT = $_POST['dateOUT'];
    $rating = $_POST['rating'];
    $fdback = $_POST['fdback'];

    $sql = "INSERT INTO feedbacks (userID, hsname, dateIN, dateOUT, rating, fdback)
    VALUES (" . $_SESSION["UID"] . ",'$hsname','$dateIN','$dateOUT','$rating','$fdback')";
    

       if(mysqli_query($conn, $sql)){
        $id = mysqli_insert_id($conn);
        echo "New Food Review Inserted: Review ID - '$id'<br>";
        echo '<a href="feedback.php?fdbackID=' . $id .'">View Review</a>';
    }
    else {
        echo '<a href="feedback.php">Back</a>';
    }
    }


