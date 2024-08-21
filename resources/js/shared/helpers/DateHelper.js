/*!
 * Emotality (c) 2024 DateHelper.js
 */
export default class {
    constructor() {
        //
    }

    isFuture = (_dateTime) => {
        return new Date() < new Date(_dateTime);
    }

    isPast = (_dateTime) => {
        return new Date() > new Date(_dateTime);
    }

    humanDate = (_date) => {
        return window.moment(_date).format('ddd, D MMM YYYY, HH:mm:ss');
    }
}
