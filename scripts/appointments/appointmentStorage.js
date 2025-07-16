
class AppointmentStorage {
    static storageKey = 'pendingAppointment';

    static getAll() {
        return JSON.parse(localStorage.getItem(this.storageKey)) || {};
    }

    static set(key, value) {
        const data = this.getAll();
        data[key] = value;
        localStorage.setItem(this.storageKey, JSON.stringify(data));
    }

    static get(key) {
        return this.getAll()[key];
    }

    static hasAll(requiredKeys = []) {
        const data = this.getAll();
        return requiredKeys.every(key => key in data);
    }

    static clear() {
        localStorage.removeItem(this.storageKey);
    }
}
