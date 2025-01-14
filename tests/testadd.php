<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../managehomestay_add_action.php'); // Assuming this contains the add functionality

class TestHomestayAdd {
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
        echo "Running Homestay Add Tests...\n\n";
        
        $this->testAddHomestayWithoutImage();
        $this->testAddHomestayWithImage();
        
        $this->displayResults();
    }

    private function testAddHomestayWithoutImage() {
        // Simulate form data
        $_POST = [
            'hsname' => 'Test Homestay',
            'hsdesc' => 'A lovely place to stay',
            'hsprice' => '100'
        ];
        $_FILES = []; // No image uploaded

        // Call the add functionality
        ob_start();
        include(__DIR__ . '/../managehomestay_add_action.php');
        $output = ob_get_clean();

        // Verify the result
        $this->assert(
            strpos($output, 'Form data updated successfully!') !== false,
            "Homestay added successfully without an image"
        );
    }

    private function testAddHomestayWithImage() {
        // Simulate form data
        $_POST = [
            'hsname' => 'Test Homestay With Image',
            'hsdesc' => 'A luxurious place to stay',
            'hsprice' => '200'
        ];
        $_FILES = [
            'fileToUpload' => [
                'name' => 'testimage.jpg',
                'tmp_name' => __DIR__ . '/testimage.jpg', // Replace with a real temporary file if needed
                'error' => 0,
                'size' => 50000
            ]
        ];

        // Call the add functionality
        ob_start();
        include(__DIR__ . '/../managehomestay_add_action.php');
        $output = ob_get_clean();

        // Verify the result
        $this->assert(
            strpos($output, 'Form data updated successfully!') !== false,
            "Homestay added successfully with an image"
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
    $tester = new TestHomestayAdd($conn);
    $tester->runTests();
} catch (Exception $e) {
    echo "Error running tests: " . $e->getMessage() . "\n";
}
?>
