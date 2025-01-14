<?php
// Include required files
include_once '../config.php'; // Path to your database config
include_once '../managehomestay_add.php'; // File to be tested
include_once '../managehomestay_edit.php'; // File to be tested
include_once '../managehomestay_delete.php'; // File to be tested

// Database connection
$conn = new mysqli("localhost", "test_user", "test_password", "test_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Test case 1: Add a homestay
echo "Running test case 1: Add Homestay...<br>";
$userID = 1; // Example user ID
$hsname = "Test Homestay";
$hsdesc = "This is a test homestay.";
$hsprice = 120.50;

$sql = "INSERT INTO homestaylist (userID, hsname, hsdesc, hsprice) VALUES ($userID, '$hsname', '$hsdesc', $hsprice)";
if ($conn->query($sql) === TRUE) {
    echo "Test case 1 passed: Homestay added successfully.<br>";
} else {
    echo "Test case 1 failed: " . $conn->error . "<br>";
}

// Test case 2: Edit a homestay
echo "Running test case 2: Edit Homestay...<br>";
$newHsname = "Updated Homestay";
$hsID = $conn->insert_id; // Get the ID of the last inserted record

$sql = "UPDATE homestaylist SET hsname = '$newHsname' WHERE hslistID = $hsID";
if ($conn->query($sql) === TRUE) {
    echo "Test case 2 passed: Homestay edited successfully.<br>";
} else {
    echo "Test case 2 failed: " . $conn->error . "<br>";
}

// Test case 3: Delete a homestay
echo "Running test case 3: Delete Homestay...<br>";

$sql = "DELETE FROM homestaylist WHERE hslistID = $hsID";
if ($conn->query($sql) === TRUE) {
    echo "Test case 3 passed: Homestay deleted successfully.<br>";
} else {
    echo "Test case 3 failed: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
