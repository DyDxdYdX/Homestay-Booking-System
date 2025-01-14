<?php
// db_operations.php - Contains reusable database operations

function execute_query($conn, $sql) {
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function insert_homestay($conn, $userID, $hsname, $hsdesc, $hsprice, $imgpath = null) {
    $sql = "INSERT INTO homestaylist (userID, hsname, hsdesc, hsprice, imgpath) 
            VALUES ($userID, '$hsname', '$hsdesc', '$hsprice', '$imgpath')";
    return execute_query($conn, $sql);
}

function update_homestay($conn, $hslistID, $userID, $hsname, $hsdesc, $hsprice, $imgpath = null) {
    $sql = "UPDATE homestaylist SET hsname = '$hsname', hsdesc = '$hsdesc', hsprice = '$hsprice', imgpath = '$imgpath'
            WHERE hslistID = $hslistID AND userID = $userID";
    return execute_query($conn, $sql);
}

function delete_homestay($conn, $hslistID, $userID) {
    $sql = "DELETE FROM homestaylist WHERE hslistID = $hslistID AND userID = $userID";
    return execute_query($conn, $sql);
}
?>
