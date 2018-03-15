import Vue from 'vue'
import VueI18n from 'vue-i18n'
import ElementUI from 'element-ui'

import enLocale from 'element-ui/lib/locale/lang/en'
import zhLocale from 'element-ui/lib/locale/lang/zh-CN'

import zh from '@/lang/zh/index'
import en from '@/lang/en/index'

Vue.use(VueI18n);
const ELEMENT_UI_PREFIX = 'el_i18n';

const messages = {
    zh: {
        [ELEMENT_UI_PREFIX]: zhLocale,
        ...zh
    },
    en: {
        [ELEMENT_UI_PREFIX]: enLocale,
        ...en
    },
};

const I18N_KEY_MAP = {
    'zh-cn': 'zh',
    'cn': 'zh',
    'zh_cn': 'zh',
    'en-us': 'en',
    'en_us': 'en'
};

Vue.use(ElementUI, {
    i18n: (key, value) => {
        return i18n.vm._t(ELEMENT_UI_PREFIX + '.' + key, value);
    }
});

const i18n = new VueI18n({
    locale: getPreferLang(),
    fallbackLocale: 'zh',
    messages,
});

console.log(i18n.locale, messages)

export default i18n;

export function setLocale(key) {
    // async load lang json
    // i18n.locale = normalizeLangKey(key);
    // refresh
}
/**
 *
 * 优先级 queryString --> Hash Query ---> cookie ---> navigator ---> default('zh')
 */
function getPreferLang() {
    var lang;
    if (window.LOCALE) {
      lang = window.LOCALE;
    } else if (/locale=([^&]+)/.test(location.search)) {
        lang = RegExp.$1;
    } else if (/\?(?:.*)locale=([^&]+)/.test(location.hash)) {
        lang = RegExp.$1
    } else if (/locale=([^;]*)/.test(document.cookie)) {
        lang = RegExp.$1;
    } else {
        lang = getNavLanguage()
    }
    if (!lang) {
        return null;
    }
    return normalizeLangKey(lang);
}

function normalizeLangKey(lang) {
    lang = lang.toLowerCase();
    var real_lang = I18N_KEY_MAP[lang];
    if (!real_lang) {
        // 处理 zh-CN zh_cn
        var prefix = lang.split(/-|_/)[0];
        real_lang = I18N_KEY_MAP[prefix];
    }
    return real_lang || lang;
}

function getNavLanguage() {
    var keys = ['language', 'browserLanguage', 'systemLanguage', 'userLanguage'];
    var languages = navigator.languages;
    if (Array.isArray(languages)) {
        for (var i = 0, len = languages.length; i < len; i++) {
            var l = languages[i];
            if (l && l.length) {
                return l;
            }
        }
    }
    for (var i = 0, len = keys.length; i < len; i++) {
        var l = navigator[keys[i]];
        if (l && l.length) {
            return l
        }
    }
    return null;
}
