/**
 * Created by huangzhongjian on 17/11/28.
 */


module.exports = {
    bosConfig: {
        endpoint: 'http://bos.bj.baidubce.com',
        credentials: {
            ak: 'ef79696626b64531855acabfd78c1c69',
            sk: '9168f3a5371d4bd89e6f7fae626cff92'
        }
    },

    development: {
        bosBucket: 'wdyedu-static-dev'
    },
    production: {
        bosBucket: 'wdyedu-static'
    }
};
