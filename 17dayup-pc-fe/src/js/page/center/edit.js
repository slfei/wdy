import '../../components/tab/tab.js';
import '../../components/modal/avator-modal.js';
$(function() {
    var image = '';
    $('.update-avator a').click(function(e) {
        $('.avator-modal').show()
    })
    $('.close-avator').click(function(e) {
        $('.avator-modal').hide()
    })
    $('a.upload-img').on('click', function() {
        $('#upload-avatar-input').click()
    });
    $('#upload-avatar-input').on('change', function(e) {
        if (!this.files || !this.files[0]) {
            return;
        }
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function(evt) {}
        reader.readAsDataURL(file);
        var form_image = new FormData();
        form_image.append('image', file);
        $.ajax({
            type: 'POST',
            url: '/api/universal/uploadimage',
            data: form_image,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status == 200) {
                    $('.avator-img').attr('src', res.data.url);
                    utils.toast($i18n('public.success'));
                } else {
                    utils.toast($i18n('public.error'));
                }
            }
        })
    });
    var errorMechanism = function(val, require, errMsg) {

    };
    $('.save_info').click(function() {
        var nick_name;
        nick_name = $('.nick_name').val();
        if (!nick_name) {
            return utils.toast($i18n('center.edit.nickNameRequired'));
        }
        var userinfo = {
            avatar_url: $('.avator-img').attr('src'),
            nick_name: $('.nick_name').val(),
            short_desc: $('.signature').val(),
            sex: $('input.sex:checked').val() || 0,
            province: $('.province option:selected').val(),
            city: $('.city option:selected').val(),
            county: $('.country option:selected').val(),
            birthday: $('.year option:selected').val() + '-' + $('.month option:selected').val() + '-' + $('.day option:selected').val(),
            industry: $('.industry option:selected').val()
        };
        $.post('/api/center/saveinfo', userinfo, function(data, status) {
            if (data.status == 200) {
                // $('.save_info').attr("disabled",false); 
                utils.toast($i18n('public.success'));
                window.location.reload();
            }
        })
    });
    var pwd_data, pwd_id, select_url;
    //var post_url = 'http://passport.ac.enimo.cn';
    $('.w-pwd-primary').click(function(e) {
        pwd_id = e.target.id;
        select_url = (pwd_id == 'set-pwd') ? '/api/v1.2/account/setpassword' : '/api/v1.2/account/centerresetpassword';
        if (e.target.id == 'set-pwd') {
            pwd_data = {
                phone: userphone,
                password: $('.setpwd').val()
            }
            updatepwd();
        } else {
            pwd_data = {
                phone: userphone,
                old_pwd: $('.oldpwd').val(),
                first_pwd: $('.newpwd').val(),
                second_pwd: $('.second_pwd').val()
            }
            if ($('.second_pwd').val() !== $('.newpwd').val()) {
                utils.toast($i18n('center.edit.passwordMismatch'));
            } else {
                updatepwd();
            }
        }
    })

    var changeDate = function() {
        var monthMax = [1, 3, 5, 7, 8, 10, 12];
        var monthNormal = [4, 6, 9, 11];
        /*获取月份，获取年份*/
        var month = parseInt($('.input_select .month').val());
        var year = parseInt($('.input_select .year').val());
        if (monthMax.indexOf(month) != -1) {
            $('.input_select .day option').show();
        } else if (monthNormal.indexOf(month) != -1) {
            $('.input_select .day option').each(function(i, option) {
                if (i + 1 <= 30) {
                    $(option).show();
                } else {
                    $(option).hide()
                }
            })
        } else if (month == 2) {
            if (year % 400 == 0 || (year % 100 != 0 && year & 4 == 0)) {
                $('.input_select .day option').each(function(i, option) {
                    if (i + 1 <= 29) {
                        $(option).show();
                    } else {
                        $(option).hide()
                    }
                });
            } else {
                $('.input_select .day option').each(function(i, option) {
                    if (i + 1 <= 28) {
                        $(option).show();
                    } else {
                        $(option).hide()
                    }
                });

            }
        }
    };
    $('.input_select .year').change(function() {
        changeDate();
        $('.input_select .month').val(1);
        $('.input_select .day').val(1);
    });
    $('.input_select .month').change(function() {
        changeDate();
        $('.input_select .day').val(1);
    });
    changeDate();

    function updatepwd() {
        $.ajax({
            url:'//' + PASSPORT_HOST + select_url,
            data: pwd_data,
            type: 'POST',
            beforeSend: function(xhr) {
                xhr.setRequestHeader("appid", "cc0103edr1aw134r");
            },
            xhrFields: {
                withCredentials: true
            },
            success: function(res){
                if (res.status == 200) {
                    // $('.save_info').attr("disabled",false); 
                    utils.toast($i18n('public.success'));
                    location.reload();
                } else if(res.status == 706){
                    utils.toast($i18n('center.edit.oldPasswordError'));
                }else {
                    utils.toast(res.msg);
                }
            }
        })
    }
});
