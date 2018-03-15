function getQuery(name, url) {
    url = url  || location.href;
    if (new RegExp('(\\?|&)' + name + '=' + '([^&]*)').test(url)) {
        return RegExp.$2
    }
    return '';
}

function initPassport () {
    var passport = window.wdy.passport;
    var $login = document.querySelector('#J-header-login');
    if ($login) {
        $login.querySelector('.login').addEventListener('click', function() {
            passport.showView('login');
        });
        $login.querySelector('.register').addEventListener('click', function() {
            passport.showView('register');
        });
    }

    // 登录/退出/注册/绑定手机号成功 刷新页面
    passport.on('loginSuccess registerSuccess bindPhoneSuccess logoutSuccess', function() {
        location.reload();
    });
    // 重置密码跳回登录
    passport.on('resetPasswordSuccess', function(){
        passport.showView('login');
    });

    if (getQuery('errorCode') === '10010') {
        passport.showView('bindPhone')
            .setOption(getQuery('openid'), getQuery('thirdLoginType') || 0);
    } else if (getQuery('errorCode') === '0') {
        console.log('login~~~')
    }

    //退出
    var logout = document.querySelector('.logout');
    if (logout) {
        logout.addEventListener('click', function() {
            passport.logout();
        });
    }
}


initPassport()
