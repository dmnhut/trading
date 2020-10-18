import {
    common
} from '../container/index';

const ready = {
    run: function() {
        
        common();
        eventHandler();
    }
};

const eventHandler = () => {

    document.querySelectorAll('label').forEach(label => {

        label.classList.add('active');
    });

    document.querySelector('#btn-back').addEventListener('click', event => {

        event.preventDefault();
        let url = document.querySelector('input[name=_url_back]').value;
        $.pjax({
            url,
            container: 'body'
        });
    });
};

export {
    ready as UsersInfo
};
