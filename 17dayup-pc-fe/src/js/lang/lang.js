import {cn} from './lang_cn.js';
import {en} from './lang_en.js';
import {i18n} from './i18n.js';

if(LOCALE == '' || LOCALE != 'en'){
    window.lang = cn;
}else{
    window.lang = en;
}

window.$i18n = i18n;
