export class DateTimeFormater {
    constructor(time) {
        this.time = time;
    }

    message_time() {
        if(!this.time || this.time.trim() == '') return '';
        const date = new Date(this.time);
        return date.toISOString().slice(0, 19).replace('T', ' ');
    }
}