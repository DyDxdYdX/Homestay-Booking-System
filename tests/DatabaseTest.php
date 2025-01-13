<?php
use PHPUnit\Framework\TestCase;
use App\Config\Database;

class DatabaseTest extends TestCase
{
    public function testConnection()
    {
        $conn = Database::getConnection();
        $this->assertInstanceOf(mysqli::class, $conn);
        $this->assertFalse($conn->connect_error, "Connection failed: " . $conn->connect_error);
    }
}
