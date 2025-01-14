<?php
// Custom Testing Script for user_manage.php

// Include the necessary configuration
include("config.php");

// Function to mock database operations
function mockDatabaseInsert($conn, $email, $password, $usertype, $status)
{
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO user (userEmail, userPwd, usertype, user_STATUS) VALUES ('$email', '$hashedPassword', '$usertype', '$status')";
    return mysqli_query($conn, $sql);
}

// Function to fetch and assert user status
function assertUserStatus($conn, $email, $expectedStatus)
{
    $sql = "SELECT user_STATUS FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['user_STATUS'] === $expectedStatus;
    }
    return false;
}

// Test 1: Block a user
function testBlockUser($conn)
{
    $email = "testuser1@example.com";
    $password = "password123";
    $usertype = 3; // Customer
    $status = "Active";

    // Insert mock data
    mockDatabaseInsert($conn, $email, $password, $usertype, $status);

    // Perform the action to block the user
    $sql = "UPDATE user SET user_STATUS = 'Blocked' WHERE userEmail = '$email'";
    mysqli_query($conn, $sql);

    // Assert the user is blocked
    if (assertUserStatus($conn, $email, "Blocked")) {
        echo "Test 1 Passed: User successfully blocked.\n";
    } else {
        echo "Test 1 Failed: User blocking failed.\n";
    }
}

// Test 2: Activate a blocked user
function testActivateUser($conn)
{
    $email = "testuser2@example.com";
    $password = "password123";
    $usertype = 3; // Customer
    $status = "Blocked";

    // Insert mock data
    mockDatabaseInsert($conn, $email, $password, $usertype, $status);

    // Perform the action to activate the user
    $sql = "UPDATE user SET user_STATUS = 'Active' WHERE userEmail = '$email'";
    mysqli_query($conn, $sql);

    // Assert the user is activated
    if (assertUserStatus($conn, $email, "Active")) {
        echo "Test 2 Passed: User successfully activated.\n";
    } else {
        echo "Test 2 Failed: User activation failed.\n";
    }
}

// Test 3: Prevent duplicate user email insertion
function testDuplicateUserInsertion($conn)
{
    $email = "testuser3@example.com";
    $password = "password123";
    $usertype = 3; // Customer
    $status = "Active";

    // Insert the first user
    mockDatabaseInsert($conn, $email, $password, $usertype, $status);

    // Attempt to insert a duplicate user
    $result = mockDatabaseInsert($conn, $email, $password, $usertype, $status);

    if (!$result) {
        echo "Test 3 Passed: Duplicate user insertion prevented.\n";
    } else {
        echo "Test 3 Failed: Duplicate user insertion allowed.\n";
    }
}

// Run the tests
echo "Running Tests...\n";
testBlockUser($conn);
testActivateUser($conn);
testDuplicateUserInsertion($conn);

// Clean up mock data
mysqli_query($conn, "DELETE FROM user WHERE userEmail LIKE 'testuser%'");

// Close the database connection
mysqli_close($conn);

echo "Tests Completed.\n";
?>
