import {
    BLANK,
    NONE,
    common,
    onFocusOutInputNumber
} from '../container/index';

const ready = {
    run: function() {

        common();
        onFocusOutInputNumber(['#kg', '#amount']);
        eventHandler();
    }
};

const eventHandler = () => {

    document.querySelectorAll('label').forEach(label => {

        label.classList.remove('active');
    });

    document.querySelector('#kg').value = BLANK;
    document.querySelector('#amount').value = BLANK;

    document.querySelector('#btn-cancel').addEventListener('click', () => {

        $('.modal').modal('close');

        document.querySelectorAll('label').forEach(label => {

            label.classList.remove('active');
        });

        document.querySelector('#kg').value = BLANK;
        document.querySelector('#amount').value = BLANK;
    });

    document.querySelector('#btn-add').addEventListener('click', () => {

        let messages = [];
        let {
            amount,
            kg,
        } = JSON.parse($('input[name=_messages]').val());
        if (0 === document.querySelector('#amount').value.length) {
            messages.push(amount);
        }
        if (0 === document.querySelector('#kg').value.length) {
            messages.push(kg);
        }
        if (messages.length > 0) {
            toastr.error(messages.join('<br>'));
            return;
        }
        document.querySelector('.main-loader').style.display = BLANK;

        axios.post(location, {
            '_token': document.querySelector('input[name=_token]').value,
            'kg': document.querySelector('#kg').value,
            'amount': document.querySelector('#amount').value
        }).then(response => {

            $('#tbl').html(BLANK);

            document.querySelectorAll('label').forEach(label => {

                label.classList.remove('active');
            });

            document.querySelector('#kg').value = BLANK;
            document.querySelector('#amount').value = BLANK;
            let tbody = BLANK;

            response.data.data.map(val => {

                tbody += `<tr>`;
                tbody += `<td data-label='${document.querySelector('#th-kg').textContent}'>${val.kg}</td>`;
                tbody += `<td data-label='${document.querySelector('#th-amount').textContent}'>${val.amount}</td>`;
                tbody += `<td data-label='${document.querySelector('#th-status').textContent}'>`;
                tbody += `<form method='POST' action='${location}/status'>`;
                tbody += `<input type='hidden' name='_token' value='${document.querySelector('input[name="_token"]').value}'>`;
                tbody += `<input type='hidden' name='id' value='${val.id}'></input>`;
                if (0 == val.turn_on) {
                    tbody += `<button class='waves-effect waves-light btn btn-small green darken-3'>bật</button>`;
                } else {
                    tbody += `<button class='waves-effect waves-light btn btn-small green darken-3'>tắt</button>`;
                }
                tbody += `</form>`;
                tbody += `</td>`;
                tbody += `<td data-label='${document.querySelector('#th-delete').textContent}'>`;
                tbody += `<form method='POST' action='${val.url}'>`;
                tbody += `<input type='hidden' name='_method' value='DELETE'>`;
                tbody += `<input type='hidden' name='_token' value='${document.querySelector('input[name=_token]').value}'>`;
                tbody += `<button class='waves-effect waves-light btn btn-small grey darken-2'>xóa</button>`;
                tbody += `</form>`;
                tbody += `</td>`;
                tbody += `</tr>`;
            });

            $('.modal').modal('close');
            $('#tbl').html(tbody);
            document.querySelector('.main-loader').style.display = NONE;
            toastr.success(response.data.message);
        }).catch(error => {

            console.log(error);
        });
    });
};

export {
    ready as Prices
};
