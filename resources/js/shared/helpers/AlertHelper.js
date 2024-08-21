/*!
 * Emotality (c) 2024 AlertHelper.js
 */
export default class {
    constructor() {
        //
    }

    success = (_msg, _timer = 1900) => {
        this.custom('Success', _msg, 'success', _timer);
    }

    warning = (_msg, _timer = 2500) => {
        this.custom('Warning', _msg, 'warning', _timer);
    }

    error = (_msg, _timer = 3100) => {
        this.custom('Failed', _msg, 'error', _timer);
    }

    custom = (_title, _body, _icon, _timer) => {
        window.sweetAlert({
            title: _title,
            text: _body,
            icon: _icon,
            timer: _timer,
            buttons: false,
        });
    }
}
