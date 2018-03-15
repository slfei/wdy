
import Vue from 'vue';
import iScroll from '@/lib/iscroll.js';

export default Vue.directive('iscroll', {

    inserted (el, binding, vnode, oldVnode) {
        var options = binding.value;

        vnode.scroll = new iScroll(el, options);
    },

    componentUpdated (el, binding, vnode, oldVnode) {
        vnode.scroll = oldVnode.scroll;
        vnode.scroll.refresh();
    },

    unbind (el, binding, vnode, oldVnode) {
        vnode.scroll = oldVnode.scroll;
        vnode.scroll.destroy();
        vnode.scroll = null;
    }

});