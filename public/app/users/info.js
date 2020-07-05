import {
    common
} from '../container/index.js';

$(document).ready(() => {

    ready();
});

const ready = () => {

    common();

    document.querySelector('#btn-back').addEventListener('click', event => {

        event.preventDefault();
        window.location.href = document.querySelector('input[name=_url_back]').value;
    });
};
