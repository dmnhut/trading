import {
    common
} from '../container/index.js';

const ready = () => {

    common();
    eventHandler();
};

const eventHandler = () => {

    document.querySelector('#btn-back').addEventListener('click', event => {

        event.preventDefault();
        window.location.href = document.querySelector('input[name=_url_back]').value;
    });
};

export {
    ready as UsersInfo
};
