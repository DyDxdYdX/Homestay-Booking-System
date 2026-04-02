<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../managehomestay_edit.php'); // Assuming this contains the edit functionality

class TestHomestayEdit {
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
        echo "Running Homestay Edit Tests...\n\n";

        $this->testEditHomestayDetails();
        $this->testEditHomestayWithImage();

        $this->displayResults();
    }

    private function testEditHomestayDetails() {
        // Simulate form data for editing details
        $_POST = [
            'hsname' => 'Updated Homestay',
            'hsdesc' => 'An updated description',
            'hsprice' => '150',
            'hslistID' => 1 // Replace with a valid hslistID in your database
        ];
        $_FILES = []; // No image uploaded

        ob_start();
        include(__DIR__ . '/../managehomestay_edit_action.php');
        $output = ob_get_clean();

        $this->assert(
            strpos($output, 'Homestay updated successfully!') !== false,
            "Homestay details updated successfully"
        );
    }

    private function testEditHomestayWithImage() {
        // Simulate form data for editing with an image
        $_POST = [
            'hsname' => 'Updated Homestay with Image',
            'hsdesc' => 'An updated description with image',
            'hsprice' => '200',
            'hslistID' => 1 // Replace with a valid hslistID in your database
        ];
        $_FILES = [
            'fileToUpload' => [
                'name' => 'updatedimage.jpg',
                'tmp_name' => __DIR__ . '/updatedimage.jpg', // Replace with a valid temporary file path
                'error' => 0,
                'size' => 60000
            ]
        ];

        ob_start();
        include(__DIR__ . '/../managehomestay_edit_action.php');
        $output = ob_get_clean();

        $this->assert(
            strpos($output, 'Homestay updated successfully!') !== false,
            "Homestay updated successfully with an image"
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
    $tester = new TestHomestayEdit($conn);
    $tester->runTests();
} catch (Exception $e) {
    echo "Error running tests: " . $e->getMessage() . "\n";
}
?>
