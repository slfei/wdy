
var validators = {
    phone: function(phone, message) {
        if (!(/^1[3456789]\d{9}$/.test(phone))) {
            return {
                message: message || '手机号码格式不正确',
                valid: false
            };
        }

        return {
            valid: true,
            message: ''
        }
    },

    empty: function(text, message = '请填写此字段') {
        if (text.length > 0) {
            return {
                valid: true
            }
        }
        return {
            valid: false,
            message: message
        }
    },

    password : function(password, message) {
        if (!(/^[\w\W]{6,32}$/.test(password))) {
            return {
                message: message || '密码长度为6到32位的字母、数字、特殊字符组合',
                valid: false
            };
        }
        return {
            valid: true
        }
    },

    equalTo: function(v, message, args) {
        var flag =  v == document.querySelector(args).value;
        return {
            valid: flag,
            message: flag ? '' : message
        }
    }
};

export function runValidator($field, type = 'empty', message, args) {
    var value = $field.value;
    if (type != 'password') {
        value = value.trim();
    }

    return validators[type](value, message, args);
}

export function showFieldError($field, message) {
    var span;
    if (!$field._errMsg) {
        span = document.createElement('span');
        span.className = 'field-error';
        $field.classList.add('error');
    } else {
        span = $field._errMsg;
    }

    span.innerText = message;
    $field.parentNode.appendChild(span);

    $field._errMsg = span;
}

export function validField ($field, showError = true) {
    var data = $field.getAttribute('data-validator');
    var ret;

    try {
        data = JSON.parse(data);
    } catch(e) { }
    
    // listen to input, 防止重复绑定
    if(!$field._listen_to_input_ && showError) {
        $field.addEventListener('input', listenToInput);
        $field._listen_to_input_ = true;
    }

    if (!data) {
        ret = $field.required ? runValidator($field) : {valid: true};
    } else {
        if (!Array.isArray(data)) {
            data = [data];
        }
        for (var j = 0, k = data.length; j < k; j++) {
            var validator = data[j];
            var type = typeof validator == 'string' ? validator : validator.type;
            var message = typeof validator == 'string' ? undefined : validator.text;
            ret = runValidator($field, type, message, validator.args);
            if (!ret.valid) {
                break;
            }
        }
    }
    if (!showError) return ret.valid;

    if (ret.valid) {
        if ($field._errMsg) {
            $field.classList.remove('error');
            $field.parentNode.removeChild($field._errMsg);
            delete $field._errMsg;
        }
    } else {
        showFieldError($field, ret.message);
    }
    return ret.valid;
}

export function validForm(form) {
    var fields = form.querySelectorAll('input');
    for ( var i = 0, len = fields.length; i < len; i++) {
        if (!fields[i].clientWidth && !fields[i].clientHeight) {
            // skip :hidden
            console.log('skip :hidden', fields[i]);
            continue;
        }
        if (!validField(fields[i])) {
            return false;
        }
    }

    return true;
}


function listenToInput() {
    validField(this);
}