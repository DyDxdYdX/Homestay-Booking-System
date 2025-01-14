<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../managehomestay_edit.php');

class ManageHomestayEditTest extends TestCase
{
    public function testEditHomestayWithoutImage()
    {
        // Mocking the POST data for editing a homestay
        $_POST['hsname'] = "Updated Homestay";
        $_POST['hsdesc'] = "Updated description";
        $_POST['hsprice'] = "60";
        $_POST['hslistID'] = 1; // Assuming an ID of 1 for the homestay

        // Simulating file upload (no file)
        $_FILES['fileToUpload'] = null;

        // Call the code to test
        ob_start();
        include(__DIR__ . '/../managehomestay_edit_action.php');
        $output = ob_get_clean();

        $this->assertStringContainsString('Homestay updated successfully!', $output);
    }

    public function testEditHomestayWithImage()
    {
        // Mocking the POST data for editing a homestay
        $_POST['hsname'] = "Updated Homestay";
        $_POST['hsdesc'] = "Updated description";
        $_POST['hsprice'] = "60";
        $_POST['hslistID'] = 1; // Assuming an ID of 1 for the homestay

        // Mock the file upload
        $_FILES['fileToUpload'] = [
            'name' => 'updatedimage.jpg',
            'tmp_name' => '/tmp/php1234', // Temporary file path
            'error' => 0,
            'size' => 50000
        ];

        // Call the code to test
        ob_start();
        include(__DIR__ . '/../managehomestay_edit_action.php');
        $output = ob_get_clean();

        $this->assertStringContainsString('Homestay updated successfully!', $output);
    }
}
