
import html from './register.html';
import './register.styl';
import api from '../api';
import * as codeMixin from '../codeMixin';
import ev from '../events';
import { validForm, showFieldError } from '../validator';

export class Register {
    constructor (modal) {
        this.modal = modal;
        this._init();

        this._isPicCodeValid = false;
    }

    _init () {
        this.modal.appendHTML(html);
        this.$el = this.modal.find('.register-modal-wrap');
        this.hide();
        this.initForm();
        this._bindCodeEvent();
        this.$el.querySelector('.go-to-login').addEventListener('click', function() {
            ev.trigger('go-to-view', 'login');
        });
    }


    hide () {
        this.$el.classList.add('hide');
        this.reset();
        return this;
    }

    show () {
        this.$el.classList.remove('hide');
        if (!this._isPicCodeValid) {
            this.getPicCode();
        }
        return this;
    }

    initForm () {
        var _this = this;
        this.$el.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (validForm(this)) {
                _this.register(this);
            }
        });

    }

    _getCodeForm () {
        return this.$el;
    }

    getCaptcha () {
        return api.getCaptcha({
            type: 1,
            phone:  this.$el.querySelector('.phone').value.trim()
        });
    }

    register (form) {
        var $code = form.querySelector('.mobile-code-input');
        var $password = form.querySelector('.password');

        var code = $code.value.trim();
        var password = $password.value.trim();

        return api.register({
            captcha: code,
            password: password,
            phone: form.querySelector('.phone').value.trim()
        }).then((res) => {
            if (res.status === 200) {
                ev.trigger('registerSuccess');
            } else {
                this.$el.querySelector('.error-tip').innerText = res.msg;
            }
        });
    }

    reset() {
        this._getCodeForm().querySelector('.row-pic-code').classList.remove('hide');
        this._getCodeForm().querySelector('.row-mobile-code').classList.add('hide');
        this.$el.querySelector('form').reset();
        this._isPicCodeValid = false;
        this._phoneValid = false;
        this._picCodeValid = false;

    }
}

codeMixin.mixTo(Register);