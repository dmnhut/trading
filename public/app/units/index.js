import {
    common
} from '../container/index.js';

$(document).ready(() => {

    ready();
});

const ready = () => {

    common();

    document.querySelectorAll('label').forEach(label => {

        label.classList.remove('active');
    });

    document.querySelector('#name').value = '';

    document.querySelector('.btn-close').addEventListener('click', () => {

        $('.modal').modal('close');

        document.querySelectorAll('label').forEach(label => {

            label.classList.remove('active');
        });

        document.querySelector('#name').value = '';
    });

    document.querySelector('.fixed-action-btn').addEventListener('click', () => {

        $('#modal-add').modal('open');
    });

    document.querySelector('#btn-modal-add').addEventListener('click', () => {

        document.querySelector('.main-loader').style.display = '';

        axios.post(document.querySelector('#url').value, {
            _token: document.querySelector('input[name=_token]').value,
            name: document.querySelector('#name').value.trim()
        }).then(response => {

            document.querySelector('.main-loader').style.display = 'none';
            if (response.data.error) {
                response.data.messages.map(val => {
                    toastr.error(val);
                });
            } else {
                document.querySelector('#message').innerHTML = response.data.messages[0];
                $('#modal-message').modal('open');
            }
        }).catch(error => {

            console.log(error);
        });
    });
};
