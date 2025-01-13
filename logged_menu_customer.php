<?php 
$current_page = basename($_SERVER['PHP_SELF']);

function isProfilePage() {
    global $current_page;
    return $current_page == 'profile.php' || $current_page == 'profile_edit.php';
}

function isCheckInOutPage() {
    global $current_page;
    return $current_page == 'checkin_checkout.php' || $current_page == 'checkin_checkout_add.php';
}

function isPaymentPage() {
    global $current_page;
    return $current_page == 'payment.php' || $current_page == 'payment_make.php';
}

function isFeedbackPage() {
    global $current_page;
    return $current_page == 'feedback.php' || $current_page == 'feedback_edit.php';
}

echo '<div class="nav" id="myTopnav">
    <a href="index.php" class="' . ($current_page == 'index.php' ? 'active' : '') . '"><i class="fa fa-fw fa-home"></i> Home</a>
    <a href="profile.php" class="' . (isProfilePage() ? 'active' : '') . '"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
    <a href="home_listing_customer.php" class="' . ($current_page == 'home_listing_customer.php' ? 'active' : '') . '"><i class="fa fa-bed" aria-hidden="true"></i> View Homestay</a>
    <a href="booking.php" class="' . ($current_page == 'booking.php' ? 'active' : '') . '"><i class="fa fa-location-arrow" aria-hidden="true"></i> Manage Booking</a>
    <a href="checkin_checkout.php" class="' . (isCheckInOutPage() ? 'active' : '') . '"><i class="fa fa-list-alt" aria-hidden="true"></i> Check In/Out</a>
    <a href="payment.php" class="' . (isPaymentPage() ? 'active' : '') . '"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Payment</a>
    <a href="feedback.php" class="' . (isFeedbackPage() ? 'active' : '') . '"><i class="fa fa-commenting-o" aria-hidden="true"></i> Feedback</a>
    <a href="logout.php" onClick="return confirm(\'Logout?\');"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
</div>';
?>
