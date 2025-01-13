<?php
namespace App\Menus;

class HomeownerMenu {
    private $currentPage;

    public function __construct() {
        $this->currentPage = basename($_SERVER['PHP_SELF']);
    }

    private function isPage(array $pages): bool {
        return in_array($this->currentPage, $pages);
    }

    public function render() {
        echo '<div class="nav" id="myTopnav">
            <a href="index.php" class="' . ($this->isPage(['index.php']) ? 'active' : '') . '"><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="profile.php" class="' . ($this->isPage(['profile.php', 'profile_edit.php']) ? 'active' : '') . '"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
            <a href="managehomestay.php" class="' . ($this->isPage(['managehomestay.php', 'managehomestay_edit.php', 'managehomestay_add.php']) ? 'active' : '') . '"><i class="fa fa-bed" aria-hidden="true"></i> Manage Homestay</a>
            <a href="booking.php" class="' . ($this->isPage(['booking.php']) ? 'active' : '') . '"><i class="fa fa-location-arrow" aria-hidden="true"></i> Manage Booking</a>
            <a href="logout.php" onClick="return confirm(\'Logout?\');"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
        </div>';
    }
}
?>
