
import modal from '../modal/modal.js';
import html from './login.html';
import './login.styl';
import api, { $host } from '../api';
import * as codeMixin from '../codeMixin';
import eventBus from '../events';
import { validForm, showFieldError } from '../validator';

export class Login {

    constructor(modal) {
        this.modal = modal;
        this._init();
        this.thirdLoginMode = 'self'; // blank self
    }

    _init () {
        this.modal.appendHTML(html);
        this.$el = this.modal.find('.login-modal-wrap');
        this.initTab();
        this.initForm();
        this._bindCodeEvent();
        this.hide();

        this.$el.querySelector('.go-to-register').addEventListener('click', function() {
            eventBus.trigger('go-to-view', 'register');
        });
        this.$el.querySelector('.go-to-resetPwd').addEventListener('click', function() {
            eventBus.trigger('go-to-view', 'resetPassword');
        });

    }

    setThirdLogin (thirdLoginMode, thirdLoginCallbackUrl) {
        this.thirdLoginCallbackUrl = resolveUrl(thirdLoginCallbackUrl);
        this.thirdLoginMode = thirdLoginMode;
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


    initTab() {
        var items = Array.prototype.slice.call(this.$el.querySelectorAll('.tab-header-item'));
        var $el = this.$el;
        items.forEach(item => {
            item.addEventListener('click', function() {
                if (this.classList.contains('active')) return ;
                var lastActive = find(items, function(item){
                    return item.classList.contains('active');
                });
                lastActive.classList.remove('active');
                this.classList.add('active');
                $el.querySelector('.' + lastActive.getAttribute('data-tab')).classList.add('hide');
                $el.querySelector('.' + this.getAttribute('data-tab')).classList.remove('hide');
            });
        })
    }

    initForm () {
        var _this = this;
        var mobileForm = this.$el.querySelector('.mobile-login');
        mobileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validForm(this)) {
                _this.mobileLogin(this);
            }
        });
        this.$el.querySelector('.account-login').addEventListener('submit', function(e) {
            e.preventDefault();
            if (validForm(this)) {
                _this.accountLogin(this);
            }
        });
        this.$el.querySelector('.weixin').addEventListener('click', this.wxLogin.bind(this));
        this.$el.querySelector('.qq').addEventListener('click', this.qqLogin.bind(this));

    }


    _getCodeForm () {
        return this.$el.querySelector('.mobile-login');
    }

    getCaptcha () {
        return api.getCaptcha({
            type: 2,
            phone: this.$el.querySelector('.mobile-login .phone').value.trim()
        });
    }

    mobileLogin (form) {
        //var form = this.$el.querySelector('.mobile-login');
        api.mobileLogin({
            phone: form.querySelector('.phone').value.trim(),
            captcha: form.querySelector('.mobile-code-input').value.trim()
        }).then((res) => {
            if (res.status == 200) {
                //todo login success callback
                eventBus.trigger('loginSuccess', 'mobile');
            } else {
                showFieldError(res.status == 705 ?
                               form.querySelector('.phone') :
                               form.querySelector('.mobile-code-input'),
                    res.msg
                );
            }
        });
    }

    accountLogin(form) {
        api.accountLogin({
            username: form.querySelector('.phone').value.trim(),
            password: form.querySelector('.password').value
        }).then(res => {
            if(res.status == 200) {
                eventBus.trigger('loginSuccess', 'account');
            } else {
                showFieldError(res.status == 705 ?
                               form.querySelector('.phone') :
                               form.querySelector('.password'),
                    res.msg
                );
            }
        });
    }

    thirdLoginSelf (type) {
        var url = location.href;
        url = addQuery(url, 'thirdLoginType=' + type);
        var returnUrl = encodeURIComponent(url);
        var loginUrl = $host + `/api/v1.2/account/thirdpartylogin?type=${type}&returnUrl=` + returnUrl;
        window.open(loginUrl, '_self');
    }

    thirdLoginCallback (type) {
        var url = this.thirdLoginCallbackUrl;
        url = addQuery(url, 'thirdLoginType=' + type);
        var returnUrl = encodeURIComponent(url);
        var loginUrl = $host + `/api/v1.2/account/thirdpartylogin?type=${type}&returnUrl=` + returnUrl;
        var win = window.open(loginUrl);
        window._THIRD_LOGIN_CALLBACK = () => {
            eventBus.trigger('loginSuccess', type == 0 ? 'weixin' : 'qq');
            win.close();
        };
    }

    wxLogin () {
        if (this.thirdLoginMode == 'blank') {
            this.thirdLoginCallback(0);
        } else {
            this.thirdLoginSelf(0);
        }
    }

    qqLogin () {
        if (this.thirdLoginMode == 'blank') {
            this.thirdLoginCallback(1);
        } else {
            this.thirdLoginSelf(1);
        }
    }

    reset () {
        this._getCodeForm().querySelector('.row-pic-code').classList.remove('hide');
        this._getCodeForm().querySelector('.row-mobile-code').classList.add('hide');
        this.$el.querySelector('.mobile-login form').reset();
        this.$el.querySelector('.account-login form').reset();

        this._isPicCodeValid = false;
        this._phoneValid = false;
        this._picCodeValid = false;
    }
}

codeMixin.mixTo(Login);

function find(array, fn) {
    for (var  i = 0, len = array.length; i < len; i++) {
        if (fn(array[i], i)) {
            return array[i]
        }
    }
    return null;
}

function addQuery(url, query) {
    var tmp = url.split('?');
    var s = tmp[1];
    if (!s) {
        tmp[1] = query;
    } else if (s[0] === '#') {
        tmp[1] = query + s;
    } else {
        tmp[1] = query + '&' + tmp[1];
    }
    return tmp.join('?');
}

// refers to https://github.com/lydell/resolve-url
function resolveUrl(/* ...urls */) {
    var numUrls = arguments.length;

    if (numUrls === 0) {
        throw new Error("resolveUrl requires at least one argument; got none.")
    }

    var base = document.createElement("base");
    base.href = arguments[0];

    if (numUrls === 1) {
        return base.href;
    }

    var head = document.getElementsByTagName("head")[0];
    head.insertBefore(base, head.firstChild);

    var a = document.createElement("a");
    var resolved;

    for (var index = 1; index < numUrls; index++) {
        a.href = arguments[index];
        resolved = a.href;
        base.href = resolved;
    }

    head.removeChild(base);

    return resolved;
}