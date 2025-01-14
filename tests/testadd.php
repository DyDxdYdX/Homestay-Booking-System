<?php


require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../managehomestay_add.php');

class ManageHomestayAddTest extends TestCase
{
    public function testAddHomestayWithoutImage()
    {
        // Mocking the POST data
        $_POST['hsname'] = "Test Homestay";
        $_POST['hsdesc'] = "A beautiful place";
        $_POST['hsprice'] = "50";

        // Simulating file upload
        $_FILES['fileToUpload'] = null; // No file

        // Call the function or execute the code to test
        ob_start();
        include(__DIR__ . '/../managehomestay_add_action.php');
        $output = ob_get_clean();

        $this->assertStringContainsString('Form data updated successfully!', $output);
    }

    public function testAddHomestayWithImage()
    {
        // Similar setup as above but include an image upload
        $_POST['hsname'] = "Test Homestay";
        $_POST['hsdesc'] = "A beautiful place";
        $_POST['hsprice'] = "50";

        // Mock the file upload
        $_FILES['fileToUpload'] = [
            'name' => 'testimage.jpg',
            'tmp_name' => '/tmp/php1234', // Use an actual temporary file or mock it
            'error' => 0,
            'size' => 50000
        ];

        ob_start();
        include(__DIR__ . '/../managehomestay_add_action.php');
        $output = ob_get_clean();

        $this->assertStringContainsString('Form data updated successfully!', $output);
    }
}
