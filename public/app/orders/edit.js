import {
    onFocusOutInputNumber,
    common
} from '../container/index.js';

$(document).ready(() => {

    ready();
});

const ready = () => {

    common();
    onFocusOutInputNumber(['#phone', '#quantity']);
    clear();
    printCode();


    document.querySelector('#btn-back').addEventListener('click', event => {

        event.preventDefault();
        window.location.href = document.querySelector('input[name=_url_orders]').value.slice(0, -2);
    });

    document.querySelector('#btn-reload').addEventListener('click', event => {

        event.preventDefault();
        location.href = location.toLocaleString();
    });

    document.querySelector('#btn-add-item').addEventListener('click', event => {

        event.preventDefault();
        let messages = [];
        let {
            item,
            unit,
            quantity
        } = JSON.parse($('input[name=_messages]').val());
        let validate = JSON.parse($('input[name=_validator]').val());
        if (0 === document.querySelector('#item').value.length) {
            messages.push(item);
        }
        if (0 === $('#unit').formSelect('getSelectedValues').length) {
            messages.push(unit);
        }
        if (0 === document.querySelector('#quantity').value.length) {
            messages.push(quantity);
        } else {
            if (Array.isArray(document.querySelector('#quantity').value.match(new RegExp(validate.quantity.re)))) {
                messages.push(validate.quantity.error);
            }
        }
        if (0 !== messages.length) {
            document.querySelector('.message.items').style.display = '';
            document.querySelector('.message.form').style.display = 'none';
            $('.alert').html('<span class="closebtn" type="items" onclick="removeMessage($(this))">&times;</span>');

            messages.map(val => {

                $('.alert').append(val + '<br>');
            });

            document.querySelector('.alert').style.display = '';
            document.querySelector('.section.error').style.display = '';
            return;
        }
        let row = document.createElement('tr');
        row.appendChild(document.createElement('td'));
        row.appendChild(document.createElement('td'));
        row.appendChild(document.createElement('td'));
        row.appendChild(document.createElement('td'));
        row.childNodes[0].appendChild(document.createTextNode(document.querySelector('#item').value));
        row.childNodes[0].setAttribute('data', document.querySelector('#item').value);
        row.childNodes[1].appendChild(document.createTextNode($('#unit>option:selected').html()));
        row.childNodes[1].setAttribute('data', $('#unit').formSelect()[0].selectedOptions[0].value);
        row.childNodes[2].appendChild(document.createTextNode(document.querySelector('#quantity').value));
        row.childNodes[2].setAttribute('data', document.querySelector('#quantity').value);
        row.childNodes[3].innerHTML = '<button class="waves-effect waves-light btn red" onclick="removeRow($(this))"><i class="small material-icons">close</i></button>';
        document.querySelector('#items').appendChild(row);
        $('#items').parents().css('display', '');
    });


    document.querySelector('#kg').addEventListener('change', () => {

        document.querySelector('#total-amount').value = $('#kg').formSelect()[0].selectedOptions[0].value.split('-')[1] + ' VND';
        document.querySelector('#total-amount').setAttribute('data', $('#kg').formSelect()[0].selectedOptions[0].value.split('-')[0]);
    });

    document.querySelector('#province').addEventListener('change', () => {

        document.querySelector('.main-loader').style.display = '';
        $('#district').empty();
        $('#district').prop('disabled', true);
        $('#district').formSelect();
        $('#ward').empty();
        $('#ward').prop('disabled', true);
        $('#ward').formSelect();

        axios.get(document.querySelector('input[name=_url_districts]').value, {
            params: {
                id: $('#province').formSelect()[0].selectedOptions[0].value
            }
        }).then(response => {

            response.data.forEach(element => {

                let opt = document.createElement('option');
                opt.value = element.id;
                opt.innerHTML = element.text;
                document.querySelector('#district').appendChild(opt);
            });

            $('#district').prop('disabled', false);
            $('#district').formSelect();

            axios.get(document.querySelector('input[name=_url_wards]').value, {
                params: {
                    id: $('#district').formSelect('getSelectedValues').pop()
                }
            }).then(response => {

                response.data.forEach(element => {

                    let opt = document.createElement('option');
                    opt.value = element.id;
                    opt.innerHTML = element.text;
                    document.querySelector('#ward').appendChild(opt);
                });

                $('#ward').prop('disabled', false);
                $('#ward').formSelect();
                document.querySelector('#address').value = [
                    $('#' + $('#province').parent().children()[1].id + '>li.selected').text(),
                    $('#' + $('#district').parent().children()[1].id + '>li.selected').text(),
                    $('#' + $('#ward').parent().children()[1].id + '>li.selected').text()
                ].join(', ');
                document.querySelector('label[for=address]').classList.add('active');
            }).catch(error => {

                console.log(error);
            }).finally(() => {

                document.querySelector('.main-loader').style.display = 'none';
            });
        }).catch(error => {
            console.log(error);
        })
    });

    document.querySelector('#district').addEventListener('change', () => {

        document.querySelector('.main-loader').style.display = '';
        $('#ward').empty();
        $('#ward').prop('disabled', true);
        $('#ward').formSelect();

        axios.get(document.querySelector('input[name=_url_wards]').value, {
            params: {
                id: $('#district').formSelect()[0].selectedOptions[0].value
            }
        }).then(response => {

            response.data.forEach(element => {

                let opt = document.createElement('option');
                opt.value = element.id;
                opt.innerHTML = element.text;
                document.querySelector('#ward').appendChild(opt);
            });

            $('#ward').prop('disabled', false);
            $('#ward').formSelect();
            document.querySelector('#address').value = [
                $('#' + $('#province').parent().children()[1].id + '>li.selected').text(),
                $('#' + $('#district').parent().children()[1].id + '>li.selected').text(),
                $('#' + $('#ward').parent().children()[1].id + '>li.selected').text()
            ].join(', ');
            document.querySelector('label[for=address]').classList.add('active');
        }).catch(error => {

            console.log(error);
        }).finally(() => {

            document.querySelector('.main-loader').style.display = 'none';
        });
    });

    document.querySelector('#ward').addEventListener('change', () => {

        document.querySelector('#address').value = [
            $('#' + $('#province').parent().children()[1].id + '>li.selected').text(),
            $('#' + $('#district').parent().children()[1].id + '>li.selected').text(),
            $('#' + $('#ward').parent().children()[1].id + '>li.selected').text()
        ].join(', ');
        document.querySelector('label[for=address]').classList.add('active');
    });

    document.querySelector('#btn-edit').addEventListener('click', event => {

        event.preventDefault();
        let messages = [];
        let {
            items,
            province,
            district,
            ward,
            address,
            receiver,
            phone,
            kg
        } = JSON.parse($('input[name=_messages]').val());
        let listItems = getDataItems();
        if (0 === listItems.length) {
            messages.push(items);
        }
        if (0 === $('#province').formSelect('getSelectedValues')[0]) {
            messages.push(province);
        }
        if (0 === $('#district').formSelect('getSelectedValues')[0]) {
            messages.push(district);
        }
        if (0 === $('#ward').formSelect('getSelectedValues')[0]) {
            messages.push(ward);
        }
        if ('' === document.querySelector('#address').value) {
            messages.push(address);
        }
        if ('' === document.querySelector('#receiver').value) {
            messages.push(receiver);
        }
        if ('' === document.querySelector('#phone').value) {
            messages.push(phone);
        }
        if (0 === $('#kg').formSelect('getSelectedValues')[0]) {
            messages.push(kg);
        }
        if (0 !== messages.length) {
            document.querySelector('.message.form').style.display = '';
            document.querySelector('.message.items').style.display = 'none';
            $('.alert').html('<span class="closebtn" type="form" onclick="removeMessage($(this))">&times;</span>');

            messages.map(val => {

                $('.alert').append(val + '<br>');
            });

            document.querySelector('.alert').style.display = '';
            document.querySelector('.section.error').style.display = '';
            return;
        }
        let params = {};
        params._token = document.querySelector('input[name=_token]').value;
        params._method = document.querySelector('input[name=_method]').value;
        params.code = document.querySelector('#code').value;
        params.items = JSON.stringify(listItems);
        params.user = $('#user').formSelect()[0].selectedOptions[0].value;
        params.province = $('#province').formSelect()[0].selectedOptions[0].value;
        params.district = $('#district').formSelect()[0].selectedOptions[0].value;
        params.ward = $('#ward').formSelect()[0].selectedOptions[0].value;
        params.address = document.querySelector('#address').value;
        params.receiver = document.querySelector('#receiver').value;
        params.phone = document.querySelector('#phone').value;
        params.kg = $('#kg').formSelect()[0].selectedOptions[0].value.split('-')[0];
        params.total_amount = document.querySelector('#total-amount').value.split(' ')[0];

        geocode(params.address).then(value => {

            params.lat = String(value.latitude);
            params.lng = String(value.longitude);
            document.querySelector('.main-loader').style.display = '';

            axios.put(document.querySelector('input[name=_url_orders]').value, params).then(response => {

                if (response.data.error) {
                    document.querySelector('.message.form').style.display = '';
                    document.querySelector('.message.items').style.display = 'none';
                    $('.alert').html('<span class="closebtn" type="form" onclick="removeMessage($(this))">&times;</span>');
                    $('.alert').append(response.data.message);
                    document.querySelector('.alert').style.display = '';
                    document.querySelector('.section.error').style.display = '';
                    document.querySelector('.main-loader').style.display = 'none';
                } else {
                    document.querySelector('#message').innerHTML = response.data.message;
                    document.querySelector('.main-loader').style.display = 'none';
                    document.querySelector('.alert').style.display = 'none';
                    document.querySelector('.section.error').style.display = 'none';
                    document.querySelector('.message.form').style.display = 'none';
                    document.querySelector('.message.items').style.display = 'none';
                    document.querySelector('.main-loader').style.display = 'none';
                    $('#modal-message').modal('open');
                }
            }).catch(error => {

                console.log(error);
            });
        });
    });
};

