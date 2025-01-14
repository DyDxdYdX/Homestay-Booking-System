<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../booking.php');

class CustomBookingTest {
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
        echo "Running Booking System Tests...\n\n";
        
        $this->testGetHomeownerBookings();
        $this->testGetCustomerBookings();
        $this->testGetAvailableHomestays();
        
        $this->displayResults();
    }

    private function testGetHomeownerBookings() {
        // Test case 1: Valid homeowner with bookings
        $result = getHomeownerBookings($this->conn, 2); // Assuming 2 is a valid homeowner ID
        $this->assert(
            $result !== false && mysqli_num_rows($result) >= 0,
            "getHomeownerBookings returns valid result for existing homeowner"
        );

        // Test case 2: Non-existent homeowner
        $result = getHomeownerBookings($this->conn, 99999);
        $this->assert(
            $result !== false && mysqli_num_rows($result) === 0,
            "getHomeownerBookings returns empty result for non-existent homeowner"
        );
    }

    private function testGetCustomerBookings() {
        // Test case 1: Valid customer with bookings
        $result = getCustomerBookings($this->conn, 3); // Assuming 3 is a valid customer ID
        $this->assert(
            $result !== false && mysqli_num_rows($result) >= 0,
            "getCustomerBookings returns valid result for existing customer"
        );

        // Test case 2: Non-existent customer
        $result = getCustomerBookings($this->conn, 99999);
        $this->assert(
            $result !== false && mysqli_num_rows($result) === 0,
            "getCustomerBookings returns empty result for non-existent customer"
        );
    }

    private function testGetAvailableHomestays() {
        // Test available homestays function
        $result = getAvailableHomestays($this->conn);
        $this->assert(
            $result !== false,
            "getAvailableHomestays returns valid result"
        );

        // Test if the result contains expected columns
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $this->assert(
                isset($row['hslistID']) && isset($row['hsname']) && isset($row['hsprice']),
                "Homestay results contain required columns"
            );
        }
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
    $tester = new CustomBookingTest($conn);
    $tester->runTests();
} catch (Exception $e) {
    echo "Error running tests: " . $e->getMessage() . "\n";
}
?> 