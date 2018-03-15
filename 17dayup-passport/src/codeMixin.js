
import api from './api';
import { validField } from './validator';
import eventBus from './events';

const proto = {

    _bindCodeEvent () {
        var _this = this;
        var form = this._getCodeForm();
        this._phoneValid = false;
        this._picCodeValid = false;

        form.querySelector('.pic-code').addEventListener('click', () => {
            this.getPicCode();
        });

        form.querySelector('.pic-code-input').addEventListener('input', function() {
            _this._tip('');
            if (this.value.trim().length == 4) {
                _this._picCodeValid = true;
                checkBothValid();
            } else {
                _this._picCodeValid = false;
            }
        });

        form.querySelector('.phone').addEventListener('input', function() {
            _this._tip('');
            if (validField(this, false)) {
                _this._phoneValid = true;
                checkBothValid();
            } else {
                _this._phoneValid = false;
            }
        });

        function checkBothValid() {
            if (_this._phoneValid && _this._picCodeValid) {
                _this.verifyPicCode(form.querySelector('.pic-code-input').value.trim());
            }
        }

        form.querySelector('.mobile-code').addEventListener('click', function() {
            if (this.classList.contains('count-down')) {
                return ;
            }
            if (!_this._validPhone()) {
                return ;
            }
            var btn = this;
            _this.getCaptcha().then(function(res) {
                if (res.status == 200) {
                    countdown(60, {
                        onEnd: function() {
                            btn.classList.remove('count-down');
                            btn.innerText = '获取动态码'
                        },
                        onProgress: function(s) {
                            btn.classList.add('count-down');
                            btn.innerText = s + '秒后重发';
                        }
                    })
                } else {
                    _this._tip(res.msg);
                }
            })
        });
    },

    _validPhone ($phone) {
        $phone = $phone || this._getCodeForm().querySelector('.phone');

        return validField($phone);
    },

    getPicCode () {
        api.getPicCode().then((res) => {
            if (res.status != 200) {
                this._tip(res.msg);
            }
            this.picCodeId = res.data.phrase_id;
            this._getCodeForm().querySelector('.pic-code').src = res.data.img;
        });
    },

    verifyPicCode (code) {
        if (this._isPicCodeValid) {
            this.showMobileCode ();
            eventBus.emit('picCodeValid', this);
            return this._tip('');
        }
        var _timeStamp = this._verifyCodeTime = +new Date();
        return api.verifyPicCode(this.picCodeId, code).then(res => {
            if (_timeStamp !== this._verifyCodeTime) return ;

            if (res.status == 200) {
                this.showMobileCode ();
                eventBus.emit('picCodeValid', this);
                this._tip('');
            } else {
                this._tip(res.msg);
            }
        });
    },

    showMobileCode () {
        this._isPicCodeValid = true;
        this._getCodeForm().querySelector('.row-pic-code').classList.add('hide');
        this._getCodeForm().querySelector('.row-mobile-code').classList.remove('hide');
    },

    _tip (text) {
        var $tip = this._getCodeForm().querySelector('.error-tip');
        $tip && ($tip.innerText = text);
    }

};

export var codeMixin = proto;

export function mixTo(receiver) {
    receiver = isFunction(receiver) ? receiver.prototype : receiver;
    for (var key in proto) {
        if (proto.hasOwnProperty(key)) {
            receiver[key] = proto[key]
        }
    }
}

function countdown(seconds, option) {
    var sTime = +new Date();
    var timer = setInterval(function() {
        var s = seconds - Math.round((+new Date() - sTime) / 1e3);
        if (s < 0) {
            s = 0;
            option.onEnd && option.onEnd(s);
            clearInterval(timer);
        } else {
            option.onProgress && option.onProgress(s);
        }
    }, option.interval || 1000);

    return function destroy() {
        clearInterval(timer);
    }
}

function isFunction(func) {
    return Object.prototype.toString.call(func) === '[object Function]'
}