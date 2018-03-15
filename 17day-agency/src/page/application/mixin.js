
import * as api from '@/js/api'
import i18n from '@/i18n';
export default {

    created: function () {
        if(window.USER_INFO && window.USER_INFO.is_enter){
            this.$message.error(i18n.t('application.error_tips[0]'));
        }else{
            this.checkApplyRecord();
        }

    },
    methods: {
        doAgreement(){
            if(!this.agreeProtocol){
                this._mbox && this._mbox.close()
                return this._mbox = this.$message.error({
                    'message': i18n.t('application.error_tips[1]'),
                });
            }else{
                this._mbox && this._mbox.close()
                this.stage = 2
            }
        },

        prev () {
            this.stage = Math.max(this.stage - 1, 1);
        },

        // 查询申请记录, code （1提交审核，0审核成功，2审核失败，3未申请）type(institute 机构 personal 个人)
        checkApplyRecord () {
            var currentType = this.type;
            //return Promise.resolve({code: 3, type: ''}).then(
            return api.account.isEnter().then(
                (data) => {
                if (data.type && data.type != currentType && data.code != 2) {
                    var path = '/application/' + data.type;
                    var typeMap = {
                        institute: i18n.t('application.type.institute'),
                        personal: i18n.t('application.type.personal')
                    };
                    this.$message.error(i18n.t('application.error_tips[2]', { type: typeMap[data.type],currentType:typeMap[currentType]}));
                    return setTimeout(() => {
                        this.$router.replace({path: path});
                    }, 2000);
                }
                this.applyStatus.type = data.type;
                this.applyStatus.code = data.code;
                switch(data.code) {
                    case 3:
                        //未提交
                        this.stage = 1;
                        break;
                    case 2:
                        this.stage = 3;
                        this.getRecord().then((res) =>{
                            this.applyStatus.reason = res.personal_status_reason||res.ins_status_reason;
                        })
                        break;
                    case 1:
                    case 0:
                        this.stage = 3;
                        this.getRecord().then(() => console.log(this.instituteData));
                }
            });
        },

        getRecord () {
            if (this.type === "institute") {
                return api.institute.getEnterInfo().then(data => this.instituteData = data);
            } else {
                return api.personal.getEnterInfo().then(data => this.instituteData = data);
            }
        }
    }

}
