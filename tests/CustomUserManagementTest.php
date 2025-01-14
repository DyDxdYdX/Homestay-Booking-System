<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../user_manage.php');

class CustomUserManagementTest {
    private $conn;
    private $testResults = [];

    public function __construct($conn) {
        $this->conn = $conn;
    }

    private function assert($condition, $message) {
        if ($condition) {
            $this->testResults[] = "✅ PASS: $message";
            return true;
        } else {
            $this->testResults[] = "❌ FAIL: $message";
            return false;
        }
    }

    public function runTests() {
        echo "Running User Management Tests...\n\n";

        $this->cleanUpMockData();
        $this->testBlockUser();
        $this->testActivateUser();
        $this->testDuplicateUserInsertion();
        $this->cleanUpMockData();

        $this->displayResults();
    }

    private function testBlockUser() {
        $email = "testuser1@example.com";
        $password = "password123";

        // Insert mock data
        $this->mockDatabaseInsert($email, $password, USER_ROLE_CUSTOMER, STATUS_ACTIVE);

        // Perform the action to block the user
        $sql = "UPDATE user SET user_STATUS = '" . STATUS_BLOCKED . "' WHERE userEmail = '$email'";
        $this->executeQuery($sql, "Failed to block the user");

        // Assert the user is blocked
        $this->assert(
            $this->assertUserStatus($email, STATUS_BLOCKED),
            "User successfully blocked"
        );
    }

    private function testActivateUser() {
        $email = "testuser2@example.com";
        $password = "password123";

        // Insert mock data
        $this->mockDatabaseInsert($email, $password, USER_ROLE_CUSTOMER, STATUS_BLOCKED);

        // Perform the action to activate the user
        $sql = "UPDATE user SET user_STATUS = '" . STATUS_ACTIVE . "' WHERE userEmail = '$email'";
        $this->executeQuery($sql, "Failed to activate the user");

        // Assert the user is activated
        $this->assert(
            $this->assertUserStatus($email, STATUS_ACTIVE),
            "User successfully activated"
        );
    }

    private function testDuplicateUserInsertion() {
        $email = "testuser3@example.com";
        $password = "password123";

        // Insert the first user
        $this->mockDatabaseInsert($email, $password, USER_ROLE_CUSTOMER, STATUS_ACTIVE);

        // Attempt to insert a duplicate user
        $result = $this->mockDatabaseInsert($email, $password, USER_ROLE_CUSTOMER, STATUS_ACTIVE);

        $this->assert(
            !$result,
            "Duplicate user insertion prevented"
        );
    }

    private function mockDatabaseInsert($email, $password, $usertype, $status) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO user (userEmail, userPwd, usertype, user_STATUS) VALUES ('$email', '$hashedPassword', '$usertype', '$status')";
        return mysqli_query($this->conn, $sql);
    }

    private function assertUserStatus($email, $expectedStatus) {
        $sql = "SELECT user_STATUS FROM user WHERE userEmail = '$email'";
        $result = mysqli_query($this->conn, $sql);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            return $row['user_STATUS'] === $expectedStatus;
        }
        return false;
    }

    private function executeQuery($sql, $errorMessage = "Query execution failed") {
        if (!mysqli_query($this->conn, $sql)) {
            die("$errorMessage: " . mysqli_error($this->conn));
        }
    }

    private function cleanUpMockData() {
        $sql = "DELETE FROM user WHERE userEmail LIKE 'testuser%'";
        $this->executeQuery($sql, "Failed to clean up mock data");
    }

    private function displayResults() {
        echo "\nTest Results:\n";
        echo "=============\n\n";
        foreach ($this->testResults as $result) {
            echo "$result\n";
        }

        $totalTests = count($this->testResults);
        $passedTests = count(array_filter($this->testResults, function ($result) {
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
} finally {
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>
