<?php
namespace App\Menus;

class AdminMenu {
    private $currentPage;

    public function __construct() {
        $this->currentPage = basename($_SERVER['PHP_SELF']);
    }

    private function isProfilePage(): bool {
        return in_array($this->currentPage, ['profile.php', 'profile_edit.php']);
    }

    private function isNewsPage(): bool {
        return in_array($this->currentPage, ['news.php', 'news_edit.php']);
    }

    public function render() {
        echo '<div class="nav" id="myTopnav">
            <a href="index.php" class="' . ($this->currentPage === 'index.php' ? 'active' : '') . '"><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="profile.php" class="' . ($this->isProfilePage() ? 'active' : '') . '"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
            <a href="report.php" class="' . ($this->currentPage === 'report.php' ? 'active' : '') . '"><i class="fa fa-book" aria-hidden="true"></i> Report</a>
            <a href="user_manage.php" class="' . ($this->currentPage === 'user_manage.php' ? 'active' : '') . '"><i class="fa fa-pencil-square" aria-hidden="true"></i> Manage User</a>
            <a href="news.php" class="' . ($this->isNewsPage() ? 'active' : '') . '"><i class="fa fa-pencil-square" aria-hidden="true"></i> News</a>
            <a href="logout.php" onClick="return confirm(\'Logout?\');"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
        </div>';
    }
}
