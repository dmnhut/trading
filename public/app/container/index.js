const NULL = null;

const onClickCloseBtn = element => {

    let div = element.parentElement;
    div.style.opacity = '0';

    setTimeout(() => {

        div.style.display = 'none';
    }, 400);
}

const onFocusOutInputNumber = ids => {

    ids.forEach(id => {

        document.querySelector(id).addEventListener('focusout', () => {

            if (isNaN(Number(document.querySelector(id).value))) {
                document.querySelector(id).value = '';
            }
        });
    });
}

const common = () => {

    console.clear();
    console.log('%cHACK!', 'color:black;font-family:monospace;font-size:2rem;font-weight:bold');

    window.history.pushState(NULL, '', window.location.href);

    window.onpopstate = () => {

        window.history.pushState(NULL, '', window.location.href);
    };

    // $(document).pjax('a', 'body');
    $('select').formSelect();
    $('.sidenav').sidenav();
    $('.modal').modal({
        opacity: '0.2',
        dismissible: false
    });
    $('.tabs').tabs();
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();

    document.querySelectorAll('.closebtn').forEach(element => {

        element.addEventListener('click', () => {

            onClickCloseBtn(element);
        });
    });

    document.querySelector('#txt')?.addEventListener('input', () => {

        if (NULL != document.querySelector('#txt').value) {
            let count = 0;
            let rows = document.querySelector('table.activated').rows;
            for (let i = 1; i < rows.length; i++) {
                for (let cell = 0; cell < rows[i].childNodes.length; cell++) {
                    if (NULL != rows[i].childNodes[cell].firstChild) {
                        if ('material-placeholder' === rows[i].childNodes[cell].firstChild.className) {
                            continue;
                        }
                    }
                    if (0 !== rows[i].childNodes[cell].childNodes.length) {
                        if (rows[i].childNodes[cell].childNodes[0].nodeValue.toUpperCase().indexOf(document.querySelector('#txt').value.toUpperCase()) > -1) {
                            rows[i].style.display = '';
                            count++;
                            break;
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                }
            }
            if (0 === count) {
                rows[0].style.display = 'none';
            } else {
                rows[0].style.display = '';
            }
        }
    });

    toastr.options = {
        'closeButton': false,
        'debug': false,
        'newestOnTop': false,
        'progressBar': false,
        'positionClass': 'toast-top-right',
        'preventDuplicates': false,
        'onclick': NULL,
        'showDuration': '300',
        'hideDuration': '1000',
        'timeOut': '8000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut'
    };
};

export {
    NULL,
    onFocusOutInputNumber,
    common
};
