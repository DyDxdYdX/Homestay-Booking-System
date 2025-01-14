
<?php


require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../managehomestay_delete.php');

class ManageHomestayDeleteTest extends TestCase
{
    public function testDeleteHomestay()
    {
        // Assuming homestay ID 1 for the test
        $_GET['id'] = 1;

        // Simulating session with a user ID
        $_SESSION['UID'] = 1; // Assuming a logged-in user with ID 1

        // Call the code to test
        ob_start();
        include(__DIR__ . '/../managehomestay_delete_action.php');
        $output = ob_get_clean();

        $this->assertStringContainsString('Record deleted successfully', $output);
    }

    public function testDeleteNonExistentHomestay()
    {
        // Trying to delete a non-existent homestay
        $_GET['id'] = 999; // Non-existent ID

        // Simulating session with a user ID
        $_SESSION['UID'] = 1; // Assuming a logged-in user with ID 1

        // Call the code to test
        ob_start();
        include(__DIR__ . '/../managehomestay_delete_action.php');
        $output = ob_get_clean();

        $this->assertStringContainsString('Error deleting record', $output);
    }
}
