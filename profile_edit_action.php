<!-- Author: MOHD. NAZMI BIN NORMAN BI21110356 -->
<?PHP
session_start();
include('config.php');
?>

<html>
<head>
<title>Homestay Booking System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style2.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php            
//check if logged-in
if(!isset($_SESSION["UID"])){
    header("location:index.php"); 
}

$userID = $_SESSION["UID"];
$username = "";
$phoneNo = "";
$address = "";

//for upload
$target_dir = "uploads/";
$target_file = "";
$uploadOk = 0;
$imageFileType = "";
$uploadfileName = "";

// Function to delete the previous image file
function deletePreviousImage($conn, $userID) {
    $sql = "SELECT img_profile FROM profile WHERE userID = $userID";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $previousImagePath = $row['img_profile'];
        
        // Check if the previous image path exists and delete it
        if ($previousImagePath && file_exists("uploads/$previousImagePath")) {
            unlink("uploads/$previousImagePath");
        }
    }
}

//this block is called when button Submit is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$username = $_POST["username"];
$phoneNo = $_POST["phoneNo"];
$address = $_POST["address"];
$filetmp = $_FILES["fileToUpload"];
//file of the image/photo file
$uploadfileName = $filetmp["name"];

//Check if there is an image to be uploaded
    //IF no image
    if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["name"] == ""){
        $sql="UPDATE profile SET username = '$username', phoneNo = '$phoneNo', address = '$address'
        WHERE userID = '$userID'";
                
                $status = update_DBTable($conn, $sql);
                if ($status) {
                    echo '<div class="error-box">Form data updated successfully!<br></div>';
                    header("refresh:2;URL=profile.php");
                } else {
                    header("refresh:2;URL=profile.php");
                }
            }

//IF there is image
else if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
    
    // Delete previous image before updating
    deletePreviousImage($conn, $userID);

    //Variable to determine for image upload is OK
    $uploadOk = 1;
    
    //file of the image/photo file
    $uploadfileName = $filetmp["name"];
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    echo "ERROR: Sorry, image file $uploadfileName already exists.<br>";
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "ERROR: Sorry, your file is too large. Try resizing your image.<br>";
    $uploadOk = 0;
}

// Allow only these file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
   && $imageFileType != "gif" ) {
    echo "ERROR: Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}

//If uploadOk, then try add to database first
//uploadOK=1 if there is image to be uploaded, filename not exists, file size is ok and format ok
if($uploadOk){
    $sql="UPDATE profile SET username = '$username', phoneNo = '$phoneNo', address = '$address', img_profile = '$uploadfileName'
    WHERE userID = '$userID'";
    
    $status = update_DBTable($conn, $sql);
    
    if ($status) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

//Image file successfully uploaded

//Tell successfull record
echo '<div class="error-box">Form data updated successfully!<br></div>';
header("refresh:2;URL=profile.php");
}
else{
//There is an error while uploading image

echo '<div class="error-box">Sorry, there was an error uploading your file<br></div>';
echo '<a href="javascript:history.back()">Back</a>';
}
}
}
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
        </div></div>
        </body>
</html>
