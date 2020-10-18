const NULL = null;
const NONE = 'none';
const BLANK = '';
const MATERIAL_PLACEHOLDER = 'material-placeholder';

const onClickCloseBtn = element => {

    let div = element.parentElement;
    const setDisplayNone = () => {

        div.style.display = NONE;
    };
    div.style.opacity = '0';
    setTimeout(setDisplayNone, 400);
};

const onFocusOutInputNumber = arrs => {

    arrs.forEach(id => {
        let idQuery = document.querySelector(id);
        idQuery.addEventListener('focusout', inputNumberFocusOutHandler);
        const inputNumberFocusOutHandler = () => {

            if (isNaN(Number(idQuery.value))) {
                idQuery.value = BLANK;
            }
        };
    });
};

const onInputSearchHandler = (txtQuery) => {

    if (NULL != txtQuery.value) {
        let count = 0;
        let rows = tableActivatedQuery.rows;
        for (let i = 1; i < rows.length; i = i + 1) {
            for (let cell = 0; cell < rows[i].childNodes.length; cell = cell + 1) {
                if (NULL != rows[i].childNodes[cell].firstChild) {
                    if (MATERIAL_PLACEHOLDER === rows[i].childNodes[cell].firstChild.className) {
                        continue;
                    }
                }
                if (0 !== rows[i].childNodes[cell].childNodes.length) {
                    if (rows[i].childNodes[cell].childNodes[0].nodeValue.toUpperCase().indexOf(txtQuery.value.toUpperCase()) > -1) {
                        rows[i].style.display = BLANK;
                        count++;
                        break;
                    } else {
                        rows[i].style.display = NONE;
                    }
                }
            }
        }
        if (0 === count) {
            rows[0].style.display = NONE;
        } else {
            rows[0].style.display = BLANK;
        }
    }
};

const common = () => {

    let documentQuery = $(document);
    let selectQuery = $('select');
    let sidenavQuery = $('.sidenav');
    let modalQuery = $('.modal');
    let tabsQuery = $('.tabs');
    let materialboxedQuery = $('.materialboxed');
    let tooltippedQuery = $('.tooltipped');
    let modalCloseQuery = document.querySelectorAll('.modal-close');
    let closebtnQuery = document.querySelectorAll('.closebtn');
    let txtQuery = document.querySelector('#txt');
    let tableActivatedQuery = document.querySelector('table.activated');
    let options = {
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
    console.clear();
    console.log('%cHACK!', 'color:black;font-family:monospace;font-size:2rem;font-weight:bold');
    window.history.pushState(NULL, BLANK, window.location.href);
    window.onpopstate = () => {

        window.history.pushState(NULL, BLANK, window.location.href);
    };
    window.M.AutoInit();
    documentQuery.pjax('a', 'body');
    selectQuery.formSelect();
    sidenavQuery.sidenav();
    modalQuery.modal({
        opacity: '0.2',
        dismissible: false
    });
    tabsQuery.tabs();
    materialboxedQuery.materialbox();
    tooltippedQuery.tooltip();
    modalCloseQuery.forEach(element => {

        let bodyQuery = document.querySelector('body');
        element.addEventListener('click', onModalCloseHandler);
        const onModalCloseHandler = () => {

            body.style.overflow = BLANK;
        }
    });
    closebtnQuery.forEach(element => {
        
        element.addEventListener('click', onClickCloseBtn(element));
    });
    txtQuery?.addEventListener('input', onInputSearchHandler({txtQuery, tableActivatedQuery}));
    toastr.options = options;
};

export {
    BLANK,
    NULL,
    NONE,
    onFocusOutInputNumber,
    common
};
