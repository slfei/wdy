
import html from './index.html';
import './index.styl';
import api from '../api';
import * as codeMixin from '../codeMixin';
import ev from '../events';
import { validForm, showFieldError } from '../validator';

export class ResetPassword {
    constructor (modal) {
        this.modal = modal;
        this._init();

        this._isPicCodeValid = false;
    }

    _init () {
        this.modal.appendHTML(html);
        this.$el = this.modal.find('.reset-password-modal-wrap');
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
        this.showStep1();
        return this;
    }

    initForm () {
        var _this = this;
        this.$el.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (validForm(this)) {
                _this.submit(this);
            }
        });
        this.$el.querySelector('.backward').addEventListener('click', () => {
            this._isPicCodeValid = false;
            this.getPicCode();
            this.showStep1();
            var $phone = this.$el.querySelector('.phone');
            $phone.focus();
            $phone.select();
        });

        ev.on('picCodeValid', (context) => {
            if (context !== this) return ;
            this.showStep2();
        });

    }

    showStep1 () {
        var $root = this.$el;
        var $phone = $root.querySelector('.phone').parentNode;
        var $picCode = $root.querySelector('.row-pic-code');
        var $mobileCode = $root.querySelector('.row-mobile-code');
        var $rowPassword = $root.querySelectorAll('.row-password');
        var $login = $root.querySelector('.go-to-login');
        var $backward = $root.querySelector('.backward');

        $phone.classList.remove('hide');
        $picCode.classList.remove('hide');
        $picCode.querySelector('.pic-code-input').value = '';
        $mobileCode.classList.add('hide');
        $login.classList.remove('hide');
        $backward.classList.add('hide');
        Array.prototype.slice.call($rowPassword).forEach(el => el.classList.add('hide'));
    }

    showStep2 () {
        var $root = this.$el;
        var $phone = $root.querySelector('.phone').parentNode;
        var $picCode = $root.querySelector('.row-pic-code');
        var $mobileCode = $root.querySelector('.row-mobile-code');
        var $rowPassword = $root.querySelectorAll('.row-password');
        var $login = $root.querySelector('.go-to-login');
        var $backward = $root.querySelector('.backward');

        $phone.classList.add('hide');
        $picCode.classList.add('hide');
        $mobileCode.classList.remove('hide');
        $login.classList.add('hide');
        $backward.classList.remove('hide');
        Array.prototype.slice.call($rowPassword).forEach(el => el.classList.remove('hide'));
    }

    _getCodeForm () {
        return this.$el;
    }

    getCaptcha () {
        return api.getCaptcha({
            type: 3,
            phone:  this.$el.querySelector('.phone').value.trim()
        });
    }

    submit (form) {
        if (!this._isPicCodeValid) return ;
        var $code = form.querySelector('.mobile-code-input');
        var $password = form.querySelector('.password');

        var code = $code.value.trim();
        var password = $password.value.trim();

        return api.resetPassword({
            captcha: code,
            first_pwd: password,
            second_pwd: password,
            phone: form.querySelector('.phone').value.trim()
        }).then((res) => {
            if (res.status === 200) {
                ev.trigger('resetPasswordSuccess');
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

codeMixin.mixTo(ResetPassword);