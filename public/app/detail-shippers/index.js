import {
    common
} from '../container/index';

const ready = () => {

    common();
    formSelect();
    eventHandler();
};

const formSelect = () => {

    $('#province').formSelect('destroy');
    $('#province').empty();
    $('#province').formSelect();
    $('#district').formSelect('destroy');
    $('#district').empty();
    $('#district').prop('disabled', true);
    $('#district').formSelect();
    $('#ward').formSelect('destroy');
    $('#ward').empty();
    $('#ward').prop('disabled', true);
    $('#ward').formSelect();
}

const eventHandler = () => {

    document.querySelector('.btn-close').addEventListener('click', () => {

        formSelect();
    });

    document.querySelector('#province').addEventListener('change', () => {

        document.querySelector('.main-loader').style.display = ''
        $('#district').empty();
        $('#district').prop('disabled', true);
        $('#district').formSelect();
        $('#ward').empty();
        $('#ward').prop('disabled', true);
        $('#ward').formSelect();

        axios.get(document.querySelector('#districts').value, {
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

            axios.get(document.querySelector('#wards').value, {
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
            }).catch(error => {

                console.log(error);
            }).finally(() => {

                document.querySelector('.main-loader').style.display = 'none';
            });
        }).catch(error => {

            console.log(error);
        });
    });

    document.querySelector('#district').addEventListener('change', () => {

        document.querySelector('.main-loader').style.display = '';
        $('#ward').empty();
        $('#ward').prop('disabled', true);
        $('#ward').formSelect();

        axios.get(document.querySelector('#wards').value, {
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
        }).catch(error => {

            console.log(error);
        }).finally(() => {

            document.querySelector('.main-loader').style.display = 'none';
        });
    });

    document.querySelectorAll('.btn-cu').forEach(element => {

        element.addEventListener('click', () => {

            let captions = JSON.parse(document.querySelector('input[name=_captions]').value);
            if ('update' === element.getAttribute('mode')) {
                $('#btn-modal-cu').html(captions['update']);
                document.querySelector('input[name=_mode]').value = 'update';
            } else {
                $('#btn-modal-cu').html(captions['add']);
                document.querySelector('input[name=_mode]').value = 'add';
            }
            document.querySelector('#usrname').innerHTML = element.getAttribute('usrname');
            document.querySelector('input[name=_id_shipper]').value = element.getAttribute('id_shipper');
            document.querySelector('.main-loader').style.display = '';
            document.querySelector('input[name=_id]').value = element.getAttribute('data');

            axios.get(document.querySelector('#provinces').value).then(response => {

                response.data.forEach(element => {

                    let opt = document.createElement('option');
                    opt.value = element.id;
                    opt.innerHTML = element.text;
                    document.querySelector('#province').appendChild(opt);
                });

                if ('update' === element.getAttribute('mode')) {
                    $('#province').val(element.getAttribute('province'));
                }
                $('#province').formSelect();

                axios.get(document.querySelector('#districts').value, {
                    params: {
                        id: $('#province').formSelect('getSelectedValues').pop()
                    }
                }).then(response => {

                    $('#district').empty();

                    response.data.forEach(element => {

                        let opt = document.createElement('option');
                        opt.value = element.id;
                        opt.innerHTML = element.text;
                        document.querySelector('#district').appendChild(opt);
                    });

                    $('#district').prop('disabled', false);
                    if ('update' === element.getAttribute('mode')) {
                        $('#district').val(element.getAttribute('district'));
                    }
                    $('#district').formSelect();

                    axios.get(document.querySelector('#wards').value, {
                        params: {
                            id: $('#district').formSelect('getSelectedValues').pop()
                        }
                    }).then(response => {

                        $('#ward').empty();

                        response.data.forEach(element => {

                            let opt = document.createElement('option');
                            opt.value = element.id;
                            opt.innerHTML = element.text;
                            document.querySelector('#ward').appendChild(opt);
                        });

                        $('#ward').prop('disabled', false);
                        if ('update' === element.getAttribute('mode')) {
                            $('#ward').val(element.getAttribute('ward'));
                        }
                        $('#ward').formSelect();
                    }).catch(error => {

                        console.log(error);
                    }).finally(() => {

                        document.querySelector('.main-loader').style.display = 'none';
                        $('#modal-area').modal('open');
                    });
                }).catch(error => {

                    console.log(error);
                });
            }).catch(error => {

                console.log(error);
            });
        });
    });

    document.querySelectorAll('.btn-detail').forEach(element => {

        let id = element.getAttribute('data');

        element.addEventListener('click', () => {

            document.querySelector('.main-loader').style.display = '';
            let data = {
                _token: document.querySelector('input[name=_token]').value,
                id: id
            }

            axios.post(document.querySelector('#modal-detail').getAttribute('url'), data).then(response => {

                if (response.data.error) {
                    $('.btn-close').click();
                    document.querySelector('#message').innerHTML = response.data.message;
                    document.querySelector('.main-loader').style.display = 'none';
                    $('#modal-message').modal('open');
                } else {
                    document.querySelector('#detail-name').innerHTML = response.data.name;
                    document.querySelector('#detail-birthdate').innerHTML = response.data.birthdate;
                    document.querySelector('#detail-email').innerHTML = response.data.email;
                    document.querySelector('#detail-identity_card').innerHTML = response.data.identity_card;
                    document.querySelector('#detail-phone').innerHTML = response.data.phone;
                    document.querySelector('#detail-gender').innerHTML = response.data.gender;
                    document.querySelector('.main-loader').style.display = 'none';
                    $('#modal-detail').modal('open');
                }
            }).catch(error => {

                console.log(error);
            });
        });
    });

    document.querySelector('#btn-modal-cu').addEventListener('click', () => {

        document.querySelector('.main-loader').style.display = '';
        if (0 === $('#province').formSelect('getSelectedValues') ||
            0 === $('#district').formSelect('getSelectedValues') ||
            0 === $('#ward').formSelect('getSelectedValues')) {
            console.log('wait loading...');
            return false;
        }
        let data = {
            _token: document.querySelector('input[name=_token]').value,
            user: document.querySelector('input[name=_id]').value,
            province: $('#province').formSelect()[0].selectedOptions[0].value,
            district: $('#district').formSelect()[0].selectedOptions[0].value,
            ward: $('#ward').formSelect()[0].selectedOptions[0].value
        };
        if ('update' === document.querySelector('input[name=_mode]').value) {
            data._method = 'PUT';
        }

        axios.post([document.querySelector('#url').value, '/', document.querySelector('input[name=_id_shipper]').value].join(''), data).then(response => {

            if (response.data.error) {
                $('.btn-close').click();
            }
            document.querySelector('#message').innerHTML = response.data.message;
            document.querySelector('.main-loader').style.display = 'none';
            $('#modal-message').modal('open');
        }).catch(error => {

            console.log(error);
        });
    });
};

export {
    ready as DetailShippers
};
