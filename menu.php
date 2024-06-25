<?php
$current_page = basename($_SERVER['PHP_SELF']);

echo '<div class="nav" id="myTopnav">
    <a href="index.php" class="' . ($current_page == 'index.php' ? 'active' : '') . '"><i class="fa fa-fw fa-home"></i> Home</a>
    <a href="login.php" class="' . ($current_page == 'login.php' ? 'active' : '') . '"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
</div>';
?>