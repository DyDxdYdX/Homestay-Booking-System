<?php
namespace App;

use App\Menus\{AdminMenu, CustomerMenu, HomeownerMenu};

function getMenu($usertype) {
    switch ($usertype) {
        case "1": // Admin
            $menu = new AdminMenu();
            break;
        case "2": // Homeowner
            $menu = new HomeownerMenu();
            break;
        default: // Customer
            $menu = new CustomerMenu();
            break;
    }

    $menu->render();
}
?>
