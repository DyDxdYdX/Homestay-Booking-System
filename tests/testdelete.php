<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../managehomestay_delete.php'); // Assuming this contains the delete functionality

class TestHomestayDelete {
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
        echo "Running Homestay Delete Tests...\n\n";

        $this->testDeleteExistingHomestay();
        $this->testDeleteNonExistentHomestay();

        $this->displayResults();
    }

    private function testDeleteExistingHomestay() {
        // Simulate a delete request for an existing record
        $_GET = [
            'id' => 1 // Replace with a valid hslistID in your database
        ];

        ob_start();
        include(__DIR__ . '/../managehomestay_delete.php');
        $output = ob_get_clean();

        $this->assert(
            strpos($output, 'Record deleted successfully') !== false,
            "Existing homestay deleted successfully"
        );
    }

    private function testDeleteNonExistentHomestay() {
        // Simulate a delete request for a non-existent record
        $_GET = [
            'id' => 99999 // Replace with an invalid hslistID
        ];

        ob_start();
        include(__DIR__ . '/../managehomestay_delete.php');
        $output = ob_get_clean();

        $this->assert(
            strpos($output, 'Error deleting record') !== false,
            "Deleting non-existent homestay handled correctly"
        );
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
    $tester = new TestHomestayDelete($conn);
    $tester->runTests();
} catch (Exception $e) {
    echo "Error running tests: " . $e->getMessage() . "\n";
}
?>
