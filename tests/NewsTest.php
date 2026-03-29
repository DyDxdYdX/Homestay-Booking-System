<?php
require_once __DIR__ . '/../config.php';

class NewsTest {
    private $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
        
        // Run all tests
        $this->runAllTests();
    }
    
    private function runAllTests() {
        // Track test results
        $passedTests = 0;
        $totalTests = 0;
        
        // Run individual tests
        $this->testNewsDisplay($passedTests, $totalTests);
        $this->testNewsAdd($passedTests, $totalTests);
        $this->testNewsEdit($passedTests, $totalTests);
        $this->testNewsDelete($passedTests, $totalTests);
        $this->testNewsSearch($passedTests, $totalTests);
        
        // Display results
        echo "\nTest Results: $passedTests/$totalTests tests passed\n";
    }
    
    private function createTestUser() {
        $sql = "INSERT INTO user (usertype, userEmail, userPwd, user_STATUS) 
                VALUES (2, 'test_" . time() . "@test.com', 'testpassword', 'Active')";
        mysqli_query($this->conn, $sql);
        return mysqli_insert_id($this->conn);
    }
    
    private function createTestNews($userId, $news, $remark) {
        $sql = "INSERT INTO news (userID, news, remark) 
                VALUES ($userId, '$news', '$remark')";
        mysqli_query($this->conn, $sql);
        return mysqli_insert_id($this->conn);
    }
    
    private function cleanup($userId) {
        mysqli_query($this->conn, "DELETE FROM news WHERE userID = $userId");
        mysqli_query($this->conn, "DELETE FROM user WHERE userID = $userId");
    }
    
    private function testNewsDisplay(&$passedTests, &$totalTests) {
        $totalTests++;
        echo "\nTesting News Display...";
        
        // Create test user and news
        $userId = $this->createTestUser();
        $newsId = $this->createTestNews($userId, "Test News", "Test Remark");
        
        // Query the news
        $sql = "SELECT * FROM news WHERE userID = $userId";
        $result = mysqli_query($this->conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            echo "PASSED";
            $passedTests++;
        } else {
            echo "FAILED";
        }
        
        // Cleanup
        $this->cleanup($userId);
    }
    
    private function testNewsAdd(&$passedTests, &$totalTests) {
        $totalTests++;
        echo "\nTesting News Addition...";
        
        $userId = $this->createTestUser();
        $news = "Test News Addition";
        $remark = "Test Remark Addition";
        
        $sql = "INSERT INTO news (userID, news, remark) VALUES ($userId, '$news', '$remark')";
        if (mysqli_query($this->conn, $sql)) {
            $newsId = mysqli_insert_id($this->conn);
            
            // Verify insertion
            $checkSql = "SELECT * FROM news WHERE newsID = $newsId";
            $result = mysqli_query($this->conn, $checkSql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                echo "PASSED";
                $passedTests++;
            } else {
                echo "FAILED";
            }
        } else {
            echo "FAILED";
        }
        
        // Cleanup
        $this->cleanup($userId);
    }
    
    private function testNewsEdit(&$passedTests, &$totalTests) {
        $totalTests++;
        echo "\nTesting News Edit...";
        
        $userId = $this->createTestUser();
        $newsId = $this->createTestNews($userId, "Original News", "Original Remark");
        
        $updatedNews = "Updated News";
        $sql = "UPDATE news SET news = '$updatedNews' WHERE newsID = $newsId";
        
        if (mysqli_query($this->conn, $sql)) {
            // Verify update
            $checkSql = "SELECT news FROM news WHERE newsID = $newsId";
            $result = mysqli_query($this->conn, $checkSql);
            $row = mysqli_fetch_assoc($result);
            
            if ($row['news'] === $updatedNews) {
                echo "PASSED";
                $passedTests++;
            } else {
                echo "FAILED";
            }
        } else {
            echo "FAILED";
        }
        
        // Cleanup
        $this->cleanup($userId);
    }
    
    private function testNewsDelete(&$passedTests, &$totalTests) {
        $totalTests++;
        echo "\nTesting News Deletion...";
        
        $userId = $this->createTestUser();
        $newsId = $this->createTestNews($userId, "News to Delete", "Remark to Delete");
        
        $sql = "DELETE FROM news WHERE newsID = $newsId";
        if (mysqli_query($this->conn, $sql)) {
            // Verify deletion
            $checkSql = "SELECT * FROM news WHERE newsID = $newsId";
            $result = mysqli_query($this->conn, $checkSql);
            
            if (mysqli_num_rows($result) === 0) {
                echo "PASSED";
                $passedTests++;
            } else {
                echo "FAILED";
            }
        } else {
            echo "FAILED";
        }
        
        // Cleanup
        $this->cleanup($userId);
    }
    
    private function testNewsSearch(&$passedTests, &$totalTests) {
        $totalTests++;
        echo "\nTesting News Search...";
        
        $userId = $this->createTestUser();
        $searchTerm = "UniqueSearchTerm";
        $newsId = $this->createTestNews($userId, $searchTerm, "Test Remark");
        
        $sql = "SELECT * FROM news WHERE userID = $userId AND news LIKE '%$searchTerm%'";
        $result = mysqli_query($this->conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            echo "PASSED";
            $passedTests++;
        } else {
            echo "FAILED";
        }
        
        // Cleanup
        $this->cleanup($userId);
    }
}

// Run the tests
new NewsTest(); 
