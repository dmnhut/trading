import {
    PageCommon
} from './container/common';
import {
    DetailShippers
} from './detail-shippers';
import {
    MapIndex
} from './map';
import {
    MapLocation
} from './map/location';
import {
    OrdersCreate
} from './orders/create';
import {
    OrdersEdit
} from './orders/edit';
import {
    Portal
} from './portal';
import {
    Prices
} from './prices';
import {
    Units
} from './units';
import {
    UsersCreate
} from './users/create';
import {
    UsersEdit
} from './users/edit';
import {
    UsersInfo
} from './users/info';

$(document).ready(() => {

    let object = document.querySelector('#object').value;
    if ('PageCommon' === object) {
        PageCommon();
    }
    if ('DetailShippers' === object) {
        DetailShippers();
    }
    if ('MapIndex' === object) {
        MapIndex();
    }
    if ('MapLocation' === object) {
        MapLocation();
    }
    if ('OrdersCreate' === object) {
        OrdersCreate();
    }
    if ('OrdersEdit' === object) {
        OrdersEdit();
    }
    if ('Portal' === object) {
        Portal();
    }
    if ('Prices' === object) {
        Prices();
    }
    if ('Units' === object) {
        Units();
    }
    if ('UsersCreate' === object) {
        UsersCreate();
    }
    if ('UsersEdit' === object) {
        UsersEdit();
    }
    if ('UsersInfo' === object) {
        UsersInfo();
    }
});
