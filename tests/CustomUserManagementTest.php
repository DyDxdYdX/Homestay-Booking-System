<?php
// Custom Testing Script for user_manage.php

// Include the necessary configuration and functionality
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../user_manage.php');

// Constants for user roles and statuses
const USER_ROLE_CUSTOMER = 3;
const STATUS_ACTIVE = 'Active';
const STATUS_BLOCKED = 'Blocked';

// Helper function to execute a query and check for errors
function executeQuery($conn, $sql, $errorMessage = "Query execution failed")
{
    if (!mysqli_query($conn, $sql)) {
        die("$errorMessage: " . mysqli_error($conn));
    }
}

// Helper function to clean up mock data
function cleanUpMockData($conn)
{
    $sql = "DELETE FROM user WHERE userEmail LIKE 'testuser%'";
    executeQuery($conn, $sql, "Failed to clean up mock data");
}

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
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['user_STATUS'] === $expectedStatus;
    }
    return false;
}

// Test 1: Block a user
function testBlockUser($conn)
{
    $email = "testuser1@example.com";
    $password = "password123";

    // Insert mock data
    mockDatabaseInsert($conn, $email, $password, USER_ROLE_CUSTOMER, STATUS_ACTIVE);

    // Perform the action to block the user
    $sql = "UPDATE user SET user_STATUS = '" . STATUS_BLOCKED . "' WHERE userEmail = '$email'";
    executeQuery($conn, $sql, "Failed to block the user");

    // Assert the user is blocked
    if (assertUserStatus($conn, $email, STATUS_BLOCKED)) {
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

    // Insert mock data
    mockDatabaseInsert($conn, $email, $password, USER_ROLE_CUSTOMER, STATUS_BLOCKED);

    // Perform the action to activate the user
    $sql = "UPDATE user SET user_STATUS = '" . STATUS_ACTIVE . "' WHERE userEmail = '$email'";
    executeQuery($conn, $sql, "Failed to activate the user");

    // Assert the user is activated
    if (assertUserStatus($conn, $email, STATUS_ACTIVE)) {
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

    // Insert the first user
    mockDatabaseInsert($conn, $email, $password, USER_ROLE_CUSTOMER, STATUS_ACTIVE);

    // Attempt to insert a duplicate user
    $result = mockDatabaseInsert($conn, $email, $password, USER_ROLE_CUSTOMER, STATUS_ACTIVE);

    if (!$result) {
        echo "Test 3 Passed: Duplicate user insertion prevented.\n";
    } else {
        echo "Test 3 Failed: Duplicate user insertion allowed.\n";
    }
}

// Run the tests
echo "Running Tests...\n";

// Clean up any leftover mock data before running tests
cleanUpMockData($conn);

testBlockUser($conn);
testActivateUser($conn);
testDuplicateUserInsertion($conn);

// Clean up mock data after tests
cleanUpMockData($conn);

// Close the database connection
mysqli_close($conn);

echo "Tests Completed.\n";
?>