const printCode = () => {

    JsBarcode('#barcode', document.querySelector('#code').value, {
        width: 1,
        height: 80,
        displayValue: true
    });
    document.querySelector('#qrcode').innerHTML = '';
    QRCode.toCanvas(
        document.querySelector('#qrcode'), document.querySelector('#code').value
    );
}

const clear = () => {

    $('#quantity').parent().children().last().removeClass('active');
    $('select').formSelect('destroy');
    $('select').formSelect();
    document.querySelector('#item').value = '';
    document.querySelector('#quantity').value = '';
    document.querySelector('.alert').style.display = 'none';
    document.querySelector('.section.error').style.display = 'none';
    document.querySelector('.message.items').style.display = 'none';
    document.querySelector('.message.form').style.display = 'none';
};

const geocode = async text => {

    window.apikey = 'rdPtJTe3tAU-3NtGSN8ZaPeJGm63EsYwqSFwxEzmBYg';
    let platform = new H.service.Platform({
        apikey: window.apikey
    });
    let geocoder = platform.getGeocodingService(),
        geocodingParameters = {
            searchText: text,
            jsonattributes: 1
        };
    let locations = {};
    await geocoder.geocode(
        geocodingParameters,
        result => {
            locations = result.response.view[0].result[0].location.displayPosition;
        },
        error => {
            console.log(error);
        }
    );
    return locations;
};

window.removeRow = node => {

    event.preventDefault();
    node.parents('tr').remove();
    if (0 === $('#items').children().length) {
        $('#items').parents('table').css('display', 'none');
    }
};

window.removeMessage = node => {

    setTimeout(() => {

        node.parent().css('display', 'none');
        document.querySelector('.section.error').style.display = 'none';
    }, 400);

    document.querySelector('.message.items').style.display = 'none';
    document.querySelector('.message.form').style.display = 'none';
};

const getDataItems = () => {

    let result = [];
    let arr = Array.from(document.querySelector('#items').children);
    if (0 === arr.length) {
        return result;
    }

    Array.from(document.querySelector('#items').children).forEach(el => {

        let dataTable = {
            item_name: el.children[0].getAttribute('data'),
            id_unit: el.children[1].getAttribute('data'),
            quantity: el.children[2].getAttribute('data')
        };
        result.push(dataTable);
    });

    return result;
};
