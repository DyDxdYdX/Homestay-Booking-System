<?php
namespace App;

use App\Menus\{renderAdminMenu, renderHomeownerMenu, renderCustomerMenu};

function getMenu($usertype) {
    switch ($usertype) {
        case "1":
            renderAdminMenu();
            break;
        case "2":
            renderHomeownerMenu();
            break;
        default:
            renderCustomerMenu();
            break;
    }
}
