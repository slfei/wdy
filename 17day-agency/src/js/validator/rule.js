import i18n from '@/i18n';
export default {
    email: {
        valid: function(value) {
            return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/.test(value);
        },
        message: i18n.t('common.rules.email')
    },
    phone: {
        valid: function(value) {
            return /^1[3|4|5|7|8]\d{9}$/.test(value);
        },
        message: i18n.t('common.rules.phone')
    },
    idCardNo: {
        valid: function(value) {
            return /(^\d{15}$)|(^\d{17}(\d|X|x)$)/.test(value);
        },
        message: i18n.t('common.rules.idCard')
    }
}
