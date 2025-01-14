<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = ''; // Update this as per your setup
$database = 'homestay';

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Test Adding News
echo "\n=== Test: Adding News ===\n";
$userID = 1; // Assume userID exists
$newsContent = "Test news content.";
$remark = "Test remark.";

$sqlAddNews = "INSERT INTO news (userID, news, remark) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sqlAddNews);
$stmt->bind_param("iss", $userID, $newsContent, $remark);

if ($stmt->execute()) {
    echo "News added successfully with ID: " . $stmt->insert_id . "\n";
    $newsID = $stmt->insert_id;
} else {
    echo "Failed to add news: " . $stmt->error . "\n";
}

// Test Fetching News
echo "\n=== Test: Fetching News ===\n";
$sqlFetchNews = "SELECT * FROM news WHERE newsID = ?";
$stmt = $conn->prepare($sqlFetchNews);
$stmt->bind_param("i", $newsID);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "NewsID: {$row['newsID']}, UserID: {$row['userID']}, News: {$row['news']}, Remark: {$row['remark']}\n";
        }
    } else {
        echo "No news found with ID: $newsID\n";
    }
} else {
    echo "Failed to fetch news: " . $stmt->error . "\n";
}

// Test Updating News
echo "\n=== Test: Updating News ===\n";
$newContent = "Updated news content.";
$newRemark = "Updated remark.";

$sqlUpdateNews = "UPDATE news SET news = ?, remark = ? WHERE newsID = ?";
$stmt = $conn->prepare($sqlUpdateNews);
$stmt->bind_param("ssi", $newContent, $newRemark, $newsID);

if ($stmt->execute()) {
    echo "News updated successfully. Rows affected: " . $stmt->affected_rows . "\n";
} else {
    echo "Failed to update news: " . $stmt->error . "\n";
}

// Test Deleting News
echo "\n=== Test: Deleting News ===\n";
$sqlDeleteNews = "DELETE FROM news WHERE newsID = ?";
$stmt = $conn->prepare($sqlDeleteNews);
$stmt->bind_param("i", $newsID);

if ($stmt->execute()) {
    echo "News deleted successfully. Rows affected: " . $stmt->affected_rows . "\n";
} else {
    echo "Failed to delete news: " . $stmt->error . "\n";
}

// Close connection
$conn->close();
?>
