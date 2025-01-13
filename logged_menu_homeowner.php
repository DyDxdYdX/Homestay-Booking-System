<?php
$current_page = basename($_SERVER['PHP_SELF']);

function isProfilePage() {
    global $current_page;
    return $current_page == 'profile.php' || $current_page == 'profile_edit.php';
}

function isHomestayPage() {
    global $current_page;
    return $current_page == 'managehomestay.php' || $current_page == 'managehomestay_edit.php' || $current_page == 'managehomestay_add.php';
}

echo '<div class="nav" id="myTopnav">
    <a href="index.php" class="' . ($current_page == 'index.php' ? 'active' : '') . '"><i class="fa fa-fw fa-home"></i> Home</a>
    <a href="profile.php" class="' . (isProfilePage() ? 'active' : '') . '"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
    <a href="managehomestay.php" class="' . (isHomestayPage() ? 'active' : '') . '"><i class="fa fa-bed" aria-hidden="true"></i> Manage Homestay</a>
    <a href="booking.php" class="' . ($current_page == 'booking.php' ? 'active' : '') . '"><i class="fa fa-location-arrow" aria-hidden="true"></i> Manage Booking</a>
    <a href="logout.php" onClick="return confirm(\'Logout?\');"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
</div>';
?>
