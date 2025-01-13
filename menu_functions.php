<?php

function getMenu($usertype) {
    switch ($usertype) {
        case "1":
            include_once 'logged_menu_admin.php';
        
            break;
        case "2":
            include_once 'logged_menu_homeowner.php';
        
            break;
        default:
            include_once 'logged_menu_customer.php';
       
            break;
    }

    $menu->render();
}
?>
