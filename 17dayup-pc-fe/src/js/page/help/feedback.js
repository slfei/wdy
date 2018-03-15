/**
 * Created by Administrator on 2017/10/18.
 */
$('.type a').click(function () {
    $('.type .ico').removeClass('active');
    $(this).find('.ico').addClass('active');
});
$('.submit').click(function () {

    var json = {
        type: $('.type .active').attr('value'),
        phone: $('.phone').val(),
        suggest: $('.suggest').val()
    };
    var reg = new RegExp('[\\u4E00-\\u9FFF]+', 'g');
    if (!json.phone) {
        utils.toast($i18n('help.phoneRequired'), 'error');
        return;
    } else if (reg.test(json.phone)) {
        utils.toast($i18n('help.phoneVal'), 'error');
        return;
    }
    if (!json.suggest) {
        utils.toast($i18n('help.suggestRequired'), 'error');
        return;
    } else if (json.suggest.length < 10) {
        utils.toast($i18n('help.suggestNin'), 'error');
        return;
    } else if (json.suggest.length > 500) {
        utils.toast($i18n('help.suggestMax'), 'error');
        return;
    }
    var url = '/api/help/feedback';
    $.post(url, json).then(function (data) {
        if (data.status == 200) {
            utils.toast(data.msg || $i18n('feedback.msg'));
        } else {
            utils.toast(data.msg || $i18n('public.error'));
        }
    }, function (err) {
        utils.toast(err.msg);
    })
});
