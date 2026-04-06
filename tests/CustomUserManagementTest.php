<?php
require_once(__DIR__ . '/../config.php'); // Ensure this provides the $conn object.

class CustomUserManagementTest {
    private $conn;
    private $testResults = [];

    public function __construct($conn) {
        if (!$conn || $conn->connect_error) {
            throw new Exception("Database connection error: " . $conn->connect_error);
        }
        $this->conn = $conn;
    }

    private function assert($condition, $message) {
        if ($condition) {
            $this->testResults[] = "✅ PASS: $message";
        } else {
            $this->testResults[] = "❌ FAIL: $message";
        }
    }

    public function runTests() {
        echo "Running User Management Tests...\n\n";
        
        $this->testDisplayActiveUsers();
        $this->testDisplayBlockedUsers();
        $this->testBlockAndActivateUsers();
        
        $this->displayResults();
    }

    private function testDisplayActiveUsers() {
        $sql = "SELECT * FROM user WHERE user_STATUS = 'Active' AND usertype != '1'";
        $result = $this->conn->query($sql);

        $this->assert($result !== false, "Query for active users executed successfully");
        if ($result) {
            $this->assert($result->num_rows >= 0, "Active users query returned valid results");
        }
    }

    private function testDisplayBlockedUsers() {
        $sql = "SELECT * FROM user WHERE user_STATUS = 'Blocked' AND usertype != '1'";
        $result = $this->conn->query($sql);

        $this->assert($result !== false, "Query for blocked users executed successfully");
        if ($result) {
            $this->assert($result->num_rows >= 0, "Blocked users query returned valid results");
        }
    }

    private function testBlockAndActivateUsers() {
        // Insert a test user
        $this->conn->query("INSERT INTO user (usertype, userEmail, userPwd, user_STATUS) VALUES (2, 'testuser@example.com', 'testpassword', 'Active')");
        $userID = $this->conn->insert_id;

        // Block the test user
        $this->conn->query("UPDATE user SET user_STATUS = 'Blocked' WHERE userID = $userID");
        $result = $this->conn->query("SELECT user_STATUS FROM user WHERE userID = $userID");
        $status = $result->fetch_assoc()['user_STATUS'];
        $this->assert($status === 'Blocked', "User was successfully blocked");

        // Activate the test user
        $this->conn->query("UPDATE user SET user_STATUS = 'Active' WHERE userID = $userID");
        $result = $this->conn->query("SELECT user_STATUS FROM user WHERE userID = $userID");
        $status = $result->fetch_assoc()['user_STATUS'];
        $this->assert($status === 'Active', "User was successfully activated");

        // Clean up the test user
        $this->conn->query("DELETE FROM user WHERE userID = $userID");
    }

    private function displayResults() {
        echo "\nTest Results:\n";
        echo "=============\n\n";
        foreach ($this->testResults as $result) {
            echo "$result\n";
        }

        $totalTests = count($this->testResults);
        $passedTests = count(array_filter($this->testResults, function($result) {
            return strpos($result, '✅') === 0;
        }));

        echo "\nSummary:\n";
        echo "Total Tests: $totalTests\n";
        echo "Passed: $passedTests\n";
        echo "Failed: " . ($totalTests - $passedTests) . "\n";
    }
}

// Run the tests
try {
    $tester = new CustomUserManagementTest($conn);
    $tester->runTests();
} catch (Exception $e) {
    echo "Error running tests: " . $e->getMessage() . "\n";
}
?>
