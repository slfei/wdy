# 17dayup-passport

### 本地调试
    node dev-server.js
    访问 dev.ac.enimo.cn:17171 (dev.ac.enimo.cn配置host到127.0.0.1)
    webpack --config webpack.config.js --watch 实时编译

### 部署到线上
    执行 node deploy.js, 发送到百度云服务bos上
    其他产品引用的是bos的文件

### passport几个页面如何展示
    passport.showView(viewName);
    passport.getInstance(viewName); // 获取viewInstance
    viewName 'login' 登录 'register' 登录 'bindPhone' 第三方登录绑定手机号 'resetPassword' 忘记密码/重置密码

### 操作回调
    passport 引入eventBus模块来代理事件

    比较监听登录成功 `passport.on('loginSuccess', (loginType) => console.log(loginType))`,
    其他事件, bindPhoneSuccess, registerSuccess, resetPasswordSuccess

### 第三方登录
    第三方登录支持, 当前页面登录和新标签打开窗口登录两种方式, 默认为当前页面登录
    1. 当前页面登录方式 `passport.showView('login').setThirdLogin('self');`,
       这种方式登录成功,后端会回调到原页面,带个第三方登录的参数到url上, 需要在页面处理绑定手机号逻辑
    2. 新窗口打开方式 `passport.showView('login').setThirdLogin('blank', 'thirdLoginCallback.html')'`,
       这种方式第三方登录完成会跳到传入的 'thirdLoginCallback.html'页面上
       这个登录完成后可触发原页面回调

