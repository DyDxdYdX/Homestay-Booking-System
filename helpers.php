<?php
function fetchUserFeedbacks($conn, $userID) {
    $stmt = $conn->prepare("SELECT * FROM feedbacks WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    return $stmt->get_result();
}

function fetchHomestays($conn) {
    $stmt = $conn->prepare("SELECT hsname FROM homestaylist");
    $stmt->execute();
    return $stmt->get_result();
}
?>
