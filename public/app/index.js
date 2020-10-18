import { PageCommon } from './container/common';
import { DetailShippers } from './detail-shippers';
import { MapIndex } from './map';
import { MapLocation } from './map/location';
import { OrdersCreate } from './orders/create';
import { OrdersEdit } from './orders/edit';
import { Portal } from './portal';
import { Prices } from './prices';
import { Units } from './units';
import { UsersCreate } from './users/create';
import { UsersEdit } from './users/edit';
import { UsersInfo } from './users/info';

const ready = {
    PageCommon,
    DetailShippers,
    MapIndex,
    MapLocation,
    OrdersCreate,
    OrdersEdit,
    Portal,
    Prices,
    Units,
    UsersCreate,
    UsersEdit,
    UsersInfo
};
const documentQuery = $(document);
const onReadyHandler = () => {

    documentQuery.on('pjax:complete', run);
    run();
};
const run = () => {

    let objectQuery = document.querySelector('#object');
    ready[objectQuery.value].run();
};
documentQuery.ready(onReadyHandler);
