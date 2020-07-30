import {
    onFocusOutInputNumber,
    common
} from '../container/index';

const ready = () => {

    common();
    onFocusOutInputNumber(['#identity_card', '#phone']);
    eventHandler();
};

const eventHandler = () => {

    let text = JSON.parse($('input[name=_text]').val());
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        changeMonth: true,
        changeYear: true,
        i18n: {
            cancel: text['cancel'],
            clear: text['clear'],
            done: text['done'],
            months: text['months'],
            monthsShort: text['monthsShort'],
            weekdays: text['weekdays'],
            weekdaysShort: text['weekdaysShort'],
            weekdaysAbbrev: text['weekdaysAbbrev']
        }
    });

    document.querySelectorAll('input + label').forEach(label => {

        label.classList.add('active');
    });

    document.querySelector('.datepicker-calendar-container').classList.add(...['grey', 'darken-3', 'white-text']);
    $('.datepicker').datepicker('setDate', new Date(document.querySelector('#birthdate').value.split('/')[2], document.querySelector('#birthdate').value.split('/')[1] - 1, document.querySelector('#birthdate').value.split('/')[0], '00', '00', '00'));

    document.querySelector('#btn-edit').addEventListener('click', event => {

        event.preventDefault();
        document.querySelector('.main-loader').style.display = '';
        let data = new FormData(document.querySelector('#users-edit'));
        $.ajax({
            method: 'POST',
            enctype: 'multipart/form-data',
            url: document.querySelector('#users-edit').action,
            contentType: false,
            processData: false,
            data: data,
            success: response => {

                document.querySelector('.main-loader').style.display = 'none';
                if (response.error) {
                    response.messages.map(val => {
                        toastr.error(val);
                    });
                } else {
                    document.querySelector('#message').innerHTML = response.messages[0];
                    $('#modal-message').modal('open');
                }
            }
        });
    });
};

export {
    ready as UsersEdit
};
