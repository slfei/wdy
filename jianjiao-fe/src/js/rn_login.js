export default {
    methods: {
        checkRNLogin () {
            if (window.isReactNative && !$tplData.user_info.is_login) {
                window.postMessage(JSON.stringify({
                    action: 'Login',
                    data: {}
                }));
                return false;
            }
            return true;
        }
    }
}
