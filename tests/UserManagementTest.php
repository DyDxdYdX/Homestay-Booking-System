<?php
use PHPUnit\Framework\TestCase;

class UserManagementTest extends TestCase
{
    public function testUserActivationQuery()
    {
        $userID = 1;
        $expectedQuery = "UPDATE user SET user_STATUS = 'Active' WHERE userID = $userID";

        // Assuming a function buildActivationQuery exists
        $this->assertEquals($expectedQuery, buildActivationQuery($userID));
    }
}
