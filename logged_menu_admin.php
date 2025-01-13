<?php
$current_page = basename($_SERVER['PHP_SELF']);

function isProfilePage() {
    global $current_page;
    return $current_page == 'profile.php' || $current_page == 'profile_edit.php';
}

function isNewsPage() {
    global $current_page;
    return $current_page == 'news.php' || $current_page == 'news_edit.php';
}

echo '<div class="nav" id="myTopnav">
    <a href="index.php" class="' . ($current_page == 'index.php' ? 'active' : '') . '"><i class="fa fa-fw fa-home"></i> Home</a>
    <a href="profile.php" class="' . (isProfilePage() ? 'active' : '') . '"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
    <a href="report.php" class="' . ($current_page == 'report.php' ? 'active' : '') . '"><i class="fa fa-book" aria-hidden="true"></i> Report</a>
    <a href="user_manage.php" class="' . ($current_page == 'user_manage.php' ? 'active' : '') . '"><i class="fa fa-pencil-square" aria-hidden="true"></i> Manage User</a>
    <a href="news.php" class="' . (isNewsPage() ? 'active' : '') . '"><i class="fa fa-pencil-square" aria-hidden="true"></i> News</a>
    <a href="logout.php" onClick="return confirm(\'Logout?\');"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
</div>';
?>
