<?php
namespace App\Menus;

class CustomerMenu {
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
            <a href="home_listing_customer.php" class="' . ($this->isPage(['home_listing_customer.php']) ? 'active' : '') . '"><i class="fa fa-bed" aria-hidden="true"></i> View Homestay</a>
            <a href="booking.php" class="' . ($this->isPage(['booking.php']) ? 'active' : '') . '"><i class="fa fa-location-arrow" aria-hidden="true"></i> Manage Booking</a>
            <a href="checkin_checkout.php" class="' . ($this->isPage(['checkin_checkout.php', 'checkin_checkout_add.php']) ? 'active' : '') . '"><i class="fa fa-list-alt" aria-hidden="true"></i> Check In/Out</a>
            <a href="payment.php" class="' . ($this->isPage(['payment.php', 'payment_make.php']) ? 'active' : '') . '"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Payment</a>
            <a href="feedback.php" class="' . ($this->isPage(['feedback.php', 'feedback_edit.php']) ? 'active' : '') . '"><i class="fa fa-commenting-o" aria-hidden="true"></i> Feedback</a>
            <a href="logout.php" onClick="return confirm(\'Logout?\');"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
        </div>';
    }
}
?>
