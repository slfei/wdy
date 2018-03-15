import './passport.styl'
import { Login } from './login'
import { Register } from './register'
import { BindPhone } from './bindPhone'
import { ResetPassword } from './resetPwd';
import Modal from './modal/modal'
import eventBus from './events';
import api from './api';

var classMap = {
    login: Login,
    register: Register,
    bindPhone: BindPhone,
    resetPassword: ResetPassword
};


/* todo  抽一个简易dom操作库  */

export class Passport {

    constructor (host) {
        this.modal = new Modal();
        this.viewMap = {};
        host && api.setHost(host);

        this.on('go-to-view', this.showView, this);
    }

    showView(view) {
        if (view !== this._curView) {
            this._curView && this.viewMap[this._curView].hide();
            if (!this.viewMap[view]) {
                this.viewMap[view] = new classMap[view](this.modal);
            }
            this.viewMap[view].show();
            this._curView = view;
        }
        this.modal.show();
        return this.viewMap[view];
    }

    hide () {
        this.modal.hide();
        return this;
    }

    getInstance(view) {
        return this.viewMap[view];
    }

    on (ev, callback) {
        eventBus.on(ev, callback, this);
        return this;
    }

    once (ev, callback) {
        eventBus.once(ev, callback, this);
        return this;
    }

    off (ev, callback) {
        eventBus.off(ev, callback, this);
        return this;
    }

    destroy () {
        this.modal.destroy();
        return this;
    }

    logout () {
        return api.logout().then((res) => {
            if (res.status == 200) {
                eventBus.emit('logoutSuccess');
            }
            return res;
        });
    }
}

var host = window.PASSPORT_HOST;
if (host) {
    // lost protocol
    if (host.indexOf('http:') != 0 && host.indexOf('//') != 0) {
        host = '//' + host;
    }
}
export var passport = new Passport(host);
